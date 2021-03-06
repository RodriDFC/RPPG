@extends('layouts.menu')
@section('titulo','EDITAR DOCENTE')
@section('contenido')
   <div class="row justify-content-center mt-4">
        <div class="col-sm-6" >
            
           @include('complementos.error')
            <form method="POST" action="{{route('modificarDocente',$docente)}}">
                {!! csrf_field() !!}

				
				<div class = "form-group row "> 
					<label for="nombre" class="col-sm-2 col-form-label" >Nombre</label>
					<div class="col-sm-10">
						<input type="text" id="nombre" class="form-control" name="nombre_prof" value="{{old('nombre_prof',$docente->profesional->nombre_prof)}}">
					</div>
				</div>
								
				<!--Nombre tutor -->
                

				<div class = "form-group row"> 
					<label for="ap_pa" class=" col-sm-2 col-form-label">Apellido Pa</label>
					<div class="col-sm-10">
						<input type="text" id="ape_pa" class="form-control" name="ap_pa_prof" value="{{old('ap_pa_prof',$docente->profesional->ap_pa_prof)}}">
					</div>
				</div>
				

               
				<div class = "form-group row"> 
					<label for="ap_ma_prof" class="col-2 col-form-label">Apellido Ma</label>
					<div class="col-sm-10">
						<input type="text" id="ape_ma_prof" class="form-control" name="ap_ma_prof" value="{{old('ap_ma_prof',$docente->profesional->ap_ma_prof)}}">
					</div>
				</div>

				<div class = "form-group row"> 
					<label for="ci_prof" class="col-sm-2 col-form-label">CI</label>
					<div class="col-sm-4">
						<input type="text"  class="form-control" name="ci_prof" id="ci_prof" value="{{old('ci_prof',$docente->profesional->ci_prof)}}">
					</div>
					<label for="telef_prof" class="col-sm-2 col-form-label">Telefono</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="telef_prof" id="telef_prof" value="{{old('telef_prof',$docente->profesional->telef_prof)}}">
					</div>
				</div>

                <div class = "form-group row"> 
					<label for="direc_prof" class="col-sm-2 col-form-label">Direccion</label>
					<div class="col-sm-4">
						<input type="text" id="direccion" class="form-control" name="direc_prof" id="direc_prof" value="{{old('direc_prof',$docente->profesional->direc_prof)}}">
					</div>
					<label for="correo_prof" class="col-sm-2 col-form-label">Correo</label>
					<div class="col-sm-4">
						<input type="email"  class="form-control" name="correo_prof" value="{{old('correo_prof',$docente->profesional->correo_prof)}}">
					</div>
				</div>

				<div class = "form-group row"> 
					<label for="cargahoraria_id" class="col-sm-2 col-form-label">Carga Horaria</label>
					<div class="col-sm-4 row-fluid" >
							<select name="cargahoraria_id" id="cargahoraria_id" class="form-control form-control-chosen" >
								<option disabled selected > -- seleccione la Carga Horaria -- </option>
								@foreach ($horarios as $horario)
									<option value="{{$horario->id}}" 
											{{$docente->cargaHoraria->pluck('id')->contains($horario->id) ? 'selected':''}}>{{$horario->carga_horaria}}</option>
								@endforeach

							</select>
					</div>
					
					<label for="codigo_sis" class="col-sm-2 col-form-label">CodigoSIS</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="codigo_sis" id="codigo_sis" value="{{old('codigo_sis',$docente->codigo_sis)}}">
					</div>
				</div>

				<div class = "form-group row"> 
					<label for="titulo_id" class="col-sm-2 col-form-label">Titulo</label>
					<div class="col-sm-4 row-fluid" >
						<select name="titulo_id" id="titulo_id" class="form-control form-control-chosen" >
							<option disabled selected > -- seleccione una Titulo -- </option>
							@foreach ($titulos as $titulo)
								<option value="{{$titulo->id}}" 
								{{$docente->profesional->titulo->pluck('id')->contains($titulo->id) ? 'selected':''}}>{{$titulo->abreviatura}}</option>
							@endforeach
						</select>
					</div>

					<label for="carrera_id" class="col-sm-2 col-form-label">Carrera</label>
					<div class="col-sm-4 row-fluid" >
						<select name="carrera_id" id="carrera_id" class="form-control form-control-chosen" >
							<option disabled selected > -- seleccione una Titulo -- </option>
							@foreach ($carreras as $carrera)
								<option value="{{$carrera->id}}" 
								{{$docente->profesional->carrera_id == $carrera->id ? 'selected':''}}>{{$carrera->nombre_carrera}}</option>
							@endforeach
						</select>
					</div>
				</div>

				
				<div class = "form-group row"> 
					<label for="area_id" class="col-sm-2 col-form-label">Area</label>
					<div class="col-sm-10">
						<select name="area_id" id="area_id" class="form-control form-control-chosen" >
							<option disabled selected >Seleccionar </option>
							@foreach ($areas as $area)
								<option value="{{$area->id}}"
								{{$docente->profesional->areas->pluck('id')->contains($area->id) ? 'selected':''}}>{{$area->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="subarea_id" class="col-sm-2 col-form-label">Sub Area</label>
					<div class="col-sm-10">
						<select name="subarea_id" id="subarea_id" class="form-control form-control-chosen" >
							<option disabled selected > Seleccionar </option>
							@foreach ($subareas as $subarea)
								<option value="{{$subarea->id}}"
								{{$docente->profesional->areas->pluck('id')->contains($subarea->id) ? 'selected':''}}>{{$subarea->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>   

				<div class="form-group row">   
					<div class="col-sm-3"></div>
					<label for="directorCarrera" class="col-sm-3 col-form-label">Director de Carrera  &nbsp;
							<input type="checkbox"  id="directorCarrera" name="director_carrera" value="{{$docente->profesional->carrera_id}}"
							{{$docente->director_carrera ? 'checked' :''}}  >		
					</label>
					<label for="docenteMateria" class="col-sm-3 col-form-label">Docente de Materia  &nbsp;
							<input type="checkbox"  id="docenteMateria" name="docente_materia" value="si" 
							{{$docente->docente_materia ? 'checked':''}}>
							
					</label> 
				</div>
				
				<div class = "form-group row"> 
					<div class="col-sm-2"></div>
					<div class="col-8">
							<a href="{{ route('Docentes') }}" class="btn btn-danger">Cancelar</a>
							<button type="submit" class='btn btn-success registrar'>Registrar</button>
					</div>
					
						
				</div>
			</form>

		</div>
	
	</div>
	<script>
			$('.form-control-chosen').chosen({});
	</script>
@endsection


