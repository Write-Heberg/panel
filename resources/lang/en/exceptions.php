<?php

return [
    'daemon_connection_failed' => 'Une exception s\'est produite lors de la tentative de communication avec le daemon, entraînant un code de réponse HTTP/:code. Cette exception a été enregistrée.',
    'node' => [
        'servers_attached' => 'Un nœud ne peut pas être supprimé s\'il a des serveurs liés à lui.',
        'daemon_off_config_updated' => 'La configuration du daemon <strong>a été mise à jour</strong>, cependant une erreur est survenue lors de la tentative de mise à jour automatique du fichier de configuration sur le daemon. Vous devrez mettre à jour manuellement le fichier de configuration (config.yml) du daemon pour appliquer ces changements.',
    ],
    'allocations' => [
        'server_using' => 'Un serveur est actuellement affecté à cette allocation. Une allocation ne peut être supprimée que si aucun serveur n\'y est actuellement affecté.',
        'too_many_ports' => 'Ajouter plus de 1000 ports dans une seule plage à la fois n\'est pas pris en charge.',
        'invalid_mapping' => 'La correspondance fournie pour :port est invalide et ne peut pas être traitée.',
        'cidr_out_of_range' => 'La notation CIDR n\'autorise que des masques entre /25 et /32.',
        'port_out_of_range' => 'Les ports dans une allocation doivent être supérieurs à 1024 et inférieurs ou égaux à 65535.',
    ],
    'nest' => [
        'delete_has_servers' => 'Une Niche avec des serveurs actifs qui y sont rattachés ne peut pas être supprimée du panneau.',
        'egg' => [
            'delete_has_servers' => 'Un Conteneur avec des serveurs actifs qui y sont rattachés ne peut pas être supprimé du panneau.',
            'invalid_copy_id' => 'L\'Œuf sélectionné pour copier un script n\'existe pas, ou copie déjà un script.',
            'must_be_child' => 'La directive "Copier les paramètres de" pour cet Œuf doit être une option enfant pour la Niche sélectionnée.',
            'has_children' => 'Cet Œuf est parent de un ou plusieurs autres Œufs. Veuillez supprimer ces Œufs avant de supprimer celui-ci.',
        ],
        'variables' => [
            'env_not_unique' => 'La variable d\'environnement :name doit être unique pour cet Œuf.',
            'reserved_name' => 'La variable d\'environnement :name est protégée et ne peut pas être attribuée à une variable.',
            'bad_validation_rule' => 'La règle de validation ":rule" n\'est pas valide pour cette application.',
        ],
        'importer' => [
            'json_error' => 'Une erreur s\'est produite lors de la tentative d\'analyse du fichier JSON : :error.',
            'file_error' => 'Le fichier JSON fourni n\'était pas valide.',
            'invalid_json_provided' => 'Le fichier JSON fourni n\'est pas dans un format reconnaissable.',
        ],
    ],
    'subusers' => [
        'editing_self' => 'Il n\'est pas permis de modifier votre propre compte de sous-utilisateur.',
        'user_is_owner' => 'Vous ne pouvez pas ajouter le propriétaire du serveur en tant que sous-utilisateur pour ce serveur.',
        'subuser_exists' => 'Un utilisateur avec cette adresse e-mail est déjà assigné en tant que sous-utilisateur pour ce serveur.',
    ],
    'databases' => [
        'delete_has_databases' => 'Impossible de supprimer un serveur d\'hébergement de base de données qui a des bases de données actives liées à lui.',
    ],
    'tasks' => [
        'chain_interval_too_long' => 'L\'intervalle maximal pour une tâche chaînée est de 15 minutes.',
    ],
    'locations' => [
        'has_nodes' => 'Impossible de supprimer un emplacement qui a des nœuds actifs attachés à lui.',
    ],
    'users' => [
        'node_revocation_failed' => 'Échec de la révocation des clés sur <a href=":link">Nœud #:node</a>. :error',
    ],
    'deployment' => [
        'no_viable_nodes' => 'Aucun nœud répondant aux exigences spécifiées pour le déploiement automatique n\'a pu être trouvé.',
        'no_viable_allocations' => 'Aucune allocation répondant aux exigences pour le déploiement automatique n\'a été trouvée.',
    ],
    'api' => [
        'resource_not_found' => 'La ressource demandée n\'existe pas sur ce serveur.',
    ],
];