<?php

namespace Pterodactyl\Console\Commands\Server;

use Carbon\Carbon;
use Pterodactyl\Models\Server;
use Illuminate\Console\Command;
use Pterodactyl\Models\DeletedFile;
use Pterodactyl\Repositories\Wings\DaemonFileRepository;

class EmptyTrashcanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'p:server:empty-trashcan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empties the trashcan 24 hours after deletion.';

    /**
     * @var \Pterodactyl\Repositories\Wings\DaemonFileRepository
     */
    private $fileRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DaemonFileRepository $fileRepository)
    {
        parent::__construct();
        $this->fileRepository = $fileRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(DeletedFile::all() as $file) {
            if(Carbon::parse($file->deleted_at)->addHours(24) < Carbon::now()) {
                $server = Server::where('id', $file->server_id)->first();

                try {
                    if ($server) $this->fileRepository->setServer($server)->deleteFiles(
                        '/' . $server->uuid,
                        array($file->file_name)
                    );
                } catch (\Exception) {
                    // if the file can not be found just catch the error and continue deleting the database instance
                }

                DeletedFile::where('id', $file->id)->delete();
            }
        }

        return 0;
    }
}
