<?php

return [
    'sign_in' => 'Connexion',
    'go_to_login' => 'Aller à la page de connexion',
    'failed' => 'Aucun compte correspondant à ces identifiants n\'a été trouvé.',

    'forgot_password' => [
        'label' => 'Mot de passe oublié ?',
        'label_help' => 'Saisissez l\'adresse e-mail de votre compte pour recevoir des instructions de réinitialisation de votre mot de passe.',
        'button' => 'Récupérer le compte',
    ],

    'reset_password' => [
        'button' => 'Réinitialiser et se connecter',
    ],

    'two_factor' => [
        'label' => 'Jeton à 2 facteurs',
        'label_help' => 'Ce compte nécessite une seconde couche d\'authentification pour continuer. Veuillez saisir le code généré par votre appareil pour finaliser cette connexion.',
        'checkpoint_failed' => 'Le jeton d\'authentification à 2 facteurs était invalide.',
    ],

    'throttle' => 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
    'password_requirements' => 'Le mot de passe doit comporter au moins 8 caractères et doit être unique pour ce site.',
    '2fa_must_be_enabled' => 'L\'administrateur a exigé que l\'authentification à 2 facteurs soit activée pour votre compte afin d\'utiliser le panneau de contrôle.',
];