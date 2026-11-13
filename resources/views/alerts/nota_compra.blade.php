@if(Session::has('nota_compra_id'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
  SE REGISTRO CORRECTAMENTE <a class="btn btn-warning"   href="{!!URL::to('nota_compra_imprimir',Session::get('nota_compra_id'))!!}" aria-hidden="true"  ><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR NOTA DE COMPRA</a> 
</div>
@endif