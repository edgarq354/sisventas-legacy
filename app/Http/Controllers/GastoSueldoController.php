<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\GastoRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GastoSueldoController extends Controller
{
      public function __construct() {
         $this->middleware('auth');
    }

    public  function index() {          
         
            $gasto=DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado 
            from gasto g, caja c, users a, tipo_gasto tg , cliente cli 
            where g.id_caja=c.id 
            and g.id_usuario=a.id 
            and tg.id=g.id_tipo_gasto  
            and cli.id= g.id_empleado  
              and g.id_empresa=".Auth::user()->id_empresa." order by g.id asc");

            $caja=DB::select("SELECT id from caja where  estado ='Abierta' and id_usuario=".Auth::user()->id." and id_empresa=".Auth::user()->id_empresa." order by id desc limit 1 ");
            $tipo_gasto=DB::select("SELECT * from tipo_gasto where   id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
            $empleado=DB::select("SELECT * from cliente where  tipo_e=1 and id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
       $id_caja="";

       foreach ($caja as $key => $value) {
            $id_caja= $value->id;   
        }

            return view('gasto_sueldo.index', [
              'gasto'=>$gasto,
              'tipo_gasto'=>$tipo_gasto,
              'empleado'=>$empleado,
            'id_caja'=>$id_caja]);             
    }
 
    public function store(GastoRequest $request){
            DB::beginTransaction(); 
        try { 
                $id_gasto_padre=DB::table('gasto')->insertGetId([
                  'id_caja'=>$request['id_caja'], 
                  'precio_gasto'=>$request['precio_gasto'],  
                  'detalle'=>$request['detalle'], 
                  'id_tipo_gasto'=>$request['id_tipo_gasto'],
                  'id_gasto_padre'=>"0",
                  'id_empleado'=>$request['id_empleado'],
                  'id_usuario'=>Auth::user()->id,
                  'fecha'=>now(),
                  'id_empresa'=>Auth::user()->id_empresa
                  ]
                  );
                   // Registrar DETALLE DE GASTOS
                   $cant=0; 
                   if(isset($request['idCarrito'])){
                  foreach ($request['idCarrito'] as $val) {
                    $id_gasto=$request['idCarrito'][$cant];  
                    $cant++;
                    DB::table('gasto')
                    ->where('id',$id_gasto)
                    ->update([
                      'id_gasto_padre'=>$id_gasto_padre
                    ]);
                   }
                  }

                DB::commit(); 
                return redirect('/gasto_sueldo')->with("gasto_sueldo_id",$id_gasto_padre);  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/gasto_sueldo')->with("message-error","ERROR INTENTE NUEVAMENTE".$e);      
        }      
    }

    public function update(Request $request){
        DB::beginTransaction(); 
        try {
          
          
             $pedido = DB::table('caja')
             ->where('id',$request['id'])
           ->update(['monto_cierre'=>$request['monto_cierre'],
            'estado'=>'Cerrada',
            'fecha_cierre'=>now() ]);
                DB::commit();
                return redirect('/caja')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/caja')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }       
             
        }

    public function show($id){
       return "En proceso";  
    }

    public  function gasto_historial($fechaInicio,$fechaFinal,$id_tipo_gasto,$id_empleado)
    { 
      $sql="SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado 
      from gasto g, caja c, users a, tipo_gasto tg , cliente cli 
      where g.id_caja=c.id 
      and g.id_usuario=a.id 
      and tg.id=g.id_tipo_gasto  
      and cli.id= g.id_empleado
      and g.id_empresa=".Auth::user()->id_empresa." 
      and date(g.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') ";
          
      if($id_tipo_gasto!=0){
        $sql.=" and g.id_tipo_gasto=".$id_tipo_gasto;
      }
      
      if($id_empleado!=0){
        $sql.=" and g.id_empleado=".$id_empleado;
      }

      $sql.="  order by g.id asc";

       $gasto=DB::select($sql); 
        
      $tipo_gasto=DB::select("SELECT * from tipo_gasto where   id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
      $empleado=DB::select("SELECT * from cliente where   tipo_e=1 and id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
          
       return view('gasto.historial',[
        'gasto'=>$gasto,
        'fechaInicio'=>$fechaInicio,
        'fechaFinal'=>$fechaFinal,
        'tipo_gasto'=>$tipo_gasto,
        'empleado'=>$empleado,
        'id_empleado'=>$id_empleado,
        'id_tipo_gasto'=>$id_tipo_gasto
         ]);   
    }


        public  function gasto_historial_imprimir($fechaInicio,$fechaFinal,$id_tipo_gasto,$id_empleado)
    { 
          
       $sql="SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado 
      from gasto g, caja c, users a, tipo_gasto tg , cliente cli 
      where g.id_caja=c.id 
      and g.id_usuario=a.id 
      and tg.id=g.id_tipo_gasto  
      and cli.id= g.id_empleado
      and g.id_empresa=".Auth::user()->id_empresa." 
      and date(g.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') ";
          
      if($id_tipo_gasto!=0){
        $sql.=" and g.id_tipo_gasto=".$id_tipo_gasto;
      }
      
      if($id_empleado!=0){
        $sql.=" and g.id_empleado=".$id_empleado;
      }

      $sql.="  order by g.id asc";

       $gasto=DB::select($sql); 
        
         $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
            
         $pdf=\PDF::loadView('gasto.historial_imprimir',[
          'gasto'=>$gasto,
          'fechaInicio'=>$fechaInicio,
          'fechaFinal'=>$fechaFinal,
          'empresa'=>$empresa
           ]);   
        return   $pdf->stream(); 
    }

  
      public  function gasto_imprimir() {          
         
            $gasto=DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado 
            from gasto g, caja c, users a, tipo_gasto tg , cliente cli 
            where g.id_caja=c.id 
            and g.id_usuario=a.id 
            and tg.id=g.id_tipo_gasto  
            and cli.id= g.id_empleado 
              and g.id_empresa=".Auth::user()->id_empresa." order by g.id asc");

        $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
            
        $pdf=\PDF::loadView('gasto.gasto_imprimir',[
        'gasto'=>$gasto,
        'empresa'=>$empresa]); 
        return $pdf->stream();        
    }

    //CARGAR LISTA DE GASTOS COMO ADELANTO
public function get_lista_gastos_para_sueldo($fechaInicio,$fechaFinal,$id_tipo_gasto,$id_empleado)
{ 
      
  $sql="SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado 
  from gasto g, caja c, users a, tipo_gasto tg , cliente cli 
  where g.id_caja=c.id 
  and g.id_usuario=a.id 
  and tg.id=g.id_tipo_gasto  
  and cli.id= g.id_empleado
  and g.id_gasto_padre is null 
  and g.id_empresa=".Auth::user()->id_empresa." 
  and date(g.fecha) between date('".$fechaInicio."') and date('".$fechaFinal."') ";
      
  if($id_tipo_gasto!=0){
    $sql.=" and g.id_tipo_gasto=".$id_tipo_gasto;
  }
  
  if($id_empleado!=0){
    $sql.=" and g.id_empleado=".$id_empleado;
  }

  $sql.="  order by g.id asc";

   $gasto=DB::select($sql); 

  return response($gasto);
}



   

}
