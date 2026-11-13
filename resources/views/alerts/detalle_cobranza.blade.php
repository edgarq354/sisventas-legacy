@if(Session::has('id_detalle_cobranza'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
  SE REGISTRO CORRECTAMENTE 
  <a hidden class="btn btn-warning"  target="_blank" href="{!!URL::to('detalle_cobranza_imprimir',['id_detalle_cobranza' => Session::get('id_detalle_cobranza'), 'id_cobranza' => Session::get('id_cobranza')])!!}" aria-hidden="true"  ><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR PAGO</a> 

  <a class="btn btn-primary" target="_blank"  href="{!!URL::to('detalle_cobranza_imprimir_pequenio',['id_detalle_cobranza' => Session::get('id_detalle_cobranza'), 'id_cobranza' => Session::get('id_cobranza')])!!}" aria-hidden="true"  ><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR BOLETO</a> 

</div>
@endif