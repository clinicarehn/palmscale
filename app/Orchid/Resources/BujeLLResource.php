<?php

namespace App\Orchid\Resources;

use App\Models\BujeLL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class BujeLLResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = BujeLL::class;

    public function fields(): array
    {
        return [
            Group::make([
                Select::make('idbujeRBNum')
                    ->options(function () {
                        // Selecciona los campos que deseas concatenar en la tabla 'buje_r_b_s'
                        return DB::table('buje_r_b_s')
                            ->select(
                                'id',
                                DB::raw("CONCAT(bujeRBNum, ', ', dia_cpo_PI, ', ', long_cpo_PI, ', ', dia_cpo_MM, ', ', long_tot_MM) as detalles")
                            )
                            ->pluck('detalles', 'id');
                    })
                    ->title('Seleccione un Buje RB')
                    ->id('bujeRBidInput')
                    ->required()
                    ->empty('Seleccione una opción')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->help('Por favor seleccione un Buje RB.')
            ]),
            Group::make([
                Input::make('dim_a')
                    ->title('Diam A')
                    ->type('text')  // Corregido
                    ->autofocus()
                    ->required(),
                Input::make('dim_b')
                    ->title('Dim B')
                    ->type('text')  // Corregido
                    ->required(),
                Input::make('dim_c')
                    ->title('Dim C')
                    ->type('text')  // Corregido
                    ->required(),
            ]),
            Group::make([
                Input::make('dim_d')
                    ->title('Diam D')
                    ->type('text')  // Corregido
                    ->autofocus()
                    ->required(),
                Input::make('remarks')
                    ->title('Remark')
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
            TD::make('id')
                ->sort()
                ->filter(Input::make()),
            TD::make('bujeRB.bujeRBNum', 'ID Buje RB Num')  // Mostrar el campo relacionado
                ->render(function ($model) {
                    return $model->bujeRB ? $model->bujeRB->bujeRBNum : 'N/A';
                })
                ->sort()
                ->filter(Input::make()),
            TD::make('dim_a', 'Diam A')
                ->sort()
                ->filter(Input::make()),
            TD::make('dim_b', 'Diam B')
                ->sort()
                ->filter(Input::make()),
            TD::make('dim_c', 'Diam C')
                ->sort()
                ->filter(Input::make()),
            TD::make('dim_d', 'Diam D')
                ->sort()
                ->filter(Input::make()),
            TD::make('remarks', 'Remarks')
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
                                ->route('platform.resource.view', ['resource' => 'buje-l-l-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'buje-l-l-resources', 'id' => $model->id])
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
            Sight::make('dim_a', 'Diam A'),
            Sight::make('dim_b', 'Diam B'),
            Sight::make('dim_c', 'Diam C'),
            Sight::make('dim_d', 'Diam D'),
            Sight::make('remarks', 'Rermarks'),
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
     * Save the uploaded image and store a copy in the public/uploads folder.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BujeLC $bujeLC
     * @return void
     */
    public function onSave(Request $request, BujeLL $bujeLL): void
    {
        // dd($request->all());

        // Validar los datos del request
        $validatedData = $request->validate($this->rules($bujeLL), $this->messages());

        // Guardar los datos
        $bujeLL->idbujeRBNum = $validatedData['idbujeRBNum'];
        $bujeLL->dim_a = $validatedData['dim_a'];
        $bujeLL->dim_b = $validatedData['dim_b'];
        $bujeLL->dim_c = $validatedData['dim_c'];
        $bujeLL->dim_d = $validatedData['dim_d'];
        $bujeLL->remarks = $validatedData['remarks'];

        // Procesar la carga del archivo
        if ($request->hasFile('model.picture')) {  // Cambiar aquí para acceder correctamente
            $file = $request->file('model.picture');

            // Verifica si hay errores en el archivo
            if ($file->getError() === UPLOAD_ERR_OK) {
                $fileName = date('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // Guarda el archivo en el sistema de archivos
                $file->storeAs('uploads', $fileName, 'public');
                // Solo guarda el nombre del archivo en la base de datos
                $bujeLL->picture = $fileName;  // Solo el nombre del archivo
            } else {
                // Maneja el error de carga
                $bujeLL->picture = 'Error al cargar el archivo: ' . $file->getError();
            }
        } else {
            $bujeLL->picture = 'no-preview.jpg';
        }

        // dd($bujeLL);

        $bujeLL->save();

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
            'idbujeRBNum' => 'required|exists:buje_r_b_s,id',  // Verifica que el ID de Buje RB exista en la base de datos
            'dim_a' => 'nullable|string|max:10',  // Opcional, debe ser una cadena y máximo de 10 caracteres
            'dim_b' => 'nullable|string|max:10',  // Opcional, debe ser una cadena y máximo de 10 caracteres
            'dim_c' => 'nullable|string|max:10',  // Opcional, debe ser una cadena y máximo de 10 caracteres
            'dim_d' => 'nullable|string|max:10',  // Opcional, debe ser una cadena y máximo de 10 caracteres
            'remarks' => 'nullable|string|max:20',  // Opcional, debe ser una cadena y máximo de 20 caracteres
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // Opcional, debe ser una imagen y máximo de 2MB
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
            'idbujeRBNum.required' => 'El campo "Buje RB" es obligatorio.',
            'idbujeRBNum.exists' => 'El Buje RB seleccionado no es válido.',
            'dim_a.nullable' => 'El campo "Diámetro A" es opcional.',
            'dim_a.string' => 'El campo "Diámetro A" debe ser una cadena de texto.',
            'dim_a.max' => 'El "Diámetro A" no puede tener más de 10 caracteres.',
            'dim_b.nullable' => 'El campo "Diámetro B" es opcional.',
            'dim_b.string' => 'El campo "Diámetro B" debe ser una cadena de texto.',
            'dim_b.max' => 'El "Diámetro B" no puede tener más de 10 caracteres.',
            'dim_c.nullable' => 'El campo "Diámetro C" es opcional.',
            'dim_c.string' => 'El campo "Diámetro C" debe ser una cadena de texto.',
            'dim_c.max' => 'El "Diámetro C" no puede tener más de 10 caracteres.',
            'dim_d.nullable' => 'El campo "Diámetro D" es opcional.',
            'dim_d.string' => 'El campo "Diámetro D" debe ser una cadena de texto.',
            'dim_d.max' => 'El "Diámetro D" no puede tener más de 10 caracteres.',
            'remarks.nullable' => 'El campo "Remarks" es opcional.',
            'remarks.string' => 'El campo "Remarks" debe ser una cadena de texto.',
            'remarks.max' => 'Los "Remarks" no pueden tener más de 20 caracteres.',
            'picture.image' => 'El archivo debe ser una imagen (JPG, JPEG, PNG).',
            'picture.mimes' => 'Solo se permiten imágenes en formato JPG, JPEG y PNG.',
            'picture.max' => 'La imagen no puede ser mayor de 2MB.',
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
        return __('Buje LL');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Buje LL');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Buje LL');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Bujes Ll');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Bujes LL.');
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
