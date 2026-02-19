# CLAUDE.md - Module Medic Service

This file provides guidance to Claude Code when working with the `hanafalah/module-medic-service` package.

## Module Overview

`module-medic-service` is a Laravel package that provides medical service type management for healthcare facilities (clinics, puskesmas). It handles the definition and categorization of medical service types such as outpatient, inpatient, emergency, laboratory, radiology, pharmacy, and other healthcare departments.

**Namespace:** `Hanafalah\ModuleMedicService`

**Dependencies:**
- `hanafalah/laravel-support` - Base support utilities, traits, and Unicode schema
- `hanafalah/module-service` - Service management integration (pricing, items)

## WARNING: Memory Issues with ServiceProvider

This module's ServiceProvider uses `registers(['*'])` which can cause memory exhaustion issues. The current implementation:

```php
public function register()
{
    $this->registerMainClass(ModuleMedicService::class)
        ->registerCommandService(Providers\CommandServiceProvider::class)
        ->registers([
            '*'
        ]);
}
```

**Important Notes:**
- As of laravel-support v2.0, `registers(['*'])` only registers SAFE methods: `Config, Model, Database, Migration, Route, Namespace, Provider`
- The dangerous methods (`Schema`, `Services`) are excluded from `'*'` by default
- If you need to explicitly register Schema classes, use `->registers(['Schema'])` but be aware of memory implications

**If experiencing memory issues:**
1. Remove `registers(['*'])` from the ServiceProvider
2. Register only what you need explicitly
3. Use deferred singleton bindings with closures

## Directory Structure

```
module-medic-service/
├── assets/
│   ├── config/
│   │   └── config.php              # Module configuration
│   └── database/
│       └── migrations/             # Database migrations (empty - uses unicodes table)
├── src/
│   ├── Commands/
│   │   ├── EnvironmentCommand.php  # Base command class
│   │   └── InstallMakeCommand.php  # Install command
│   ├── Concerns/
│   │   └── HasService.php          # Trait for service relationship
│   ├── Contracts/
│   │   ├── Data/
│   │   │   ├── MedicServiceData.php
│   │   │   └── ServiceClusterData.php
│   │   ├── Schemas/
│   │   │   ├── MedicService.php
│   │   │   └── ServiceCluster.php
│   │   └── ModuleMedicService.php  # Main contract
│   ├── Data/
│   │   ├── MedicServiceData.php    # DTO for medic services
│   │   └── ServiceClusterData.php  # DTO for service clusters
│   ├── Enums/
│   │   ├── Label.php               # Service type labels (RAWAT JALAN, UGD, etc.)
│   │   └── Status.php              # ACTIVE, INACTIVE
│   ├── Models/
│   │   ├── MedicService.php        # Main model (uses unicodes table)
│   │   └── ServiceCluster.php      # Cluster model (extends MedicService)
│   ├── Providers/
│   │   └── CommandServiceProvider.php
│   ├── Resources/
│   │   ├── MedicService/
│   │   │   ├── ShowMedicService.php
│   │   │   └── ViewMedicService.php
│   │   └── ServiceCluster/
│   │       ├── ShowServiceCluster.php
│   │       └── ViewServiceCluster.php
│   ├── Schemas/
│   │   ├── MedicService.php        # Business logic for medic services
│   │   └── ServiceCluster.php      # Business logic for clusters
│   ├── ModuleMedicService.php      # Main package class
│   └── ModuleMedicServiceServiceProvider.php
└── composer.json
```

## Core Concepts

### Unicode-Based Architecture

This module extends the Unicode pattern from `laravel-support`. All medic services are stored in the shared `unicodes` table using the `flag` column to differentiate record types:

- `MedicService` records have `flag = 'MedicService'`
- `ServiceCluster` records have `flag = 'ServiceCluster'`

This allows for flexible categorization while sharing a common data structure.

### Service Integration

Each MedicService can optionally create an associated `Service` record (from `module-service`) for pricing and billing purposes. This is controlled by the `isUsingService()` method on the model:

```php
class MedicService extends Unicode
{
    public function isUsingService(): bool
    {
        return true;  // Auto-creates Service record
    }
}
```

## Core Models

### MedicService

The main model representing a medical service category/type.

**Table:** `unicodes` (shared with other Unicode-based entities)

**Key Fields (inherited from Unicode):**
- `id` (ULID) - Primary key
- `parent_id` - For hierarchical structures
- `flag` - Set to `'MedicService'`
- `label` - Human-readable label
- `name` - Service name
- `status` - ACTIVE or INACTIVE
- `ordering` - Display order
- `props` - JSON metadata

**Resources:**
- `ViewMedicService` - List/index representation
- `ShowMedicService` - Detail representation

### ServiceCluster

A specialized type of MedicService for grouping services into clusters (e.g., KLUSTER 2, KLUSTER 3 for patient visits).

**Table:** `unicodes`

**Key Fields:**
- Same as MedicService but with `flag = 'ServiceCluster'`

**Special Behavior:**
When `request()->is_for_visit_patient` is set, only returns clusters with labels 'KLUSTER 2' or 'KLUSTER 3'.

## Enums

### Label Enum

Defines standard healthcare service type labels used in Indonesian healthcare facilities:

```php
enum Label: string
{
    case OUTPATIENT         = 'RAWAT JALAN';      // Outpatient
    case MCU                = 'MCU';              // Medical Check-Up
    case INPATIENT          = 'RAWAT INAP';       // Inpatient
    case VERLOS_KAMER       = 'VK';               // Delivery Room
    case OPERATING_ROOM     = 'OR';               // Operating Room
    case EMERGENCY_UNIT     = 'UGD';              // Emergency Department
    case ICU                = 'ICU';              // Intensive Care Unit
    case NICU               = 'NICU';             // Neonatal ICU
    case LABORATORY         = 'LABORATORIUM';     // Laboratory
    case PATHOLOGY_CLINIC   = 'PATOLOGI KLINIK';  // Clinical Pathology
    case PATHOLOGY_ANATOMY  = 'PATOLOGI ANATOMI'; // Anatomical Pathology
    case RADIOLOGY          = 'RADIOLOGI';        // Radiology
    case ADMINISTRATION     = 'ADMINISTRASI';     // Administration
    case PHARMACY           = 'FARMASI';          // Pharmacy
    case PHARMACY_UNIT      = 'INSTALASI FARMASI';// Pharmacy Unit
    case TREATMENT_ROOM     = 'RUANG TINDAKAN';   // Treatment Room
    case MEDICAL_RECORD     = 'MEDICAL RECORD';   // Medical Records
    case PUSKESMAS_PEMBANTU = 'PUSKESMAS PEMBANTU'; // Auxiliary Health Center
    case POSYANDU           = 'POSYANDU';         // Community Health Post
    case SURVEILLANCE       = 'SURVEILLANCE';     // Health Surveillance
    case OTHER              = 'OTHER';            // Other
}
```

### Status Enum

```php
enum Status: string
{
    case ACTIVE   = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
```

## Schemas (Business Logic)

### MedicService Schema

Located at `src/Schemas/MedicService.php`. Extends the Unicode schema.

**Key Methods:**

```php
// Store/update a medic service
public function prepareStoreMedicService(MedicServiceData $medic_service_dto): Model

// Update with tariff components
public function prepareUpdateMedicService(?array $attributes = null): Model

// Query builder for medic services
public function medicService(mixed $conditionals = null): Builder
```

**Update Flow:**
1. Validates service ID is present
2. Updates status on both Service and MedicService records
3. Creates/updates price components via `price_component` schema
4. Deletes price components if `tariff_components` is empty

### ServiceCluster Schema

Extends MedicService schema with cluster-specific behavior.

**Key Methods:**

```php
// Store a service cluster
public function prepareStoreServiceCluster(ServiceClusterData $service_cluster_dto): Model

// Query builder with visit patient filtering
public function serviceCluster(mixed $conditionals = null): Builder
```

## Data Transfer Objects

### MedicServiceData

```php
use Hanafalah\ModuleMedicService\Data\MedicServiceData;

$dto = MedicServiceData::from([
    'name' => 'Rawat Jalan',
    'label' => 'RAWAT JALAN',
    'status' => 'ACTIVE',
    // flag defaults to 'MedicService' via before() hook
]);
```

### ServiceClusterData

```php
use Hanafalah\ModuleMedicService\Data\ServiceClusterData;

$dto = ServiceClusterData::from([
    'name' => 'Kluster 2',
    'label' => 'KLUSTER 2',
    'status' => 'ACTIVE',
    // flag defaults to 'ServiceCluster' via before() hook
]);
```

## Traits

### HasService Trait

Located at `src/Concerns/HasService.php`. Adds service relationship to models.

```php
use Hanafalah\ModuleMedicService\Concerns\HasService;

class MyModel extends Model
{
    use HasService;

    // Provides: service() morphOne relationship
}
```

**Note:** This initializes `ServiceModel::setIdentityFlags()` which may be used for filtering.

## Configuration

### config/module-medic-service.php

```php
return [
    'namespace' => 'Hanafalah\\ModuleMedicService',
    'app' => [
        'contracts' => [
            // Custom contract bindings
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
            // Custom model bindings
        ]
    ],
    'commands' => [
        Commands\InstallMakeCommand::class
    ]
];
```

## Usage Examples

### Creating a MedicService

```php
use Hanafalah\ModuleMedicService\Contracts\Schemas\MedicService as MedicServiceContract;
use Hanafalah\ModuleMedicService\Data\MedicServiceData;

$schema = app(MedicServiceContract::class);

$dto = MedicServiceData::from([
    'name' => 'Unit Gawat Darurat',
    'label' => 'UGD',
    'status' => 'ACTIVE',
    'ordering' => 1,
]);

$medicService = $schema->prepareStoreMedicService($dto);
```

### Creating a ServiceCluster

```php
use Hanafalah\ModuleMedicService\Contracts\Schemas\ServiceCluster as ServiceClusterContract;
use Hanafalah\ModuleMedicService\Data\ServiceClusterData;

$schema = app(ServiceClusterContract::class);

$dto = ServiceClusterData::from([
    'name' => 'Kluster 2 - Penyakit Ringan',
    'label' => 'KLUSTER 2',
    'status' => 'ACTIVE',
]);

$cluster = $schema->prepareStoreServiceCluster($dto);
```

### Querying MedicServices

```php
use Hanafalah\ModuleMedicService\Contracts\Schemas\MedicService as MedicServiceContract;

$schema = app(MedicServiceContract::class);

// Get all medic services
$services = $schema->medicService()->get();

// With conditionals
$services = $schema->medicService(['status' => 'ACTIVE'])->get();

// Paginated view
$paginated = $schema->viewMedicServicePaginate();
```

### Updating with Tariff Components

```php
$schema = app(MedicServiceContract::class);

$updated = $schema->prepareUpdateMedicService([
    'id' => $serviceId,
    'status' => 'ACTIVE',
    'tariff_components' => [
        ['component_id' => 1, 'amount' => 50000],
        ['component_id' => 2, 'amount' => 25000],
    ]
]);
```

## Artisan Commands

### medic-service:install

Publishes migrations to the application's database directory.

```bash
php artisan medic-service:install
```

## Integration with Wellmed

This module integrates with:
- **module-service** - Creates Service records for pricing and billing
- **EMR modules** - Service types for patient visits and encounters
- **POS modules** - Service categorization for billing
- **Klinik Starterpack** - Used across all clinic configurations

## Octane Considerations

When running under Laravel Octane:
- Schema instances are resolved fresh per request via contracts
- No static state is stored in Schema classes
- The Unicode base model uses dynamic resolution via `morphOneModel()` helper
- Cache tags (`unicode`) are used for index caching with `forgetTags()` on updates

## Common Patterns

### Hierarchical Services

```php
// Parent service
$parentDto = MedicServiceData::from([
    'name' => 'Rawat Jalan',
    'label' => 'RAWAT JALAN',
    'status' => 'ACTIVE',
]);
$parent = $schema->prepareStoreMedicService($parentDto);

// Child service
$childDto = MedicServiceData::from([
    'parent_id' => $parent->id,
    'name' => 'Poli Umum',
    'label' => 'POLI UMUM',
    'status' => 'ACTIVE',
]);
$child = $schema->prepareStoreMedicService($childDto);
```

### Service with Associated Pricing

When `isUsingService()` returns true, the Unicode schema automatically creates a Service record:

```php
$dto = MedicServiceData::from([
    'name' => 'Laboratorium',
    'label' => 'LABORATORIUM',
    'status' => 'ACTIVE',
    'service' => [  // Optional - auto-created if isUsingService() is true
        'price' => 100000,
        'cogs' => 50000,
    ]
]);

$medicService = $schema->prepareStoreMedicService($dto);
$service = $medicService->service;  // Access the linked Service
```

## Database Notes

- **No dedicated migrations** - Uses the shared `unicodes` table from `laravel-support`
- Records are differentiated by the `flag` column
- The `props` JSON column stores additional metadata including `prop_service` for linked service data
- Uses ULID for primary keys

## Modification Checklist

Before modifying this module:

- [ ] Understand the Unicode base class behavior
- [ ] Don't break the `flag` column conventions ('MedicService', 'ServiceCluster')
- [ ] Test with `module-service` integration (price components, service creation)
- [ ] Verify Octane compatibility (no static state)
- [ ] Run cache clear after changes: `php artisan cache:clear`
- [ ] Test with multiple tenants if applicable
