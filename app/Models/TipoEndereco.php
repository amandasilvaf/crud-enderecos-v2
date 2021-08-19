<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Adress;

class TipoEndereco extends Model
{
    use HasFactory;

    public function adresses()
    {
        return $this->hasMany(Adress::class);
    }
}
