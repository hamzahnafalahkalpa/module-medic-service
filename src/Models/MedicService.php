<?php

namespace Hanafalah\ModuleMedicService\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleMedicService\Enums\Status;
use Hanafalah\ModuleMedicService\Resources\MedicService\{ViewMedicService, ShowMedicService};
use Hanafalah\ModuleService\Concerns\HasService;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicService extends BaseModel
{
    use HasUlids, SoftDeletes, HasProps, HasService;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = ['id', 'parent_id', 'name', 'flag', 'label', 'props'];

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->where('flag','MEDIC_SERVICE');
        });
        static::creating(function ($query) {
            $query->flag = 'MEDIC_SERVICE';
        });
        static::created(function ($query) {
            $parent    = $query->parent;
            $parent_id = null;
            if (isset($parent)) $parent_id = $parent->service->getKey();
            $query->service()->updateOrCreate([
                'parent_id' => $parent_id,
                'name'      => $query->name,
            ], [
                'status' => 'ACTIVE'
            ]);
        });
    }

    public function viewUsingRelation(): array{
        return ['service','childs'];
    }

    public function showUsingRelation(): array{
        return ['service.priceComponents.tariffComponent','childs'];
    }

    public function getViewResource(){
        return ViewMedicService::class;
    }

    public function getShowResource(){
        return ShowMedicService::class;
    }

    public function scopeActive($builder){return $builder->where('props->status', Status::ACTIVE->value);}
    public function priceComponent(){return $this->morphOneModel('PriceComponent', 'model');}
    public function priceComponents(){return $this->morphManyModel('PriceComponent', 'model');}
    public function childs(){return $this->hasMany(self::class, 'parent_id')->with('childs','service');}    
}
