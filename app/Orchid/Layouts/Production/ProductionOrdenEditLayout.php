<?php

namespace App\Orchid\Layouts\Production;

use App\Models\DescriptionPart;
use Carbon\Carbon;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

class ProductionOrdenEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Group::make([
                // Campo para seleccionar fecha
                Input::make('production_date')
                    ->title('Fecha de Producción')
                    ->type('date')
                    ->required(),
            ]),
            // Matrix para agregar productos a la orden
            Matrix::make('products')
                ->title('Productos')
                ->columns(['Número Hoja de Resorte' => 'idDescriptionParts', 'Descripción' => 'description', 'Cantidad' => 'quantity'])
                ->fields([
                    'idDescriptionParts' => Select::make('idDescriptionParts')
                        ->fromModel(DescriptionPart::class, 'code', 'id')
                        ->empty('Seleccione una opción')
                        ->required()
                        ->searchable()
                        ->set('class', 'form-select'),
                    'description' => TextArea::make()
                        ->type('text')
                        ->required(),
                    'quantity' => Input::make()
                        ->type('number')
                        ->required(),
                ])
        ];
    }
}