<?php

namespace App\Orchid\Screens\Production;

use App\Models\ProductionOrden;
use App\Models\Status;
use App\Orchid\Layouts\Production\ProductionOrdenListLayout;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class ProductionOrdenListScren extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    /*   public function query(): iterable
      {
          return [
              'productionOrders' => ProductionOrden::paginate(10),  // Paginación de 10 órdenes por página
          ];
      } */

    public function query(): iterable
    {
        $startDate = Carbon::now()->subMonth();  // Fecha de inicio (hace un mes)
        $endDate = Carbon::now();  // Fecha de fin (hoy)

        return [
            'productionOrders' => ProductionOrden::whereBetween('production_date', [$startDate, $endDate])
                ->orderBy('production_date', 'desc')  // Orden descendente por fecha de producción
                ->paginate(10),  // Paginación de 10 órdenes por página
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Orden de Producción';
    }

    /**
     * Get the label for the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        // Este método define el nombre que aparecerá en el menú para este recurso.
        return __('Ordenes de Producción');
    }

    /**
     * Get a brief description of the resource.
     *
     * This method provides a short summary of the functionality and purpose
     * of the resource. It helps users understand what they can expect from
     * this section of the application.
     *
     * @return string|null A brief description of the resource or null if not applicable.
     */
    public function description(): ?string
    {
        return 'Visualiza y gestiona las órdenes de producción existentes en el sistema.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Crear'))
                ->icon('bs.check-circle')
                ->type(Color::PRIMARY)
                ->method('createOrder'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProductionOrdenListLayout::class,
        ];
    }

    /**
     * Redirige a la pantalla de creación de una nueva orden de producción.
     *
     * Este método se utiliza para navegar a la página donde se puede crear
     * una nueva orden de producción dentro del sistema. Al ser invocado,
     * redirige al usuario a la ruta definida para la creación de órdenes de
     * producción.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrder()
    {
        return redirect()->route('platform.production.orders.create');
    }

    /**
     * Process the production order.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(int $id)
    {
        $orden = ProductionOrden::find(id: $id);

        // Mostrar un mensaje toast de éxito
        Toast::info("Orden de producción #{$orden->numero_orden} procesada con éxito.");

        // Redirigir a la misma página o a otra según sea necesario
        return redirect()->route('platform.production.orders');
    }

    /**
     * Cancel the production order.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(int $id)
    {
        // Obtener el ID del estado "Cancelado" de la tabla statuses
        $canceladoStatusId = Status::where('name', 'Cancelado')->value('id');

        // Actualizar la orden al nuevo estado
        $orden = ProductionOrden::find(id: $id);

        if ($orden) {
            $orden->status_id = $canceladoStatusId;
            $orden->save();

            // Mostrar el número de orden en el mensaje de éxito
            Toast::info("Orden de producción #{$orden->numero_orden} cancelada con éxito.");
        } else {
            // Mostrar un mensaje de error si la orden no se encuentra
            Toast::error("La orden de producción #{$id} no fue encontrada.");
        }

        // Redirigir a la página de órdenes de producción
        return redirect()->route('platform.production.orders');
    }
}
