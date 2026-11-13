

@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

<div class="row"  style="overflow-x:inherit">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
        {{Form::open(array('url' => 'asistencia/finalizar'))}}  
        <div class="form-group">
        <h2>¿Desea cerrar sesión?</h2>
        
      </div>

     

          <div class="form-group" align="left">
         <!-- <a class="btn btn-success" data-dismiss="modal"  data-toggle="modal" data-target="#modal_finalizar" hidden=""> SI</a>  -->
          <a href="{!!URL::to('logout')!!}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesión"> SI</a>  
            <button data-dismiss="modal"  class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Cancelar">Cancelar</button>
                
                
        </div>

    </div>
   {!!Html::script('js/Admins.js')!!}

@endsection