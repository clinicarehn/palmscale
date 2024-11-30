<?php

namespace App\Orchid\Resources;

use App\Models\BujeLC;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class BujeLCResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = BujeLC::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('part_no')
                    ->title('Part_No')
                    ->type('text')  // Corregido
                    ->autofocus()
                    ->required(),
                Input::make('od_a')
                    ->title('OD_A')
                    ->type('text')  // Corregido
                    ->required(),
                Input::make('id_b')
                    ->title('ID_B')
                    ->type('text')  // Corregido
                    ->required(),
            ]),
            Group::make([
                Input::make('length_c')
                    ->title('Length C')
                    ->type('text')  // Corregido
                    ->required(),
                Input::make('picture')  // Este debe coincidir
                    ->title('Seleccione una Imágen')
                    ->placeholder('Seleccione una imágen JPG, JPEG, PNG')
                    ->type('file')
                    ->acceptedFiles('image/jpeg,image/png,image/jpg')
                    ->autofocus(),
            ]),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('part_no', 'Part_No')
                ->sort()
                ->filter(Input::make()),
            TD::make('od_a', 'OD_A')
                ->sort()
                ->filter(Input::make()),
            TD::make('id_b', 'ID_B')
                ->sort()
                ->filter(Input::make()),
            TD::make('length_c', 'Length C')
                ->sort()
                ->filter(Input::make()),
            TD::make('picture', 'Imagen')
                ->render(function ($model) {
                    if ($model->picture) {
                        // Construir la ruta a la imagen
                        return "<img src='" . asset('storage/uploads/' . $model->picture) . "' style='width: 100px; height: auto;' />";
                    }
                    return 'No Image';
                }),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
            TD::make('Acciones')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($model) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Ver')
                                ->route('platform.resource.view', ['resource' => 'buje-l-c-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'buje-l-c-resources', 'id' => $model->id])
                                ->icon('pencil'),
                            Button::make('Eliminar')
                                ->method('delete')
                                ->confirm('¿Estás seguro de que deseas eliminar este registro?')
                                ->parameters([
                                    'id' => $model->id,
                                ])
                                ->icon('trash'),
                        ]);
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('part_no', 'Part_No'),
            Sight::make('od_a', 'Od A'),
            Sight::make('id_b', 'Id B'),
            Sight::make('length_c', 'Lenth C'),
            Sight::make('picture', 'Imagen')
                ->render(function ($model) {
                    if ($model->picture) {
                        return "<img src='" . asset('storage/uploads/' . $model->picture) . "' style='width: 100px; height: auto;' />";
                    }
                    return 'No Image';
                }),
            Sight::make('created_at', 'Fecha de creación')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            Sight::make('updated_at', 'Fecha de actualización')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();  // Cambiado `created_at` por `updated_at`
                }),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * Save the uploaded image and store a copy in the public/uploads folder.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BujeLC $bujeLC
     * @return void
     */
    public function onSave(Request $request, BujeLC $bujeLC): void
    {
        // Validar los datos del request
        $validatedData = $request->validate($this->rules($bujeLC), $this->messages());

        // Guardar los datos
        $bujeLC->part_no = $validatedData['part_no'];
        $bujeLC->od_a = $validatedData['od_a'];
        $bujeLC->id_b = $validatedData['id_b'];
        $bujeLC->length_c = $validatedData['length_c'];

        // Procesar la carga del archivo
        if ($request->hasFile('model.picture')) {  // Cambiar aquí para acceder correctamente
            $file = $request->file('model.picture');

            // Verifica si hay errores en el archivo
            if ($file->getError() === UPLOAD_ERR_OK) {
                $fileName = date('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // Guarda el archivo en el sistema de archivos
                $file->storeAs('uploads', $fileName, 'public');
                // Solo guarda el nombre del archivo en la base de datos
                $bujeLC->picture = $fileName;  // Solo el nombre del archivo
            } else {
                // Maneja el error de carga
                $bujeLC->picture = 'Error al cargar el archivo: ' . $file->getError();
            }
        } else {
            $bujeLC->picture = 'no-preview.jpg';
        }

        $bujeLC->save();

        // Mostrar mensaje de éxito
        Toast::info(message: __('Datos guardados exitosamente.'));
    }

    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'part_no' => 'required|string|max:10',
            'od_a' => 'required|string|max:10',
            'id_b' => 'required|string|max:10',
            'length_c' => 'required|string|max:10',
            'picture' => 'nullable|image|max:2048',  // La imagen es opcional y debe ser de un máximo de 2MB
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
            'part_no.required' => 'El campo "Parte No" es obligatorio.',
            'part_no.string' => 'El campo "Parte No" debe ser una cadena de texto.',
            'part_no.max' => 'El campo "Parte No" no puede exceder los 10 caracteres.',
            'od_a.required' => 'El campo "OD A" es obligatorio.',
            'od_a.string' => 'El campo "OD A" debe ser una cadena de texto.',
            'od_a.max' => 'El campo "OD A" no puede exceder los 10 caracteres.',
            'id_b.required' => 'El campo "ID B" es obligatorio.',
            'id_b.string' => 'El campo "ID B" debe ser una cadena de texto.',
            'id_b.max' => 'El campo "ID B" no puede exceder los 10 caracteres.',
            'length_c.required' => 'El campo "Longitud C" es obligatorio.',
            'length_c.string' => 'El campo "Longitud C" debe ser una cadena de texto.',
            'length_c.max' => 'El campo "Longitud C" no puede exceder los 10 caracteres.',
            'picture.image' => 'El archivo de imagen debe ser de tipo JPG, JPEG o PNG.',
            'picture.max' => 'La imagen no puede ser mayor de 2MB.',
        ];
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Buje LC');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Buje LC');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Bujes LC');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Buje LC.');
    }

    /**
     * Get the text for the list breadcrumbs.
     *
     * @return string
     */
    public static function listBreadcrumbsMessage(): string
    {
        return static::label();
    }

    /**
     * Get the text for the create breadcrumbs.
     *
     * @return string
     */
    public static function createBreadcrumbsMessage(): string
    {
        return __('Nuevo :resource', ['resource' => static::singular()]);
    }

    /**
     * Get the text for the edit breadcrumbs.
     *
     * @return string
     */
    public static function editBreadcrumbsMessage(): string
    {
        return __('Editar :resource', ['resource' => static::singular()]);
    }

    /**
     * Get the text for the create resource button.
     *
     * @return string|null
     */
    public static function createButtonLabel(): string
    {
        return __('Crear :resource', [
            'resource' => static::singular()
        ]);
    }

    /**
     * Get the text for the create resource toast.
     *
     * @return string
     */
    public static function createToastMessage(): string
    {
        return __(':resource fue creado!', [
            'resource' => static::singular()
        ]);
    }

    /**
     * Get the text for the update resource button.
     *
     * @return string|null
     */
    public static function updateButtonLabel(): string
    {
        return __('Actualizar :resource', [
            'resource' => static::singular()
        ]);
    }

    /**
     * Get the text for the update resource toast.
     *
     * @return string
     */
    public static function updateToastMessage(): string
    {
        return __(':resource fue actualizado!', [
            'resource' => static::singular()
        ]);
    }

    /**
     * Get the text for the delete resource button.
     *
     * @return string|null
     */
    public static function deleteButtonLabel(): string
    {
        return __('Eliminar :resource', [
            'resource' => static::singular()
        ]);
    }

    /**
     * Get the number of models to return per page
     *
     * @return int
     */
    public static function perPage(): int
    {
        return 30;
    }

    /**
     * Indicates whether should check for modifications
     * between viewing and updating a resource.
     *
     * @return bool
     */
    public static function trafficCop(): bool
    {
        return true;  // Habilita la verificación de cambios
    }

    /**
     * Determine if the resource should be displayed in the navigation menu.
     *
     * This method controls whether the resource will appear in the navigation menu.
     * Returning false means the resource will not be automatically added to the menu.
     *
     * @return bool
     */

    /**
     * Determine if the resource should be displayed in the navigation menu.
     *
     * This method controls whether the resource will appear in the navigation menu.
     * Returning false means the resource will not be automatically added to the menu.
     *
     * @return bool
     */
    public static function displayInNavigation(): bool
    {
        return false;
    }
}
