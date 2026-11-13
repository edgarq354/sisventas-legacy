@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')




<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <h3 id="titulogalpon" class="modal-title">Notificación</h3>

          <table  border="1" id="table" class="table table-striped table-bordered table-condensed table-hover" style="background: white" >
           <tr style="background-color: #ef973f;">
            <th><h4><center>Agenda</center></h4></th>
            </tr>
            @foreach($agenda as $value)
          <tr>
            <td>
            {{ $value->fechaIni}}<br>
            <textarea style="width: 100%;">{{ $value->titulo}}</textarea></td>
          </tr>
          @endforeach
        
            
        </table>


          <h4>Conductores con deuda:</h4>
          <table  border="1" id="table" class="table table-striped table-bordered table-condensed table-hover" style="background: white" >
           <tr style="background-color: #ef973f;">
            <th ><h4><center>Codigo</center><h4></th>
            <th><h4><center>Ci</center></h4></th>
            <th><h4><center>Nombre</center></h4></th>
            <th><h4><center>Celular</center></h4></th>
            <th><h4><center>Numero</center></h4></th>
            <th><h4><center>Tipo de Pago</center></h4></th>
            <th><h4><center><i class="fa fa-hand-o-right "></i></center></h4></th>
            </tr>
            @foreach($deudores as $conductor)
          <tr>
            <td><center>{{ $conductor->codigo_empresa}}</center></td>
            <td><center>{{ $conductor->ci}}</center></td>
            <td>{{ $conductor->nombre}} {{$conductor->paterno}} {{$conductor->materno}}</td>
            <td>{{ $conductor->celular}}</td>
            <td><center>{{ $conductor->numero}}</center></td>
            <td>{{ $conductor->tipo}}</td>
           <td>
            {!!Form::open(['route'=>'pago_frecuencia.create', 'method'=>'GET'])!!}  
              <input type="hidden" name="ci" id="ci" value="{{$conductor->ci}}">  
                 {!!Form::submit('PAGAR',['class'=>'btn btn-primary','id'=>'btn_buscar','onclick'=>'btn_esconder()'])!!}
              </form>
            </td>
          </tr>
          @endforeach
        
            
        </table>



    </div>
  </div>

@endsection