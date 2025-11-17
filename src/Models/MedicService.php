<?php

namespace Hanafalah\ModuleMedicService\Models;

use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModuleMedicService\Resources\MedicService\{ViewMedicService, ShowMedicService};

class MedicService extends Unicode
{
    protected $table = 'unicodes';

    public function isUsingService(): bool{
        return true;
    }

    public function getViewResource(){
        return ViewMedicService::class;
    }

    public function getShowResource(){
        return ShowMedicService::class;
    }
}
