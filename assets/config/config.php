<?php

use Hanafalah\ModuleMedicService\Models as ModuleMedicService;

return [
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'database' => [
        'models' => [
            'MedicService' => ModuleMedicService\MedicService::class,
        ]
    ],
];
