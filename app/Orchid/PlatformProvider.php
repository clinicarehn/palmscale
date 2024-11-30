<?php declare(strict_types=1);

namespace App\Orchid;

use App\Http\Controllers\VersionController;  // Asegúrate de importar el controlador si es necesario
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            // MapOPRh
            Menu::make('Codigo Hoja de Resortes')
                ->icon('fa.book')
                ->route('platform.resource.list', ['resource' => 'description-part-resources'])
                ->permission('platform.descriptionpart')
                ->title(__('MapOPRh')),
            // Inventario
            Menu::make('Inventario')
                ->icon('fa.book')
                ->route('platform.resource.list', ['resource' => 'inventory-resources'])
                ->permission('platform.inventory')
                ->title(__('Inventario')),
            // Ordenes de Producción
            Menu::make(__('Ordenes de Producción'))
                ->icon('fa.book')
                ->route('platform.production.orders')
                ->permission('platform.production-orden')
                ->title(__('Ordenes de Producción')),
            // Packing List
            Menu::make(__('Packing List'))
                ->icon('fa.book')
                ->route('platform.packing.list')
                ->permission('platform.packing.list')
                ->title(__('Packing List')),
            // CONFIGURACIÓN
            Menu::make('Configuración')
                ->icon('fa.gear')  // Asegúrate de que el nombre del icono sea correcto
                ->title(__('Configuración'))
                ->list([
                    Menu::make('Abrazadera')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'abraz-resources'])
                        ->permission('platform.abraz'),
                    Menu::make('Brios')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'brio-resources'])
                        ->permission(permission: 'platform.brio'),
                    Menu::make('Buje LC')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'buje-l-c-resources'])
                        ->permission('platform.bujelc'),
                    Menu::make('Buje LL')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'buje-l-l-resources'])
                        ->permission('platform.bujell'),
                    Menu::make('Buje RB')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'buje-r-b-resources'])
                        ->permission('platform.bujerb'),
                    Menu::make('Materia Prima')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'material-const-vehiculo-resources'])
                        ->permission('platform.material.const.vehiculo'),
                    Menu::make('Crear Grapa')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'material-grapa-resources'])
                        ->permission('platform.material.grapa'),
                    Menu::make('Modelo Vehiculos')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'modelo-vehiculo-resources'])
                        ->permission('platform.modelo.vehiculo'),
                    Menu::make('Molde')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'molde-resources'])
                        ->permission('platform.molde'),
                    Menu::make('Posicion Vehiculo')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'posicion-vehiculo-resources'])
                        ->permission('platform.posicion.vehiculo'),
                    Menu::make('Referencia Tensado Vehiculo')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'ref-tensado-vehiculo-resources'])
                        ->permission('platform.ref.tensado.vehiculo'),
                    Menu::make('Roleo Long Vehiculo')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'roleo-long-vehiculo-resources'])
                        ->permission('platform.roleo.long.vehiculo'),
                    Menu::make('Tipo Hoja Vehiculo')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'tipo-hoja-vehiculo-resources'])
                        ->permission('platform.tipo.hoja.vehiculos'),
                    Menu::make('Vehiculo')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'vehiculo-resources'])
                        ->permission('platform.vehiculo'),
                    Menu::make('Año Vehiculo')
                        ->icon('fa.book')
                        ->route('platform.resource.list', ['resource' => 'year-vehiculo-resources'])
                        ->permission('platform.year.vehiculo'),
                ])
                ->permission('platform.configuracion'),
            // CONTROL DE ACCESO
            Menu::make(__('Usuarios'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Control de Acceso')),
            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),
            Menu::make('Versión')
                ->icon('bs.box-arrow-up-right')
                ->url('https://github.com/clinicarehn/PalmScale/tree/main/Laravel/CHANGELOG.md')
                ->target('_blank')
                ->badge(fn() => VersionController::getLatestVersionFromChangelog(), Color::DARK)
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Usuarios')),
            ItemPermission::group(__('Fast Solutions - Menus'))
                ->addPermission('platform.configuracion', __('Configuración'))
                ->addPermission('platform.production-orden', __('Oredenes de Producción'))
                ->addPermission('platform.inventory', __('Inventario'))
                ->addPermission('platform.packing.list', __('Packing List')),
            ItemPermission::group(__('Fast Solutions - Sub-Menus'))
                ->addPermission('platform.descriptionpart', __('Codigo Hoja de Resortes'))
                ->addPermission('platform.bujelc', __('Buje LC'))
                ->addPermission('platform.bujell', __('Buje LL'))
                ->addPermission('platform.bujerb', __('Buje RB'))
                ->addPermission('platform.material.const.vehiculo', __('Materia Prima'))
                ->addPermission('platform.material.grapa', __('Crear Grapa'))
                ->addPermission('platform.modelo.vehiculo', __('Modelo Vehiculos'))
                ->addPermission('platform.molde', __('Molde'))
                ->addPermission('platform.posicion.vehiculo', __('Posicion Vehiculo'))
                ->addPermission('platform.ref.tensado.vehiculo', __('Referencia Tensado Vehiculo'))
                ->addPermission('platform.roleo.long.vehiculo', __('Roleo Long Vehiculo'))
                ->addPermission('platform.tipo.hoja.vehiculos', __('Tipo Hoja Vehiculo'))
                ->addPermission('platform.vehiculo', __('Tipo Vehiculo'))
                ->addPermission('platform.year.vehiculo', __('Año Vehiculo'))
                ->addPermission('platform.abraz', __('Abrazaderas'))
                ->addPermission('platform.brio', __('Brios'))
        ];
    }
}
