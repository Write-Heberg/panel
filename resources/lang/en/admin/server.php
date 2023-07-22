<?php

return [
    'exceptions' => [
        'no_new_default_allocation' => 'Vous essayez de supprimer l\'allocation par défaut de ce serveur, mais il n\'y a aucune allocation de secours à utiliser.',
        'marked_as_failed' => 'Ce serveur a été marqué comme ayant échoué à une installation précédente. L\'état actuel ne peut pas être modifié dans cet état.',
        'bad_variable' => 'Il y a eu une erreur de validation avec la variable :name.',
        'daemon_exception' => 'Une exception s\'est produite lors de la tentative de communication avec le démon, ce qui a entraîné un code de réponse HTTP/:code. Cette exception a été enregistrée. (ID de la requête : :request_id)',
        'default_allocation_not_found' => 'L\'allocation par défaut demandée n\'a pas été trouvée dans les allocations de ce serveur.',
    ],
    'alerts' => [
        'startup_changed' => 'La configuration de démarrage de ce serveur a été mise à jour. Si le nid ou l\'œuf de ce serveur a été modifié, une réinstallation aura lieu maintenant.',
        'server_deleted' => 'Le serveur a été supprimé avec succès du système.',
        'server_created' => 'Le serveur a été créé avec succès sur le panneau. Veuillez accorder quelques minutes au démon pour installer complètement ce serveur.',
        'build_updated' => 'Les détails de construction de ce serveur ont été mis à jour. Certaines modifications peuvent nécessiter un redémarrage pour prendre effet.',
        'suspension_toggled' => 'Le statut de suspension du serveur a été modifié en :status.',
        'rebuild_on_boot' => 'Ce serveur a été marqué comme nécessitant une reconstruction du conteneur Docker. Cela se produira la prochaine fois que le serveur sera démarré.',
        'install_toggled' => 'Le statut d\'installation de ce serveur a été modifié.',
        'server_reinstalled' => 'Ce serveur a été mis en file d\'attente pour une réinstallation commençant maintenant.',
        'details_updated' => 'Les détails du serveur ont été mis à jour avec succès.',
        'docker_image_updated' => 'Le Docker image par défaut à utiliser pour ce serveur a été changé avec succès. Un redémarrage est nécessaire pour appliquer ce changement.',
        'node_required' => 'Vous devez configurer au moins un nœud avant de pouvoir ajouter un serveur à ce panneau.',
        'transfer_nodes_required' => 'Vous devez configurer au moins deux nœuds avant de pouvoir transférer des serveurs.',
        'transfer_started' => 'Le transfert du serveur a été lancé.',
        'transfer_not_viable' => 'Le nœud que vous avez sélectionné n\'a pas l\'espace disque ou la mémoire nécessaires pour accueillir ce serveur.',
    ],
];
