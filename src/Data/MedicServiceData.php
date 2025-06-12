<?php

namespace Hanafalah\ModuleMedicService\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleMedicService\Contracts\Data\MedicServiceData as DataMedicServiceData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class MedicServiceData extends Data implements DataMedicServiceData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;
    
    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;
    
    #[MapInputName('flag')]
    #[MapName('flag')]
    public string $flag;

    #[MapInputName('label')]
    #[MapName('label')]
    public ?string $label = null;
    
    #[MapInputName('childs')]
    #[MapName('childs')]
    #[DataCollectionOf(MedicServiceData::class)]
    public array $childs = [];

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = [];

    public static function after(mixed $data): MedicServiceData{
        $data->flag = 'MEDIC_SERVICE';
        return $data;
    }
}