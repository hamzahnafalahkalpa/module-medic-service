<?php

namespace Hanafalah\ModuleMedicService\Data;

use Hanafalah\ModuleMedicService\Contracts\Data\ServiceClusterData as DataServiceClusterData;
class ServiceClusterData extends MedicServiceData implements DataServiceClusterData{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'ServiceCluster';
        parent::before($attributes);
    }
}