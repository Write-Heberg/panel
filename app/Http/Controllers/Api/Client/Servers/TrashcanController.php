<?php

namespace Pterodactyl\Http\Controllers\Api\Client\Servers;

use Pterodactyl\Models\Server;
use Pterodactyl\Models\DeletedFile;
use Pterodactyl\Http\Controllers\Api\Client\ClientApiController;
use Pterodactyl\Http\Requests\Api\Client\Servers\Files\DeleteFileRequest;
use Pterodactyl\Repositories\Wings\DaemonFileRepository;
use Illuminate\Http\JsonResponse;

class TrashcanController extends ClientApiController
{
    private DaemonFileRepository $fileRepository;

    public function __construct(DaemonFileRepository $fileRepository)
    {
        parent::__construct();
        
        $this->fileRepository = $fileRepository;
    }

    public function size(Server $server): JsonResponse
    {
        $size = DeletedFile::where('server_id', $server->id)->sum('size');
        
        return new JsonResponse([
            'size' => $size,
        ]);
    }

    public function restore(DeleteFileRequest $request, Server $server): JsonResponse
    {
        $files = $request->input('files', []);
        $root = $request->input('root');

        foreach ($files as $file) {
            $deletedFile = DeletedFile::where('server_id', $server->id)
                ->where('file_name', $file)
                ->first();

            if ($deletedFile) {
                $this->fileRepository->setServer($server)
                    ->renameFiles('/' . $server->uuid, [
                        [
                            'from' => $file,
                            'to' => str_repeat('../', substr_count($deletedFile->directory, '/')) . ltrim($deletedFile->directory . '/' . $file, '/'),
                        ],
                    ]);

                $deletedFile->delete();
            }
        }

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}