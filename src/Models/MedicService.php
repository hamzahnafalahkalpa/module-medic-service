<?php

namespace Hanafalah\ModuleMedicService\Models;

use Hanafalah\ModuleMedicService\Enums\Status;
use Hanafalah\ModuleMedicService\Resources\MedicService\{ViewMedicService, ShowMedicService};
use Hanafalah\ModulePatient\Models\Patient\PatientType;

class MedicService extends PatientType
{
    protected $table = 'patient_types';

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->where('flag','MEDIC_SERVICE');
        });
        static::creating(function ($query) {
            $query->flag = 'MEDIC_SERVICE';
        });
    }

    public function viewUsingRelation(): array{
        return ['service'];
    }

    public function showUsingRelation(): array{
        return ['service.priceComponents.tariffComponent'];
    }

    public function getViewResource(){
        return ViewMedicService::class;
    }

    public function getShowResource(){
        return ShowMedicService::class;
    }

    public function scopeActive($builder)
    {
        return $builder->where('props->status', Status::ACTIVE->value);
    }

    public function priceComponent()
    {
        return $this->morphOneModel('PriceComponent', 'model');
    }
    public function priceComponents()
    {
        return $this->morphManyModel('PriceComponent', 'model');
    }
}
