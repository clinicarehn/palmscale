<?php

namespace App\Orchid\Resources;

use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class ModeloVehiculoResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ModeloVehiculo::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Select::make('idVehiculo')
                    ->fromModel(\App\Models\Vehiculo::class, 'descripcionvehiculo', 'id')  // Usar el modelo Vehiculo
                    ->title('Seleccione un Vehículo')
                    ->help('Permite buscar vehículos')
                    ->empty('')  // Mensaje si no hay opciones disponibles
                    ->searchable()  // Hacer que el select sea "searchable"
                    ->set('class', 'selectpicker'),
                Input::make('modelo_detalle')
                    ->title('Modelo')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->placeholder('Ingrese el modelo del vehículo')
                    ->required()
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
            TD::make('vehiculo.descripcionvehiculo', 'Nombre del Vehículo')
                ->sort()
                ->filter(Input::make())
                ->render(function ($model) {
                    return $model->vehiculo ? $model->vehiculo->descripcionvehiculo : 'N/A';
                }),
            TD::make('modelo_detalle')
                ->sort()
                ->filter(Input::make()),
            TD::make('created_at', 'Fecha de creación')
                ->sort()
                ->filter(Input::make())
                ->render(function ($model) {
                    return $model->created_at ? $model->created_at->toDateTimeString() : 'N/A';
                }),
            TD::make('updated_at', 'Fecha de actualización')
                ->sort()
                ->filter(Input::make())
                ->render(function ($model) {
                    return $model->updated_at ? $model->updated_at->toDateTimeString() : 'N/A';
                }),
            TD::make('Acciones')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($model) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Ver')
                                ->route('platform.resource.view', ['resource' => 'modelo-vehiculo-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'modelo-vehiculo-resources', 'id' => $model->id])
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
            Sight::make('vehiculo.descripcionvehiculo', 'Nombre del Vehículo')
                ->render(function ($model) {
                    return $model->vehiculo ? $model->vehiculo->descripcionvehiculo : 'N/A';
                }),
            Sight::make('modelo_detalle', 'Modelo'),
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
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'idVehiculo' => 'required|exists:vehiculos,id',  // Requerido, debe existir en la tabla 'vehiculos'
            'modelo_detalle' => 'required|string|max:255',  // Requerido, cadena de texto, máximo 255 caracteres
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
            'idVehiculo.required' => 'El campo idVehiculo es obligatorio.',
            'idVehiculo.exists' => 'El idVehiculo debe existir en la tabla de vehículos.',
            'modelo_detalle.required' => 'El modelo de detalle es obligatorio.',
            'modelo_detalle.string' => 'El modelo de detalle debe ser un texto.',
            'modelo_detalle.max' => 'El modelo de detalle no puede tener más de 255 caracteres.',
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
     * Get the label for the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        // Este método define el nombre que aparecerá en el menú para este recurso.
        return __('Modelo Vehículos');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Modelo Vehículos');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Modelo Vehículo');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Modelo Vehículos');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Modelo de Vehículos');
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
