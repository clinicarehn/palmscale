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

class VehiculoResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Vehiculo::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('descripcionvehiculo')
                    ->title('Descripción del Vehículo')
                    ->placeholder('Ingrese la descripción del vehículo')
                    ->autofocus()
                    ->required(),
                Input::make('nombrecorto')
                    ->title('Nombre Corto')
                    ->placeholder('Ingrese el nombre corto del vehículo')
                    ->required(),
                Input::make('numero')
                    ->title('Número')
                    ->placeholder('Ingrese el número')
                    ->required(),
            ]),
            Group::make([
                Select::make('typeid')
                    ->options([
                        0 => 'VEHICULO (01-99)',
                        1 => 'TRAMO TERMINADO (9T -- TrT)',
                        2 => 'TRAMO RECTO (9TR -- TrR)',
                        3 => 'GRAPA',
                    ])
                    // ->title('Tipo Vehículo')
                    ->id('typeid')
                    ->empty('')
                    ->searchable()
                    ->required()
                    ->set('class', 'form-select d-none')
                    ->value(0),
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
            TD::make('descripcionvehiculo', 'Descripción del Vehículo')
                ->sort()
                ->filter(Input::make()),
            TD::make('nombrecorto', 'Nombre Corto')
                ->sort()
                ->filter(Input::make()),
            TD::make('numero', 'Número')
                ->sort()
                ->filter(Input::make()),
            // TD::make('typeid', 'Tipo Vehículo')
            //     ->sort()
            //     ->filter(Input::make())
            //     ->render(function ($vehiuloResource) {
            //         return [
            //             0 => 'VEHICULO (01-99)',
            //             1 => 'TRAMO TERMINADO (9T -- TrT)',
            //             2 => 'TRAMO RECTO (9TR -- TrR)',
            //             3 => 'GRAPA',
            //         ][$vehiuloResource->typeid] ?? '';
            //     }),
            TD::make(
                'created_at',
                'Fecha de creación',
            )
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
                                ->route('platform.resource.view', ['resource' => 'vehiculo-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'vehiculo-resources', 'id' => $model->id])
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
            Sight::make('descripcionvehiculo', 'Descripción del Vehículo'),
            Sight::make('nombrecorto', 'Nombre corto'),
            Sight::make('numero', title: 'Número'),
            // Sight::make('typeid', title: 'Número')
            //     ->render(function ($vehiuloResource) {
            //         return [
            //             0 => 'VEHICULO (01-99)',
            //             1 => 'TRAMO TERMINADO (9T -- TrT)',
            //             2 => 'TRAMO RECTO (9TR -- TrR)',
            //             3 => 'GRAPA',
            //         ][$vehiuloResource->typeid] ?? '';
            //     }),
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
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'descripcionvehiculo' => 'required|string|max:255',  // Requerido, cadena de texto, máximo 255 caracteres
            'nombrecorto' => 'required|string|max:10',  // Requerido, cadena de texto, máximo 10 caracteres
            'numero' => 'required|string|max:10',  // Requerido, debe ser un número entero mayor o igual a 1
            // 'typeid' => 'required|integer|in:0,1,2,3',  // Requerido, debe ser uno de los valores específicos del select
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
            'descripcionvehiculo.required' => 'El campo descripción del vehículo es obligatorio.',
            'descripcionvehiculo.string' => 'El campo descripción del vehículo debe ser un texto.',
            'descripcionvehiculo.max' => 'El campo descripción del vehículo no puede tener más de 255 caracteres.',
            'nombrecorto.required' => 'El campo nombre corto es obligatorio.',
            'nombrecorto.string' => 'El campo nombre corto debe ser un texto.',
            'nombrecorto.max' => 'El campo nombre corto no puede tener más de 10 caracteres.',
            'numero.required' => 'El campo número es obligatorio.',
            'numero.string' => 'El campo número debe ser una cadena de texto.',
            'numero.max' => 'El campo número no puede tener más de 10 caracteres.',
            'typeid.required' => 'El campo tipo de vehículo es obligatorio.',
            'typeid.integer' => 'El campo tipo de vehículo debe ser un número válido.',
            // 'typeid.in' => 'El campo tipo de vehículo debe ser uno de los valores permitidos: VEHÍCULO (01-99), TRAMO TERMINADO, TRAMO RECTO o GRAPA.',
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
        return __('Vehículo');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Vehículo');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Vehículo');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Vehículos');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Vehículos');
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
