<?php

namespace App\Orchid\Resources;

use App\Models\DescriptionPart;
use App\Models\ModeloVehiculo;
use App\Orchid\Components\ImagePreview;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use \App\Models\PosicionVehiculo;
use \App\Models\RefTensadoVehiculo;
use \App\Models\TipoHojaVehiculo;
use \App\Models\Vehiculo;
use \App\Models\YearVehiculo;

class DescriptionPartResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = DescriptionPart::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        $imageUrl = asset('storage/uploads/' . 'no-preview.jpg');  // Aquí puedes construir la URL de tu imagen

        return [
            // Fila 0
            Group::make([
                Input::make('code')
                    ->title('Código')
                    ->type(value: 'text')
                    ->id('CódigoInput')
                    ->required()
                    ->readonly()
                    ->placeholder('Código')
                    ->autocomplete('off'),  // Desactivar autocompletado
                Select::make('typeid')
                    ->options([
                        0 => 'VEHICULO (01-99)',
                        1 => 'TRAMO TERMINADO (9T -- TrT)',
                        2 => 'TRAMO RECTO (9TR -- TrR)',
                        3 => 'GRAPA',
                    ])
                    ->title('Tipo Vehículo')
                    ->id('typeidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'form-select'),
            ]),
            // Fila 1
            Group::make([
                Select::make('vehiculosid')
                    ->fromModel(Vehiculo::class, 'descripcionvehiculo', 'id')
                    ->displayAppend('descripcionvehiculo')  // Usa el nuevo atributo
                    ->title('Seleccione un Vehículo')
                    ->empty('Seleccione una opción')
                    ->id('vehiculoidInput')
                    ->set('class', 'form-select')
                    ->disabled()
                    ->help('Por favor seleccione el vehículo.'),
                Select::make('modelid')
                    ->options([])  // Comienza vacío
                    ->title('Seleccione un Vehículo con su Modelo')
                    ->empty('Seleccione una opción')
                    ->id('modelidInput')
                    ->set('class', 'form-select')
                    ->disabled()
                    ->help('Por favor seleccione un modelo.'),
                Input::make('apodo')
                    ->title('Apodo')
                    ->type(value: 'text')
                    ->id(value: 'apodoInput')
                    ->readonly()
                    ->autocomplete('off')
                    ->placeholder('Apodo'),
            ]),
            // Fila 2
            Group::make([
                Select::make('yearid')
                    ->fromModel(YearVehiculo::class, 'year_vh', 'id')  // Usar el modelo YearVehiculo
                    ->title('Seleccione un año')
                    ->id('yearidInput')
                    ->empty('Seleccione un año')
                    ->searchable()
                    ->set('class', 'form-select')
                    ->disabled()
                    ->help('Por favor seleccione un año.'),
                Select::make('positionid')
                    ->fromModel(PosicionVehiculo::class, 'posicion', 'id')  // Usar el modelo PosicionVehiculo
                    ->title('Seleccione una posición')
                    ->id('positionidInput')
                    ->empty('Seleccione una posición')
                    ->searchable()
                    ->set('class', 'form-select')
                    ->disabled()
                    ->help('Por favor seleccione una posición.'),
                Select::make('dlttrsid')
                    ->options([
                        0 => 'T',
                        1 => 'D',
                    ])
                    ->title('Seleccione una Dlt/Trs')
                    ->id('dlttrsidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione una Dlt/Trs.'),
            ]),
            // Fila 3
            Group::make([
                Input::make('identidad')
                    ->title('Identidad')
                    ->type(value: 'text')
                    ->id('identidadInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Identidad'),
                Select::make('refauxid')
                    ->fromModel(RefTensadoVehiculo::class, 'Descripcion', 'id')
                    ->title('Seleccione un Ref/Aux')
                    ->id('refauxidInput')
                    ->empty('Seleccione una Ref/Aux')
                    ->searchable()
                    ->set('class', 'form-select')
                    ->disabled()
                    ->help('Por favor seleccione una Ref/Aux.'),
                Select::make('materialgrapaid')
                    ->options(function () {
                        // Selecciona los campos 'inches', 'decimal' y 'mm' y los concatena
                        return DB::table('material_grapas')
                            ->select(
                                'id',
                                DB::raw("CONCAT(inches, ', ', decimal, ', ', mm) as detalles")
                            )
                            ->pluck('detalles', 'id');
                    })
                    ->title('Seleccione un Material Grapa')
                    ->id('materialgrapaidInput')
                    ->empty('Seleccione una opción')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Material Grapa.'),
            ]),
            // Fila 4
            Group::make([
                Select::make('materialid')
                    ->options(function () {
                        // Selecciona los campos 'no_mat', 'width_plg', 'thick_plg', 'width_mm', 'thick_mm', 'Grueso' y 'material_combinado' y los concatena
                        return DB::table('material_const_vehiculos')
                            ->select(
                                'id',
                                DB::raw("CONCAT(no_mat, ', ', width_plg, ', ', thick_plg, ', ', width_mm, ', ', thick_mm, ', ', Grueso, ', ', material_combinado) as detalles")
                            )
                            ->pluck('detalles', 'id');
                    })
                    ->title('Seleccione un Material')
                    ->id('materialidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Material.'),
                Input::make('anchomm')
                    ->title('Ancho (MM)')
                    ->type(value: 'text')
                    ->id('anchommInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Ancho (MM)'),
                Input::make('gruesomm')
                    ->title('Grueso (MM)')
                    ->type(value: 'text')
                    ->id('gruesommInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Grueso (MM)'),
            ]),
            // Fila 5
            Group::make([
                Input::make('longit')
                    ->title('Longit CM')
                    ->type(value: 'text')
                    ->id('longitInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Longit (MM)'),
                /* ->rules('required|numeric|min:10|max:180') */
                // Añade las reglas de validación aquí,
                Input::make('description')
                    ->title('Descripción')
                    ->type(value: 'text')
                    ->id('descriptionInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Descripción'),
                Select::make('tipohojaid')
                    ->fromModel(TipoHojaVehiculo::class, 'tipo_hoja', 'id')  // Usar el modelo Vehiculo
                    ->title('Seleccione un Tipo de Hoja')
                    ->empty('')
                    ->id('tipohojaidInput')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Tipo de Hoja.'),
            ]),
            // Fila 6
            Group::make([
                Input::make('cortecm')
                    ->title('Corte Cm')
                    ->type(value: 'text')
                    ->id('cortecmInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Corte CM'),
                Input::make('distcccm')
                    ->title('Distcc CM')
                    ->type(value: 'text')
                    ->id('distcccmInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Distcc CM'),
                Input::make('lccm')
                    ->title('LC CM')
                    ->type(value: 'text')
                    ->id('lccmInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('LC CM'),
            ]),
            // Fila 7
            Group::make([
                Input::make('llcm')
                    ->title('LL CM')
                    ->type(value: 'text')
                    ->id('llcmInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('LL CM'),
                Select::make('roleolcid')
                    ->options(function () {
                        // Selecciona los campos 'milimetros' y 'pulgadas' y los concatena
                        return DB::table('roleo_long_vehiculos')
                            ->select(
                                'id',
                                DB::raw("CONCAT(milimetros, ', ', pulgadas) as detalles")
                            )
                            ->pluck('detalles', 'id');
                    })
                    ->title('Seleccione una Roleo LC')
                    ->empty('')
                    ->id('roleolcidInput')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Roleo LL.'),
                Select::make('roleollid')
                    ->options(function () {
                        // Selecciona los campos 'milimetros' y 'pulgadas' y los concatena
                        return DB::table('roleo_long_vehiculos')
                            ->select(
                                'id',
                                DB::raw("CONCAT(milimetros, ', ', pulgadas) as detalles")
                            )
                            ->pluck('detalles', 'id');
                    })
                    ->title('Seleccione una Roleo LL')
                    ->empty('')
                    ->id('roleollidInput')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Roleo LL.'),
            ]),
            // Fila 8
            Group::make([
                Input::make('dosroleolc')
                    ->title('2Roleo LC')
                    ->type(value: 'text')
                    ->id('2roleolcInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('2Roleo LC'),
                Input::make(name: 'dosroleollcm')
                    ->title('2Roleo LL')
                    ->type(value: 'text')
                    ->id('2roleollcmInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('2Roleo LL'),
                Select::make('dosporcenroleo')
                    ->options([
                        0 => '0%',
                        1 => '25%',
                        2 => '75%',
                        3 => '100%',
                    ])
                    ->title('Seleccione un 2% Roleo')
                    ->id('2porcenroleoInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un 2% Roleo.'),
            ]),
            // Fila 9
            Group::make([
                Select::make('diambocadoid')
                    ->options(value: [
                        0 => '1.25"',
                        1 => '1.50"',
                        2 => '1.75"',
                        3 => '2.0"',
                        4 => '2.25"',
                    ])
                    ->title('Seleccione un Diam Bocado')
                    ->id('diambocadoidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Diam Bocado.'),
                Select::make('anchoteid')
                    ->options(value: [
                        0 => '1.0"',
                        1 => '1.25"',
                        2 => '1.50"',
                        3 => '1.75"',
                        4 => '2.0"',
                        5 => '2.25"',
                    ])
                    ->title('Seleccione un Ancho TE')
                    ->id('anchoteidInput')
                    ->empty('')
                    ->searchable()
                    ->disable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Ancho TE.'),
                Select::make('destajeid')
                    ->options(value: [
                        0 => 'SiLC -- NoLL',
                        1 => 'No',
                        2 => 'SiLL -- NoLC',
                        3 => 'SiLL -- SiLC',
                    ])
                    ->title('Seleccione un Destaje')
                    ->id('destajeidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Destaje.'),
            ]),
            // Fila 10
            Group::make([
                Select::make('porcendespunte')
                    ->options([
                        0 => '0%',
                        1 => '25%',
                        2 => '75%',
                        3 => '100%',
                    ])
                    ->title('Seleccione un % Despunte')
                    ->id('porcendespunteInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un % Despunte.'),
                Select::make('abraztipoid')
                    ->options([
                        0 => '',
                        1 => 'Tornillo',
                        2 => 'Doblada',
                    ])
                    ->title('Seleccione un Abraz Tipo')
                    ->id('abraztipoidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Abraz Tipo.'),
                Select::make('abrazmasterid')
                    ->options([
                        0 => '',
                        1 => '1/8x3/4',
                        2 => '1/8x1.0',
                        3 => '1/8x1.1/4',
                        4 => '3/16x3/4',
                        5 => '3/16x1.0',
                        6 => '3/16x1.1/4',
                        7 => '1/4x3/4',
                        8 => '1/4x1.0',
                        9 => '1/4x1.1/4',
                    ])
                    ->title('Seleccione un Abraz Master')
                    ->id('abrazmasteridInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Abraz Master.'),
            ]),
            // Fila 11
            Group::make([
                Input::make('abrazlongcm')
                    ->title('Abraz Long CM')
                    ->type(value: 'text')
                    ->id('abrazlongcmInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Abraz Long CM'),
                Select::make('diatcid')
                    ->options([
                        0 => '',
                        1 => '6',
                        2 => '7',
                        3 => '8',
                        4 => '8.5',
                        5 => '9',
                        6 => '9.5',
                        7 => '10',
                        8 => '10.5',
                        9 => '11',
                        10 => '11.5',
                        11 => '12',
                        12 => '12.5',
                        13 => '13',
                        14 => '13.5',
                        15 => '14',
                        16 => '14.5',
                        17 => '15',
                        18 => '15.5',
                        19 => '16',
                        20 => '16.5',
                        21 => '19',
                        22 => '19.5',
                        23 => '20',
                        24 => '22',
                        25 => '23',
                        26 => '25',
                        27 => '26',
                    ])
                    ->title('Seleccione un Dia TC')
                    ->id('diatcidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Dia TC.'),
                Select::make('tiposbujesid')
                    ->options([
                        0 => '',
                        1 => 'Tipos de Buje',
                        2 => 'RB buje',
                        3 => 'BM buje',
                        4 => 'TB buje',
                        5 => 'HB buje',
                        6 => 'Copa buje',
                    ])
                    ->title('Seleccione un Tipo de Buje')
                    ->id('tiposbujesidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Tipo de Buje.'),
            ]),
            // Fila 12
            Group::make([
                Select::make('bujelcid')
                    ->options(function () {
                        // Selecciona los campos 'part_no', 'od_a', 'id_b', 'length_c' y los concatena
                        return DB::table('buje_l_c_s')
                            ->select(
                                'id',
                                DB::raw("CONCAT(part_no, ', ', od_a, ', ', id_b, ', ', length_c) as detalles")
                            )
                            ->pluck('detalles', 'id');
                    })
                    ->title('Seleccione un Buje LC')
                    ->id('bujelcidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Buje LC.'),
                Select::make('bujellid')
                    ->options(function () {
                        // Selecciona los campos 'dim_a', 'dim_b', 'dim_c', 'dim_d' y 'remarks' y los concatena
                        return DB::table('buje_l_l_s')
                            ->select(
                                'id',
                                DB::raw("CONCAT(dim_a, ', ', dim_b, ', ', dim_c, ', ', dim_d, ', ', remarks) as dimensiones")
                            )
                            ->pluck('dimensiones', 'id');
                    })
                    ->title('Seleccione un Buje LL')
                    ->id('bujellidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Buje LL.'),
                Select::make('brioid')
                    ->options(function () {
                        // Selecciona los campos 'cm' e 'inches' y los concatena
                        return DB::table('brios')
                            ->select(
                                'id',
                                DB::raw("CONCAT(cm, ' - ', inches) as cm_and_inches")
                            )
                            ->pluck('cm_and_inches', 'id');
                    })
                    ->title('Seleccione un Brio CM')
                    ->id('brioidInput')
                    ->empty('')
                    ->searchable()
                    ->set('class', 'selectpicker')
                    ->disabled()
                    ->help('Por favor seleccione un Brio CM.'),
            ]),
            // Fila 13
            Group::make([
                Input::make('pesokg')
                    ->title('Peso KG')
                    ->type(value: 'text')
                    ->id('pesokgInput')
                    ->autocomplete('off')
                    ->readonly()
                    ->placeholder('Peso KG'),
            ]),
            Group::make([
                ImagePreview::make()
                    ->containerId('imagePreviewContainerTipoHoja')
                    ->imageId('imagePreviewTipoHoja')
                    ->setImageUrl($imageUrl)
                    ->title('Tipo de Hoja'),
                ImagePreview::make()
                    ->containerId('imagePreviewContainerBujeLL')
                    ->imageId('imagePreviewBujeLL')
                    ->setImageUrl($imageUrl)
                    ->title('Buje LL'),
                ImagePreview::make()
                    ->containerId('imagePreviewContainerBujeLC')
                    ->imageId('imagePreviewBujeLC')
                    ->setImageUrl($imageUrl)
                    ->title('Buje LC'),
            ]),
            // Fila 15
            Group::make([
                TextArea::make('observacion')
                    ->title('Observación')
                    ->id('observacionInput')
                    ->rows(5)
                    ->width('100%'),
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
            TD::make('Acciones')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($model) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Ver')
                                ->route('platform.resource.view', ['resource' => 'description-part-resources', 'id' => $model->id])
                                ->icon('eye'),
                            Link::make('Editar')
                                ->route('platform.resource.edit', ['resource' => 'description-part-resources', 'id' => $model->id])
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
            TD::make('id')
                ->sort()
                ->filter(Input::make()),
            TD::make('code', 'Código')
                ->sort()
                ->filter(Input::make()),
            TD::make('typeid', 'Tipo')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => 'VEHICULO (01-99)',
                        1 => 'TRAMO TERMINADO (9T -- TrT)',
                        2 => 'TRAMO RECTO (9TR -- TrR)',
                        3 => 'GRAPA',
                    ][$descriptionPart->typeid] ?? '';
                }),
            TD::make('vehiculosid', 'Vehiculo')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $vehiculo = Vehiculo::Find($descriptionPart->vehiculosid);
                    return $vehiculo ? $vehiculo->descripcionvehiculo : '';
                }),
            TD::make('modelid', 'Modelo')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $modelo = ModeloVehiculo::Find($descriptionPart->modelid);
                    return $modelo ? $modelo->modelo_detalle : '';
                }),
            TD::make('apodo', 'Apodo')
                ->sort()
                ->filter(Input::make()),
            TD::make('yearid', 'Año')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $year = YearVehiculo::Find($descriptionPart->modelid);
                    return $year ? $year->year_vh : '';
                }),
            TD::make('positionid', 'Posición')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $position = PosicionVehiculo::Find($descriptionPart->modelid);
                    return $position ? $position->posicion : '';
                }),
            TD::make('dlttrsid', 'Dlt/Trs')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => 'T',
                        1 => 'D',
                    ][$descriptionPart->dlttrsid] ?? '';
                }),
            TD::make('identidad', 'Identidad')
                ->sort()
                ->filter(Input::make()),
            TD::make('refauxid', 'Ref/Aux')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $ref = RefTensadoVehiculo::Find($descriptionPart->modelid);
                    return $ref ? $ref->letra : '';
                }),
            TD::make('materialgrapaid', 'Material Grapa')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $materialGrapa = DB::table('material_grapas')
                        ->select(DB::raw("CONCAT(inches, ', ', decimal, ', ', mm) as detalles"))
                        ->where('id', $descriptionPart->materialgrapaid)
                        ->first();

                    return $materialGrapa ? $materialGrapa->detalles : '';
                }),
            TD::make('anchomm', 'Ancho')
                ->sort()
                ->filter(Input::make()),
            TD::make('gruesomm', 'Grueso (mm)')
                ->sort()
                ->filter(Input::make()),
            TD::make('longit', 'Longit (mm)')
                ->sort()
                ->filter(Input::make()),
            TD::make('description', 'Descripción')
                ->sort()
                ->filter(Input::make()),
            TD::make('tipohojaid', 'Tipo Hoja')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $tipoHoja = TipoHojaVehiculo::Find($descriptionPart->modelid);
                    return $tipoHoja ? $tipoHoja->tipo_hoja : '';
                }),
            TD::make('cortecm', 'Corte (cm)')
                ->sort()
                ->filter(Input::make()),
            TD::make('distcccm', 'DistCC (cm)')
                ->sort()
                ->filter(Input::make()),
            TD::make('lccm', 'LC (cm)')
                ->sort()
                ->filter(Input::make()),
            TD::make('llcm', 'LL (cm)')
                ->sort()
                ->filter(Input::make()),
            TD::make('roleolcid', 'RoleoLC')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $roleolc = DB::table('roleo_long_vehiculos')
                        ->select(DB::raw("CONCAT(milimetros, ', ', pulgadas) as detalles"))
                        ->where('id', $descriptionPart->roleolcid)
                        ->first();

                    return $roleolc ? $roleolc->detalles : '';
                }),
            TD::make('roleollid', 'Roleo LL')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $roleoll = DB::table('roleo_long_vehiculos')
                        ->select(DB::raw("CONCAT(milimetros, ', ', pulgadas) as detalles"))
                        ->where('id', $descriptionPart->roleollid)
                        ->first();

                    return $roleoll ? $roleoll->detalles : '';
                }),
            TD::make('dosroleolc', '2RoleoLL')
                ->sort()
                ->filter(Input::make()),
            TD::make('dosroleoll', '2RoleoLC')
                ->sort()
                ->filter(Input::make()),
            TD::make('dosroleollcm', '2Roleo LL')
                ->sort()
                ->filter(Input::make()),
            TD::make('dosporcenroleo', '2% Roleo')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => '0%',
                        1 => '25%',
                        2 => '75%',
                        3 => '100%',
                    ][$descriptionPart->dosporcenroleo] ?? '';
                }),
            TD::make('diambocadoid', 'Diam Bocado')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => '1.25"',
                        1 => '1.50"',
                        2 => '1.75"',
                        3 => '2.0"',
                        4 => '2.25"',
                    ][$descriptionPart->diambocadoid] ?? '';
                }),
            TD::make('anchoteid', 'Ancho TE')
                ->sort()
                ->filter(Input::make()),
            TD::make('destajeid', 'Destaje')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => 'SiLC -- NoLL',
                        1 => 'No',
                        2 => 'SiLL -- NoLC',
                        3 => 'SiLL -- SiLC',
                    ][$descriptionPart->destajeid] ?? '';
                }),
            TD::make('porcendespunte', '% Despunte')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => '0%',
                        1 => '25%',
                        2 => '75%',
                        3 => '100%',
                    ][$descriptionPart->porcendespunte] ?? '';
                }),
            TD::make('abraztipoid', 'Abraz-Tipo')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => '',
                        1 => 'Tornillo',
                        2 => 'Doblada',
                    ][$descriptionPart->abraztipoid] ?? '';
                }),
            TD::make('abrazmasterid', 'Abraz-Master')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => '',
                        1 => '1/8x3/4',
                        2 => '1/8x1.0',
                        3 => '1/8x1.1/4',
                        4 => '3/16x3/4',
                        5 => '3/16x1.0',
                        6 => '3/16x1.1/4',
                        7 => '1/4x3/4',
                        8 => '1/4x1.0',
                        9 => '1/4x1.1/4',
                    ][$descriptionPart->abrazmasterid] ?? '';
                }),
            TD::make('abrazlongcm', 'Abrazad-Long (cm)')
                ->sort()
                ->filter(Input::make()),
            TD::make('diatcid', 'DiaTC')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => '',
                        1 => '6',
                        2 => '7',
                        3 => '8',
                        4 => '8.5',
                        5 => '9',
                        6 => '9.5',
                        7 => '10',
                        8 => '10.5',
                        9 => '11',
                        10 => '11.5',
                        11 => '12',
                        12 => '12.5',
                        13 => '13',
                        14 => '13.5',
                        15 => '14',
                        16 => '14.5',
                        17 => '15',
                        18 => '15.5',
                        19 => '16',
                        20 => '16.5',
                        21 => '19',
                        22 => '19.5',
                        23 => '20',
                        24 => '22',
                        25 => '23',
                        26 => '25',
                        27 => '26',
                    ][$descriptionPart->diatcid] ?? '';
                }),
            TD::make('tiposbujesid', 'Tipos de Buje')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    return [
                        0 => '',
                        1 => 'Tipos de Buje',
                        2 => 'RB buje',
                        3 => 'BM buje',
                        4 => 'TB buje',
                        5 => 'HB buje',
                        6 => 'Copa buje',
                    ][$descriptionPart->tiposbujesid] ?? '';
                }),
            TD::make('bujelcid', 'Buje LC')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $bujelc = DB::table('buje_l_c_s')
                        ->select(DB::raw("CONCAT(part_no, ', ', od_a, ', ', id_b, ', ', length_c) as detalles"))
                        ->where('id', $descriptionPart->bujelcid)
                        ->first();

                    return $bujelc ? $bujelc->detalles : '';
                }),
            TD::make('bujellid', 'Buje LL')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $bujell = DB::table('buje_l_l_s')
                        ->select(DB::raw("CONCAT(dim_a, ', ', dim_b, ', ', dim_c, ', ', dim_d, ', ',  remarks) as detalles"))
                        ->where('id', $descriptionPart->bujellid)
                        ->first();

                    return $bujell ? $bujell->detalles : '';
                }),
            TD::make('brioid', 'Brio (cm)')
                ->sort()
                ->filter(Input::make())
                ->render(function ($descriptionPart) {
                    $bujell = DB::table('brios')
                        ->select(DB::raw("CONCAT(cm, ', ', inches) as detalles"))
                        ->where('id', $descriptionPart->bujellid)
                        ->first();

                    return $bujell ? $bujell->detalles : '';
                }),
            TD::make('pesokg', 'Peso (kg)')
                ->sort()
                ->filter(Input::make()),
            TD::make('observacion', 'Observación')
                ->sort()
                ->filter(Input::make()),
            TD::make('rosca', 'Rosca')
                ->sort()
                ->filter(Input::make()),
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
                })
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
            Sight::make('code', 'Código'),
            Sight::make('typeid', 'Tipo Vehículo')
                ->render(function ($model) {
                    return [
                        0 => 'VEHICULO (01-99)',
                        1 => 'TRAMO TERMINADO (9T -- TrT)',
                        2 => 'TRAMO RECTO (9TR -- TrR)',
                        3 => 'GRAPA',
                    ][$model->typeid] ?? '';
                }),
            Sight::make('vehiculoid', 'Vehículo')
                ->render(function ($model) {
                    return $model->vehiculo->nombre ?? '';  // Cambia 'nombre' al campo correspondiente
                }),
            Sight::make('modelid', 'Modelo')
                ->render(function ($model) {
                    return $model->modelo->nombre ?? '';  // Cambia 'nombre' al campo correspondiente
                }),
            Sight::make('apodo', 'Apodo'),
            Sight::make('yearid', 'Año'),
            Sight::make('positionid', 'Posición')
                ->render(function ($model) {
                    return $model->posicion->posicion ?? '';  // Cambia 'posicion' al campo correspondiente
                }),
            Sight::make('dlttrsid', 'Dlt/Trs'),
            Sight::make('identidad', 'Identidad'),
            Sight::make('refauxid', 'Ref/Aux'),
            Sight::make('materialgrapaid', 'Material Grapa')
                ->render(function ($model) {
                    return $model->materialGrapa->nombre ?? '';  // Cambia 'nombre' al campo correspondiente
                }),
            Sight::make('anchomm', 'Ancho (mm)'),
            Sight::make('gruesomm', 'Grueso (mm)'),
            Sight::make('longit', 'Longit (cm)'),
            Sight::make('description', 'Descripción'),
            Sight::make('tipohojaid', 'Tipo Hoja'),
            Sight::make('cortecm', 'Corte (cm)'),
            Sight::make('distcccm', 'DistCC (cm)'),
            Sight::make('lccm', 'LC (cm)'),
            Sight::make('llcm', 'LL (cm)'),
            Sight::make('roleolcid', 'RoleoLC')
                ->render(function ($descriptionPart) {
                    $roleolc = DB::table('roleo_long_vehiculos')
                        ->select(DB::raw("CONCAT(milimetros, ', ', pulgadas) as detalles"))
                        ->where('id', $descriptionPart->roleolcid)
                        ->first();

                    return $roleolc ? $roleolc->detalles : '';
                }),
            Sight::make('roleollid', 'RoleoLL')
                ->render(function ($descriptionPart) {
                    $roleoll = DB::table('roleo_long_vehiculos')
                        ->select(DB::raw("CONCAT(milimetros, ', ', pulgadas) as detalles"))
                        ->where('id', $descriptionPart->roleollid)
                        ->first();

                    return $roleoll ? $roleoll->detalles : '';
                }),
            Sight::make('dosroleolc', '2Roleo LC'),
            Sight::make('dosroleoll', '2Roleo LL'),
            Sight::make('dosporcenroleo', '2% Roleo')
                ->render(function ($descriptionPart) {
                    return [
                        0 => '0%',
                        1 => '25%',
                        2 => '75%',
                        3 => '100%',
                    ][$descriptionPart->dosporcenroleo] ?? '';
                }),
            Sight::make('diambocadoid', 'Diam Bocado')
                ->render(function ($descriptionPart) {
                    return [
                        0 => '1.25"',
                        1 => '1.50"',
                        2 => '1.75"',
                        3 => '2.0"',
                        4 => '2.25"',
                    ][$descriptionPart->diambocadoid] ?? '';
                }),
            Sight::make('anchoteid', 'Ancho TE'),
            Sight::make('destajeid', 'Destaje')
                ->render(function ($descriptionPart) {
                    return [
                        0 => 'SiLC -- NoLL',
                        1 => 'No',
                        2 => 'SiLL -- NoLC',
                        3 => 'SiLL -- SiLC',
                    ][$descriptionPart->destajeid] ?? '';
                }),
            Sight::make('porcendespunte', '% Despunte')
                ->render(function ($descriptionPart) {
                    return [
                        0 => '0%',
                        1 => '25%',
                        2 => '75%',
                        3 => '100%',
                    ][$descriptionPart->porcendespunte] ?? '';
                }),
            Sight::make('abraztipoid', 'Abraz-Tipo')
                ->render(function ($descriptionPart) {
                    return [
                        0 => '',
                        1 => 'Tornillo',
                        2 => 'Doblada',
                    ][$descriptionPart->abraztipoid] ?? '';
                }),
            Sight::make('abrazmasterid', 'Abraz-Master')
                ->render(function ($descriptionPart) {
                    return [
                        0 => '',
                        1 => '1/8x3/4',
                        2 => '1/8x1.0',
                        3 => '1/8x1.1/4',
                        4 => '3/16x3/4',
                        5 => '3/16x1.0',
                        6 => '3/16x1.1/4',
                        7 => '1/4x3/4',
                        8 => '1/4x1.0',
                        9 => '1/4x1.1/4',
                    ][$descriptionPart->abrazmasterid] ?? '';
                }),
            Sight::make('abrazlongcm', 'Abraz-Long (cm)'),
            Sight::make('diatcid', 'DiaTC')->render(function ($descriptionPart) {
                return [
                    0 => '',
                    1 => '6',
                    2 => '7',
                    3 => '8',
                    4 => '8.5',
                    5 => '9',
                    6 => '9.5',
                    7 => '10',
                    8 => '10.5',
                    9 => '11',
                    10 => '11.5',
                    11 => '12',
                    12 => '12.5',
                    13 => '13',
                    14 => '13.5',
                    15 => '14',
                    16 => '14.5',
                    17 => '15',
                    18 => '15.5',
                    19 => '16',
                    20 => '16.5',
                    21 => '19',
                    22 => '19.5',
                    23 => '20',
                    24 => '22',
                    25 => '23',
                    26 => '25',
                    27 => '26',
                ][$descriptionPart->diatcid] ?? '';
            }),
            Sight::make('tiposbujesid', 'Tipos de Buje')
                ->render(function ($descriptionPart) {
                    return [
                        0 => '',
                        1 => 'Tipos de Buje',
                        2 => 'RB buje',
                        3 => 'BM buje',
                        4 => 'TB buje',
                        5 => 'HB buje',
                        6 => 'Copa buje',
                    ][$descriptionPart->tiposbujesid] ?? '';
                }),
            Sight::make('bujelcid', 'Buje LC')
                ->render(function ($descriptionPart) {
                    $bujelc = DB::table('buje_l_c_s')
                        ->select(DB::raw("CONCAT(part_no, ', ', od_a, ', ', id_b, ', ', length_c) as detalles"))
                        ->where('id', $descriptionPart->bujelcid)
                        ->first();

                    return $bujelc ? $bujelc->detalles : '';
                }),
            Sight::make('bujellid', 'Buje LL')
                ->render(function ($descriptionPart) {
                    $bujell = DB::table('buje_l_l_s')
                        ->select(DB::raw("CONCAT(dim_a, ', ', dim_b, ', ', dim_c, ', ', dim_d, ', ',  remarks) as detalles"))
                        ->where('id', $descriptionPart->bujellid)
                        ->first();

                    return $bujell ? $bujell->detalles : '';
                }),
            Sight::make('brioid', 'Brio (cm)')
                ->render(function ($descriptionPart) {
                    $bujell = DB::table('brios')
                        ->select(DB::raw("CONCAT(cm, ', ', inches) as detalles"))
                        ->where('id', $descriptionPart->bujellid)
                        ->first();

                    return $bujell ? $bujell->detalles : '';
                }),
            Sight::make('pesokg', 'Peso (kg)'),
            Sight::make('observacion', 'Observación'),
            Sight::make('rosca', 'Rosca'),
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
     * Save the uploaded image and store a copy in the public/uploads folder.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DescriptionPart $descriptionPart
     * @return void
     */
    /*public function onSave(Request $request, DescriptionPart $descriptionPart): void
    {
        // dd($request->all());
        // Registrar los datos del request en el archivo de log
        Log::info($request->all());

        // Validar los datos del request
        // $validatedData = $request->validate($this->rules($descriptionPart), $this->messages());

        // Guardar los datos del tipo de hoja
        $descriptionPart->code = $request['code'] ?? '';
        $descriptionPart->typeid = $valirequestdatedData['typeid'] ?? '';

        $descriptionPart->save();

        // Mostrar mensaje de éxito
        Toast::info(message: __('Datos guardados exitosamente.'));
    }*/

    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'code' => 'required|string|max:255',
            'typeid' => 'nullable|string|max:255',
            'vehiculosid' => 'nullable|integer',
            'modelid' => 'nullable|integer',
            'apodo' => 'nullable|string|max:255',
            'yearid' => 'nullable|integer',
            'positionid' => 'nullable|integer',
            'dlttrsid' => 'nullable|string|max:255',
            'identidad' => 'nullable|string|max:255',
            'refauxid' => 'nullable|integer',
            'materialgrapaid' => 'nullable|integer',
            'materialid' => 'nullable|integer',
            'anchomm' => 'nullable|string|max:255',
            'gruesomm' => 'nullable|string|max:255',
            'longit' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'tipohojaid' => 'nullable|integer',
            'cortecm' => 'nullable|string|max:255',
            'distcccm' => 'nullable|string|max:255',
            'lccm' => 'nullable|string|max:255',
            'llcm' => 'nullable|string|max:255',
            'roleolcid' => 'nullable|integer',
            'roleollid' => 'nullable|integer',
            'dosroleolc' => 'nullable|string|max:255',
            'dosroleollcm' => 'nullable|string|max:255',
            'dosporcenroleo' => 'nullable|string|max:255',
            'diambocadoid' => 'nullable|string|max:255',
            'anchoteid' => 'nullable|string|max:255',
            'destajeid' => 'nullable|string|max:255',
            'porcendespunte' => 'nullable|integer',
            'abraztipoid' => 'nullable|integer',
            'abrazmasterid' => 'nullable|integer',
            'abrazlongcm' => 'nullable|string|max:255',
            'diatcid' => 'nullable|integer',
            'tiposbujesid' => 'nullable|integer',
            'bujelcid' => 'nullable|integer',
            'bujellid' => 'nullable|integer',
            'brioid' => 'nullable|integer',
            'pesokg' => 'nullable|string|max:255',
            'observacion' => 'nullable|string|max:255',
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
            'code.required' => 'El código es obligatorio.',
            'code.string' => 'El código debe ser un texto.',
            'code.max' => 'El código no puede tener más de 255 caracteres.',
            'typeid.string' => 'El tipo debe ser un texto.',
            'typeid.max' => 'El tipo no puede tener más de 255 caracteres.',
            'vehiculosid.integer' => 'El ID de vehículo debe ser un número.',
            'modelid.integer' => 'El ID del modelo debe ser un número.',
            'apodo.string' => 'El apodo debe ser un texto.',
            'apodo.max' => 'El apodo no puede tener más de 255 caracteres.',
            'yearid.integer' => 'El ID del año debe ser un número.',
            'positionid.integer' => 'El ID de la posición debe ser un número.',
            'dlttrsid.string' => 'El campo DL TTRS debe ser un texto.',
            'dlttrsid.max' => 'El campo DL TTRS no puede tener más de 255 caracteres.',
            'identidad.string' => 'El campo identidad debe ser un texto.',
            'identidad.max' => 'El campo identidad no puede tener más de 255 caracteres.',
            'refauxid.integer' => 'El ID de referencia auxiliar debe ser un número.',
            'materialgrapaid.integer' => 'El ID de material de grapa debe ser un número.',
            'materialid.integer' => 'El ID de material debe ser un número.',
            'anchomm.string' => 'El ancho en mm debe ser un texto.',
            'anchomm.max' => 'El ancho en mm no puede tener más de 255 caracteres.',
            'gruesomm.string' => 'El grosor en mm debe ser un texto.',
            'gruesomm.max' => 'El grosor en mm no puede tener más de 255 caracteres.',
            'longit.string' => 'La longitud debe ser un texto.',
            'longit.max' => 'La longitud no puede tener más de 255 caracteres.',
            'description.string' => 'La descripción debe ser un texto.',
            'description.max' => 'La descripción no puede tener más de 255 caracteres.',
            'tipohojaid.integer' => 'El ID del tipo de hoja debe ser un número.',
            'cortecm.string' => 'El corte en cm debe ser un texto.',
            'cortecm.max' => 'El corte en cm no puede tener más de 255 caracteres.',
            'distcccm.string' => 'La distancia en cc cm debe ser un texto.',
            'distcccm.max' => 'La distancia en cc cm no puede tener más de 255 caracteres.',
            'lccm.string' => 'El campo LCCM debe ser un texto.',
            'lccm.max' => 'El campo LCCM no puede tener más de 255 caracteres.',
            'llcm.string' => 'El campo LLCM debe ser un texto.',
            'llcm.max' => 'El campo LLCM no puede tener más de 255 caracteres.',
            'roleolcid.integer' => 'El ID de roleolc debe ser un número.',
            'roleollid.integer' => 'El ID de roleoll debe ser un número.',
            'dosroleolc.string' => 'El segundo roleolc debe ser un texto.',
            'dosroleolc.max' => 'El segundo roleolc no puede tener más de 255 caracteres.',
            'dosroleollcm.string' => 'El segundo roleol LLCM debe ser un texto.',
            'dosroleollcm.max' => 'El segundo roleol LLCM no puede tener más de 255 caracteres.',
            'dosporcenroleo.string' => 'El porcentaje de roleo debe ser un texto.',
            'dosporcenroleo.max' => 'El porcentaje de roleo no puede tener más de 255 caracteres.',
            'diambocadoid.string' => 'El ID de diámetro de bocado debe ser un texto.',
            'diambocadoid.max' => 'El ID de diámetro de bocado no puede tener más de 255 caracteres.',
            'anchoteid.string' => 'El ID de ancho de TE debe ser un texto.',
            'anchoteid.max' => 'El ID de ancho de TE no puede tener más de 255 caracteres.',
            'destajeid.string' => 'El ID de destaje debe ser un texto.',
            'destajeid.max' => 'El ID de destaje no puede tener más de 255 caracteres.',
            'porcendespunte.integer' => 'El porcentaje de despunte debe ser un número.',
            'abraztipoid.integer' => 'El ID del tipo de abrazadera debe ser un número.',
            'abrazmasterid.integer' => 'El ID de la abrazadera maestra debe ser un número.',
            'abrazlongcm.string' => 'La longitud de abrazadera en cm debe ser un texto.',
            'abrazlongcm.max' => 'La longitud de abrazadera en cm no puede tener más de 255 caracteres.',
            'diatcid.integer' => 'El ID de diatc debe ser un número.',
            'tiposbujesid.integer' => 'El ID del tipo de buje debe ser un número.',
            'bujelcid.integer' => 'El ID del buje LC debe ser un número.',
            'bujellid.integer' => 'El ID del buje LL debe ser un número.',
            'brioid.integer' => 'El ID de BRIO debe ser un número.',
            'pesokg.string' => 'El peso en kg debe ser un texto.',
            'pesokg.max' => 'El peso en kg no puede tener más de 255 caracteres.',
            'observacion.string' => 'La observación debe ser un texto.',
            'observacion.max' => 'La observación no puede tener más de 255 caracteres.',
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
        return __('Descripción de Partes');
    }

    /**
     * Get the title for the resource.
     *
     * @return string
     */
    public function title(): string
    {
        // Este método define el título que se mostrará en la vista de detalles del recurso.
        return __('Descripción de Partes');
    }

    /**
     * Get the singular name of the resource.
     *
     * @return string
     */
    public static function singular(): string
    {
        return __('Descripción de Parte');
    }

    /**
     * Get the plural name of the resource.
     *
     * @return string
     */
    public static function plural(): string
    {
        return __('Descripción de Partes');
    }

    /**
     * Get the description of the resource.
     *
     * @return string
     */
    public static function description(): string
    {
        return __('Gestión de Descripciones de Partes');
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
