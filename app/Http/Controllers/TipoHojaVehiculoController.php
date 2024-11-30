<?php

namespace App\Http\Controllers;

use App\Models\TipoHojaVehiculo;

class TipoHojaVehiculoController extends Controller
{
    /**
     * Obtiene la URL de la imagen de un tipo de hoja de vehículo específico.
     *
     * @param int $id El ID del tipo de hoja de vehículo.
     * @return \Illuminate\Http\JsonResponse La URL de la imagen en formato JSON.
     */
    public function obtenerImagenTipoHoja($id)
    {
        // Buscar el tipo de hoja de vehículo por su ID
        $tipoHojaVehiculo = TipoHojaVehiculo::find($id);

        // Verificar si el tipo de hoja de vehículo existe y tiene una imagen subida
        if ($tipoHojaVehiculo && $tipoHojaVehiculo->upload) {
            $filePath = 'uploads/' . $tipoHojaVehiculo->upload;

            // Verificar si el archivo de imagen existe en el almacenamiento
            if (file_exists(storage_path('app/public/' . $filePath))) {
                return response()->json([
                    'imageUrl' => asset('storage/' . $filePath),
                ]);
            }
        }

        // En caso de que no se encuentre la imagen, devolver una imagen por defecto
        return response()->json([
            'imageUrl' => asset('storage/no-preview.jpg'),
        ]);
    }
}