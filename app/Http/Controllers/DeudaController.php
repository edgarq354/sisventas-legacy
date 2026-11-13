<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
 
use App\Http\Requests\DeudaRequest;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeudaController extends Controller
{
     public function __construct() {
         $this->middleware('auth');
    }

    public  function index()
    {
    	if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            
            $deuda=DB::select("SELECT d.*, concat(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor',tp.nombre as 'tipo_deuda',a.nombre as 'usuario',c.numero_movil from users a,deuda d, conductor c, tipo_ingreso_egreso tp where a.id=d.id_login and d.id_conductor=c.ci and d.id_tipo_deuda=tp.id  limit 80 ");
           
            return view('deuda.index',['deuda'=>$deuda]);            
        } else {
            return view('errors.404');                        
        }

    }
     public  function index_conductor($id_conductor)
    {
      if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            
            $deuda=DB::select("SELECT d.*, concat(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor',tp.nombre as 'tipo_deuda',a.nombre as 'usuario',c.numero_movil from users a,deuda d, conductor c, tipo_ingreso_egreso tp where a.id=d.id_login and d.id_conductor=c.ci and d.id_tipo_deuda=tp.id  and c.ci='".$id_conductor."' limit 80 ");
           
            return view('deuda.index',['deuda'=>$deuda]);            
        } else {
            return view('errors.404');                        
        }

    }

    public function create( ){
    	  $tipo_ingreso_egreso=DB::select("SELECT * from tipo_ingreso_egreso where id_empresa='".Auth::user()->id_empresa."' ");

       $conductor=DB::select("(SELECT c.*,'1'as 'tipo_asignacion',v.codigo_empresa from conductor c, vehiculo v where c.id_vehiculo=v.placa) 
            union( SELECT cc.*,'0'as 'tipo_asignacion',''  from conductor cc where cc.id_vehiculo not in (SELECT placa from vehiculo))");
           
            return view('deuda.create',['buscar_tipo_ingreso_egreso'=>$tipo_ingreso_egreso,'buscar_conductor'=>$conductor]); 
    }

      public function store(DeudaRequest $request)
    {
    		$empleado=DB::select("SELECT e.ci as 'id_administrador' from empleado e,users a where  a.id_empleado=e.ci and  a.id='".Auth::user()->id."'");
    	   try {
            DB::beginTransaction();
            DB::table('deuda')->insert([
            	'id_conductor' => $request['id_conductor'], 
            	'id_tipo_deuda' =>$request['id_tipo_deuda'],
            	'monto'=>$request['monto'],
            	'monto_pagar'=>$request['monto'],
            	'monto_interes'=>0,
            	'descripcion'=> $request['descripcion'],
            	'id_empresa'=>Auth::user()->id_empresa,
            	'id_login'=>Auth::user()->id]
            ); 
              DB::commit();     
            Session::flash('message','SE REGISTRO CORRECTAMENTE');
            return Redirect::to('/deuda'); 
            
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/deuda')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   

    }

    public function edit($id)
    {
            $deuda=DB::select("SELECT d.*,concat(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor'  from deuda d,conductor c where c.ci=d.id_conductor and d.id='".$id."'");
             $tipo_ingreso_egreso=DB::select("SELECT * from tipo_ingreso_egreso where id_empresa='".Auth::user()->id_empresa."' ");
             $detalle_ingreso=DB::select("SELECT i.*,a.usuario from users a,ingreso i where a.id=i.id_login and i.opcion=1 and i.id_deuda='".$id."'");
            
         return View('deuda.edit',['deuda'=>$deuda,'tipo'=>$tipo_ingreso_egreso,'detalle_ingreso'=>$detalle_ingreso]);
    }
    //TODO: estaba sin $id
    public function show($id){
         $deuda=DB::select("SELECT d.*,concat(c.nombre,' ',c.paterno,' ',c.materno) as 'conductor'  from deuda d,conductor c where c.ci=d.id_conductor and d.id='".$id."'");
             $tipo_ingreso_egreso=DB::select("SELECT * from tipo_ingreso_egreso where id_empresa='".Auth::user()->id_empresa."' ");
             $detalle_ingreso=DB::select("SELECT i.*,a.usuario from users a,ingreso i where a.id=i.id_login and i.opcion=1 and i.id_deuda='".$id."'");
            
         return View('deuda.edit',['deuda'=>$deuda,'tipo'=>$tipo_ingreso_egreso,'detalle_ingreso'=>$detalle_ingreso]);
    }

      public function update(DeudaRequest $request)
    {
             
           try {
            DB::beginTransaction();
            DB::table('deuda')
            ->where('id',$request['id_deuda'])
            ->update([
                'id_tipo_deuda' =>$request['id_tipo_deuda'],
                'monto'=>$request['monto'],
                'monto_pagar'=>$request['monto_pagar'],
                'monto_interes'=>0,
                'descripcion'=> $request['descripcion'], 
                'estado'=> $request['estado'], 
                'id_login'=>Auth::user()->id]
            ); 
              DB::commit();     
            
             return redirect('/deuda')->with("message","SE REGISTRO CORRECTAMENTE");     
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/deuda')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   

    }

    public function pagar_deuda_conductor(Request $request)
    {

        try {
          DB::beginTransaction();
          $monto=$request->get('monto');
          $id_deuda=$request->get('id_deuda');
          $observacion=$request->get('observacion');
          $monto_total_aux=$monto; 
          $registro=0;

            if ($request['monto'] > $request['monto_aux'] ||  $monto<=0) {
                      DB::rollback();
                      return redirect('/deuda')->with("message-error","ERROR: LA CANTIDAD DE PAGO ESTA MAL, VERIFIQUE NUEVAMENTE");      
            } else {                
                $deuda=DB::select("SELECT id, monto_pagar,id_tipo_deuda,id_conductor from deuda where monto_pagar>0 and id='".$id_deuda."'");
                foreach ($deuda as $key => $value) {
                  $monto_pagar=$value->monto_pagar;
                  if($monto<=$monto_pagar)
                  {                    
                    $monto_aux=$monto_pagar-$monto; 
                    if($monto_aux==0){
                        $pedido_actualizar = DB::table('deuda')->where('id',$id_deuda)->update(['monto_pagar'=>$monto_aux,'estado'=>1]);
                    }else{
                       $pedido_actualizar = DB::table('deuda')->where('id',$id_deuda)->update(['monto_pagar'=>$monto_aux]);  
                    }
                    
                     
                     DB::table('ingreso')->insert([  
                    'id_conductor' => $value->id_conductor,
                    'observacion'=>$observacion,
                    'monto'=>$monto,
                    'saldo'=>$monto_aux,
                    'opcion'=>1,
                    'id_login'=>Auth::user()->id,
                    'id_tipo_ingreso_egreso'=>$value->id_tipo_deuda,
                    'id_deuda'=>$value->id,
                    'id_empresa'=>Auth::user()->id_empresa ]); 
                     $registro=1;
                  }
                }
              DB::commit();

                if($registro==1){
                     return redirect('/deuda')->with("message","SE REALIZO EL PAGO CORRECTAMENTE");  
                  
                }else{
                    DB::rollback();
                     return redirect('/deuda')->with("message-error","ERROR INTENTE NUEVAMENTE");  
                }
                
            }                    

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/deuda')->with("message-error","ERROR INTENTE NUEVAMENTE");      
     }
    }
 
}
