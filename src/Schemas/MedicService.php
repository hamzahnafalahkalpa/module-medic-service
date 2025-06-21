<?php

namespace Hanafalah\ModuleMedicService\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\ModuleMedicService\Contracts;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleMedicService\Contracts\Data\MedicServiceData;
use Illuminate\Database\Eloquent\Builder;

class MedicService extends Unicode implements Contracts\Schemas\MedicService
{
    protected string $__entity = 'MedicService';
    public static $medic_service_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected function createPriceComponent($medicService, $service, $attributes){
        $price_component_schema = $this->schemaContract('price_component');
        return $price_component_schema->prepareStorePriceComponent([
            'model_id'          => $medicService->getKey(),
            'model_type'        => $medicService->getMorphClass(),
            'service_id'        => $service->getKey(),
            'tariff_components' => $attributes['tariff_components']
        ]);
    }

    public function prepareUpdateMedicService(?array $attributes = null): Model{
        $attributes ??= \request()->all();

        if (!isset($attributes['id'])) throw new \Exception('MedicService id is required');
        $service = $this->ServiceModel()->findOrFail($attributes['id']);
        $service->status      = $attributes['status'];

        $medicService         = $service->reference;
        $medicService->status = $attributes['status'];

        $medicService->save();
        $service->save();

        if (isset($attributes['tariff_components']) && count($attributes['tariff_components']) > 0) {
            $this->createPriceComponent($medicService, $service, $attributes);
        } else {
            $service->priceComponents()->delete();
        }
        return static::$medic_service_model = $medicService;
    }

    public function prepareStoreMedicService(MedicServiceData $medic_service_dto): Model{
        $medic_service = $this->prepareStoreUnicode($medic_service_dto);
        return static::$medic_service_model = $medic_service;
    }

    public function medicService(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}
