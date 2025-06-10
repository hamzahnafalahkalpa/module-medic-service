<?php

namespace Hanafalah\ModuleMedicService\Contracts\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleMedicService\Contracts\Data\ServiceClusterData;

/**
 * @see \Hanafalah\ModuleMedicService\Schemas\ServiceCluster
 * @method self conditionals(mixed $conditionals)
 * @method bool deleteServiceCluster()
 * @method bool prepareDeleteServiceCluster(? array $attributes = null)
 * @method mixed getServiceCluster()
 * @method ?Model prepareShowServiceCluster(?Model $model = null, ?array $attributes = null)
 * @method array showServiceCluster(?Model $model = null)
 * @method Collection prepareViewServiceClusterList()
 * @method array viewServiceClusterList()
 * @method LengthAwarePaginator prepareViewServiceClusterPaginate(PaginateData $paginate_dto)
 * @method array viewServiceClusterPaginate(?PaginateData $paginate_dto = null)
 * @method array storeServiceCluster(?ServiceClusterData $service_cluster_dto = null)
 * @method Builder serviceCluster(mixed $conditionals = null)
 */
interface ServiceCluster extends MedicService
{
    public function prepareStoreServiceCluster(ServiceClusterData $service_cluster_dto): Model;
}
