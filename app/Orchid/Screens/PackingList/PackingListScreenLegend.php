<?php

namespace App\Orchid\Screens\PackingList;

use App\Models\pkglist;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class PackingListScreenLegend extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $pkglist = null): iterable
    {
        // Obtener el registro de pkglist. Si no se encuentra, devolver null.
        $pkglistData = pkglist::find($pkglist);

        // Si no se encuentra el registro, puedes manejarlo según sea necesario.
        // Por ejemplo, podrías lanzar una excepción o simplemente devolver un arreglo vacío.
        if (!$pkglistData) {
            // Manejo del caso donde el pkglist no existe
            return [
                'pkglist' => null,  // O puedes retornar un arreglo vacío
            ];
        }

        return [
            'pkglist' => $pkglistData,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Packing List';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Visualizar los Packing List asociadas existentes en el sistema';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        // Obtener el ID del pkglist desde la ruta
        $pkglistId = request()->route('pkglist');

        // Verificar que el ID no sea nulo
        if ($pkglistId !== null) {
            return [
                Button::make(__('Editar'))
                    ->icon('bs.check-circle')
                    ->type(Color::PRIMARY)
                    ->method('editRecord', [
                        'id' => $pkglistId  // Enviando el ID del modelo
                    ])
            ];
        }

        // Retornar un arreglo vacío si no hay ID
        return [];
    }

    /**
     * Los elementos de diseño de la pantalla.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            // Leyenda con los detalles del pkglist
            Layout::legend('pkglist', [
                Sight::make('no_contact', 'No Contacto'),
                Sight::make('steel_grande', 'Steel Grande'),
                Sight::make('pkg_Standard', 'Paquete Estándar'),
                Sight::make('DIA', 'DIA'),
                Sight::make('pkg_Lenght', 'Longitud del Paquete'),
                Sight::make('pkg_Weight', 'Peso del Paquete'),
                Sight::make('pkg_Bars', 'Barras en el Paquete'),
                Sight::make('pkg_Bundles', 'Paquetes'),
            ]),
        ];
    }

    /**
     * Edit record method.
     *
     * @param int $id
     */
    public function editRecord(int $id)
    {
        // Redirigir a la ruta de edición con el ID del registro
        return redirect()->route('platform.packing.list.edit', ['pkglist' => $id]);
    }
}
