<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Profesional extends Authenticatable
{
    use Notifiable;
<<<<<<< HEAD:Perfiles/app/Tutor.php
    protected $table = 'profesional';
=======
    public $timestamps=false;

>>>>>>> master:Perfiles/app/Profesional.php
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'profesional';
    protected $primaryKey ='id';
    protected $fillable = [
        'id','ci_prof','nombre_prof', 'ap_ap_prof','ap_ma_prof','correo_prof','telef_prof','direc_prof','perfil_prof'
    ];

    
}