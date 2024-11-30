<?php

namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class pkglistResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\pkglist::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('no_contact')
                    ->title('No Contacto')
                    ->type(value: 'text')  // Campo de texto para No Contacto
                    ->autofocus()
                    ->required(),
                Input::make('steel_grande')
                    ->title('Steel Grande')
                    ->type(value: 'text')  // Campo de texto para Steel Grande
                    ->required(),
                Input::make('pkg_Standard')
                    ->title('Paquete Estándar')
                    ->type(value: 'text')  // Campo de texto para Paquete Estándar
                    ->required(),
                Input::make('DIA')
                    ->title('DIA')
                    ->type(value: 'number')  // Definir como número para DIA
                    ->required(),
            ]),
            Group::make([
                Input::make('pkg_Lenght')
                    ->title('Longitud del Paquete')
                    ->mask(['alias' => 'decimal', 'groupSeparator' => ',', 'radixPoint' => '.'])
                    ->required(),
                Input::make('pkg_Weight')
                    ->title('Peso del Paquete')
                    ->type(value: 'number')  // Definir como número para el Peso
                    ->required(),
                Input::make('pkg_Bars')
                    ->title('Barras en el Paquete')
                    ->type(value: 'number')  // Definir como número para las Barras
                    ->required(),
                Input::make('pkg_Bundles')
                    ->title('Paquetes')
                    ->type(value: 'number')  // Definir como número para los Paquetes
                    ->required(),
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
            TD::make('no_contact', 'No Contacto'),
            TD::make('steel_grande', 'Steel Grande'),
            TD::make('pkg_Standard', 'Paquete Estándar'),
            TD::make('DIA', 'DIA'),
            TD::make('pkg_Lenght', 'Longitud del Paquete'),
            TD::make('pkg_Weight', 'Peso del Paquete'),
            TD::make('pkg_Bars', 'Barras en el Paquete'),
            TD::make('pkg_Bundles', 'Paquetes'),
            TD::make('created_at', 'Fecha de creación')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            TD::make('updated_at', 'Fecha de actualización')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
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
            Sight::make('no_contact', 'No Contacto'),
            Sight::make('steel_grande', 'Steel Grande'),
            Sight::make('pkg_Standard', 'Paquete Estándar'),
            Sight::make('DIA', 'DIA'),
            Sight::make('pkg_Lenght', 'Longitud del Paquete'),
            Sight::make('pkg_Weight', 'Peso del Paquete'),
            Sight::make('pkg_Bars', 'Barras en el Paquete'),
            Sight::make('pkg_Bundles', 'Paquetes'),
            Sight::make('created_at', 'Fecha de creación')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            Sight::make('updated_at', 'Fecha de actualización')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
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
     *   @return array
     *
     * public function rules(Model $model): array
     * {
     *     return [
     *         'year_vh' => 'required|integer|min:1886|max:' . date('Y'),  // Requerido, debe ser un entero entre 1886 y el año actual
     *     ];
     * }
     */

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'no_contact.required' => 'El campo No Contacto es obligatorio.',
            'steel_grande.required' => 'El campo Steel Grande es obligatorio.',
            'pkg_Standard.required' => 'El campo Paquete Estándar es obligatorio.',
            'DIA.required' => 'El campo DIA es obligatorio.',
            'DIA.integer' => 'El campo DIA debe ser un número entero.',
            'pkg_Lenght.required' => 'El campo Longitud del Paquete es obligatorio.',
            'pkg_Lenght.numeric' => 'El campo Longitud del Paquete debe ser un número.',
            'pkg_Weight.required' => 'El campo Peso del Paquete es obligatorio.',
            'pkg_Weight.numeric' => 'El campo Peso del Paquete debe ser un número.',
            'pkg_Bars.required' => 'El campo Barras en el Paquete es obligatorio.',
            'pkg_Bars.integer' => 'El campo Barras en el Paquete debe ser un número entero.',
            'pkg_Bundles.required' => 'El campo Paquetes es obligatorio.',
            'pkg_Bundles.integer' => 'El campo Paquetes debe ser un número entero.',
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
        return __('Paking List');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Paking List');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Paking List');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Paking List');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Paking List.');
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

    /*
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
