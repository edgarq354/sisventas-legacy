@if(Session::has('gasto_sueldo_id'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
  SE REGISTRO CORRECTAMENTE <a class="btn btn-warning"   href="{!!URL::to('gasto_imprimir',Session::get('gasto_sueldo_id'))!!}" aria-hidden="true"  ><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR PAGO</a> 
</div>
@endif