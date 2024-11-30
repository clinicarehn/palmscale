<?php

namespace App\Orchid\Layouts\Production;

use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductionOrdenDetailListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'productionOrdenDetails';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            /*             TD::make('id', 'ID')
                            ->sort()
                            ->filter(Input::make()), */
            TD::make('production_order.numero_orden', 'Número de Orden')  // Aquí se agrega la columna para el número de orden
                ->sort()
                ->filter(Input::make())
                ->render(function ($model) {
                    return $model->productionOrder->numero_orden ?? 'N/A';  // Cambia 'numero_orden' por el nombre real del campo en tu tabla de órdenes de producción
                }),
            TD::make('part_id', 'Codigo Hoja de Resorte')
                ->sort()
                ->filter(Input::make()),
            TD::make('description', 'Descripción')
                ->sort()
                ->filter(Input::make()),
            TD::make('quantity', 'Cantidad')
                ->sort()
                ->filter(Input::make()),
            TD::make('quantity_weight', 'Cantidad (Medida)')
                ->sort()
                ->filter(Input::make()),
            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),
            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),
        ];
    }
}
