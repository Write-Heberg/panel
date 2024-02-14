<?php

namespace Pterodactyl\Http\Controllers\Api\Client\Servers;

use Illuminate\Http\Request;
use Pterodactyl\Models\Server;
use Pterodactyl\Models\DeletedFile;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Repositories\Wings\DaemonFileRepository;

class TrashcanController extends Controller
{
    /**
     * @var \Pterodactyl\Repositories\Wings\DaemonFileRepository
     */
    protected $fileRepository;

    /**
     * TrashcanController constructor.
     */
    public function __construct(
        DaemonFileRepository $fileRepository
    ) {
        $this->fileRepository = $fileRepository;
    }

    public function restore(Server $server, Request $request)
    {   
        foreach($request->input('files') as $file) {
            $deletedFile = DeletedFile::where('server_id', $server->id)->where('file_name', $file)->first();
            
            $this->fileRepository->setServer($server)->renameFiles($server->uuid, array(array('from' => $file, 'to' => '..' . $deletedFile->directory . '/' . $deletedFile->file_name)));

            $deletedFile->delete();
        }
    }

    public function size(Server $server) {
        $size = null;
        $deleted_at = null;
        if(DeletedFile::where('server_id', $server->id)->first()) {
            foreach(DeletedFile::where('server_id', $server->id)->get() as $file) {
                $size = $size + $file->size;
            }
            $deleted_at = DeletedFile::where('server_id', $server->id)->orderBy('deleted_at', 'DESC')->first()->deleted_at;
        }

        return ['data' => ['size' => $size, 'last_deletion' => $deleted_at]];
    }
}