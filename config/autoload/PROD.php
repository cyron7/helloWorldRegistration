<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host' => 'a2plcpnl0705.prod.iad2.secureserver.net',
                    'port' => '3306',
                    'user' => 'helloWorldAppPrx',
                    'password' => 'Stuff5Stuff',
                    'dbname' => 'HelloWorld2',
//                    'user' => 'billDBAdmin',
//                    'password' => 'n//Exm`"7Y[G3>[e',
//                    'dbname' => 'BillManagement',
                ],
            ],
        ],
        'entitymanager' => [
            'orm_default' => [
                'connection' => 'orm_default',
                'configuration' => 'orm_default',
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'hydration_cache' => 'array',
                'generate_proxies' => true,
            ],
        ],

    ],
];
