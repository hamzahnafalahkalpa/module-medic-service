<?php

namespace Hanafalah\ModuleMedicService\Models;

use Hanafalah\ModuleMedicService\Resources\ServiceCluster\{ViewServiceCluster, ShowServiceCluster};

class ServiceCluster extends MedicService
{
    protected $table = 'medic_services';

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->where('flag','SERVICE_CLUSTER');
        });
        static::creating(function ($query) {
            $query->flag = 'SERVICE_CLUSTER';
        });
    }

    public function getViewResource(){
        return ViewServiceCluster::class;
    }

    public function getShowResource(){
        return ShowServiceCluster::class;
    }
}
