<?php

namespace App\Orchid\Layouts\Production;

use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductionOrdenListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'productionOrders';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            /*             TD::make('id')
                            ->sort()
                            ->filter(Input::make()), */
            TD::make('numero_orden', 'Número de Orden')  // Agregar columna para numero_orden
                ->sort()  // Permitir ordenar por este campo
                ->filter(Input::make()),  // Permitir filtrar por este campo
            TD::make('production_date', 'Fecha de Producción')
                ->sort()
                ->filter(Input::make())
                ->render(function ($model) {
                    // Verifica si production_date es un string y conviértelo a Carbon
                    $date = is_string($model->production_date) ? Carbon::parse($model->production_date) : $model->production_date;
                    return $date->toDateTimeString();
                })
                ->usingComponent(DateTimeSplit::class)
                ->sort(),
            TD::make('status_id', 'Estado')
                ->sort()
                ->filter(Input::make())
                ->render(function ($model) {
                    return $model->status ? $model->status->name : 'Desconocido';  // Obtiene el nombre del estado
                }),
            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),
            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),
            TD::make('Acciones')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($model) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Ver Detalles')
                                ->route('platform.production.orders.detail', ['id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.production.orders.edit', ['order' => $model->id])
                                ->icon('pencil'),
                            Button::make('Procesar')
                                ->method('process')
                                ->confirm("¿Estás seguro de que deseas procesar la orden #{$model->numero_orden}?")
                                ->parameters(['id' => $model->id])
                                ->icon('check'),
                            Button::make('Cancelar')
                                ->method('cancel')
                                ->confirm("¿Estás seguro de que deseas cancelar la orden #{$model->numero_orden}?")
                                ->parameters(['id' => $model->id])
                                ->icon('trash'),
                        ]);
                }),
        ];
    }
}
