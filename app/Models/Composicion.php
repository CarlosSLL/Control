<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Composicion extends Model
{
     protected $table = 'composiciones';
     public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

       public function materiales(){
        return $this->hasMany(Material::class);
    }
}
