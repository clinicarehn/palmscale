<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;

class RoleoLongVehiculo extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    // Dejar $guarded vacío significa que todos los campos son asignables en masa
    protected $guarded = [''];
}