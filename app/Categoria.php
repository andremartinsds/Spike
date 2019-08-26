<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Pagina;
class Categoria extends Model
{
    protected $fillable = ['nome', 'publicado', 'user_id'];
    
    public function paginas()
    {
        return $this->hasMany(Pagina::class);
    }
}
