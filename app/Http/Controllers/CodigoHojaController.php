<?php

namespace App\Http\Controllers;

use App\Models\MaterialConstVehiculo;
use App\Models\Vehiculo;
use Illuminate\Http\JsonResponse;
use \App\Models\MaterialGrapa;
use \App\Models\ModeloVehiculo;

class CodigoHojaController extends Controller
{
    /**
     * Obtiene el código de tipo de un vehículo específico.
     *
     * @param int $id El ID del vehículo.
     * @return JsonResponse El número del vehículo en formato JSON.
     */
    public function obtenerCodigoTipoVehiculo(int $id): JsonResponse
    {
        // Si el ID es 0, devolver directamente el número 0
        if ($id === 0) {
            return response()->json(['numero' => 0]);
        }

        // Buscar el vehículo por su typeid
        $vehiculo = Vehiculo::where('typeid', $id)->first();

        // Verificar si el vehículo existe
        if ($vehiculo) {
            return response()->json(['numero' => $vehiculo->numero, 'message' => 'Código obtenido exitosamente.']);
        }

        // En caso de que no se encuentre el vehículo
        return response()->json(['error' => 'Vehículo no encontrado'], 404);
    }

    /**
     * Obtiene el material combinado de un vehículo específico.
     *
     * @param int $id El ID del material del vehículo.
     * @return JsonResponse El material combinado en formato JSON.
     */
    public function obtenerMaterialCombinadoMaterial(int $id): JsonResponse
    {
        // Si el ID es 0, devolver directamente el número 0
        if ($id === 0) {
            return response()->json(['material_combinado' => 0]);
        }

        // Buscar el material del vehículo por su ID
        $materialConstVehiculo = MaterialConstVehiculo::find($id);

        // Verificar si el material del vehículo existe
        if ($materialConstVehiculo) {
            return response()->json(['material_combinado' => $materialConstVehiculo->material_combinado, 'message' => 'Material Combinado obtenido exitosamente.']);
        }

        // En caso de que no se encuentre el material del vehículo
        return response()->json(['error' => 'Material Combinado no encontrado'], 404);
    }

    /**
     * Obtiene las pulgadas de un material de grapa específico.
     *
     * @param int $id El ID del material de grapa.
     * @return JsonResponse Las pulgadas del material de grapa en formato JSON.
     */
    public function obtenerInchesMaterialGrapa(int $id): JsonResponse
    {
        // Si el ID es 0, devolver directamente el número 0
        if ($id === 0) {
            return response()->json(['inches' => 0]);
        }

        // Buscar el material de grapa por su ID
        $materialGrapa = MaterialGrapa::find($id);

        // Verificar si el material de grapa existe
        if ($materialGrapa) {
            return response()->json(['inches' => $materialGrapa->inches, 'message' => 'Pulgadas obtenido exitosamente.']);
        }

        // En caso de que no se encuentre el material de grapa
        return response()->json(['error' => 'Pulgadas no encontrado'], 404);
    }

    /**
     * Obtiene el nombre corto y el detalle del modelo de un vehículo específico.
     *
     * @param int $id El ID del modelo del vehículo.
     * @return JsonResponse El nombre corto y el detalle del modelo en formato JSON.
     */
    public function obtenerNombreCortoVehiculo(int $id): JsonResponse
    {
        // Si el ID es 0, devolver directamente el número 0
        if ($id === 0) {
            return response()->json(['nombrecorto' => 0]);
        }

        // Buscar el modelo de vehículo y el vehículo relacionado en una sola consulta
        $modelo_vehiculos = ModeloVehiculo::with('vehiculo')->find($id);

        // Verificar si el modelo de vehículo existe y tiene un vehículo relacionado
        if ($modelo_vehiculos && $modelo_vehiculos->vehiculo) {
            return response()->json([
                'nombrecorto' => $modelo_vehiculos->vehiculo->nombrecorto,
                'modelo_detalle' => $modelo_vehiculos->modelo_detalle,
                'message' => 'Datos obtenidos exitosamente.'
            ]);
        }

        // En caso de que no se encuentre el vehículo
        return response()->json(['error' => 'Datos no encontrados'], 404);
    }
}