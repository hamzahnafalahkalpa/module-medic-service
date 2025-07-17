<?php

namespace Hanafalah\ModuleMedicService\Resources\MedicService;

use Illuminate\Http\Request;
use Hanafalah\LaravelSupport\Resources\Unicode\ViewUnicode;

class ViewMedicService extends ViewUnicode
{
    public function toArray(Request $request): array
    {
        $arr = [
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
