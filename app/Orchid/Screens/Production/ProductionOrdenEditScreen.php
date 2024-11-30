<?php

namespace App\Orchid\Screens\Production;

use App\Models\ProductionOrden;
use App\Orchid\Layouts\Production\ProductionOrdenEditLayout;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class ProductionOrdenEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $order = null): iterable
    {
        if ($order) {
            $productionOrder = ProductionOrden::with('details')->findOrFail($order);
            $products = $productionOrder->details->map(function ($detail) {
                return [
                    'idDescriptionParts' => $detail->part_id,
                    'description' => $detail->description,
                    'quantity' => $detail->quantity,
                ];
            })->toArray();

            // Formatear la fecha de producción solo a 'Y-m-d'
            $productionDate = Carbon::parse($productionOrder->production_date)->format('Y-m-d');
        } else {
            $products = [];
            $productionDate = now()->format('Y-m-d');
        }

        return [
            'products' => $products,
            'production_date' => $productionDate,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Editar Ordenes de Porducción';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Modifica las ordenes de produccion asociadas existentes en el sistema';
    }

    /**
     * The permissions required to access this screen.
     */
    public function permission(): ?iterable
    {
        return [
            'platform.production-orden',
        ];
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
                ProductionOrdenEditLayout::class,
            ])
                ->title('Órdenes de Producción')
                ->description('La orden de producción es un conjunto de instrucciones y recursos necesarios para la fabricación de un producto específico. Permite planificar, organizar y controlar cada etapa del proceso de producción.')
        ];
    }

    /**
     * Save the uploaded data and store it in the production orders table.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductionOrden $productionOrden
     * @return mixed
     */
    public function save(Request $request, ProductionOrden $productionOrden = null): mixed
    {
        // Validar los datos del request
        $validatedData = $request->validate($this->rules($productionOrden), $this->messages());

        // Verificar si hay productos
        if (empty($validatedData['products'])) {
            Toast::error(__('No se han proporcionado productos. Por favor, añade al menos un producto.'));
            return redirect()->back();  // Redirige de nuevo a la misma página si no hay productos
        }

        // Obtener la fecha de producción y establecer la hora actual
        $productionDateTime = Carbon::parse($validatedData['production_date'])->setTime(now()->hour, now()->minute);

        // cosultame el numero de la tabla maestra

        $numeroMaestro = 1;  // Encargado de definir en que numero comienza numeracion, a partir del primer registro

        // Obtener el último número de orden
        $lastOrder = ProductionOrden::orderBy('numero_orden', 'desc')->first();
        $nextNumber = $lastOrder ? intval(substr($lastOrder->numero_orden, 2)) + 1 : $numeroMaestro;

        // Formar el nuevo numero_orden
        $newOrderNumber = 'OP' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Crear la orden de producción principal
        $productionOrden = ProductionOrden::create([
            'numero_orden' => $newOrderNumber,
            'production_date' => $productionDateTime
        ]);

        // Recorrer los productos validados y guardar los detalles de la orden
        foreach ($validatedData['products'] as $product) {
            // Asignar los valores del producto a la tabla de detalles de la orden
            $productionOrden->details()->create([
                'part_id' => $product['idDescriptionParts'],  // Usar la clave foránea correcta para 'part_id'
                'quantity' => $product['quantity'],  // Cantidad del producto
                'quantity_weight' => 0,  // Cantidad del producto en pesos (medida)
                'description' => $product['description'],  // Descripción del producto
            ]);
        }

        // Mostrar mensaje de éxito
        Toast::info(__('Datos guardados exitosamente.'));

        // Redirigir a la ruta deseada después de guardar
        return redirect()->route('platform.production.orders');
    }

    public function update(Request $request, ProductionOrden $productionOrden)
    {
        // Mostrar mensaje de éxito
        Toast::info(__('Datos guardados exitosamente.'));

        // Redirigir a la ruta deseada después de guardar
        return redirect()->route('platform.production.orders');
    }

    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'production_date' => 'required|date',  // Requerido, debe ser una fecha válida
            'numero_orden' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('production_ordens')->ignore($model ? $model->id : null),
            ],
            'products.*.idDescriptionParts' => 'required|exists:description_parts,id',  // Requerido, debe existir en la tabla description_parts
            'products.*.description' => 'nullable|string|max:255',  // Opcional, cadena de texto, máximo 255 caracteres
            'products.*.quantity' => 'required|integer|min:1',  // Requerido, debe ser un número entero mayor o igual a 1
            'status_id' => 'nullable|exists:statuses,id',  // Opcional, debe existir en la tabla statuses
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
            'production_date.required' => 'La fecha de producción es obligatoria.',
            'production_date.date' => 'La fecha de producción debe ser una fecha válida.',
            // Mensajes para los productos en la matriz
            'products.*.idDescriptionParts.required' => 'El campo de descripción de partes es obligatorio para cada producto.',
            'products.*.idDescriptionParts.exists' => 'La descripción de partes seleccionada no es válida para uno o más productos.',
            'products.*.description.string' => 'La descripción debe ser un texto para cada producto.',
            'products.*.description.max' => 'La descripción no puede tener más de 255 caracteres en uno o más productos.',
            'products.*.quantity.required' => 'La cantidad es obligatoria para cada producto.',
            'products.*.quantity.integer' => 'La cantidad debe ser un número entero en uno o más productos.',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1 para cada producto.',
            'status_id.exists' => 'El estado seleccionado no es válido.',
        ];
    }
}
