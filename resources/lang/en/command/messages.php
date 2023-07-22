<?php

return [
    'location' => [
        'no_location_found' => 'Impossible de trouver un enregistrement correspondant au code court fourni.',
        'ask_short' => 'Code court de la localisation',
        'ask_long' => 'Description de la localisation',
        'created' => 'Nouvelle localisation (:name) créée avec succès. ID : :id.',
        'deleted' => 'Localisation demandée supprimée avec succès.',
    ],
    'user' => [
        'search_users' => 'Entrez un nom d\'utilisateur, un identifiant d\'utilisateur ou une adresse e-mail',
        'select_search_user' => 'ID de l\'utilisateur à supprimer (Entrez \'0\' pour rechercher à nouveau)',
        'deleted' => 'Utilisateur supprimé avec succès du panneau.',
        'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer cet utilisateur du panneau?',
        'no_users_found' => 'Aucun utilisateur n\'a été trouvé pour le terme de recherche fourni.',
        'multiple_found' => 'Plusieurs comptes ont été trouvés pour l\'utilisateur fourni. Impossible de supprimer un utilisateur en raison du drapeau --no-interaction.',
        'ask_admin' => 'Cet utilisateur est-il un administrateur?',
        'ask_email' => 'Adresse e-mail',
        'ask_username' => 'Nom d\'utilisateur',
        'ask_name_first' => 'Prénom',
        'ask_name_last' => 'Nom de famille',
        'ask_password' => 'Mot de passe',
        'ask_password_tip' => 'Si vous souhaitez créer un compte avec un mot de passe aléatoire envoyé par e-mail à l\'utilisateur, relancez cette commande (CTRL+C) et passez le drapeau `--no-password`.',
        'ask_password_help' => 'Les mots de passe doivent contenir au moins 8 caractères, dont au moins une lettre majuscule et un chiffre.',
        '2fa_help_text' => [
            'Cette commande désactivera l\'authentification à deux facteurs pour le compte de l\'utilisateur s\'il est activé. Cela ne doit être utilisé que comme une commande de récupération de compte si l\'utilisateur est bloqué de son compte.',
            'Si ce n\'est pas ce que vous vouliez faire, appuyez sur CTRL+C pour quitter ce processus.',
        ],
        '2fa_disabled' => 'L\'authentification à deux facteurs a été désactivée pour :email.',
    ],
    'schedule' => [
        'output_line' => 'Envoi de la tâche pour la première tâche de ":schedule" (:hash).',
    ],
    'maintenance' => [
        'deleting_service_backup' => 'Suppression du fichier de sauvegarde du service :file.',
    ],
    'server' => [
        'rebuild_failed' => 'La demande de reconstruction pour ":name" (#:id) sur le nœud ":node" a échoué avec l\'erreur : :message',
        'reinstall' => [
            'failed' => 'La demande de réinstallation pour ":name" (#:id) sur le nœud ":node" a échoué avec l\'erreur : :message',
            'confirm' => 'Vous êtes sur le point de réinstaller un groupe de serveurs. Voulez-vous continuer?',
        ],
        'power' => [
            'confirm' => 'Vous êtes sur le point d\'effectuer une :action sur :count serveurs. Voulez-vous continuer?',
            'action_failed' => 'La demande d\'action de puissance pour ":name" (#:id) sur le nœud ":node" a échoué avec l\'erreur : :message',
        ],
    ],
    'environment' => [
        'mail' => [
            'ask_smtp_host' => 'Hôte SMTP (par exemple, smtp.gmail.com)',
            'ask_smtp_port' => 'Port SMTP',
            'ask_smtp_username' => 'Nom d\'utilisateur SMTP',
            'ask_smtp_password' => 'Mot de passe SMTP',
            'ask_mailgun_domain' => 'Domaine Mailgun',
            'ask_mailgun_endpoint' => 'Point de terminaison Mailgun',
            'ask_mailgun_secret' => 'Secret Mailgun',
            'ask_mandrill_secret' => 'Secret Mandrill',
            'ask_postmark_username' => 'Clé API Postmark',
            'ask_driver' => 'Quel pilote doit être utilisé pour envoyer des e-mails?',
            'ask_mail_from' => 'Adresse e-mail d\'où proviendront les e-mails',
            'ask_mail_name' => 'Nom qui apparaîtra dans les e-mails',
            'ask_encryption' => 'Méthode de chiffrement à utiliser',
        ],
    ],
];
