<?php

namespace App\Orchid\Resources;

use App\Models\TipoHojaVehiculo;
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

class TipoHojaVehiculoResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = TipoHojaVehiculo::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('tipo_hoja')
                    ->title('Tipo Hoja')
                    ->placeholder('Ingrese el tipo de la hoja')
                    ->autofocus()
                    ->required(),
            ]),
            Group::make([
                Input::make('upload')  // Este debe coincidir
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
            TD::make('id')
                ->sort()
                ->filter(Input::make()),
            TD::make('tipo_hoja', 'Tipo de Hoja')
                ->sort()
                ->filter(Input::make()),
            TD::make('upload', 'Imagen')
                ->render(function ($model) {
                    if ($model->upload) {
                        // Construir la ruta a la imagen
                        return "<img src='" . asset('storage/uploads/' . $model->upload) . "' style='width: 100px; height: auto;' />";
                    }
                    return 'No Image';
                }),
            TD::make('created_at', 'Fecha de creación')
                ->sort()
                ->filter(Input::make())
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            TD::make('updated_at', 'Fecha de actualización')
                ->sort()
                ->filter(Input::make())
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
                                ->route('platform.resource.view', ['resource' => 'tipo-hoja-vehiculo-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'tipo-hoja-vehiculo-resources', 'id' => $model->id])
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
            Sight::make('tipo_hoja', 'Tipo la hoja'),
            Sight::make('upload', 'Imagen')
                ->render(function ($model) {
                    if ($model->upload) {
                        return "<img src='" . asset('storage/uploads/' . $model->upload) . "' style='width: 100px; height: auto;' />";
                    }
                    return 'No Image';
                }),
            Sight::make('created_at', 'Fecha de actualización')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            Sight::make('updated_at', 'Fecha de actualización')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
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
     * @param \App\Models\TipoHojaVehiculo $tipoHojaVehiculo
     * @return void
     */
    public function onSave(Request $request, TipoHojaVehiculo $tipoHojaVehiculo): void
    {
        // Validar los datos del request
        $validatedData = $request->validate($this->rules($tipoHojaVehiculo), $this->messages());

        // Guardar los datos del tipo de hoja
        $tipoHojaVehiculo->tipo_hoja = $validatedData['tipo_hoja'];

        // Procesar la carga del archivo
        if ($request->hasFile('model.upload')) {  // Cambiar aquí para acceder correctamente
            $file = $request->file('model.upload');

            // Verifica si hay errores en el archivo
            if ($file->getError() === UPLOAD_ERR_OK) {
                $fileName = date('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // Guarda el archivo en el sistema de archivos
                $file->storeAs('uploads', $fileName, 'public');
                // Solo guarda el nombre del archivo en la base de datos
                $tipoHojaVehiculo->upload = $fileName;  // Solo el nombre del archivo
            } else {
                // Maneja el error de carga
                $tipoHojaVehiculo->upload = 'Error al cargar el archivo: ' . $file->getError();
            }
        } else {
            $tipoHojaVehiculo->upload = 'No tiene foto';
        }

        $tipoHojaVehiculo->save();

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
            'tipo_hoja' => 'required|string|max:4000',
            'upload' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',  // Asegúrate de que el nombre coincida con tu formulario
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
            'tipo_hoja.required' => 'El tipo de hoja es obligatorio.',
            'tipo_hoja.max' => 'El tipo de hoja no puede tener más de 4000 caracteres.',
            'upload.required' => 'El archivo de imagen es obligatorio.',
            'upload.image' => 'El archivo debe ser una imagen.',
            'upload.mimes' => 'La imagen debe ser de tipo: jpg, jpeg, png, gif.',
            'upload.max' => 'La imagen no debe exceder los 10 MB.',
        ];
    }

    /**
     * Get the label for the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        // Este método define el nombre que aparecerá en el menú para este recurso.
        return __('Tipo Hoja');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Tipo Hoja');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Tipo Hoja');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Tipos de Hoja');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Tipos de Hoja');
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
    public static function displayInNavigation(): bool
    {
        return false;
    }
}
