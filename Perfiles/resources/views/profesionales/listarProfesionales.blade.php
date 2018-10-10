@extends('layouts.menu')
@section('titulo','LISTA DE TUTOR')
@section('contenido')


<div  class="centrar table-responsive col-sm-11 ">

<Form method="GET" action="{{route('listarProfesionales')}}" >
    @if($profesionales->isNotEmpty()) <!--BUSCADOR -->
    <div class="centrar col-sm-10 ">
            <div class="row">
                <div class="col-sm-3"></div>
                
                <div class=" col-sm-4">       
                                <input type="search" placeholder="&#xF002; Buscar" style="font-family:Time, FontAwesome" class="form-control" 
                                name="buscar" autofocus value="{{$buscar}}" autocomplete="off" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">   
                </div>          
                <div class="col-4">
                                <button class=" btn btn-success pull-left"> Buscar</button>
                </div>
            </div>
             
    </div>
   <!--FIN BUSCADOR -->
   @include('complementos.error')
 
      <table class="table table-hover" id="listaProfesionales">
          <thead class ="columnas">
        <tr>
          <th style="width: 5%; text-align: center;">N°</th>
          <th style="width: 10%;">Nombres</th>
          <th style="width: 15%;">Apellidos</th>
          <th style="width: 8%; ">Titulo</th>
          <th style="width: 8%;">Telefono</th>
          <th style="width: 12%;">Correo</th>
          <th style="width: 10%;">Area</th>
          <th style="width: 10%;">Sub Area</th>
          <th style="width: 5%;">Opsiones</th>
        </tr>
      </thead>
      <tbody>
           
        @foreach ($profesionales as $profesional)
            <tr>  
                <td style="text-align: right;">{{$fila++}}</td>
                <td>{{$profesional->nombre_prof}}</td>
                <td>{{$profesional->ap_pa_prof}}&nbsp;&nbsp;{{$profesional->ap_ma_prof}}</td>
                <td>{{$profesional->titulo->pluck('nombre')[0]}}</td>
                <td>{{$profesional->telef_prof}}</td>
                <td>{{$profesional->correo_prof}}</td>
                @if (!$profesional->areas->pluck('id_area')[0])
                    <td>{{$profesional->areas->pluck('nombre')[0]}}</td>
                    <td>{{$profesional->areas->pluck('nombre')[1]}}</td>    
                @else
                    <td>{{$profesional->areas->pluck('nombre')[1]}}</td>
                    <td>{{$profesional->areas->pluck('nombre')[0]}}</td>
                @endif
                
                <td class="dropdown dropleft text-center">
                    <a href="#" data-toggle="dropdown"  data-placement="right" title="opsiones">
                        <i class="fa fa-ellipsis-v fa-2x" aria-hidden="true"></i>
                    </a>
                    <ul id="contextMenu" class="dropdown-menu" role="menu">    
                        <li>
                            <a href='{{ route('editarProfesional',$profesional->id)}}' tabindex="-1"  class="payLink">
                                <h5><i class="fa fa-pencil-square-o fa-2x" style="color: #3390FF" ></i>&nbsp;&nbsp; Editar</h5>
                            </a>
                        </li>
                        <li>
                            <a href='{{ route('eliminarProfesional',$profesional)}}' onclick="return confirm('¿Esta seguro de eliminar el Profesional?')" tabindex="-1"  class="payLink">
                                <h5><i class="fa fa-minus-square fa-2x" style="color: #3390FF"></i>&nbsp;&nbsp; Eliminar</h5>
                            </a>
                        </li>
                        <li>
                            <a href='{{ route('verProfesional',$profesional)}}' tabindex="-1" class="payLink">
                                <h5> <i class="fa fa-plus fa-2x" style="color: #3390FF" ></i> &nbsp;&nbsp; Ver </h5> 
                            </a>
                        </li>   
                    </ul>

                   
                          </div>
                </td>
            </tr>   
        @endforeach
      </tbody>
    </table>
    
     {!! $profesionales->render() !!}
     @else
        <li>No se encontro un Profesional con esa descripcion</li>
    @endif
    
</div>

</Form>
@endsection