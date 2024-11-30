<?php

namespace App\Orchid\Screens\PackingList;

use App\Models\pkglist;
use App\Orchid\Layouts\PackingList\PackingListEditBarraPlanaRow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class PackingListEditBarraPlanaScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $pkglist = null): iterable
    {
        $pkgListSelect = [
            'no_contact' => null,
            'steel_grande' => null,
            'pkg_Standard' => null,
            'DIA' => null,
            'pkg_Lenght' => null,
            'pkg_Weight' => null,
            'pkg_Bars' => null,
            'pkg_Bundles' => null,
        ];

        if ($pkglist) {
            try {
                // Obtener el registro de pkglist por su ID
                $pkgListValue = pkglist::findOrFail($pkglist);
                $pkgListSelect = array_merge($pkgListSelect, $pkgListValue->toArray());
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                // Manejo del error si el registro no es encontrado
                // Puedes dejar el pkgListSelect como está, o establecer un mensaje de error
                // Ejemplo de establecer un valor de error
                Toast::error(__('Error: El registro no fue encontrado.'));
                return $pkgListSelect;  // Retornar el arreglo predeterminado
            }
        }

        return $pkgListSelect;
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Editar Packing List';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Modifica los Packing List (Barra Plana), asociadas existentes en el sistema';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Guardar'))
                ->icon('bs.check-circle')
                ->type(Color::PRIMARY)
                ->method('save')
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
            Layout::block([
                PackingListEditBarraPlanaRow::class,
            ])
                ->title('Packing List')
                ->description('El Packing List es un documento detallado que enumera y describe los productos y materiales incluidos en un envío. Facilita el control y verificación de los artículos al momento de la carga y recepción, asegurando que el contenido coincide con lo solicitado y enviado.')
        ];
    }

    /**
     * Save the uploaded data and store it in the production orders table.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductionOrden $productionOrden
     * @return mixed
     */
    public function save(Request $request, pkglist $pkglist = null)
    {
        // Validar los datos del request
        $validatedData = $request->validate($this->rules($pkglist), $this->messages());

        try {
            if ($pkglist) {
                // MODIFICAMOS LOS DATOS
                $pkglistData = pkglist::findOrFail($pkglist->id);  // Busca el registro por su ID

                // Ahora actualiza el registro encontrado
                $pkglistData->update([
                    'no_contact' => $validatedData['no_contact'],
                    'steel_grande' => $validatedData['steel_grande'],
                    'pkg_Standard' => $validatedData['pkg_Standard'],
                    'DIA' => $validatedData['DIA'],
                    'pkg_Lenght' => $validatedData['pkg_Lenght'],
                    'pkg_Weight' => $validatedData['pkg_Weight'],
                    'pkg_Bars' => $validatedData['pkg_Bars'],
                    'pkg_Bundles' => $validatedData['pkg_Bundles'],
                ]);
            } else {
                // Crear la orden de producción principal
                pkglist::create([
                    'no_contact' => $validatedData['no_contact'],
                    'steel_grande' => $validatedData['steel_grande'],
                    'pkg_Standard' => $validatedData['pkg_Standard'],
                    'DIA' => $validatedData['DIA'],
                    'pkg_Lenght' => $validatedData['pkg_Lenght'],
                    'pkg_Weight' => $validatedData['pkg_Weight'],
                    'pkg_Bars' => $validatedData['pkg_Bars'],
                    'pkg_Bundles' => $validatedData['pkg_Bundles'],
                ]);
            }

            // Alimentar el inventario

            // Mostrar mensaje de éxito
            Toast::info(__('Datos guardados exitosamente.'));

            // Redirigir a la ruta deseada después de guardar
            return redirect()->route('platform.packing.list');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Captura el error si no se encuentra el modelo
            Toast::error(__('Error: El registro no fue encontrado.'));
            return redirect()->route('platform.packing.list');  // Redirigir a una página específica o a la lista
        } catch (\Exception $e) {
            // Captura cualquier otro error
            Toast::error(__('Error: Ha ocurrido un problema al guardar los datos.'));
            return redirect()->route('platform.packing.list');  // Redirigir a una página específica o a la lista
        }
    }

    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'no_contact' => 'nullable|string|max:50',  // Opcional, cadena de texto, máximo 50 caracteres
            'steel_grande' => 'nullable|string|max:50',  // Opcional, cadena de texto, máximo 50 caracteres
            'pkg_Standard' => 'nullable|string|max:50',  // Opcional, cadena de texto, máximo 50 caracteres
            'DIA' => 'nullable|numeric|min:0|max:999999.99',  // Opcional, numérico, entre 0 y 999999.99
            'pkg_Lenght' => 'nullable|numeric|min:0|max:999999.99',  // Opcional, numérico, entre 0 y 999999.99
            'pkg_Weight' => 'nullable|numeric|min:0|max:999999.99',  // Opcional, numérico, entre 0 y 999999.99
            'pkg_Bars' => 'nullable|integer|min:0',  // Opcional, entero, mínimo 0
            'pkg_Bundles' => 'nullable|string|max:50',  // Opcional, cadena de texto, máximo 50 caracteres
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'no_contact.string' => 'El campo de contacto debe ser una cadena de texto.',
            'no_contact.max' => 'El campo de contacto no puede exceder los 50 caracteres.',
            'steel_grande.string' => 'El campo de acero grande debe ser una cadena de texto.',
            'steel_grande.max' => 'El campo de acero grande no puede exceder los 50 caracteres.',
            'pkg_Standard.string' => 'El campo de paquete estándar debe ser una cadena de texto.',
            'pkg_Standard.max' => 'El campo de paquete estándar no puede exceder los 50 caracteres.',
            'DIA.numeric' => 'El campo de diámetro debe ser un número.',
            'DIA.min' => 'El campo de diámetro no puede ser negativo.',
            'DIA.max' => 'El campo de diámetro no puede exceder el valor de 999999.99.',
            'pkg_Lenght.numeric' => 'El campo de longitud debe ser un número.',
            'pkg_Lenght.min' => 'El campo de longitud no puede ser negativo.',
            'pkg_Lenght.max' => 'El campo de longitud no puede exceder el valor de 999999.99.',
            'pkg_Weight.numeric' => 'El campo de peso debe ser un número.',
            'pkg_Weight.min' => 'El campo de peso no puede ser negativo.',
            'pkg_Weight.max' => 'El campo de peso no puede exceder el valor de 999999.99.',
            'pkg_Bars.integer' => 'El campo de barras debe ser un número entero.',
            'pkg_Bars.min' => 'El campo de barras no puede ser negativo.',
            'pkg_Bundles.string' => 'El campo de paquetes debe ser una cadena de texto.',
            'pkg_Bundles.max' => 'El campo de paquetes no puede exceder los 50 caracteres.',
        ];
    }
}
