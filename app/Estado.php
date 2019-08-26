<?php

namespace App;
use App\Cliente;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public function cliente()
    {
        return $this->hasMany(Cliente::class);
    }
}
