@extends('layouts.menu')
@section('titulo','Editar ROL')
@section('contenido')


    <div class="row justify-content-center mt-4">
        <div class="col-6">
            <h1 class="mb-3">Editar el Rol seleccionado</h1>
            @if($errors ->any())
                <div class="alert-danger">
                    <h3>Se tiene los siguientes errores en el formulario</h3>
                    <ul>
                        @foreach($errors->all() as $errors)
                            <li>{{$errors}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{route('actualizarRol',['role'=>$role])}}">
                {{method_field('PUT')}}
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="nombre_rol">Nombre del Rol</label>
                    <input type="text" class="form-control" name="nombre_rol" id="nombre_rol" value="{{old('nombre_rol',$role->nombre_rol)}}">
                </div>
                <div class="form-group mb-4">
                    <label for="privilegios">Privilegios del Rol</label>
                    <select class="form-control" id="privilegios" name="privilegios">
                        <option>{{$role->privilegios}}</option>
                        <option>alto</option>
                        <option>medio</option>
                        <option>bajo</option>
                    </select>
                </div>
                <button class=" btn btn-outline-primary btn-block ">Editar</button>
            </form>
        </div>
    </div>
@endsection