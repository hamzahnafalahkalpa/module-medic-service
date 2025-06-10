<?php

namespace Hanafalah\ModuleMedicService\Data;

use Hanafalah\ModuleMedicService\Contracts\Data\ServiceClusterData as DataServiceClusterData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ServiceClusterData extends MedicServiceData implements DataServiceClusterData{
    #[MapInputName('childs')]
    #[MapName('childs')]
    #[DataCollectionOf(ServiceClusterData::class)]
    public array $childs = [];

    public static function after(mixed $data): ServiceClusterData{
        $data->flag = 'SERVICE_CLUSTER';
        return $data;
    }
}