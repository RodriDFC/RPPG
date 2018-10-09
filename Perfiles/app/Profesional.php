<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use App\Titulo;


class Profesional extends Model
{
    use Notifiable;
    public $timestamps=false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'profesionales';
     protected $fillable = [

        'id',
        'ci_prof',
        'nombre_prof', 
        'ap_pa_prof',
        'ap_ma_prof',
        'correo_prof',
        'telef_prof',
        'direc_prof',
        'perfil_prof',
        'titulo_id',
         ];

    public function areas(){
        return $this->belongsToMany(Area::class,'profesional_area')->withTimestamps();  
    }

    public function titulo(){
        return $this->belongsTo(Titulo::class);
    }

    public function scopeBuscar($query,$buscar){
        if($buscar){
            return $query->where(DB::raw("CONCAT(nombre_prof,' ',ap_pa_prof,' ',ap_ma_prof)"), "LIKE", "%$buscar%");
        }
    }
}