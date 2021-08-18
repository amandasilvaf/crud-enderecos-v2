<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use BenSampo\Enums\TipoEndereco;

class Adress extends Model
{
    use HasFactory;

    protected $casts = [
        'tipo' => TipoEndereco::class
    ];
}
