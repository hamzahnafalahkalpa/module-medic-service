<?php

namespace Hanafalah\ModuleMedicService\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleMedicService\Contracts\Data\MedicServiceData;
use Illuminate\Database\Eloquent\Builder;

/**
 * @see \Hanafalah\ModuleMedicService\Schemas\MedicService
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method bool deleteMedicService()
 * @method bool prepareDeleteMedicService(? array $attributes = null)
 * @method mixed getMedicService()
 * @method ?Model prepareShowMedicService(?Model $model = null, ?array $attributes = null)
 * @method array showMedicService(?Model $model = null)
 * @method Collection prepareViewMedicServiceList()
 * @method array viewMedicServiceList()
 * @method LengthAwarePaginator prepareViewMedicServicePaginate(PaginateData $paginate_dto)
 * @method array viewMedicServicePaginate(?PaginateData $paginate_dto = null)
 * @method array storeMedicService(?MedicServiceData $medic_service_dto = null)
 */
interface MedicService extends Unicode
{
    public function prepareUpdateMedicService(?array $attributes = null): Model;
    public function prepareStoreMedicService(MedicServiceData $medic_service_dto): Model;
    public function medicService(mixed $conditionals = null): Builder;
}
