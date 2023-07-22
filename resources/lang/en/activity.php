<?php

/**
 * Contient toutes les chaînes de traduction pour différents événements du journal d'activité.
 * Ces chaînes doivent être indexées par la valeur avant le deux-points (:) dans le nom de l'événement.
 * Si aucun deux-points n'est présent, elles doivent être placées au niveau supérieur.
 */
return [
    'auth' => [
        'fail' => 'Échec de la connexion',
        'success' => 'Connecté',
        'password-reset' => 'Réinitialisation du mot de passe',
        'reset-password' => 'Demande de réinitialisation du mot de passe',
        'checkpoint' => 'Demande d\'authentification à deux facteurs',
        'recovery-token' => 'Utilisation du jeton de récupération à deux facteurs',
        'token' => 'Résolution du défi à deux facteurs',
        'ip-blocked' => 'Demande bloquée depuis une adresse IP non répertoriée pour :identifier',
        'sftp' => [
            'fail' => 'Échec de la connexion SFTP',
        ],
    ],
    'user' => [
        'account' => [
            'email-changed' => 'Changement d\'adresse e-mail de :old à :new',
            'password-changed' => 'Changement de mot de passe',
            'username-changed' => 'Changement de nom d\'utilisateur de :old à :new',
        ],
        'api-key' => [
            'create' => 'Création d\'une nouvelle clé API :identifier',
            'delete' => 'Suppression de la clé API :identifier',
        ],
        'ssh-key' => [
            'create' => 'Ajout de la clé SSH :fingerprint au compte',
            'delete' => 'Suppression de la clé SSH :fingerprint du compte',
        ],
        'two-factor' => [
            'create' => 'Activation de l\'authentification à deux facteurs',
            'delete' => 'Désactivation de l\'authentification à deux facteurs',
        ],
        'store' => [
            'resource-purchase' => 'Achat d\'une ressource',
        ],
    ],

    'server' => [
        'reinstall' => 'Réinstallation du serveur',
        'console' => [
            'command' => 'Exécution de la commande ":command" sur le serveur',
        ],
        'power' => [
            'start' => 'Démarrage du serveur',
            'stop' => 'Arrêt du serveur',
            'restart' => 'Redémarrage du serveur',
            'kill' => 'Arrêt forcé du processus du serveur',
        ],
        'backup' => [
            'download' => 'Téléchargement de la sauvegarde :name',
            'delete' => 'Suppression de la sauvegarde :name',
            'restore' => 'Restauration de la sauvegarde :name (fichiers supprimés : :truncate)',
            'restore-complete' => 'Restauration terminée de la sauvegarde :name',
            'restore-failed' => 'Échec de la restauration de la sauvegarde :name',
            'start' => 'Lancement d\'une nouvelle sauvegarde :name',
            'complete' => 'Marquage de la sauvegarde :name comme terminée',
            'fail' => 'Marquage de la sauvegarde :name comme échouée',
            'lock' => 'Verrouillage de la sauvegarde :name',
            'unlock' => 'Déverrouillage de la sauvegarde :name',
        ],
        'database' => [
            'create' => 'Création de la nouvelle base de données :name',
            'rotate-password' => 'Rotation du mot de passe de la base de données :name',
            'delete' => 'Suppression de la base de données :name',
        ],
        'file' => [
            'compress_one' => 'Compression de :directory:file',
            'compress_other' => 'Compression de :count fichiers dans :directory',
            'read' => 'Affichage du contenu de :file',
            'copy' => 'Création d\'une copie de :file',
            'create-directory' => 'Création du répertoire :directory:name',
            'decompress' => 'Décompression de :files dans :directory',
            'delete_one' => 'Suppression de :directory:files.0',
            'delete_other' => 'Suppression de :count fichiers dans :directory',
            'download' => 'Téléchargement de :file',
            'pull' => 'Téléchargement d\'un fichier distant depuis :url vers :directory',
            'rename_one' => 'Renommage de :directory:files.0.de en :directory:files.0.vers',
            'rename_other' => 'Renommage de :count fichiers dans :directory',
            'write' => 'Ajout d\'un nouveau contenu dans :file',
            'upload' => 'Démarrage d\'un téléversement de fichier',
            'uploaded' => 'Téléversement de :directory:file',
        ],
        'sftp' => [
            'denied' => 'Accès SFTP bloqué en raison des autorisations',
            'create_one' => 'Création de :files.0',
            'create_other' => 'Création de :count nouveaux fichiers',
            'write_one' => 'Modification du contenu de :files.0',
            'write_other' => 'Modification du contenu de :count fichiers',
            'delete_one' => 'Suppression de :files.0',
            'delete_other' => 'Suppression de :count fichiers',
            'create-directory_one' => 'Création du répertoire :files.0',
            'create-directory_other' => 'Création de :count répertoires',
            'rename_one' => 'Renommage de :files.0.de en :files.0.vers',
            'rename_other' => 'Renommage ou déplacement de :count fichiers',
        ],
        'allocation' => [
            'create' => 'Ajout de :allocation au serveur',
            'notes' => 'Mise à jour des notes pour :allocation de ":old" à ":new"',
            'primary' => 'Définition de :allocation comme allocation principale du serveur',
            'delete' => 'Suppression de l\'allocation :allocation',
        ],
        'schedule' => [
            'create' => 'Création de la planification :name',
            'update' => 'Mise à jour de la planification :name',
            'execute' => 'Exécution manuelle de la planification :name',
            'delete' => 'Suppression de la planification :name',
        ],
        'task' => [
            'create' => 'Création d\'une nouvelle tâche ":action" pour la planification :name',
            'update' => 'Mise à jour de la tâche ":action" pour la planification :name',
            'delete' => 'Suppression d\'une tâche de la planification :name',
        ],
        'settings' => [
            'rename' => 'Renommage du serveur de :old en :new',
            'description' => 'Changement de la description du serveur de :old en :new',
        ],
        'startup' => [
            'edit' => 'Modification de la variable :variable de ":old" à ":new"',
            'image' => 'Mise à jour de l\'image Docker du serveur de :old à :new',
        ],
        'subuser' => [
            'create' => 'Ajout de :email en tant que sous-utilisateur',
            'update' => 'Mise à jour des permissions du sous-utilisateur :email',
            'delete' => 'Suppression de :email en tant que sous-utilisateur',
        ],
    ],
];