@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('usuario.modal')
  
  
  <div class="row"> 
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <font size="6">EGRESO</font>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <div class="pull-right">
        <a class="btn btn-link fa fa-plus" href="{!!URL::to('egreso/create')!!}"> Agregar Egreso</a> 
      </div>
    </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

{!!Form::open(['route'=>'egreso.index', 'method'=>'GET'])!!}  
  <table class=" form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <tr>
        <td>
          <div class="form-group " >
      <div class='input-group date' id='datetimepicker11'>
        {!!Form::text('fecha_inicio',date('Y-m-j'),['id'=>'fecha_inicio','class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}    
        <span class="input-group-addon ">
           <span class="fa fa-calendar" aria-hidden="true"></span> 
        </span>
      </div>
      </div> 
        </td>
        <td><i class=" fa fa-arrows-h form-group" ></i></td>
        <td>
          <div class="form-group " >
          <div class='input-group date' id='datetimepicker10'>

        {!!Form::text('fecha_fin',date('Y-m-j'),['class'=>'form-control','maxlength'=>'10','style'=>'font-size:20px;text-align:left;'])!!}        
            <span class="input-group-addon ">
               <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
            </span>
          </div>
           </div>
        </td>
      </tr>
    </table> 
    
    
    

      

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <select name="id_usuario" class="form-control selectpicker" id="id_usuario" data-live-search="true" >
         <option value="">  Buscar por usuario . .</option>
            @foreach($buscar_usuario as $mov)
            <option value="{{$mov->id}}">{{$mov->nombre}} </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <select name="id_conductor" class="form-control selectpicker" id="id_conductor" data-live-search="true" >
         <option value="">  Buscar por conductor . .</option>
            @foreach($buscar_conductor as $mov)
            <option value="{{$mov->ci}}">{{$mov->codigo_empresa}}: {{$mov->nombre}} {{$mov->paterno}} {{$mov->materno}}</option>
            @endforeach
        </select>
    </div>


   
        
     <table class=" form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <tr>
        <td><button class="btn btn-success" id="btn_buscar" name='btn_buscar'onclick="btn_esconder()"><i class="fa fa-search"></i> Buscar</button> 
        </td>
        <td class=" form-group">.</td>
        <td>
          <?php echo "<a class='btn btn-warning' target='_blank'  href='../public/pdf_egreso/$id_empresa/$id_usuario/$id_conductor/$fecha_inicio/$fecha_fin'> <i class='fa fa-print'></i> IMPRIMIR</a>";?>
        </td>
      </tr>
    </table> 

    

</form>

    </div>  
 
<?php
$monto_total=0; 
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive" style="overflow-x:inherit"> 
    
    
      

        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
          <thead>
            <th><center>ID</center></th>
            <th><center>FECHA</center></th>
            <th><center>OBSERVACIONES</center></th>
            <th><center>MONTO</center></th>
            <th><center>CLIENTE</center></th>
            <th><center>USUARIO</center></th>
            <th><center>OPCION</center></th>
            
          </thead>

          <tbody align="center" id="body_egreso">         
          @foreach($egreso as $usr)
          <tr>
            <td>{{$usr->id}}</td>
            <td>{{$usr->fecha}}</td>
            <td>{{$usr->observacion}}</td>
            <td>{{$usr->monto}}</td>
            <td>{{$usr->nombre}}</td>
            <td>{{$usr->usuario}}</td>
            <td>
            <button class="btn btn-primary fa fa-refresh" data-toggle="modal" data-target="#ModalUsuario" onclick="CargarUsuario({{$usr->id}})"></button>
            <a class='btn btn-warning fa fa-print' href="{!!URL::to('egreso/comprobante_egreso_pdf',[$usr->id])!!}" data-toggle="tooltip" data-placement="top" title="Imprimir" target="_blanck"></a>
            </td>
          </tr>
          <?php 
          $monto_total+=$usr->monto;
          ?>
          @endforeach
          </tbody>

          <tbody align="center" id="body_conductor_2">
          </tbody>          
        </table>

  <div class="pull-left btn btn-success">Monto total de egreso es<b> {{$monto_total}} bs</b> </div>
      </div>


    </div>
  </div>

   {!!Html::script('js/usuario.js')!!}
@endsection
