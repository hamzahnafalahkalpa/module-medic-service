<?php

namespace Hanafalah\ModuleMedicService\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModuleMedicService\Contracts\Data\MedicServiceData as DataMedicServiceData;

class MedicServiceData extends UnicodeData implements DataMedicServiceData{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'MedicService';
        parent::before($attributes);
    }
}