@extends('layouts.menu')
@section('titulo','REGISTRAR USUARIO')
@section('contenido')
    <div class="row justify-content-center mt-4">
        <div class="col-6">
            <h1 class="mb-3">Añadir un Nuevo Usuario</h1>
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
            <form method="POST" action="{{route('guardarUsuario')}}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="user_name">Nombre de Usuario</label>
                    <input type="text" class="form-control" name="user_name" id="user_name" value="{{old('user_name')}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}">
                </div>
                <div class="form-group mb-4">
                    <label for="role_id">Rol del Usuario</label>
                    <select class="form-control" id="role_id" name="role_id">
                        <option>seleccione una opcion</option>
                        @foreach($roles as $rol)
                            <option>{{$rol}}</option>
                        @endforeach
                    </select>
                </div>
                <button class=" btn btn-outline-primary btn-block ">Crear</button>
            </form>
        </div>
    </div>

@endsection