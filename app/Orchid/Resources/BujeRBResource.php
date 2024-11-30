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

class BujeRBResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\BujeRB::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('bujeRBNum')
                    ->title('Numero Parte Buje')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->autofocus()
                    ->required(),
                Input::make('dia_cpo_PI')
                    ->title('Descripcion del Dia CPO PI')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
            ]),
            Group::make([
                Input::make('long_cpo_PI')
                    ->title('Descripcion del Long CPO PI')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
                Input::make('long_tot_PI')
                    ->title('Descripcion del Long TOT PI')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
            ]),
            Group::make([
                Input::make('dian_int_PI')
                    ->title('Descripcion del Dian INT PI')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
                Input::make('dia_cpo_MM')
                    ->title('Descripcion del Dian CPO MM')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
            ]),
            Group::make([
                Input::make('long_cpo_MM')
                    ->title('Descripcion del Long CPO MM')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
                Input::make('long_tot_MM')
                    ->title('Descripcion del Long TOT MM')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
            ]),
            Group::make([
                Input::make('dian_int_MM')
                    ->title('Descripcion del Dian INT MM')
                    ->type(value: 'text')  // Definir que el campo es numérico
                    ->required(),
                Input::make('remarks')
                    ->title('Descripcion del Remarks')
                    ->type(value: 'text'),  // Definir que el campo es numérico
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
            /* TD::make('id'), */
            TD::make('bujeRBNum', 'Descripcion del No. Parte RB')
                ->sort()
                ->filter(Input::make()),
            TD::make('dia_cpo_PI', 'Descripcion del Dia CPO PI')
                ->sort()
                ->filter(Input::make()),
            TD::make('long_cpo_PI', 'Descripcion del Long CPO PI')
                ->sort()
                ->filter(Input::make()),
            TD::make('long_tot_PI', 'Descripcion del Long TOT PI')
                ->sort()
                ->filter(Input::make()),
            TD::make('dian_int_PI', 'Descripcion del Dian INT PI')
                ->sort()
                ->filter(Input::make()),
            TD::make('dia_cpo_MM', 'Descripcion del Dian CPO MM')
                ->sort()
                ->filter(Input::make()),
            TD::make('long_cpo_MM', 'Descripcion del Long CPO MMs')
                ->sort()
                ->filter(Input::make()),
            TD::make('long_tot_MM', 'Descripcion del Long TOT MM')
                ->sort()
                ->filter(Input::make()),
            TD::make('dian_int_MM', 'Descripcion del Dian INT MM')
                ->sort()
                ->filter(Input::make()),
            TD::make('remarks', 'Descripcion del Remarks')
                ->sort()
                ->filter(Input::make()),
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
                                ->route('platform.resource.view', ['resource' => 'buje-r-b-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'buje-r-b-resources', 'id' => $model->id])
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
            Sight::make('bujeRBNum'),
            Sight::make('dia_cpo_PI'),
            Sight::make('long_cpo_PI'),
            Sight::make('long_tot_PI'),
            Sight::make('dian_int_PI'),
            Sight::make('dia_cpo_MM'),
            Sight::make('long_cpo_MM'),
            Sight::make('long_tot_MM'),
            Sight::make('dian_int_MM'),
            Sight::make('remarks'),
            Sight::make('created_at', 'Fecha de creación')
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
            'bujeRBNum' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'dia_cpo_PI' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'long_cpo_PI' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'long_tot_PI' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'dian_int_PI' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'dia_cpo_MM' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'long_cpo_MM' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'long_tot_MM' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'dian_int_MM' => 'required|string|max:25',  // Requerido, cadena de texto, máximo 25 caracteres
            'remarks' => 'nullable|string|max:25',  // Opcional, cadena de texto, máximo 25 caracteres
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
            'bujeRBNum.required' => 'El número de buje R B es obligatorio.',
            'bujeRBNum.string' => 'El número de buje R B debe ser un texto.',
            'bujeRBNum.max' => 'El número de buje R B no puede tener más de 25 caracteres.',
            'dia_cpo_PI.required' => 'El día del cpo PI es obligatorio.',
            'dia_cpo_PI.string' => 'El día del cpo PI debe ser un texto.',
            'dia_cpo_PI.max' => 'El día del cpo PI no puede tener más de 25 caracteres.',
            'long_cpo_PI.required' => 'La longitud del cpo PI es obligatoria.',
            'long_cpo_PI.string' => 'La longitud del cpo PI debe ser un texto.',
            'long_cpo_PI.max' => 'La longitud del cpo PI no puede tener más de 25 caracteres.',
            'long_tot_PI.required' => 'La longitud total PI es obligatoria.',
            'long_tot_PI.string' => 'La longitud total PI debe ser un texto.',
            'long_tot_PI.max' => 'La longitud total PI no puede tener más de 25 caracteres.',
            'dian_int_PI.required' => 'El diámetro interior PI es obligatorio.',
            'dian_int_PI.string' => 'El diámetro interior PI debe ser un texto.',
            'dian_int_PI.max' => 'El diámetro interior PI no puede tener más de 25 caracteres.',
            'dia_cpo_MM.required' => 'El día del cpo MM es obligatorio.',
            'dia_cpo_MM.string' => 'El día del cpo MM debe ser un texto.',
            'dia_cpo_MM.max' => 'El día del cpo MM no puede tener más de 25 caracteres.',
            'long_cpo_MM.required' => 'La longitud del cpo MM es obligatoria.',
            'long_cpo_MM.string' => 'La longitud del cpo MM debe ser un texto.',
            'long_cpo_MM.max' => 'La longitud del cpo MM no puede tener más de 25 caracteres.',
            'long_tot_MM.required' => 'La longitud total MM es obligatoria.',
            'long_tot_MM.string' => 'La longitud total MM debe ser un texto.',
            'long_tot_MM.max' => 'La longitud total MM no puede tener más de 25 caracteres.',
            'dian_int_MM.required' => 'El diámetro interior MM es obligatorio.',
            'dian_int_MM.string' => 'El diámetro interior MM debe ser un texto.',
            'dian_int_MM.max' => 'El diámetro interior MM no puede tener más de 25 caracteres.',
            'remarks.string' => 'Los comentarios deben ser un texto.',
            'remarks.max' => 'Los comentarios no pueden tener más de 25 caracteres.',
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
        return __('Buje RB');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Buje RB');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Buje RB');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Bujes RB');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Bujes RB.');
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
