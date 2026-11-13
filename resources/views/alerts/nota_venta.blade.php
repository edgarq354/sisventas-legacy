@if(Session::has('nota_venta_id'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
  SE REGISTRO CORRECTAMENTE 
  <a class="btn btn-warning"   style="text-decoration: none;" target="_blank" href="{!!URL::to('nota_venta_imprimir',Session::get('nota_venta_id'))!!}" aria-hidden="true"  ><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR NOTA DE VENTA</a> 

  <a class="btn btn-primary"  style="text-decoration: none;" target="_blank"  href="{!!URL::to('nota_venta_imprimir_pequenio',Session::get('nota_venta_id'))!!}" aria-hidden="true"  ><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR BOLETO</a> 

</div>
@endif