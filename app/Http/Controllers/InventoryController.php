<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Registrar saldo inicial
    public function registrarSaldoInicial(Request $request)
    {
        $inventoryItem = new Inventory();
        $inventoryItem->idDescriptionParts = $request->input('idDescriptionParts');
        $inventoryItem->initial_balance = (float) $request->input('initial_balance');  // Convertir a decimal
        $inventoryItem->current_balance = (float) $request->input('initial_balance');  // Convertir a decimal
        $inventoryItem->final_balance = 0;
        $inventoryItem->save();

        return response()->json(['message' => 'Saldo inicial registrado correctamente.']);
    }

    // Registrar un movimiento
    public function registrarMovimiento(Request $request)
    {
        $idDescriptionParts = $request->input('idDescriptionParts');
        $cantidad = (float) $request->input('cantidad');  // Convertir a decimal
        $tipoMovimiento = $request->input('tipoMovimiento');

        $inventoryItem = Inventory::where('idDescriptionParts', $idDescriptionParts)->first();

        if ($tipoMovimiento == 'entrada') {
            $inventoryItem->entries += $cantidad;
            $inventoryItem->current_balance += $cantidad;
        } elseif ($tipoMovimiento == 'salida') {
            $inventoryItem->exits += $cantidad;
            $inventoryItem->current_balance -= $cantidad;
        }

        $inventoryItem->save();

        return response()->json(['message' => 'Movimiento registrado correctamente.']);
    }

    // Calcular saldo final al final del día
    public function calcularSaldoFinal($idDescriptionParts)
    {
        $inventoryItem = Inventory::where('idDescriptionParts', $idDescriptionParts)->first();
        $inventoryItem->final_balance = $inventoryItem->current_balance;
        $inventoryItem->save();

        return response()->json(['message' => 'Saldo final calculado correctamente.']);
    }

    // Obtener saldo actual
    public function obtenerSaldoActual($idDescriptionParts)
    {
        $inventoryItem = Inventory::where('idDescriptionParts', $idDescriptionParts)->first();
        return response()->json(['current_balance' => $inventoryItem->current_balance]);
    }
}
