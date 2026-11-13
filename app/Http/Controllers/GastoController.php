<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\GastoRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GastoController extends Controller
{
      public function __construct() {
         $this->middleware('auth');
      }

      public function index() {
        $gasto=null;
         if(Auth::user()->privilegio==0){
            $gasto=DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado
            from gasto g, caja c, users a, tipo_gasto tg , cliente cli
            where g.id_caja=c.id
            and g.id_usuario=a.id
            and tg.id=g.id_tipo_gasto
            and cli.id= g.id_empleado
              and g.id_empresa=".Auth::user()->id_empresa." order by g.id asc");
         }else{
          $gasto=DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado
            from gasto g, caja c, users a, tipo_gasto tg , cliente cli
            where g.id_caja=c.id
            and g.id_usuario=a.id
            and tg.id=g.id_tipo_gasto
            and cli.id= g.id_empleado 
            and c.id_usuario=".Auth::user()->id."
            and g.id_empresa=".Auth::user()->id_empresa." order by g.id asc");
         }
            

            $caja=DB::select("SELECT id from caja where  estado ='Abierta' and id_usuario=".Auth::user()->id." and id_empresa=".Auth::user()->id_empresa." order by id desc limit 1 ");
            $tipo_gasto=DB::select("SELECT * from tipo_gasto where   id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
            $empleado=DB::select("SELECT * from cliente where  tipo_e=1 and id_empresa=".Auth::user()->id_empresa." order by nombre asc ");
       $id_caja="";

       foreach ($caja as $key => $value) {
            $id_caja= $value->id;
        }

            return view('gasto.index', [
              'gasto'=>$gasto,
              'tipo_gasto'=>$tipo_gasto,
              'empleado'=>$empleado,
            'id_caja'=>$id_caja]);
    }

    public function store(GastoRequest $request){
            DB::beginTransaction();
        try {
                DB::table('gasto')->insert([
                  'id_caja'=>$request['id_caja'],
                  'precio_gasto'=>$request['precio_gasto'],
                  'detalle'=>$request['detalle'],
                  'nota'=>$request['nota']?? null,
                  'id_tipo_gasto'=>$request['id_tipo_gasto'],
                  'id_empleado'=>$request['id_empleado'] ?: Auth::user()->id_empleado,
                  'id_usuario'=>Auth::user()->id,
                  'fecha'=>now(),
                  'id_empresa'=>Auth::user()->id_empresa
                  ]
                  );
                DB::commit();
                return redirect('/gasto')->with("message","SE REGISTRO CORRECTAMENTE");

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/gasto')->with("message-error","ERROR INTENTE NUEVAMENTE.".$e);
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


      public  function gasto_imprimir($id_gasto) {

            $gasto=DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado
            from gasto g, caja c, users a, tipo_gasto tg , cliente cli
            where g.id_caja=c.id
            and g.id_usuario=a.id
            and tg.id=g.id_tipo_gasto
            and cli.id= g.id_empleado
            and g.id=".$id_gasto."
              and g.id_empresa=".Auth::user()->id_empresa." order by g.id asc");

              $empleado=DB::select("SELECT  cli.*
              from gasto g, caja c, users a, tipo_gasto tg , cliente cli
              where g.id_caja=c.id
              and g.id_usuario=a.id
              and tg.id=g.id_tipo_gasto
              and cli.id= g.id_empleado
              and g.id=".$id_gasto."
                and g.id_empresa=".Auth::user()->id_empresa." order by g.id asc");

            $listaGasto=DB::select("SELECT  g.*,c.caja,a.usuario, tg.nombre as tipo_gasto, concat(cli.nombre,' ', cli.paterno,' ',cli.materno) as empleado
            from gasto g, caja c, users a, tipo_gasto tg , cliente cli
            where g.id_caja=c.id
            and g.id_usuario=a.id
            and tg.id=g.id_tipo_gasto
            and cli.id= g.id_empleado
            and g.id_gasto_padre=".$id_gasto."
              and g.id_empresa=".Auth::user()->id_empresa." order by g.id asc");

        $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");

        $tipo_gasto="";

        foreach ($gasto as $key => $value) {
             $tipo_gasto= $value->tipo_gasto;
         }

         $pdf="";
         if($tipo_gasto=="SUELDO"){
          $pdf=\PDF::loadView('gasto.gasto_sueldo_imprimir',[
            'gasto'=>$gasto,
            'empleado'=>$empleado,
            'listaGasto'=>$listaGasto,
            'empresa'=>$empresa]);
         }else{
          $pdf=\PDF::loadView('gasto.gasto_imprimir',[
            'gasto'=>$gasto,
            'empleado'=>$empleado,
            'listaGasto'=>$listaGasto,
            'empresa'=>$empresa]);
         }

        return $pdf->stream();
    }



      //cancelar Gasto
function cancelar($id_gasto){
        $mensaje="No se realizo la cancelación"; 
        $ok=0;
      try{
            DB::beginTransaction(); 
            $caja=DB::select("SELECT c.estado from caja c, gasto g  where g.id_caja=c.id  and g.id=".$id_gasto); 
            $estado_caja="Abierta";
            foreach ($caja as $key => $value) {
              $estado_caja = $value->estado;
            }
            //Cancelar Gasto
              if($estado_caja=="Abierta"){
                DB::table("gasto")
                ->whereRaw('id='.$id_gasto) 
                ->update(['estado'=>'Cancelado',
              'id_usuario_cancelo'=>Auth::user()->id]);
                $mensaje="Cancelado el gasto Correctamente";
                $ok=1;
              }else{
                $mensaje="Caja Cerrada, No se puede cancelar porque la caja ya esta cerrada";
              }
              DB::commit(); 
             self::registrar_bitacora('cancelar_gasto',$id_gasto);
             
             if($ok==1){
              return redirect('/gasto')->with("message","SE CANCELO CORRECTAMENTE"); 
             }else{
              return redirect('/gasto')->with("message-error","ERROR,".$mensaje);
             }
             
          } catch (Exception $e) {
            DB::rollback(); 
            self::registrar_bitacora('cancelar_gasto',$e);
            return redirect('/gasto')->with("message-error","ERROR,".$mensaje);    
          }
       
      }
    public function registrar_bitacora($funcion,$mensaje){
    //registrar en BITACORA su inicio de sesion.
          try {
                            DB::beginTransaction();

                                        DB::table('bitacora')->insert([
                                        'nombre'=> $funcion,
                                        'mensaje'=> $funcion,
                                        'detalle'=>$mensaje,
                                        ]);

                                     DB::commit();
                            } catch (Exception $e) {

                            }
      }
            //FIN DE REGISTRO DE BITACORA  

}
