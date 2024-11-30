<?php declare(strict_types=1);

use App\Http\Controllers\BujeLCController;
use App\Http\Controllers\BujeLLController;
use App\Http\Controllers\ModeloVehiculoController;
use App\Http\Controllers\PkglistController;
use App\Http\Controllers\TipoHojaVehiculoController;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PackingList\PackingListEditBarraPlanaScreen;
use App\Orchid\Screens\PackingList\PackingListEditScreen;
use App\Orchid\Screens\PackingList\PackingListScreen;
use App\Orchid\Screens\PackingList\PackingListScreenLegend;
use App\Orchid\Screens\Production\ProductionOrdenDetailListScreen;
use App\Orchid\Screens\Production\ProductionOrdenEditScreen;
use App\Orchid\Screens\Production\ProductionOrdenListScren;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\PlatformScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use \App\Http\Controllers\CodigoHojaController;

/*
 * |--------------------------------------------------------------------------
 * | Dashboard Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the need "dashboard" middleware group. Now create something great!
 * |
 */

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn(Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn(Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

// Ruta para obtener el token CSRF
Route::get('obtener-csrf-token', function () {
    return response()->json([
        'csrfToken' => csrf_token(),
    ]);
});

// Rutas para obtener imágenes
Route::get('obtener-imagen-tipo-hoja/{id}', [TipoHojaVehiculoController::class, 'obtenerImagenTipoHoja']);
Route::get('obtener-imagen-buje-lc/{id}', [BujeLCController::class, 'obtenerImagenBujeLC']);
Route::get('obtener-imagen-buje-ll/{id}', [BujeLLController::class, 'obtenerImagenBujeLL']);

// Ruta para formar el codigo en Hoja de Resortes
Route::get('obtener-codigo-tipo-vehiculo/{id}', [CodigoHojaController::class, 'obtenerCodigoTipoVehiculo']);

// Rutas para obtener la descripción en la Hoja de Resortes
Route::get('obtener-material-combinado-material/{id}', [CodigoHojaController::class, 'obtenerMaterialCombinadoMaterial']);
Route::get('obtener-inches-material-grapa/{id}', [CodigoHojaController::class, 'obtenerInchesMaterialGrapa']);
Route::get('obtener-nombre-corto-vehiculo/{id}', [CodigoHojaController::class, 'obtenerNombreCortoVehiculo']);

// Platform > Órdenes de Producción > Crear
Route::screen('production-orders/create', ProductionOrdenEditScreen::class)
    ->name('platform.production.orders.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.production.orders')
        ->push(__('Crear'), route('platform.production.orders.create')));

// Platform > Órdenes de Producción > Editar
Route::screen('production-orders/{order}/edit', ProductionOrdenEditScreen::class)
    ->name('platform.production.orders.edit')
    ->breadcrumbs(fn(Trail $trail, $order) => $trail
        ->parent('platform.production.orders')
        ->push('Editar', route('platform.production.orders.edit', $order)));

// Platform > Órdenes de Producción
Route::screen('production-orders', ProductionOrdenListScren::class)
    ->name('platform.production.orders')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->push('Inicio', route('platform.main'))
        ->push('Órdenes de Producción', route('platform.production.orders')));

// Platform > Órdenes de Producción > Detalle
Route::screen('production-orders/{id}', ProductionOrdenDetailListScreen::class)
    ->name('platform.production.orders.detail')
    ->breadcrumbs(fn(Trail $trail, $id) => $trail
        ->parent('platform.production.orders')
        ->push('Detalle Órdenes de Producción', route('platform.production.orders.detail', $id)));

// Platform > Packing List
Route::screen('packing-list', PackingListScreen::class)
    ->name('platform.packing.list')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->push('Inicio', route('platform.main'))
        ->push('Packing List', route('platform.packing.list')));

// Platform > Packing List > Crear
Route::screen('packing-list/create', PackingListEditScreen::class)
    ->name('platform.packing.list.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.packing.list')
        ->push(__('Crear Barra Redonda'), route('platform.packing.list.create')));

// Platform > Packing List > Crear
Route::screen('packing-list/create_p', PackingListEditBarraPlanaScreen::class)
    ->name('platform.packing.list.create.p')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.packing.list')
        ->push(__('Crear Barra Plana'), route('platform.packing.list.create.p')));

// Platform > Packing List > Editar
Route::screen('packing-list/{pkglist}/edit', PackingListEditScreen::class)
    ->name('platform.packing.list.edit')
    ->breadcrumbs(fn(Trail $trail, $pkglist) => $trail
        ->parent('platform.packing.list')
        ->push('Editar', route('platform.packing.list.edit', $pkglist)));

// Platform > Packing List > Ver
Route::screen('packing-list/{pkglist}/show', PackingListScreenLegend::class)
    ->name('platform.packing.list.show')
    ->breadcrumbs(fn(Trail $trail, $pkglist) => $trail
        ->parent('platform.packing.list')
        ->push('Ver', route('platform.packing.list.show', $pkglist)));

// Imports & Exports
Route::get('packing-list/export-excel', [PkglistController::class, 'export_excel'])->name('export.excel');

// Obtener el modelo del vehiculo
Route::get('obtener-vehiculos/{vehiculoId}', [ModeloVehiculoController::class, 'getModelos']);