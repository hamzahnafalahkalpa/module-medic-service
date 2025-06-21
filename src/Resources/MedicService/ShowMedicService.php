<?php

namespace Hanafalah\ModuleMedicService\Resources\MedicService;

use Hanafalah\LaravelSupport\Resources\Unicode\ShowUnicode;
use Illuminate\Http\Request;

class ShowMedicService extends ViewMedicService
{
    public function toArray(Request $request): array
    {
        $arr = [
        ];
        $show = $this->resolveNow(new ShowUnicode($this));
        $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
        return $arr;
    }
}
