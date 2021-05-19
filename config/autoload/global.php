<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'session_config' => [
        'cookie_lifetime' => 3600,
        'gc_maxlifetime' => 2592000,
    ],
    'session_manager' => [
        'validators' => [
            0 => 'Laminas\\Session\\Validator\\RemoteAddr',
            1 => 'Laminas\\Session\\Validator\\HttpUserAgent',
        ],
    ],
    'session_storage' => [
        'type' => 'Laminas\\Session\\Storage\\SessionArrayStorage',
    ],
    'caches' => [
        'FilesystemCache' => [
            'adapter' => [
                'name' => 'Laminas\\Cache\\Storage\\Adapter\\Filesystem',
                'options' => [
                    'cache_dir' => './data/cache',
                    'ttl' => 3600,
                ],
            ],
            'plugins' => [
                0 => [
                    'name' => 'serializer',
                    'options' => [],
                ],
            ],
        ],
    ],
    'doctrine' => [
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name' => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table' => 'migrations',
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'file_manager' => [
                //'upload_dir' => '/home/airkomcms/public_html/v2/public/uploads',
                //'logger' => "/home/airkomcms/public_html/v2/error_log.txt",
				'upload_dir' => 'c:/wamp64/www/airkomcms/public/uploads',
				'logger' => "c:/wamp64/www/airkomcms/public/error_log.txt",
            ],
        ],
    ],
];
