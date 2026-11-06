<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'grupo',
    ];

    public function materiales(){
        return $this->hasMany(Material::class);
    }
    public function herramietas(){
        return $this->hasMany(Herramienta::class);
    }
}
