<?php

namespace App\Http\Controllers;

use App\Area;
use App\Subarea;
use App\Docente;
use App\Modal;
use App\Perfil;
use App\Profesional;
use App\Estudiante;
use App\Carrera;
use App\Http\Requests\PerfilFormRequest;
use Validator;
use Illuminate\Http\Request;
use PDF;

class PerfilController extends Controller
{

    function __construct(){
        // $this->middleware('auth');
        //$this->middleware(['verificarCuenta']);
    }

    public function index(Request $request){
        $modalidades = Modal::all();
        $anios    = Perfil::anios()->orderBy('year','DESC')->get();
        $profesionales = Profesional::all();
        $periodos = [1,2];
        $mod_id   = $request['modalidad_id'];
        $periodo  = $request['periodo'];
        $anio     = $request['anio'];
        $tutor_id = $request['tutor_id'];
        $buscar   = $request['buscar'];//"no hay titulo";
        $fila     = 1;
        $perfiles = Perfil::eliminado(false)
                         ->modalidadP($mod_id)
                          ->anio($anio)
                          ->periodo($periodo)
                          ->buscar($buscar)
                          ->perfilesTutor($tutor_id)
                          ->with(['tutor','estudiantes'])
                          ->orderBy('id','DESC')
                          ->paginate(20
                        );
        if ($request->ajax()) {
            return response()->json([
                view('parcial.perfiles',compact('perfiles','buscar','fila'))->render()
            ]);
        }
        return view('perfiles.listaPerfiles',compact('perfiles','buscar','fila','modalidades','anios','profesionales','periodos'));
    }

    public function nuevoFormulario(){
        $estudiante    = auth()->user()->estudiante()->first();
        $estudiante_id = 1;//$estudiante->id;
        $modalidades = Modal::all();
        $perfil        = Perfil::perfilEstudiante($estudiante_id)->with('tutor','estudiantes.carrera','docente.profesional','director.profesional','area','subarea','modalidad')->get();
       
        if($perfil->toArray() != []){
           return $this->perfilGuardado($perfil,$modalidades,$estudiante);
        }else{
            return view('perfiles.formulario',compact('modalidades'));
        } 
    }

    public function perfilGuardado($perfil,$modalidades,$estudiante){
       // dd($perfil->toArray());
        $perfil        = $perfil[0];
        $modalidad_id  = $perfil->modalidad_id;
        $carrera_id    = $perfil->estudiantes[0]->carrera_id;
        $fecha_ini     = $perfil->fecha_ini;
        $director_id   = $perfil->director->profesional->id;
        $modalidad     = Modal::where('id',$modalidad_id)->value('nombre_mod');
        $subareas      = Area::subareasCarrera($carrera_id)->get();
        $areas         = Area::areasCarrera($carrera_id)->get();
        $director      = $this->directorCarrera($carrera_id);
        if($director){
            $director_id   = $director->toArray()['id'];
        }else
            $director_id = 0;
        
        $profesionales = Profesional::where('id','!=',$director_id)
                                    ->DeCarrera($carrera_id)->get();
        $docentes      = Docente::where('id','!=',$director_id)
                                  ->where('docente_materia',"si")
                                 ->with('profesional')
                                ->porCarrera($carrera_id)->get();
        $perfiles      = Perfil::where('modalidad_id',$modalidad_id)
                                ->where('trabajo_conjunto','si')
                                ->with('docente.profesional')->with('tutor','area','subarea')
                                ->whereHas('estudiantes')->get();
        $gestion       = $this->periodo();
        $fecha_ini     = $this->fechaIni();
        $fecha_fin     = $this->fechaFin();
        return view('perfiles.perfilGuardado',compact('perfil','estudiante','modalidades','areas','docentes','subareas','profesionales','perfiles','gestion','fecha_ini','fecha_fin'));
    }

    public function mostrarForm(Request $request){
        $modalidad_id  = $request->modalidad_id;
        $estudiante    = auth()->user()->estudiante()->first();
        $carrera_id    = $estudiante->carrera_id;
        $estudiante    = Estudiante::Where('id',$estudiante->id)->with('carrera')->get();
        $estudiante    = $estudiante[0];  
        $modalidad     = Modal::where('id',$modalidad_id)->value('nombre_mod');
        $subareas      = Area::subareasCarrera($carrera_id)->get();
        $areas         = Area::areasCarrera($carrera_id)->get();
        $director      = $this->directorCarrera($carrera_id);
        if($director){
            $director_id   = $director->toArray()['id'];
        }else
            $director_id = 0;
        
        $profesionales = Profesional::where('id','!=',$director_id)
                                    ->DeCarrera($carrera_id)->get();
        $docentes      = Docente::where('id','!=',$director_id)
                                  ->where('docente_materia',"si")
                                 ->with('profesional')
                                ->porCarrera($carrera_id)->get();
        $perfiles      = Perfil::where('modalidad_id',$modalidad_id)
                                ->where('trabajo_conjunto','si')
                                ->with('docente.profesional')->with('tutor','area','subarea')
                                ->whereHas('estudiantes')->get();
        $gestion       = $this->periodo();
        $fecha_ini     = $this->fechaIni();
        $fecha_fin     = $this->fechaFin();
        //$res = $this->verificar('si',7,[]);
       // $aux = $modalidad->toArray()[0];
      // dd($res);
        if($request->ajax()){
            $errores = $this->validarDatos($docentes,$profesionales,$areas,$subareas,$director);
            if($errores == []){
                $modalidad = strtolower($modalidad);
                if($modalidad == "adscripcion" || $modalidad == "trabajo dirigido"){ 
                    return response()->json([
                       'valido'=> true, 
                       'datos' => view('perfiles.formTrabajoD',compact('director','docentes','profesionales','perfiles',
                        'areas','subareas','estudiante','modalidad_id','modalidad','gestion','fecha_ini','fecha_fin'))->render()
                    ]);
                }else{return response()->json([
                        'valido'=> true, 
                        'datos' =>  view('perfiles.formTrabajoD',compact('director','docentes','profesionales','perfiles',
                         'areas','subareas','estudiante','modalidad_id','modalidad','gestion','fecha_ini','fecha_fin'))->render()
                    ]);
                } 
            }else{
                return response()->json([
                    'valido'=> false, 
                    'errores' => $errores
                 ]);
            }
            
        }
    }
    
    
    public function almacenar(PerfilFormRequest $request){
        $perfil        = new Perfil;
        $cambioTema    = $request['cambio_tema'];
        $trabConjunto  = $request['trabajo_conjunto'];
        $estudiante_id = $request['estudiante_id'];
        $tutor_id      = $request['tutor_id'];        
        $estudiante      = Estudiante::find($estudiante_id);
        $perfil_id     = Perfil::where('titulo',$request['titulo'])->value('id');
        $validacion    = $this->verificar($trabConjunto,$perfil_id,$estudiante,$cambioTema);
        if($request->ajax()){
            return response()->json($validacion);
        }
      
        if($perfil_id  && $trabConjunto == 'si'){
            $perfil->estudiantes()->attach($estudiante_id,['perfil_id'=>$perfil_id]); 
        }else{
            $perfil->create($request->all());
            $perfil_id = Perfil::where('titulo',$request['titulo'])->value('id');
            $perfil->estudiantes()->attach($estudiante_id,['perfil_id'=>$perfil_id]); 
            $perfil->tutor()->attach($tutor_id,['perfil_id'=>$perfil_id]); 
        }
        
        return redirect()->route('perfiles');
        
    }

    public function editar($id){
       // $profesionales = Profesional::
        $perfil        = Perfil::where('id',$id)->with('tutor','estudiantes.carrera','docente.profesional','director.profesional','area','subarea','modalidad')->get();;
        $perfil        = $perfil[0];
        $carrera_id    = $perfil->estudiantes[0]->carrera_id;
        $fecha_ini     = $perfil->fecha_ini;
        $director_id   = $perfil->director->profesional->id;
        $docente_id    = $perfil->docente->profesional->id;
        //dd($perfil->toArray());
        $subareas      = Area::subareasCarrera($carrera_id)->get();
        $profesionales = Profesional::DeCarrera($carrera_id)
                                    ->where('id','!=',$director_id)
                                    ->where('id','!=',$docente_id)
                                    ->get();
        $gestion       = $this->gestion($fecha_ini);
        return view('perfiles.editarPerfil',compact('perfil','subareas','profesionales','gestion'));
            
    }


    public function modificar(PerfilFormRequest $request,Perfil $perfil){
        if($request->ajax()){
            return response()->json([
                'registrado'=>true,
                'mensaje'=>'Perfil modificado correctamente'
            ]);
        }
        $perfil->update($request->all());
        return redirect()->route('perfiles');
    }

    public function eliminar(Request $request, Perfil $perfil){
        /*$perfil->update([
            'estado'=>'eliminado'
        ]); 
        return response()->json([
            'eliminado'=>true,
            'mensaje'=>'Se a eliminado el Perfil'
        ]);*/
        if($perfil->estado=='Defendido'){
            $perfil->update([
                'estado'=>'eliminado'
            ]); 
            return response()->json([
                'eliminado'=>true,
                'mensaje'=>'Se a eliminado el Perfil'
            ]);
        }
            return response()->json([
                'eliminado'=>false,
                'mensaje'=>'No se puede eliminar este perfil'
            ]);
    }


    public function directorCarrera($carrera_id)
    {
        $id = Docente::directorCarrera($carrera_id)->value('id');
        if($id){
           return Docente::with('profesional')->findOrFail($id);
        }else{
            return [];
        }
           
    }
     public function verificar($trabConjunto,$id,$estudiante,$cambioTema){
        $est_perf = $estudiante->perfil;
        $est_perf = $est_perf->toArray();
         if($est_perf == []){
                if($cambioTema){
                    return [
                        'registrado'=>false,
                        'mensaje'=> 'No debe seleccionar el cambio de Tema'.$trabConjunto
                    ]; 
                }else if($trabConjunto == 'si'){
                    return $this->maximoIntegrantes($id);
                }else if($id){
                        return [
                            'registrado'=>false,
                            'mensaje'=> 'Ya existe un formulario registrado con ese titulo'.$trabConjunto
                        ];  
                }else{
                    return [
                        'registrado'=>true,
                        'mensaje'=> 'Formulario registrado correctamente'
                    ];  
                }
        }else if($cambioTema){
            return $this->cambiarTema($estudiante);
        }else{
            return [
                'registrado'=>false,
                'mensaje'=> 'Usted ya tiene registrado un Formulario de Perfil '
            ]; 
        }

     }

    public function maximoIntegrantes($id){
        $nro_integrantes = $this->nroIntegrantes($id);
        if ($nro_integrantes < 2) {
            return [
                'registrado'=>true,
                'mensaje'=> 'Formulario registrado correctamente'
            ];  
        }else{
            
        }
    }

    public function cambiarTema($estudiante){
        $perfil = $estudiante->perfil;
        $fecha_fin = $perfil->toArray()[0]['fecha_fin'];
        $valido = $this->fechaValido($fecha_fin);
        if($valido){
            $estudiante->perfil()->detach();
            $perfil->update([
                'estado'=>'eliminado'
            ]);
            return [
                'registrado'=>true,
                'mensaje'=> 'Formulario para el Cambio De Tema registrado correctamente '
            ];
        }else{
            return [
                'registrado'=>false,
                'mensaje'=> 'No puede realizar cambio de tema por que aun no a culminado el plazo de su Perfil de grado'
            ];
        }
        
    }

    //metodo para cambiar estado de un perfil
    public function cambiarEstado(Request $request,Perfil $perfil){
        $perfil->update([
            'estado' => $request['estado']
        ]);
        if($request->ajax()){
            return response()->json([
                'mensaje'=>'El estado del perfil fue actualizado Correctamente'
            ]);
        }
    }
    public function fechaValido($fecha_fin){
        $fechaF = explode("-",$fecha_fin);
        $fecha     = explode("-",date('Y-m-d'));
        if($fechaF[0]< $fecha[0]){
            return true;
        }else if($fechaF[0] == $fecha[0]){
                if($fechaF[1] < $fecha[1]){
                    return true;
                }else if ($fechaF[1] == $fecha[1]){
                        if($fechaF[2] <= $fecha[2]){
                             return true;
                        }
                }
        }
    }

     public function fechaFin(){
        $dia = date('d');
        $mes = date('m');
        $anio= date('Y')+2;
        $fecha_fin = "$anio-$mes-$dia";
        return  $fecha_fin;
     }

     public function fechaIni(){
        $dt = new \DateTime();
        $fecha_ini = $dt->format('Y-m-d');
        return $fecha_ini;
     }
     public function periodo(){
         $mes = date('m');
         $anio = date('Y');
        return ($mes < 7 ? 1 : 2 ).'/'.$anio;
     }

     public function gestion($fecha){
        $fecha = explode("-", $fecha);
         $mes  = $fecha[1];
         $anio = $fecha[0];
         return ($mes < 7 ? 1 : 2 ).'/'.$anio;
     }
     public function nroIntegrantes($id){
         if($id){
             $res = Perfil::find($id)->estudiantes;
             return $res->count();
         }else{
             return 0;
         }
     }

     
     public function validarDatos($docentes,$profesionales,$areas,$subareas,$director){
         $countD   = $docentes->count();
         $countP   = $profesionales->count();
         $countA   = $areas->count();
         $countS = $subareas->count();
         $errores = array();
         if ($countD == 0 ) {
             $errores['docentes'] ='no puede registrar su perfil  por q no existe registros de los Docentes en la Carreras';
         }
         if ($countP == 0 ) {
            $errores['tutores'] = 'no puede registrar su perfil  por q no no existe registros de los Tutores en la Carrera';
        }
        if ($countA == 0 ) {
            $errores['areas'] = 'no puede registrar su perfil  por q no existe registros de las Areas en la Carrera';
        }
        if ($countS == 0 ) {
            $errores['subareas'] = 'no puede registrar su perfil  por q no existe registros de las Subaras en la Carrera';
        }if($director == []){
            $errores['subareas'] = 'no puede registrar su perfil por que su carrera no tiene Registrado un direcor de carrerae';
        }

        return $errores;
     }
     public function ver($id){
        $perfil=Perfil::where('id',$id)->with('tutor.Titulo')->get();
        $perfil=$perfil[0];
       // dd($perfil->toArray());
      $profesional=$perfil->tutor[0];
        return view('perfiles.ver',compact('perfil','profesional','gestion'));
    }
    public function vistaPdf($id){
    
        $perfil=Perfil::where('id',$id)->with('tutor.Titulo','director.profesional.titulo','docente.profesional.titulo')->get();
        $perfil=$perfil[0];
        $perfil=Perfil::findOrFail($id); 
        $profesional=$perfil->tutor[0];
        $director = $perfil->director->profesional;
        $gestion = $this->gestion($perfil->fecha_ini);
        $docente = $perfil->docente->profesional;
       // $pdf = App::make('dompdf.wrapper');
       $estudiantes=Estudiante::all();
       $pdf=PDF::loadView('perfiles.formPdf',compact('perfil','profesional','gestion','director','docente'));
      // $pdf=PDF::loadView('perfiles.formPdf',['perfil'=>$perfil]); 
     return $pdf->stream(); 
		//return view('perfiles.ver',['perfil'=>$perfil]);
    }


     public function publicar(PerfilFormRequest $request,Perfil $perfil){
        if($request->ajax()){
            $mensaje = "";
         if($request['estado'] == "Guardado"){
            $mensaje = "Perfil Guardado";
         }else{
             $mensaje = "Perfil Publicado";
         }
            return response()->json([
                'registrado'=>true,
                'mensaje'=> $mensaje
            ]);
        }
        $perfil->update($request->all());
        $perfil->sec_trabajo = $request->institucion;
        $perfil->sec_trabajo = $request->sec_trabajo;
        $perfil->update();
        return redirect()->route('perfiles');
    }

}