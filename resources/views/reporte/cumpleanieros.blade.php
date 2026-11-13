@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 
  

        
  <div class="row"> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive" style="overflow-x:inherit"> 
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <font size="6">CUMPLEAÑEROS</font>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    
    </div>

       
    
       
    

<div class="panel-body">
        <table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
          <thead>
            <th><center>CI / NIT</center></th>
            <th><center>Nombre</center></th> 
            <th><center>Celular</center></th> 
            <th><center>Fecha de cumpleaño</center></th>
            <th><center>Cantidad de dias faltantes</center></th> 
            <th><center>Conductor</center></th> 
            <th><center>Personal</center></th> 
            <th><center>Hoy</center></th>
            
          </thead>

          <tbody align="center" id="body_conductor">          
          @foreach($cumpleanieros as $con)
          <tr>
            <td>
               @if($con->conductor==1)
               <a    href="{!!URL::to('conductors',$con->ci)!!} "  >  {{ $con->ci}} </a>
              @endif
               @if($con->personal==1)
               <a    href="{!!URL::to('cliente_id',$con->id)!!} "  >  {{ $con->ci}} </a>
              @endif
             </td>
             
            <td>{{ $con->nombre}} {{ $con->paterno}} {{ $con->materno}}</td>
            <td>{{ $con->celular}}</td>
            <td>{{ $con->fecha_cumpleanio}}</td>
            <td>
              @if($con->dias==0)
              Hoy
              @elseif($con->dias==-1)
              Ayer
              @elseif($con->dias==1)
              Mañana
              @else
              {{ $con->dias}} dias
              @endif
              
            </td>
            <td>
              @if($con->conductor==1)
              <label> * <i class="fa fa-check" aria-hidden="true"></i></label>
              @endif
            </td>
            <td>
              @if($con->personal==1)
              <label> * <i class="fa fa-check" aria-hidden="true"></i></label>
              @endif
            </td>
            <td>
              {{$con->fecha_actual}}
            </td> 
             
          </tr>
          @endforeach
          </tbody>
      
        </table>
        </div>

      </div>
    </div>
  </div>

 
@endsection
