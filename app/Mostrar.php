<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produto;

class Mostrar extends Model
{
    
    public function produtos()
    {
        return $this->belongsToMany(Produto::class);
    }
}
