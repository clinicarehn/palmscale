<?php

namespace App\Orchid\Layouts\PackingList;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

class PackingListRow extends Rows
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
            Input::make('no_contact')
                ->title('No Contacto')
                ->type('text')  // Campo de texto para No Contacto
                ->autofocus()
                ->required(),
            Input::make('steel_grande')
                ->title('Steel Grande')
                ->type('text')  // Campo de texto para Steel Grande
                ->required(),
            Input::make('pkg_Standard')
                ->title('Paquete Estándar')
                ->type('text')  // Campo de texto para Paquete Estándar
                ->required(),
            Input::make('DIA')
                ->title('DIA')
                ->type('number')  // Definir como número para DIA
                ->required(),
            Input::make('pkg_Lenght')
                ->title('Longitud del Paquete')
                ->mask(['alias' => 'decimal', 'groupSeparator' => ',', 'radixPoint' => '.'])
                ->id('pkg_Lenght')
                ->required(),
            Input::make('pkg_Bars')
                ->title('Barras en el Paquete')
                ->type('number')  // Definir como número para las Barras
                ->required(),
            Input::make('pkg_Bundles')
                ->title('Paquetes')
                ->type('text')  // Definir como número para los Paquetes
                ->required(),
            Input::make('pkg_Weight')
                ->title('Peso del Paquete')
                ->type('number')
                ->id('pkg_Weight')
                ->readonly()
                ->required(),
        ];
    }
}
