<?php declare(strict_types=1);

const APP_ROOT = __DIR__;

return [
    'settings' => [
        'security' => [
            'jwt_secret' => '24985a4bcbc230e1b3389888b5427231',
            'jwt_issuer' => $_SERVER['SERVER_NAME'] ?? 'localhost',
            'jwt_expires_at' => 3600 //1 hour
        ],
        'slim' => [
            // Returns a detailed HTML page with error details and
            // a stack trace. Should be disabled in production.
            'displayErrorDetails' => true,

            // Whether to display errors on the internal PHP log or not.
            'logErrors' => true,

            // If true, display full errors with message and stack trace on the PHP log.
            // If false, display only "Slim Application Error" on the PHP log.
            // Doesn't do anything when 'logErrors' is false.
            'logErrorDetails' => true,
        ],

        'doctrine' => [
            // Enables or disables Doctrine metadata caching
            // for either performance or convenience during development.
            'dev_mode' => true,

            // Path where Doctrine will cache the processed metadata
            // when 'dev_mode' is false.
            'cache_dir' => APP_ROOT . '/var/doctrine',

            // List of paths where Doctrine will search for metadata.
            // Metadata can be either YML/XML files or PHP classes annotated
            // with comments or PHP8 attributes.
            'metadata_dirs' => [
                APP_ROOT . '/src/Lotr/Infrastructure/config/doctrine',
                APP_ROOT . '/src/Security/Infrastructure/config/doctrine',
            ],

            // The parameters Doctrine needs to connect to your database.
            // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
            // needs a 'path' parameter and doesn't use most of the ones shown in this example).
            // Refer to the Doctrine documentation to see the full list
            // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
            'connection' => [
                'dsn' => 'mysql://root:root@db:3306/lotr?charset=utf8mb4',
            ]
        ],
        'validator' => [
            'paths' => [
                APP_ROOT . '/src/Lotr/Infrastructure/config/validator/validation.yaml',
                APP_ROOT . '/src/Security/Infrastructure/config/validator/validation.yaml'
            ]
        ],
        'cache' => [
            'filesystem_adapter' => [
                'namespace' => '',
                'default_life_time' => 3600,  //1 hour (time in seconds)
                'directory' => APP_ROOT.'/var/cache/dev'
            ]
        ]
    ]
];