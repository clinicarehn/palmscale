<?php

namespace App\Http\Controllers;

use App\Models\ModeloVehiculo;
use Illuminate\Http\Request;

class ModeloVehiculoController extends Controller
{
    public function getModelos($vehiculoId)
    {
        // Obtener modelos de vehículos filtrados por el id del vehículo
        $modelos = ModeloVehiculo::where('idVehiculo', $vehiculoId)->get(['id', 'modelo_detalle']);

        // Verificar si se encontraron modelos
        if ($modelos->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron modelos',
                'modelos' => [],
            ], 200);  // Devolver estado HTTP 200 con el mensaje
        }

        // Retornar los modelos en formato JSON para el uso de AJAX
        return response()->json($modelos, 200);
    }
}
