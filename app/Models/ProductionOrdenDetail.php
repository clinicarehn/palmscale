<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ProductionOrdenDetail extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    // Dejar $guarded vacío significa que todos los campos son asignables en masa
    protected $guarded = [];

    // Define la relación inversa con ProductionOrden
    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrden::class, 'production_order_id');
    }

    public function part()
    {
        return $this->belongsTo(DescriptionPart::class, 'part_id');
    }
}
