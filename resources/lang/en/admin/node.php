<?php

return [
    'validation' => [
        'fqdn_not_resolvable' => 'Le nom de domaine complet ou l\'adresse IP fournie ne se résout pas en une adresse IP valide.',
        'fqdn_required_for_ssl' => 'Un nom de domaine complet qui se résout en une adresse IP publique est requis pour utiliser SSL sur ce nœud.',
    ],
    'notices' => [
        'allocations_added' => 'Les allocations ont été ajoutées avec succès à ce nœud.',
        'node_deleted' => 'Le nœud a été supprimé avec succès du panneau.',
        'location_required' => 'Vous devez configurer au moins un emplacement avant de pouvoir ajouter un nœud à ce panneau.',
        'node_created' => 'Un nouveau nœud a été créé avec succès. Vous pouvez configurer automatiquement le démon sur cette machine en visitant l\'onglet "Configuration". <strong>Avant de pouvoir ajouter des serveurs, vous devez d\'abord allouer au moins une adresse IP et un port.</strong>',
        'node_updated' => 'Les informations du nœud ont été mises à jour. Si des paramètres du démon ont été modifiés, vous devrez le redémarrer pour que les changements prennent effet.',
        'unallocated_deleted' => 'Toutes les ports non-alloués pour <code>:ip</code> ont été supprimés.',
    ],
];
