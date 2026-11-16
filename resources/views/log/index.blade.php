<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'SisVentas') }} | Login</title>
    <link rel="shortcut icon" href="images/icono.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('css/AdminLTE.css') }}" rel="stylesheet">


    <!-- iCheck -->


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .login-page{

        }

        .switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 14px;
  margin-top: 10px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 10px;
  width: 10px;
  left: 4px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(16px);
  -ms-transform: translateX(16px);
  transform: translateX(16px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 26px;
}

.slider.round:before {
  border-radius: 50%;
}

    </style>
<script type="text/javascript">
    function pepitojimenez(){
var fecha= new Date();
var horas= fecha.getHours();
var minutos = fecha.getMinutes();
var segundos = fecha.getSeconds();
var anio= fecha.getFullYear();
var mes= fecha.getMonth()+1;
var dia= fecha.getDate();
document.getElementById('contenedor').innerHTML=dia+'-'+mes+'-'+anio+' .. '+horas+':'+minutos+':'+segundos+'';
setTimeout('pepitojimenez()',1000);
}
</script>


  </head>
  <body class="hold-transition " background="images/fondo.jpg" onload="javascript:pepitojimenez()" >



    <div class="login-box" >
      @include('alerts.errors')
      @include('alerts.request')





     <!-- /.login-logo -->
      <div class="login-box-body" style=" background:rgba(98,2,2,0.6); padding-top: 2px; ">
        <center><b> <h1><font  style="font-family: Monospace;  margin-top: -15px; color: #fff;  font-style: normal;" >Login</font></h1></b></center>
       <form action="{{ route('login.store') }}" method="POST">
          @csrf
          <!-- campos del formulario -->
          <div class="form-group has-feedback">
            <div class="input-group">
            <input type="text"
            name="usuario"
            id="usuario"
            class="form-control"
            placeholder="Username"
            aria-label="Username"
            autocomplete="username"
            maxlength="100"
            autofocus
            value="{{ old('usuario') }}">

            <span class="input-group-btn">
              <button class="btn btn-warning" type="button" tabindex="-1" style="cursor: default; min-width: 42px; text-align: center;" aria-hidden="true"><i class="fa fa-user"></i></button>
            </span>
            </div>
          </div>
          <div class="form-group has-feedback">


  <div class="input-group">
      <input  type="password" name="password" id="password" placeholder="Password" aria-label="Password" autocomplete="current-password" class="form-control"   maxlength="30"/>

      <span class="input-group-btn">
        <button class="btn btn-warning" onclick="ver_pass()" type="button" aria-label="Show or hide password" title="Show or hide password" style="min-width: 42px; text-align: center;"><i class="fa fa-eye" aria-hidden="true"></i></button>
      </span>
    </div>


          </div>

          <input hidden="true" type="text" name="contrasena" id="contrasena"  hidden=""   >


          <div class="form-group col-xs-12 pull-right" hidden="">
            <!-- Rounded switch -->
           <font style="color: #fff;">Register attendance</font>
              <label class="switch">
                <input type="checkbox" name="asistencia" value="1">
                <div class="slider round"></div>
              </label>

          </div>

          <div class="row">
           <div  align="center" style="color: #fff; width: 100%;"  class="form-group col-xs-12 pull-right">
          <h2> <div id="contenedor"></div></h2>
          </div>
            <div class="col-xs-12 pull-right">
            <input type="submit" id="btn_ingresar" name="btn_ingresar" onclick="ocultar();"  style="width: 100%; font-size: 20px;" value="Login"  class=" btn btn-warning" />

            </div><!-- /.col -->
          </div>

      </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('js/jquery.js') }}"></script>

<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('js/bootstrap.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('js/login.js') }}"></script>



  </body>
</html>
