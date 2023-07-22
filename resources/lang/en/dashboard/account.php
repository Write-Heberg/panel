<?php

return [
    'email' => [
        'title' => 'Mettre à jour votre adresse e-mail',
        'updated' => 'Votre adresse e-mail a été mise à jour.',
    ],
    'password' => [
        'title' => 'Changer votre mot de passe',
        'requirements' => 'Votre nouveau mot de passe doit contenir au moins 8 caractères.',
        'updated' => 'Votre mot de passe a été mis à jour.',
    ],
    'two_factor' => [
        'button' => 'Configurer l\'authentification à deux facteurs',
        'disabled' => 'L\'authentification à deux facteurs a été désactivée pour votre compte. Vous ne serez plus invité à fournir un code lors de la connexion.',
        'enabled' => 'L\'authentification à deux facteurs a été activée pour votre compte ! Désormais, lors de la connexion, vous devrez fournir le code généré par votre appareil.',
        'invalid' => 'Le code fourni était invalide.',
        'setup' => [
            'title' => 'Configurer l\'authentification à deux facteurs',
            'help' => 'Vous ne pouvez pas scanner le code ? Entrez le code ci-dessous dans votre application :',
            'field' => 'Entrez le code',
        ],
        'disable' => [
            'title' => 'Désactiver l\'authentification à deux facteurs',
            'field' => 'Entrez le code',
        ],
    ],
];
