<?php

namespace Hanafalah\ModuleMedicService\Data;

use Hanafalah\ModuleMedicService\Contracts\Data\MedicServiceData as DataMedicServiceData;
use Hanafalah\ModulePatient\Data\PatientTypeData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class MedicServiceData extends PatientTypeData implements DataMedicServiceData{
    #[MapInputName('childs')]
    #[MapName('childs')]
    #[DataCollectionOf(MedicServiceData::class)]
    public array $childs = [];

    public static function after(mixed $data): MedicServiceData{
        $data->flag = 'MEDIC_SERVICE';
        return $data;
    }
}