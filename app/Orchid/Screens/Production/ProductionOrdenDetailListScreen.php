<?php

namespace App\Orchid\Screens\Production;

use App\Models\ProductionOrdenDetail;
use App\Orchid\Layouts\Production\ProductionOrdenDetailListLayout;
use Orchid\Screen\Screen;

class ProductionOrdenDetailListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query($id): iterable
    {
        // Consulta los detalles de la orden de producción filtrando por el ID de la orden
        $productionOrdenDetails = ProductionOrdenDetail::where('production_order_id', $id)->get();

        // Pasamos los datos al layout, con el nombre de clave 'productionOrderDetails'
        return [
            'productionOrdenDetails' => $productionOrdenDetails,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Detalle Orden de Producción';
    }

    /**
     * Get the label for the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        // Este método define el nombre que aparecerá en el menú para este recurso.
        return __('Detalle Orden de Producción');
    }

    public function description(): ?string
    {
        return 'Visualiza y gestiona el detalle de las órdenes de producción existentes en el sistema.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProductionOrdenDetailListLayout::class,
        ];
    }
}
