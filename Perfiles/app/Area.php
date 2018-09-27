<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Area extends Model
{   
    protected $fillable = [
        'codigo',
        'nombre',
        'descripsion',
        ''
    ];

    public function scopeBuscar($query, $buscar){
		return $query->where(DB::raw("CONCAT(codigo,' ',nombre,' ',descripsion)"), "LIKE", '%' .$buscar. '%');
    }
    
    public function scopeArea($query, $codigo,$nombre){
        return $query->where('codigo',$codigo)
                ->orwhere('nombre',$nombre);
    }
}
