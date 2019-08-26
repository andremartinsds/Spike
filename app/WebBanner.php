<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebBanner extends Model
{
    protected $fillable = ['title', 'imagem', 'url','publicado'];
}
