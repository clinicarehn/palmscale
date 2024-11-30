<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ProductionOrden extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    // Dejar $guarded vacío significa que todos los campos son asignables en masa
    protected $guarded = [];

    // Definir campos que deben ser tratados como fechas
    protected $dates = ['production_date'];

    // Definir la relación con el modelo Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Define la relación con los detalles de la orden
    public function details()
    {
        return $this->hasMany(ProductionOrdenDetail::class, 'production_order_id');
    }

    // Definir la relación con el modelo DescriptionPart
    public function descriptionPart()
    {
        return $this->belongsTo(DescriptionPart::class, 'part_id');
    }

    public function products()
    {
        return $this->hasMany(ProductionOrdenDetail::class, 'production_order_id');
    }
}