<?php

namespace App\Orchid\Layouts\PackingList;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PackingListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'pkglist';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('no_contact', 'No Contacto')
                ->sort()
                ->filter(Input::make()),
            TD::make('steel_grande', 'Steel Grande')
                ->sort()
                ->filter(Input::make()),
            TD::make('pkg_Standard', 'Paquete Estándar')
                ->sort()
                ->filter(Input::make()),
            TD::make('DIA', 'DIA')
                ->sort()
                ->filter(Input::make()),
            TD::make('pkg_Lenght', 'Longitud del Paquete')
                ->sort()
                ->filter(Input::make()),
            TD::make('pkg_Weight', 'Peso del Paquete')
                ->sort()
                ->filter(Input::make()),
            TD::make('pkg_Bars', 'Barras en el Paquete')
                ->sort()
                ->filter(Input::make()),
            TD::make('pkg_Bundles', 'Paquetes')
                ->sort()
                ->filter(Input::make()),
            TD::make('created_at', 'Fecha de creación')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                })
                ->sort()
                ->filter(Input::make()),
            TD::make('updated_at', 'Fecha de actualización')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                })
                ->sort()
                ->filter(Input::make()),
            TD::make('Acciones')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($model) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Ver')
                                ->route('platform.packing.list.show', ['pkglist' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.packing.list.edit', ['pkglist' => $model->id])
                                ->icon('pencil'),
                        ]);
                }),
        ];
    }
}
