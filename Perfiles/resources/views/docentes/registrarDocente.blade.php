@extends('layouts.menu')
@section('titulo','REGISTRAR DOCENTE')
@section('contenido')

   <div class="row justify-content-center mt-4">
        <div class="col-sm-6">
            
           @include('complementos.error')
            <form method="POST" action="{{route('almacenarDocente')}}">
                {!! csrf_field() !!}

				
				<div class = "form-group row "> 
					<label for="nombre" class="col-sm-2 col-form-label" >Nombre</label>
					<div class="col-sm-10">
						<input type="text" id="nombre" class="form-control" name="nombre_prof" value="{{old('nombre_prof')}}">
					</div>
				</div>
								
				<!--Nombre tutor -->
                

				<div class = "form-group row"> 
					<label for="ap_pa" class="col-sm-2 col-form-label">Apellido Paterno</label>
					<div class="col-sm-10">
						<input type="text" id="ape_pa" class="form-control" name="ap_pa_prof" value="{{old('ap_pa_prof')}}">
					</div>
				</div>
				

               
				<div class = "form-group row"> 
					<label for="ap_ma_prof" class="col-sm-2 col-form-label">Apellido Maternos</label>
					<div class="col-sm-10">
						<input type="text" id="ape_ma_prof" class="form-control" name="ap_ma_prof" value="{{old('ap_ma_prof')}}">
					</div>
				</div>

				<div class = "form-group row"> 
					
						<label for="ci_prof" class="col-sm-2 col-form-label">CI</label>
					
					<div class="col-sm-4">
						<input type="text"  class="form-control" name="ci_prof" id="ci_prof" value="{{old('ci_prof')}}">
					</div>
					
					<label for="telef_prof" class="col-sm-2 col-form-label">Telefono</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="telef_prof" id="telef_prof" value="{{old('telef_prof')}}">
					</div>
					
				</div>

                <div class = "form-group row"> 
					<label for="direc_prof" class="col-sm-2 col-form-label">Direccion</label>
					<div class="col-sm-4">
						<input type="text" id="direccion" class="form-control" name="direc_prof" id="direc_prof" value="{{old('direc_prof')}}">
					</div>
					<label for="correo_prof" class="col-sm-2 col-form-label">Correo</label>
					<div class="col-sm-4">
						<input type="email"  class="form-control" name="correo_prof" value="{{old('correo_prof')}}">
					</div>
				</div>

				<div class = "form-group row ">
					<label for="password" class="col-sm-2 col-form-label" >Password</label>
					<div class="col-sm-10">
						<input type="password" id="password" class="form-control" name="password" value="{{old('password')}}">
					</div>
				</div>

				<div class = "form-group row"> 
						<label for="cargahoraria_id" class="col-sm-2 col-form-label">Carga Horaria</label>
						<div class="col-sm-4 row-fluid" >
								<select name="cargahoraria_id" id="cargahoraria_id" class="form-control form-control-chosen" >
									<option disabled selected > Seleccionar </option>
									@foreach ($horarios as $horario)
										<option value="{{$horario->id}}">{{$horario->carga_horaria}}</option>
									@endforeach
								</select>
						</div>

						<label for="codigo_sis" class="col-sm-2 col-form-label">CodigoSIS</label>
						<div class="col-sm-4">
						<input type="text" class="form-control" name="codigo_sis" id="codigo_sis" value="{{old('codigo_sis')}}">
						</div>		
				</div>
				
				<div class = "form-group row"> 
						<label for="titulo_id" class="col-sm-2 col-form-label">Titulo</label>
						<div class="col-sm-4 row-fluid" >
							<select name="titulo_id" id="titulo_id" class="form-control form-control-chosen" >
								<option disabled selected > Seleccionar </option>
								@foreach ($titulos as $titulo)
									<option value="{{$titulo->id}}">{{$titulo->abreviatura}}</option>
								@endforeach
							</select>
						</div>

						<label for="carrera_id" class="col-sm-2 col-form-label">Carrera</label>
						<div class="col-sm-4 row-fluid" >
							<select name="carrera_id" id="carrera_id" class="form-control form-control-chosen" >
								<option disabled selected > Seleccionar </option>
								@foreach ($carreras as $carrera)
									<option value="{{$carrera->id}}">{{$carrera->nombre_carrera}}</option>
								@endforeach
							</select>
						</div>	
				</div>

				<div class="form-group row">
					<label for="area_id" class="col-sm-2 col-form-label">Area</label>
					<div class="col-sm-10">
						<select name="area_id" id="area_id" class="form-control form-control-chosen" >
							<option disabled selected > Seleccionar </option>
							@foreach ($areas as $area)
								<option value="{{$area->id}}">{{$area->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class = "form-group row"> 
					<label for="subarea_id" class="col-sm-2 col-form-label">Sub Area</label>
					<div class="col-sm-10">
						<select name="subarea_id" id="subarea_id" class="form-control form-control-chosen" >
							<option disabled selected > Seleccionar </option>
							@foreach ($subareas as $subarea)
								<option value="{{$subarea->id}}">{{$subarea->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>   
				<div class="form-group row">   
					<div class="col-sm-3"></div>
					<label for="directorCarrera" class="col-sm-3 col-form-label">Director de Carrera  &nbsp;
							<input type="checkbox"  id="directorCarrera" name="director_carrera">
							
					</label>
					<label for="docenteMateria" class="col-sm-3 col-form-label">Docente de Materia  &nbsp;
							<input type="checkbox"  id="docenteMateria" name="docente_materia" value="si">
							
					</label> 
				</div>
				
		
				<div class = "form-group row"> 
					<div class="col-sm-2"></div>
					<div class="col-8">
							<a href="{{ route('registrarDocente') }}" class="btn btn-danger">Cancelar</a>
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


