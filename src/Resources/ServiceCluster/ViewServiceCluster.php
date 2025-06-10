<?php

namespace Hanafalah\ModuleMedicService\Resources\ServiceCluster;

use Illuminate\Http\Request;
use Hanafalah\ModuleMedicService\Resources\MedicService\ViewMedicService;

class ViewServiceCluster extends ViewMedicService
{
    public function toArray(Request $request): array
    {
        $arr = [
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}

