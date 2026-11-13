@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" />
	
	<div class="row">
<!--Registrar pago de empleados-->
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">

  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
{!!Form::open(['route'=>'horario.store', 'method'=>'POST' , 'enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!} 

<font size="6">Horario</font>
<br>
  

  <div class="form-group">
    Nombre:<br>
    <input  name="nombre" placeholder="Ingrese el Nombre" class="form-control" id="nombre" value="" >
  </div>

  <div class="form-group">
  Tipo de horario:
            {!!Form::select('tipo', array('DIURNO' => 'DIURNO', 'NOCTURNO' => 'NOCTURNO'),'DIURNO',array('id'=>'tipo','class'=>'form-control'))!!}
	</div>

</div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
  			Hora de ingreso:
			<div class="form-group">
                <div class='input-group date' id='datetimepicker3'>
                    <input type='text' class="form-control" name="hora_ingreso"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div>

            Hora de salida:
            <div class="form-group">
                <div class='input-group date' id='datetimepicker4'>
                    <input type='text' class="form-control" name="hora_salida"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div>

        <script type="text/javascript">
            $(function () {
                $('#datetimepicker3,#datetimepicker4').datetimepicker({
                    format: 'HH:mm:ss'
                });
               
            });
        </script>





       
 <div align="left">

      {!!Form::submit('REGISTRAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()'])!!}

    </div>
</div>


    </form>
    
  </div>



	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well">
       <div class="table-responsive" style="overflow-x:inherit">	
       			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
       			</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				    <select name="id_tax" class="form-control selectpicker" id="id_tax" data-live-search="true" >
				     <option value="">  BUSCAR...   </option>
				        @foreach($buscar_horario as $mov)
				        <option value="{{$mov->id}}">{{$mov->id}} {{$mov->nombre}}  </option>
				        @endforeach
				    </select>
				</div>

      

				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white">
					<thead>
						<th><center>Nombre</center></th>
						<th><center>Tipo</center></th>
						<th><center>Hora de ingreso</center></th>
						<th><center>Hora de salida</enter></th>
						<th><center>Opcion</center></th>
						
					</thead>

					<tbody align="center" id="body_egreso">					
					@foreach($horario as $usr)
					<tr>
						<td>{{$usr->nombre}}</td>
						<td>{{$usr->tipo}}</td>
						<td>{{$usr->hora_ingreso}}</td>
						<td>{{$usr->hora_salida}}</td>
						<td>
						<button class="btn btn-primary fa fa-refresh" data-toggle="modal" data-target="#ModalUsuario" onclick="CargarUsuario({{$usr->id}})"></button>
						</td>
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>

	
			</div>


		</div>
	</div>

   {!!Html::script('js/usuario.js')!!}
@endsection
