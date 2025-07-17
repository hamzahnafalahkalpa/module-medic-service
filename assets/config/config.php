<?php

use Hanafalah\ModuleMedicService as ModuleMedicService;

return [
    'namespace' => 'Hanafalah\\ModuleMedicService',
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
            
        ]
    ],
    'commands' => [
        ModuleMedicService\Commands\InstallMakeCommand::class
    ]
];
