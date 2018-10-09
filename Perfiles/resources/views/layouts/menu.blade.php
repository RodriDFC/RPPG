<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administracion de Perfiles</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet"href={{asset('css/estilos.css')}}>
    <link rel="stylesheet" href={{asset('css/bootstrap.min.css')}}>
    <link rel="stylesheet" href={{asset('css/font-awesome.css')}}>
    <link rel="stylesheet" href={{asset('css/AdminLTE.min.css')}}>
    <link rel="stylesheet" href={{asset('css/_all-skins.min.css')}}>
    <link rel="apple-touch-icon" href={{asset('img/apple-touch-icon.png')}}>
    <link rel="shortcut icon" href={{asset('img/favicon.ico')}}>
    
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      
      <!--BARRA DEL ENCABEZADO-->
      @include('layouts.header')
      <!-- BARRA DE MENU -->
      @include('layouts.sidebar')
       <!--Contenido-->
   
      <div class="content-wrapper">
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title"> @yield('titulo')</h3>
                      <!--  Revisar --->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
                  <div class="row">
                    <div class="col-md-12">
                        <!--Contenido-->
                        @yield("contenido")
                        <!--Fin Contenido-->
                    </div>
                  </div>
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div><!-- /.box -->



        </section><!-- /.content -->
      </div>
    </div>
      <!--Fin-Contenido-->

      <!--PIE DE PAGINA-->
      <footer class="main-footer">
        
      </footer>

  
    <script src={{asset('js/jQuery-3.3.1.min.js')}}></script>
    <script src={{asset('js/bootstrap.min.js')}}></script>
    <script src={{asset('js/parsley.min.js')}}></script>
    <script src={{asset('js/popper.min.js')}}></script>
    <script src={{asset('js/app.min.js')}}></script>
    <script src={{asset('js/ajax.js')}}></script>
    
  </body>
</html>
