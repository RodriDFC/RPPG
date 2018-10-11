@extends('layouts.menu')
@section('titulo','EDITAR DOCENTE')
@section('contenido')

<!--ERRORES-->
	@include('complementos.error')				
<!--FIN ERRORES-->
	<div class= "container" >
		<form method="POST" action="{{route('modificarDocente',$docente->id)}}">
			{!! csrf_field() !!}
			<div class = "form-group row">
				<div class="col-2"></div>
				<div class = "col-8">
					
					<div class = "form-group row"> 
						<label for="codigo" class="col-sm-2 col-form-label">Codigo_sis</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" placeholder="codigo sis" name="codigo_sis" autocomplete="off"
							value= {{old('codigo',$docente->codigo_sis)}}>
						</div>
					</div>
					<!--Carga Horaria -->
					<div class = "form-group row"> 
						<label for="nombre" class="col-sm-2 col-form-label">cargaHoraria</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" placeholder="carga docente" name="carga_horaria" autocomplete="off"
							value="{{old('carga_horaria',$docente->carga_horaria)}}">
						</div>
					</div>
		
					<div class = "form-group row">
						<label for="profesional_id" class="col-sm-2 col-form-label">profesion</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" placeholder="obligatoria" name="profesional_id" autocomplete="off"
							value="{{old('profesional_id',$docente->profesional_id)}}">
						</div>
						
					</div>

					<div class = "form-group row"> 
						<div class="col-sm-2"></div>
						<div class="col-8">
							<a href="{{ route('Docentes') }}" class="btn btn-danger">Cancel</a>	
							<button type="submit" class='btn btn-success'>Modificar</button>
						</div>
						
							
					</div>
				</div>
			</div>
		</form>
	</div>

@endsection