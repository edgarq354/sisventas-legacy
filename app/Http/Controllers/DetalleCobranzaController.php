<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CobranzaDetalleRequest;

use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Luecano\NumeroALetras\NumeroALetras;

class DetalleCobranzaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

 

  public function edit($id)
  {
    //LISTA DE COBRANZAS
    $detalle_cobranza = DB::select("SELECT dc.*, a.usuario, c.caja as caja
          from detalle_cobranza dc,  users a, caja c
          where  
          dc.id_caja=c.id and 
          dc.id_usuario_registro = a.id and dc.id_cobranza=" . $id . " and dc.id_empresa=" . Auth::user()->id_empresa);

    $cobranzas = DB::select("SELECT c.*,a.usuario, 
      s.nombre as sucursal,
      cl.nombre as 'cliente',
      clp.nombre as 'proveedor' 
            FROM cobranzas c
            inner join users a on(c.id_usuario_registro =a.id  )
            inner join sucursal s on(s.id =c.id_sucursal  )
            left join cliente cl on(cl.id=c.id_cliente)
            left join cliente clp on(clp.id=c.id_proveedor)
            left join nota_venta nv on(nv.id=c.id_nota_venta)
            left join nota_compra nc on(nc.id=c.id_nota_compra) 
            where  c.id_empresa=" . Auth::user()->id_empresa . " and c.id=".$id);
      $cliente=DB::select("SELECT  * from cliente where id_empresa= ".Auth::user()->id_empresa);

      $caja=DB::select("SELECT id from caja where  estado ='Abierta' and id_usuario=".Auth::user()->id." and  id_empresa= ".Auth::user()->id_empresa." order by id desc limit 1 ");
      $id_caja=0;
       foreach ($caja as $key => $value) {
            $id_caja= $value->id;   
        }
        if($id_caja==0){
          return redirect('/cobranzas')->with("message-error", "ERROR, NO TIENE CAJA ABIERTA");
        }else{
          return view('detalle_cobranza.edit', [
            'cobranzas' => $cobranzas,
            'detalle_cobranza' => $detalle_cobranza,
            'cliente'=>$cliente,
            'id_caja'=>$id_caja
          ]);
        }

  }


  public function store(CobranzaDetalleRequest $request)
  {
    if($request['monto']>0){
      DB::beginTransaction();
      try{
     
           $id_deatalle_cobranza=DB::table('detalle_cobranza')->insertGetId(
             [
               'id_caja' => $request['id_caja'],
               'id_cobranza' => $request['id_cobranza'], 
               'monto' => $request['monto'], 
               'detalle' => $request['detalle'], 
               'forma_pago' => $request['estado'], 
               'ci_nit'=>$request['numero_documento'], 
               'razon_social'=>$request['razon_social'],
               'estado_cobranza'=>$request['estado_cobranza'],
               'id_usuario_registro' => Auth::user()->id,
               'id_sucursal' => Auth::user()->id_sucursal,
               'id_empresa' => Auth::user()->id_empresa
             ]
           );
     
           DB::table('cobranzas')
                             ->where('id',$request['id_cobranza']) 
                             ->update([ 
                               'monto_pagado'=>DB::raw('monto_pagado + '.$request['monto'])
                             ]);
           DB::commit(); 
           return redirect('/detalle_cobranza/'.$request['id_cobranza'].'/edit')
           ->with("id_cobranza", $request['id_cobranza'])
           ->with("id_detalle_cobranza",$id_deatalle_cobranza);
           //->with("message", "SE REGISTRO CORRECTAMENTE");
     
         } catch (Exception $e) {
           DB::rollback();
           return redirect('/detalle_cobranza/'.$request['id_cobranza'].'/edit')->with("message-error", "ERROR INTENTE NUEVAMENTE");
         }
    }else{
      return redirect('/detalle_cobranza/'.$request['id_cobranza'].'/edit')->with("message-error", "ERROR INTENTE NUEVAMENTE. 'El Monto debe ser mayor a 0'");
    }
   
  }
 

  public function show($id)
  {
    return "En proceso";
  }


  public function detalle_cobranza_imprimir($id_deatalle_cobranza,$id_cobranza){

    $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);
    
    $detalle_cobranza = DB::select("SELECT dc.*, a.usuario, c.caja as caja
    from detalle_cobranza dc,  users a, caja c
    where  
    dc.id_caja=c.id and 
    dc.id_usuario_registro = a.id and dc.id=" . $id_deatalle_cobranza . " and dc.id_empresa=" . Auth::user()->id_empresa);

        $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa); 
        $cobranzas = DB::select("SELECT c.*,a.usuario, 
        s.nombre as sucursal,
        cl.nombre as 'cliente',
        clp.nombre as 'proveedor' 
              FROM cobranzas c
              inner join users a on(c.id_usuario_registro =a.id  )
              inner join sucursal s on(s.id =c.id_sucursal  )
              left join cliente cl on(cl.id=c.id_cliente)
              left join cliente clp on(clp.id=c.id_proveedor)
              left join nota_venta nv on(nv.id=c.id_nota_venta)
              left join nota_compra nc on(nc.id=c.id_nota_compra) 
              where  c.id_empresa=" . Auth::user()->id_empresa . " and c.id=".$id_cobranza);
        
        $formatter = new NumeroALetras();            
        $numeroLetra=ucfirst(strtolower($formatter->toInvoice($detalle_cobranza[0]->monto, 2,'Bolivianos')));

$customPaper = array(0,0,567.00,226.77); 
      $pdf=\PDF::loadView('detalle_cobranza.detalle_cobranza_imprimir',  [
        'detalle_cobranza'=>$detalle_cobranza,
        'cobranzas'=>$cobranzas,
        'empresa'=>$empresa,
        'sucursal'=>$sucursal, 
        'numeroLetra'=>$numeroLetra
      ])->setPaper($customPaper, 'landscape');
      return   $pdf->stream();              
  
  }    
 


  public function detalle_cobranza_imprimir_pequenio($id_deatalle_cobranza,$id_cobranza){

    $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);
    
    $detalle_cobranza = DB::select("SELECT dc.*, a.usuario, c.caja as caja
    from detalle_cobranza dc,  users a, caja c
    where  
    dc.id_caja=c.id and 
    dc.id_usuario_registro = a.id and dc.id=" . $id_deatalle_cobranza . " and dc.id_empresa=" . Auth::user()->id_empresa);

        $sucursal=DB::select("SELECT * from sucursal e where  e.id_empresa=".Auth::user()->id_empresa); 
        $cobranzas = DB::select("SELECT c.*,a.usuario, 
        s.nombre as sucursal,
        cl.nombre as 'cliente',
        clp.nombre as 'proveedor' 
              FROM cobranzas c
              inner join users a on(c.id_usuario_registro =a.id  )
              inner join sucursal s on(s.id =c.id_sucursal  )
              left join cliente cl on(cl.id=c.id_cliente)
              left join cliente clp on(clp.id=c.id_proveedor)
              left join nota_venta nv on(nv.id=c.id_nota_venta)
              left join nota_compra nc on(nc.id=c.id_nota_compra) 
              where  c.id_empresa=" . Auth::user()->id_empresa . " and c.id=".$id_cobranza);
        
        $formatter = new NumeroALetras();            
        $numeroLetra=ucfirst(strtolower($formatter->toInvoice($detalle_cobranza[0]->monto, 2,'Bolivianos')));

$customPaper = array(0,0,567.00,226.77); 
      $pdf=\PDF::loadView('detalle_cobranza.detalle_cobranza_imprimir_pequenio',  [
        'detalle_cobranza'=>$detalle_cobranza,
        'cobranzas'=>$cobranzas,
        'empresa'=>$empresa,
        'sucursal'=>$sucursal, 
        'numeroLetra'=>$numeroLetra
      ])->setPaper($customPaper, 'landscape');
      return   $pdf->stream();              
  
  }    
 


}
