<?php

namespace Pterodactyl\Console\Commands\Server;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Pterodactyl\Models\DeletedFile;
use Pterodactyl\Repositories\Wings\DaemonFileRepository;

class EmptyTrashcanCommand extends Command
{
    protected $signature = 'p:server:trashcan:empty';
    protected $description = 'Supprime les fichiers de la corbeille après 24 heures';

    private DaemonFileRepository $fileRepository;

    public function __construct(DaemonFileRepository $fileRepository)
    {
        parent::__construct();
        $this->fileRepository = $fileRepository;
    }

    public function handle()
    {
        $files = DeletedFile::where('deleted_at', '<=', Carbon::now()->subHours(24))->get();

        foreach($files as $file) {
            try {
                $this->fileRepository
                    ->setServer($file->server)
                    ->deleteFiles(
                        '/' . $file->server->uuid,
                        [$file->file_name]
                    );
                
                $file->delete();
                
                $this->info("Fichier supprimé avec succès : {$file->file_name}");
            } catch (\Exception $e) {
                $this->error("Erreur lors de la suppression du fichier {$file->file_name} : " . $e->getMessage());
                continue;
            }
        }

        $this->info('Nettoyage de la corbeille terminé');
    }
}