<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ModeloVehiculo extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    // Dejar $guarded vacío significa que todos los campos son asignables en masa
    protected $guarded = [''];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'idVehiculo');
    }

    public function getVehiculoYModeloAttribute()
    {
        return $this->vehiculo ? "{$this->vehiculo->descripcionvehiculo} - {$this->modelo_detalle}" : $this->modelo_detalle;
    }
}