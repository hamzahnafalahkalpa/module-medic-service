<?php

namespace Hanafalah\ModuleMedicService\Resources\ServiceCluster;

use Hanafalah\ModuleMedicService\Resources\MedicService\ShowMedicService;
use Hanafalah\ModuleMedicService\Resources\ServiceCluster\ViewServiceCluster;
use Illuminate\Http\Request;

class ShowServiceCluster extends ViewServiceCluster
{
    public function toArray(Request $request): array
    {
        $arr = [
        ];
        $show = $this->resolveNow(new ShowMedicService($this));
        $arr = $this->mergeArray(parent::toArray($request), $show, $arr);
        return $arr;
    }
}
