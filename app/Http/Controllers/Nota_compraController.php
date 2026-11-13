<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NotaCompraRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\Notificacion;
use Exception;
use Illuminate\Support\Facades\DB;

 use App\Services\QrService;

class Nota_compraController extends Controller
{
   protected $qrService;
         public function __construct() {
         $this->middleware('auth');
    }
    
 function index(Request $Request)
    { 
          $nota_compra=DB::select("SELECT nc.*, a.usuario, 
            p.ci_nit,
            (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor, 
            (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, c.nombre 
            from nota_compra nc, users a, cliente p, cliente c 
            where nc.id_proveedor = p.id and nc.id_comprador = c.id and nc.id_usuario = a.id and nc.id_empresa=".Auth::user()->id_empresa); 
        
       return view('nota_compra.index',[
        'nota_compra'=>$nota_compra ]);   
    }

    public function create()
    {
      $proveedor=DB::select("SELECT  * from cliente where tipo_p=1 and  id_empresa=".Auth::user()->id_empresa);
      // Incluir también al empleado del usuario autenticado (aunque no sea tipo_e=1) para poder marcarlo por defecto como comprador
      $empleado=DB::select("SELECT  * from cliente where id_empresa=".Auth::user()->id_empresa." and (tipo_e=1 or id=".(int)(Auth::user()->id_empleado ?? 0).")");
      $comprador_default = Auth::user()->id_empleado;
      $tipo=DB::select("SELECT  * from tipo_producto where id_empresa=".Auth::user()->id_empresa);

      $caja=DB::select("SELECT id from caja where  estado ='Abierta' and id_usuario=".Auth::user()->id." and id_empresa=".Auth::user()->id_empresa." order by id desc limit 1 ");
       $id_caja="";

       foreach ($caja as $key => $value) {
            $id_caja= $value->id;   
        }


      return view('nota_compra.create',[
        'tipo_producto'=>$tipo,
        'proveedor'=>$proveedor,
        'empleado'=>$empleado,
        'comprador_default'=>$comprador_default,
        'id_caja'=>$id_caja]);
    }

    public function store(NotaCompraRequest $request){
        	DB::beginTransaction(); 
        try {
          $cliente=DB::select("SELECT concat(nombre,' ',paterno,' ',materno) as razon_social from cliente where  id=".$request['id_proveedor']."   limit 1 ");
          $razon_social="";
          foreach ($cliente as $key => $value) {
               $razon_social= $value->razon_social;   
           }
        
                $id_nota_compra=DB::table('nota_compra')->insertGetId([
                  'id_proveedor'=>$request['id_proveedor'], 
                  'id_comprador'=>$request['id_comprador'],
                  'id_caja'=>$request['id_caja'],
                  'monto_total'=>$request['monto_total'],
                  'estado'=>$request['estado'],
                  'id_usuario'=>Auth::user()->id,
                  'fecha'=>now(),
                  'id_empresa'=>Auth::user()->id_empresa
                  ] );

                  if($request['estado']=="Por pagar"){
                    // Registrar PLAN DE PAGOS COBRANZA
                    $id_cobranza=DB::table('cobranzas')->insertGetId([
                      'monto_total'=>$request['monto_total'],  
                      'id_nota_compra'=>$id_nota_compra,
                      //'ci_nit'=>$request['numero_documento'],
                      'razon_social'=> $razon_social, 
                      'id_cliente'=>$request['id_proveedor'],
                      //'nota'=>"Ticket: ".$ticket[0]->numero_ticket.", Tipo: ".$request['tipo'],
                      'tipo'=>"NOTA_COMPRA",
                      'id_usuario_registro'=>Auth::user()->id,
                      'estado'=>$request['estado'],
                      'id_sucursal'=>Auth::user()->id_sucursal,
                      'fecha_registro'=>now(),
                      'id_empresa'=>Auth::user()->id_empresa
                      ] );
                  }
               
                  //self::registrar_bitacora('Nota Compra-Store','Registra Nota Compra');
                  $cant=0; 
                  foreach ($request['idCarrito'] as $val) {
                    $id_producto=$request['idCarrito'][$cant]; 
                    $cantidad=$request['cantidad'][$cant]; 
                    $peso=$request['peso'][$cant]; 
                    $subtotal=$request['subtotal'][$cant]; 
                    $precio=$request['precio'][$cant]; 
                    $precioCompra=$request['precioCompra'][$cant]; 
                    $precioVenta=$request['precioVenta'][$cant];
                    $cant++;
                    DB::table('detalle_compra')->insert([
                      'id_nota_compra'=>$id_nota_compra,
                      'id_producto'=>$id_producto,
                      'precio_unidad'=>$precio,
                      'cantidad'=>$cantidad, 
                      'peso'=>$peso,
                      'sub_total'=>$subtotal,
                      'id_empresa'=>Auth::user()->id_empresa                      
                    ]);
                    DB::table('producto')
                    ->where('id',$id_producto)
                    ->update([
                      'precio'=>$precioVenta,
                      'precio_compra'=>$precioCompra,
                      'cantidad'=>DB::raw('cantidad + '.$cantidad),
                      'peso'=>DB::raw('peso + '.$peso) 
                    ]);
                }

                DB::commit(); 
                return redirect('/nota_compra/create')->with('nota_compra_id',$id_nota_compra);

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/nota_compra')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

    	public function update(Request $request){
    	DB::beginTransaction(); 
        try {
          $estado=0;
          if($request['estado_edit']){
            $estado=1;
          }
          
	         $pedido = DB::table('categoria')
	         ->where('id',$request['id_categoria_edit'])
           ->update(['nombre'=>$request['nombre_edit'],'estado'=>$estado  ]);
                DB::commit();
                return redirect('/categoria')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/categoria')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    	}

    function cargar_categoria($id_video){
        $apoderado=DB::select("SELECT * FROM categoria WHERE id=".$id_video);
        return response($apoderado);
    }  




    public function nota_compra_imprimir($id){

      $empresa=DB::select("SELECT * from empresa e where e.id=".Auth::user()->id_empresa);
      
          $nota_compra=DB::select("SELECT nc.*, a.usuario, 
            p.ci_nit,
            (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor, 
            (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, c.nombre 
            from nota_compra nc, users a, cliente p, cliente c 
            where nc.id_proveedor = p.id 
            and nc.id_comprador = c.id 
            and nc.id_usuario = a.id 
            and nc.id= ".$id." and  nc.id_empresa=".Auth::user()->id_empresa ); 
          $this->qrService = new QrService();
        $qrGenerar = str_replace(["\r", "\n"], '', $this->qrService->generarBase64($nota_compra[0]->id.'|'.$nota_compra[0]->fecha.'|'.$nota_compra[0]->monto_total));
         
          $detalle_compra=DB::select("
                      SELECT dv.id_nota_compra,dv.id_producto,dv.peso,dv.precio_unidad,dv.sub_total, p.nombre
                      from detalle_compra dv, producto p 
                      where p.id=dv.id_producto and  dv.id_nota_compra=".$id ); 
 /*
 BOLETA GRANDE       
        $pdf=\PDF::loadView('nota_compra.imprimir',  [
          'nota_compra'=>$nota_compra,
          'detalle_compra'=>$detalle_compra,
          'empresa'=>$empresa,
	  'qrBase64' => $qrGenerar,
        ]);
*/
          
  /*
1 inch = 72 point
1 inch = 2.54 cm
10 cm = 10/2.54*72 = 283.464566929
20 cm = 10/2.54*72 = 566.929133858
$customPaper = array(0,0,567.00,283.80);
->setPaper($customPaper, 'landscape');
  */

$customPaper = array(0,0,567.00,226.77); 
  $pdf=\PDF::loadView('nota_compra.imprimir',  [
    'nota_compra'=>$nota_compra,
    'detalle_compra'=>$detalle_compra,
    'empresa'=>$empresa,
    'qrBase64' => $qrGenerar,
])->setPaper($customPaper, 'landscape');
return   $pdf->stream(); 

        return   $pdf->stream();            
    }       


    public function get_nota_compra_por_id($id){      
        $nota_compra=DB::select("SELECT nc.*, a.usuario
          from nota_compra nc,  users a
          where nc.id_usuario = a.id  and nc.id=".$id."  and nc.id_empresa=".Auth::user()->id_empresa);
          $detalle_compra=DB::select("
                      SELECT  dv.id_nota_compra,dv.id_producto,dv.peso,dv.precio_unidad,dv.sub_total, p.nombre
                      from detalle_compra dv, producto p 
                      where p.id=dv.id_producto and  dv.id_nota_compra=".$id); 
        return response([
          'nota_compra'=>$nota_compra,
          'detalle_compra'=>$detalle_compra
        ]);
    }

    public function get_nota_compra_por_id_producto($id,$fechaInicio,$fechaFinal){      
        $detalle_compra=DB::select("SELECT nc.id, 
            nc.fecha,
            a.usuario, 
            p.ci_nit,
            (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor, 
            (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, 
            dc.peso,
            dc.precio_unidad,
            dc.sub_total
            from nota_compra nc, users a, cliente p, cliente c,detalle_compra dc  
            where nc.id_proveedor = p.id 
            and nc.id=dc.id_nota_compra 
            and nc.id_comprador = c.id 
            and nc.id_usuario = a.id 
            and  date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')  
            and dc.id_producto=".$id); 
        return response([ 
          'detalle_compra'=>$detalle_compra
        ]);
    }
    

    public  function nota_compra_historial($fechaInicio,$fechaFinal)
    { 
          
       $nota_compra=DB::select("SELECT nc.*, a.usuario, 
            p.ci_nit,
            (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor, 
            (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, c.nombre 
            from nota_compra nc, users a, cliente p, cliente c 
            where nc.id_proveedor = p.id and nc.id_comprador = c.id and nc.id_usuario = a.id  
            and  date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') and nc.id_empresa=".Auth::user()->id_empresa); 
        
          
       return view('nota_compra.historial',[
        'nota_compra'=>$nota_compra,
        'fechaInicio'=>$fechaInicio,
        'fechaFinal'=>$fechaFinal
         ]);   
    }


        public  function nota_compra_historial_imprimir($fechaInicio,$fechaFinal)
    { 
          
       $nota_compra=DB::select("SELECT nc.*, a.usuario, 
            p.ci_nit,
            (concat(p.nombre,' ',p.paterno,' ',p.materno)) as proveedor, 
            (concat(c.nombre,' ', c.paterno,' ',c.materno)) as comprador, c.nombre 
            from nota_compra nc, users a, cliente p, cliente c 
            where nc.id_proveedor = p.id and nc.id_comprador = c.id and nc.id_usuario = a.id  
            and  date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') and nc.id_empresa=".Auth::user()->id_empresa); 

         $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
            
         $pdf=\PDF::loadView('nota_compra.historial_imprimir',[
          'nota_compra'=>$nota_compra,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'empresa'=>$empresa
           ]);   
        return   $pdf->stream(); 
    }


        public  function nota_compra_historial_por_producto($fechaInicio,$fechaFinal,$id_producto)
    { 
      $sql="";
          
      $nota_compra="";
          if($id_producto==0){

            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_compra,
            (select sum(dcc.sub_total) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total
             from producto p, detalle_compra dc, nota_compra nc, tipo_producto tp 
            where p.id_tipo_producto=tp.id 
            and dc.id_producto=p.id 
            and nc.id=dc.id_nota_compra 
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')   
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id";

          }else{
            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_compra,
            (select sum(dcc.sub_total) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total 
             from producto p, detalle_compra dc, nota_compra nc, tipo_producto tp 
            where p.id_tipo_producto=tp.id 
            and dc.id_producto=p.id 
            and nc.id=dc.id_nota_compra 
            and p.id=".$id_producto." 
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')   
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id"; 
          }
        $nota_compra=DB::select($sql);       
        $producto=DB::select("SELECT p.* from producto p where p.id_empresa=".Auth::user()->id_empresa); 
         
        // echo $sql;
       return view('nota_compra.historial_por_producto',[
          'nota_compra'=>$nota_compra,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'id_producto'=>$id_producto,
          'producto'=>$producto,
          'sql'=> $sql,
           ]);    
         
    }

    public  function nota_compra_historial_por_producto_imprimir($fechaInicio,$fechaFinal,$id_producto)
    { 
     $sql="";
          
      $nota_compra="";
          if($id_producto==0){

            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_compra,
            (select sum(dcc.sub_total) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total
             from producto p, detalle_compra dc, nota_compra nc, tipo_producto tp 
            where p.id_tipo_producto=tp.id 
            and dc.id_producto=p.id 
            and nc.id=dc.id_nota_compra 
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')   
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id";

          }else{
            $sql="SELECT p.*,tp.nombre as nombre_tipo_producto,(select sum(dcc.peso) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as peso_compra,
            (select sum(dcc.sub_total) from detalle_compra dcc, nota_compra ncc 
            where dcc.id_producto=p.id 
            and dcc.id_nota_compra=ncc.id
            and ncc.id_empresa=".Auth::user()->id_empresa." 
            and date(ncc.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."') ) as sub_total 
             from producto p, detalle_compra dc, nota_compra nc, tipo_producto tp 
            where p.id_tipo_producto=tp.id 
            and dc.id_producto=p.id 
            and nc.id=dc.id_nota_compra 
            and p.id=".$id_producto." 
            and date(nc.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."')   
            and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id"; 
          }
        $nota_compra=DB::select($sql); 

         $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
            
         $pdf=\PDF::loadView('nota_compra.historial_por_producto_imprimir',[
          'nota_compra'=>$nota_compra,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'id_producto'=>$id_producto,
          'empresa'=>$empresa
           ]);   
        return   $pdf->stream(); 
    }


    public  function actualizar_estado_nota_compra(Request $request){
      DB::beginTransaction(); 
       
        try { 

           $pedido = DB::table('nota_compra')
           ->where('id',$request['id_nota_compra'])
           ->update([ 
                  'estado'=>$request['estado'],
            ]);
                DB::commit();
               return redirect('/nota_venta')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/nota_venta')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }       
         
      }
       
}