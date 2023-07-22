<?php

return [
    'notices' => [
        'created' => 'Un nouveau nid, :name, a été créé avec succès.',
        'deleted' => 'Le nid demandé a été supprimé avec succès du panneau.',
        'updated' => 'Les options de configuration du nid ont été mises à jour avec succès.',
    ],
    'eggs' => [
        'notices' => [
            'imported' => 'Cet Egg et ses variables associées ont été importés avec succès.',
            'updated_via_import' => 'Cet Egg a été mis à jour en utilisant le fichier fourni.',
            'deleted' => 'L\'Egg demandé a été supprimé avec succès du panneau.',
            'updated' => 'La configuration de l\'Egg a été mise à jour avec succès.',
            'script_updated' => 'Le script d\'installation de l\'Egg a été mis à jour et sera exécuté chaque fois que des serveurs sont installés.',
            'egg_created' => 'Un nouvel Egg a été créé avec succès. Vous devrez redémarrer tous les démons en cours d\'exécution pour appliquer ce nouvel Egg.',
        ],
    ],
    'variables' => [
        'notices' => [
            'variable_deleted' => 'La variable ":variable" a été supprimée et ne sera plus disponible pour les serveurs une fois reconstruits.',
            'variable_updated' => 'La variable ":variable" a été mise à jour. Vous devrez reconstruire tous les serveurs utilisant cette variable pour appliquer les changements.',
            'variable_created' => 'Une nouvelle variable a été créée avec succès et attribuée à cet Egg.',
        ],
    ],
];
