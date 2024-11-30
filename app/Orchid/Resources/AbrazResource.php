<?php

namespace App\Orchid\Resources;

use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class AbrazResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Abraz::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('ANCHOmm')
                    ->title('ANCHOmm')
                    ->type('numeric')  // Corregido
                    ->autofocus()
                    ->required(),
                Input::make('GRUESOmm')
                    ->title('GRUESOmm')
                    ->type('numeric'),  // Corregido
                Input::make('ANCHOmm_Lookup')
                    ->title('ANCHOmm_Lookup')
                    ->type('numeric'),  // Corregido
            ]),
            Group::make([
                Input::make('GRUESOmm_Lookup')
                    ->title('GRUESOmm_Lookup C')
                    ->type('numeric'),
                Input::make('Pos2')
                    ->title('Pos2')
                    ->type('numeric'),  // Corregido
                Input::make('Pos3')
                    ->title('Pos3')
                    ->type('numeric'),  // Corregido
            ]),
            Group::make([
                Input::make('Pos4')
                    ->title('Pos4')
                    ->type('numeric'),
                Input::make('Pos5')
                    ->title('Pos5')
                    ->type('numeric'),  // Corregido
                Input::make('Pos6')
                    ->title('Pos6')
                    ->type('numeric'),  // Corregido
            ]),
            Group::make([
                Input::make('Pos7')
                    ->title('Pos7')
                    ->type('numeric'),
                Input::make('Pos8')
                    ->title('Pos8')
                    ->type('numeric'),  // Corregido
                Input::make('Pos9')
                    ->title('Pos9')
                    ->type('numeric'),  // Corregido
            ]),
            Group::make([
                Input::make('Pos10')
                    ->title('Pos10')
                    ->type('numeric'),
                Input::make('Pos11')
                    ->title('Pos11')
                    ->type('numeric'),  // Corregido
                Input::make('Pos12')
                    ->title('Pos12')
                    ->type('numeric'),  // Corregido
            ]),
            Group::make([
                Input::make('Pos13')
                    ->title('Pos13')
                    ->type('numeric'),
                Input::make('Pos14')
                    ->title('Pos14')
                    ->type('numeric'),  // Corregido
                Input::make('Pos15')
                    ->title('Pos15')
                    ->type('numeric'),  // Corregido
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
            TD::make('ANCHOmm', 'ANCHO mm')
                ->sort()
                ->filter(Input::make()),
            TD::make('GRUESOmm', 'GRUESO mm')
                ->sort()
                ->filter(Input::make()),
            TD::make('ANCHOmm_Lookup', 'ANCHO mm')
                ->sort()
                ->filter(Input::make()),
            TD::make('GRUESOmm_Lookup', '2 GRUESO mm')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos2', 'Pos 2')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos3', 'Pos 3')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos4', 'Pos 4')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos5', 'Pos 5')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos6', 'Pos 6')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos7', 'Pos 7')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos8', 'Pos 8')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos9', 'Pos 9')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos10', 'Pos 10')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos11', 'Pos 11')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos12', 'Pos 12')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos13', 'Pos 13')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos14', 'Pos 14')
                ->sort()
                ->filter(Input::make()),
            TD::make('Pos15', 'Pos 15')
                ->sort()
                ->filter(Input::make()),
            TD::make('created_at', 'Fecha de creación')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            TD::make('updated_at', 'Fecha de actualización')
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
                                ->route('platform.resource.view', ['resource' => 'abraz-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'abraz-resources', 'id' => $model->id])
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
            Sight::make('ANCHOmm'),
            Sight::make('GRUESOmm'),
            Sight::make('ANCHOmm_Lookup'),
            Sight::make('GRUESOmm_Lookup'),
            Sight::make('Pos2'),
            Sight::make('Pos3'),
            Sight::make('Pos4'),
            Sight::make('Pos5'),
            Sight::make('Pos6'),
            Sight::make('Pos7'),
            Sight::make('Pos8'),
            Sight::make('Pos8'),
            Sight::make('Pos9'),
            Sight::make('Pos10'),
            Sight::make('Pos11'),
            Sight::make('Pos12'),
            Sight::make('Pos13'),
            Sight::make('Pos14'),
            Sight::make('Pos15'),
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
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'ANCHOmm' => 'required|numeric|min:0|max:999999999999.99',
            'GRUESOmm' => 'required|numeric|min:0|max:999999999999.99',
            'ANCHOmm_Lookup' => 'nullable|numeric|min:0|max:999999999999.99',
            'GRUESOmm_Lookup' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos2' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos3' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos4' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos5' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos6' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos7' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos8' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos9' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos10' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos11' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos12' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos13' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos14' => 'nullable|numeric|min:0|max:999999999999.99',
            'Pos15' => 'nullable|numeric|min:0|max:999999999999.99',
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
            'ANCHOmm.required' => 'El campo Ancho es obligatorio.',
            'ANCHOmm.numeric' => 'El Ancho debe ser un número.',
            'ANCHOmm.min' => 'El Ancho debe ser mayor o igual a 0.',
            'ANCHOmm.max' => 'El Ancho no puede ser mayor a 999999999999.99.',
            'GRUESOmm.required' => 'El campo Grueso es obligatorio.',
            'GRUESOmm.numeric' => 'El Grueso debe ser un número.',
            'GRUESOmm.min' => 'El Grueso debe ser mayor o igual a 0.',
            'GRUESOmm.max' => 'El Grueso no puede ser mayor a 999999999999.99.',
            'ANCHOmm_Lookup.numeric' => 'El Ancho Lookup debe ser un número.',
            'ANCHOmm_Lookup.min' => 'El Ancho Lookup debe ser mayor o igual a 0.',
            'ANCHOmm_Lookup.max' => 'El Ancho Lookup no puede ser mayor a 999999999999.99.',
            'GRUESOmm_Lookup.numeric' => 'El Grueso Lookup debe ser un número.',
            'GRUESOmm_Lookup.min' => 'El Grueso Lookup debe ser mayor o igual a 0.',
            'GRUESOmm_Lookup.max' => 'El Grueso Lookup no puede ser mayor a 999999999999.99.',
            'Pos2.numeric' => 'Pos2 debe ser un número.',
            'Pos2.min' => 'Pos2 debe ser mayor o igual a 0.',
            'Pos2.max' => 'Pos2 no puede ser mayor a 999999999999.99.',
            'Pos3.numeric' => 'Pos3 debe ser un número.',
            'Pos3.min' => 'Pos3 debe ser mayor o igual a 0.',
            'Pos3.max' => 'Pos3 no puede ser mayor a 999999999999.99.',
            'Pos4.numeric' => 'Pos4 debe ser un número.',
            'Pos4.min' => 'Pos4 debe ser mayor o igual a 0.',
            'Pos4.max' => 'Pos4 no puede ser mayor a 999999999999.99.',
            'Pos5.numeric' => 'Pos5 debe ser un número.',
            'Pos5.min' => 'Pos5 debe ser mayor o igual a 0.',
            'Pos5.max' => 'Pos5 no puede ser mayor a 999999999999.99.',
            'Pos6.numeric' => 'Pos6 debe ser un número.',
            'Pos6.min' => 'Pos6 debe ser mayor o igual a 0.',
            'Pos6.max' => 'Pos6 no puede ser mayor a 999999999999.99.',
            'Pos7.numeric' => 'Pos7 debe ser un número.',
            'Pos7.min' => 'Pos7 debe ser mayor o igual a 0.',
            'Pos7.max' => 'Pos7 no puede ser mayor a 999999999999.99.',
            'Pos8.numeric' => 'Pos8 debe ser un número.',
            'Pos8.min' => 'Pos8 debe ser mayor o igual a 0.',
            'Pos8.max' => 'Pos8 no puede ser mayor a 999999999999.99.',
            'Pos9.numeric' => 'Pos9 debe ser un número.',
            'Pos9.min' => 'Pos9 debe ser mayor o igual a 0.',
            'Pos9.max' => 'Pos9 no puede ser mayor a 999999999999.99.',
            'Pos10.numeric' => 'Pos10 debe ser un número.',
            'Pos10.min' => 'Pos10 debe ser mayor o igual a 0.',
            'Pos10.max' => 'Pos10 no puede ser mayor a 999999999999.99.',
            'Pos11.numeric' => 'Pos11 debe ser un número.',
            'Pos11.min' => 'Pos11 debe ser mayor o igual a 0.',
            'Pos11.max' => 'Pos11 no puede ser mayor a 999999999999.99.',
            'Pos12.numeric' => 'Pos12 debe ser un número.',
            'Pos12.min' => 'Pos12 debe ser mayor o igual a 0.',
            'Pos12.max' => 'Pos12 no puede ser mayor a 999999999999.99.',
            'Pos13.numeric' => 'Pos13 debe ser un número.',
            'Pos13.min' => 'Pos13 debe ser mayor o igual a 0.',
            'Pos13.max' => 'Pos13 no puede ser mayor a 999999999999.99.',
            'Pos14.numeric' => 'Pos14 debe ser un número.',
            'Pos14.min' => 'Pos14 debe ser mayor o igual a 0.',
            'Pos14.max' => 'Pos14 no puede ser mayor a 999999999999.99.',
            'Pos15.numeric' => 'Pos15 debe ser un número.',
            'Pos15.min' => 'Pos15 debe ser mayor o igual a 0.',
            'Pos15.max' => 'Pos15 no puede ser mayor a 999999999999.99.',
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
        return __('Abrazaderas');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Abrazaderas');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Abrazadera');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Abrazaderas');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Abrazaderas');
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
     * Get the text for the delete resource toast.
     *
     * @return string
     */
    public static function deleteToastMessage(): string
    {
        return __(':resource fue eliminado!', [
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
