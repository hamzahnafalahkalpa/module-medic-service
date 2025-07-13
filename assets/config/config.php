<?php

use Hanafalah\ModuleMedicService as ModuleMedicService;

return [
<<<<<<< HEAD
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'database' => [
        'models' => [
            'MedicService' => ModuleMedicService\MedicService::class,
=======
    'namespace' => 'Hanafalah\\ModuleMedicService',
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
>>>>>>> 8174230b31edc09e4a6dc4f051e324df08ff0c0a
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
