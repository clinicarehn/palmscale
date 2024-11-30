<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class BujeLL extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    // Dejar $guarded vacío significa que todos los campos son asignables en masa
    protected $guarded = [];

    // Relación con BujeRB
    public function bujeRB()
    {
        return $this->belongsTo(BujeRB::class, 'idbujeRBNum');
    }

    public function getDimensionesAttribute()
    {
        return "{$this->dim_a} {$this->dim_b} {$this->dim_c} {$this->dim_d} {$this->remarks}";
    }
}