<?php

namespace Hanafalah\ModuleMedicService\Schemas;

use Hanafalah\ModuleMedicService\Contracts;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleMedicService\Contracts\Data\ServiceClusterData;

class ServiceCluster extends MedicService implements Contracts\Schemas\ServiceCluster
{
    protected string $__entity = 'ServiceCluster';
    public static $service_cluster_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    public function prepareStoreServiceCluster(ServiceClusterData $service_cluster_dto): Model{
        $service_cluster = $this->prepareStoreMedicService($service_cluster_dto);
        return static::$service_cluster_model = $service_cluster;
    }
}
