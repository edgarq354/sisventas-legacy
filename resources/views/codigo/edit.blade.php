@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')

 

<style type="text/css">


 input[type=range] {
  -webkit-appearance: none;
  width: 100%;
  margin: 13.8px 0;
}
input[type=range]:focus {
  outline: none;
}
input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  background: #3071a9;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}
input[type=range]::-webkit-slider-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -14px;
}
input[type=range]:focus::-webkit-slider-runnable-track {
  background: #367ebd;
}
input[type=range]::-moz-range-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  background: #3071a9;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}
input[type=range]::-moz-range-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
}
input[type=range]::-ms-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  background: transparent;
  border-color: transparent;
  color: transparent;
}
input[type=range]::-ms-fill-lower {
  background: #2a6495;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
}
input[type=range]::-ms-fill-upper {
  background: #3071a9;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
}
input[type=range]::-ms-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
  height: 8.4px;
}
input[type=range]:focus::-ms-fill-lower {
  background: #3071a9;
}
input[type=range]:focus::-ms-fill-upper {
  background: #367ebd;
}



</style>




 

 <script type="text/javascript">
function showVal(newVal){
  $("#cantidad_1").text(newVal);
}

function showVal_2(newVal){
  $("#cantidad_2").text(newVal+" mn.");
}


 
 
</script>



<div class="row">
		@foreach($codigo as $mot)
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <div class=" panel panel-success">
      	<div class="panel-heading"><h3>ACTUALIZAR EL CODIGO : <font size="7"><?php  echo base_convert("1999".$mot->id,10,16);?></font> </h3> </div>
      	<div class="panel-body">

			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			 
		
		 
		</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    	    @include('alerts.request')
	

{!!Form::open(['route'=>['codigo.update','null'],'method'=>'PUT','enctype'=>'multipart/form-data','onKeypress'=>'if(event.keyCode == 13) event.returnValue = false;'])!!}	
		
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">	
<input type="hidden" name="id_empresa" id="id_empresa" value="{{Auth::user()->id_empresa}}">  
<input type="hidden" name="id" id="id_empresa" value="{{$mot->id}}">  

  <div class="form-group" >
    Monto:
    {!!Form::number('monto',$mot->monto,['class'=>'form-control','maxlength'=>'5'])!!}
  </div> 
  <div class="form-group">
      {!!Form::label('','Usuario:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('usuario', array( '0' => 'Todos', '1' => 'Pasajero', '2' => 'Conductor'),$mot->usuario,array('id'=>'usuario','class'=>'form-control'))!!}
  </div>   
</div>

  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">      
  <div class="form-group"  >
    {!!Form::label('','Fecha inicial:')!!}
    <div class='input-group date' id='datetimepicker11'>
      {!!Form::text('fecha_inicio',$mot->fecha_inicio,['class'=>'form-control','maxlength'=>'10','onkeypress'=>'return bloqueo_de_punto(event)','style'=>'font-size:20px;text-align:left'])!!}   
      <span class="input-group-addon ">
         <span class="fa fa-calendar" aria-hidden="true"></span> 
      </span>
    </div>
  </div>

  <div class="form-group">
      {!!Form::label('','Tipo:')!!}<span ><font color="red" size="5px">*</font></span>
            {!!Form::select('unico', array( '0' => 'Multiples', '1' => 'Unico' ),$mot->unico,array('id'=>'unico','class'=>'form-control'))!!}
  </div>
</div>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">      
   <div class="form-group"  >
    {!!Form::label('','Fecha final:')!!}
  
  <div class='input-group date' id='datetimepicker10'>

      {!!Form::text('fecha_fin',$mot->fecha_fin,['class'=>'form-control','style'=>'font-size:20px;text-align:left;'])!!}        
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span>  
          </span>
    </div>
      </div>
  
    
      
</div>


  <div class="form-group"  >
  {!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary','id'=>'btn_registrar','onclick'=>'btn_esconder()','style'=>'padding: 17px;'])!!}
     </div>

	</div>
 
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    
	</form>
	@endforeach
</div>	


</div>
</div>
	</div>
</div>
</div>

      
<div class="panel-body">
        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir">
          <thead>
             <th><center>Fecha</center></th>
            <th><center>Perfil</center></th>
            <th><center>Nombre</center></th>
            <th><center>Celular</center></th>
          
          </thead>

          <tbody align="center"  >          
          @foreach($usuario_codigo as $usr)
          <tr>
            <td>{{ $usr->fecha}}</td>
            
            <td>  <a href="../../../../taxivalle2/{{$usr->direccion_imagen}}" target="_blank"><img src="../../../../taxivalle2/{{$usr->direccion_imagen}}" width="90px" height="90px" title="PERFIL" class="img-thumbnail"></a></td>
            <td>{{ $usr->nombre}} {{ $usr->apellido}}</td>
            <td>{{ $usr->celular}}</td> 
             
             
             
          </tr>
          @endforeach
          </tbody>

                    
        </table>
        </div>

      </div>
 

		
 
	@endsection