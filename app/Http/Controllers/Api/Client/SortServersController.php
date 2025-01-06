<?php

namespace Pterodactyl\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use Pterodactyl\Models\Server;
use Illuminate\Support\Facades\Auth;
use Pterodactyl\Http\Controllers\Controller;

class SortServersController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Récupérer le serveur à trier
        $sortedServer = Server::where('uuid', $request->input('uuid'))->first();
        if (!$sortedServer || $sortedServer->owner_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Synchroniser toutes les positions avant d'effectuer le tri
        $servers = Server::where('owner_id', $user->id)->orderBy('position')->get();
        $servers->each(function ($server, $index) {
            $server->update(['position' => $index]);
        });

        // Récupérer la position actuelle et la nouvelle position
        $oldPosition = $sortedServer->position;
        $newPosition = $request->input('newIndex');

        // Gérer les déplacements
        if ($oldPosition < $newPosition) {
            Server::where('owner_id', $user->id)
                ->where('position', '>', $oldPosition)
                ->where('position', '<=', $newPosition)
                ->decrement('position');
        } elseif ($oldPosition > $newPosition) {
            Server::where('owner_id', $user->id)
                ->where('position', '>=', $newPosition)
                ->where('position', '<', $oldPosition)
                ->increment('position');
        }

        // Mettre à jour la position du serveur déplacé
        $sortedServer->update(['position' => $newPosition]);

        // Ajouter un log pour le débogage
        \Log::info('Requête de tri des serveurs', [
            'uuid' => $request->input('uuid'),
            'anciennePosition' => $oldPosition,
            'nouvellePosition' => $newPosition,
            'identifiantUtilisateur' => $user->id
        ]);

        return response()->json(['success' => true]);
    }
}
