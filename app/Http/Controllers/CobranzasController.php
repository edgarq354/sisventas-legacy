<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Luecano\NumeroALetras\NumeroALetras;

class CobranzasController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
if(Auth::user()->privilegio==0 ){
      $cobranzas = DB::select("SELECT c.*,a.usuario, 
      s.nombre as sucursal,
      cl.nombre as 'cliente',
      clp.nombre as 'proveedor' 
            FROM cobranzas c
            inner join users a on(c.id_usuario_registro =a.id  )
            inner join sucursal s on(s.id =c.id_sucursal  )
            left join cliente cl on(cl.id=c.id_cliente)
            left join cliente clp on(clp.id=c.id_proveedor)
            left join nota_venta nv on(nv.id=c.id_nota_venta )
            left join nota_compra nc on(nc.id=c.id_nota_compra ) 
            where (nv.estado='Por cobrar' or nc.estado='Por pagar')  and   c.id_empresa=" . Auth::user()->id_empresa . "   order by c.id desc");
    }else{
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
            where  c.id_empresa=" . Auth::user()->id_empresa . "   order by c.id desc");
    }
 
    return view('cobranzas.index', ['cobranzas'=> $cobranzas]);

  }
  

  public function cobranzas_imprimir()
  {
    if(Auth::user()->privilegio==0 ){
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
            where  c.id_empresa=" . Auth::user()->id_empresa . "   order by c.id desc");
    }else{
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
            where  c.id_empresa=" . Auth::user()->id_empresa . "   order by c.id desc");
    }
    $empresa = DB::select("SELECT * from empresa  where id='" . Auth::user()->id_empresa . "'");

    $pdf = \PDF::loadView('cobranzas.cobranzas_imprimir', [
      'cobranzas' => $cobranzas,
      'empresa' => $empresa
    ]);
    return $pdf->stream();
  }

  public function cobranza_detalle_imprimir_pequenio($id_cobranza){

    $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);
    
    $detalle_cobranza = DB::select("SELECT dc.*, a.usuario, c.caja as caja
    from detalle_cobranza dc,  users a, caja c
    where  
    dc.id_caja=c.id and 
    dc.id_usuario_registro = a.id and dc.id_cobranza=" . $id_cobranza . " and dc.id_empresa=" . Auth::user()->id_empresa);

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
        $numeroLetra="";
        if(count($detalle_cobranza) > 0){
          $numeroLetra=ucfirst(strtolower($formatter->toInvoice($detalle_cobranza[0]->monto, 2,'Bolivianos')));
        }

$customPaper = array(0,0,567.00,226.77); 
      $pdf=\PDF::loadView('cobranzas.cobranza_detalle_imprimir_pequenio',  [
        'detalle_cobranza'=>$detalle_cobranza,
        'cobranzas'=>$cobranzas,
        'empresa'=>$empresa,
        'sucursal'=>$sucursal, 
        'numeroLetra'=>$numeroLetra
      ])->setPaper($customPaper, 'landscape');
      return   $pdf->stream();              
  
  }    
 


}