<?php

namespace Hanafalah\ModuleMedicService\Models;

use Hanafalah\ModuleMedicService\Resources\ServiceCluster\{ViewServiceCluster, ShowServiceCluster};

class ServiceCluster extends MedicService
{
    protected $table = 'unicodes';

    public function getViewResource(){
        return ViewServiceCluster::class;
    }

    public function getShowResource(){
        return ShowServiceCluster::class;
    }
}
