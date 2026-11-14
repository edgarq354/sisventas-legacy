<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;

use Auth;
use Session;
use Redirect;
use DB;

class AsistenciaController extends Controller {
    public function __construct() {
         $this->middleware('auth');
    }
  
    function index() {    
     if (Auth::user()->privilegio==0) {    
        $asistencia=DB::select("SELECT a.*, ad.nombre 
        from asistencia a, users ad 
        where ad.id_empresa=".Auth::user()->id_empresa."  
        and a.id_usuario=ad.id 
        order by a.id desc");
     
            return view('asistencia.index',['asistencia'=>$asistencia]);  
    }   
    else if (Auth::user()->privilegio>0) {    
        $asistencia=DB::select("SELECT a.*, ad.nombre from asistencia a, users ad where ad.id_empresa=".Auth::user()->id_empresa." and a.id_usuario=ad.id and ad.id=".Auth::user()->id." order by a.id desc");
     
            return view('asistencia.index',['asistencia'=>$asistencia]);  
    }else
    {
         return view('errors.404');        
    }                           
                         
    }

    function asistencia_historial($fechaInicio,$fechaFinal,$id_empleado) {  
      $sql="";
      if($id_empleado==0){
        $sql= "SELECT a.*, ad.nombre 
        from asistencia a, users ad 
        where a.id_empresa=".Auth::user()->id_empresa." 
        and a.id_usuario=ad.id  
        and date(a.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."')
        order by a.id desc";
      }else{
        $sql= "SELECT a.*, ad.nombre 
        from asistencia a, users ad 
        where a.id_empresa=".Auth::user()->id_empresa." 
        and a.id_usuario=ad.id 
        and a.id_usuario=".$id_empleado." 
        and date(a.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."')
        order by a.id desc";
      }
     // echo $sql;
      $asistencia=DB::select($sql); 
      $usuario=DB::select("SELECT * FROM users where id_empresa=".Auth::user()->id_empresa); 
      
             return view('asistencia.asistencia_historial',[
              'asistencia'=>$asistencia,
              'usuario'=>$usuario,
              'id_empleado'=>$id_empleado,
              'fechaInicio'=>$fechaInicio,
              'fechaFinal'=>$fechaFinal
            ]);                                          
     }
   
     function asistencia_historial_imprimir($fechaInicio,$fechaFinal,$id_empleado) {
      
      $sql="";
      if($id_empleado==0){
        $sql= "SELECT a.*, ad.nombre 
        from asistencia a, users ad 
        where a.id_empresa=".Auth::user()->id_empresa." 
        and a.id_usuario=ad.id  
        and date(a.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."')
        order by a.id desc";
      }else{
        $sql= "SELECT a.*, ad.nombre 
        from asistencia a, users ad 
        where a.id_empresa=".Auth::user()->id_empresa." 
        and a.id_usuario=ad.id 
        and a.id_usuario=".$id_empleado." 
        and date(a.fecha)  between date('".$fechaInicio."') and date('".$fechaFinal."')
        order by a.id asc";
      }
     // echo $sql;
      $asistencia=DB::select($sql); 
      $usuario=DB::select("SELECT * FROM users where id_empresa=".Auth::user()->id_empresa); 
      $empresa=DB::select("SELECT * FROM empresa where id=".Auth::user()->id_empresa); 
      //$pdf=\PDF::loadView(
        if($id_empleado==0){
          $pdf=\PDF::loadView('asistencia.asistencia_historial_imprimir',[
            'asistencia'=>$asistencia,
            'usuario'=>$usuario,
            'empresa'=>$empresa,
            'id_empleado'=>$id_empleado,
            'fechaInicio'=>$fechaInicio,
            'fechaFinal'=>$fechaFinal
          ]); 
        }else{
          $nombre_usuario="";
          foreach ($usuario as $key => $value) {
            if($value->id==$id_empleado)
           $nombre_usuario=$value->nombre;
          }
          $pdf=\PDF::loadView('asistencia.asistencia_historial_usuario_imprimir',[
            'asistencia'=>$asistencia,
            'usuario'=>$nombre_usuario,
            'empresa'=>$empresa,
            'id_empleado'=>$id_empleado,
            'fechaInicio'=>$fechaInicio,
            'fechaFinal'=>$fechaFinal
          ]); 
        }
        
       return   $pdf->stream();                                       
     }
   

    function asistencia_imprimir() {       
      if (Auth::user()->privilegio>=0) {    
          $asistencia=DB::table('asistencia')->select('*')
          ->where('asistencia.id_usuario', Auth::user()->id)
          ->where('asistencia.id_empresa', Auth::user()->id_empresa)
          ->orderby('id','desc')->get();
          $empresa=DB::select("SELECT * from empresa  where id='".Auth::user()->id_empresa."'");
            

               
        $pdf=\PDF::loadView('asistencia.asistencia_imprimir', 
        ['asistencia'=>$asistencia,
        'empresa'=>$empresa
        ]);
        return $pdf->stream();
      }else
      {
           return view('errors.404');        
      }                      
      }


    public function create() {
        return view('asistencia.create');
    }


    public function reporte_asistencia_pdf($id_asistencia){ 
    $usuario=DB::select("SELECT a.*,ad.nombre as 'usuario',a.observaciones,e.razon_social , a.fecha_ingreso as 'fecha_inicio',a.fecha_salida as 'fecha_fin'  
    from asistencia a,users ad,empresa e 
    where e.id=ad.id_empresa 
    and a.id_empresa=".Auth::user()->id_empresa." 
    and ad.id=a.id_usuario and a.id=".$id_asistencia); 

     $fecha_inicio="";
     $fecha_fin="";
     $id_usuario=""; 
      foreach ($usuario as $key => $value) {
        $fecha_inicio=$value->fecha_inicio;
        $fecha_fin=$value->fecha_fin;
        $id_usuario=$value->id_usuario;
      }

    $egreso=DB::select("SELECT e.*, t.nombre as 'tipo_egreso',c.nombre as 'cliente' from egreso e, tipo_ingreso_egreso t,cliente c where e.id_cliente=c.id and e.id_empleado is null and e.id_tipo_ingreso_egreso=t.id and e.id_login='".$id_usuario."' and e.fecha >= '".$fecha_inicio."' and e.fecha<= '".$fecha_fin."'"); 

    $egreso_sueldo=DB::select("SELECT e.*, t.nombre as 'tipo_egreso',concat(c.nombre,' ',c.paterno,' ',c.materno) as 'usuario' from egreso e, tipo_ingreso_egreso t,empleado c where e.id_empleado=c.ci and e.id_cliente is null and e.id_tipo_ingreso_egreso=t.id and e.id_login='".$id_usuario."' and e.fecha >= '".$fecha_inicio."' and e.fecha<= '".$fecha_fin."'"); 
    
     $ingreso=DB::select("SELECT i.*, t.nombre as 'tipo_ingreso',c.nombre as 'cliente' from ingreso i, tipo_ingreso_egreso t,cliente c 
        where i.id_cliente=c.id  and i.id_tipo_ingreso_egreso=t.id and i.id_login='".$id_usuario."' and i.fecha >= '".$fecha_inicio."' 
        and i.fecha<= '".$fecha_fin."'"); 
  
    $pdf=\PDF::loadView('asistencia.reporte_por_asistencia_pdf',['usuario'=>$usuario,'ingreso'=>$ingreso,'egreso'=>$egreso,'egreso_sueldo'=>$egreso_sueldo]);
    return   $pdf->stream();
    } 



    public function registro($tipo,Request $request)
    {

  $verificar=DB::select("SELECT id from asistencia WHERE id_usuario='".Auth::user()->id."' and fecha_salida is NULL order by id desc  limit 1");
   $id_asistencia="";
        foreach ($verificar as $usuario => $cond) {
            $id_asistencia=$cond->id;
            }

       try {

        if($tipo==0){
       
            if($id_asistencia==""){
            DB::beginTransaction();
             DB::table('asistencia')->insert([
                    'id_usuario'=>Auth::user()->id,
                    'fecha_ingreso'=> date("Y-m-d H:i:s") ,
                    'fecha'=> date("Y-m-d"),
                    'id_empresa'=>Auth::user()->id_empresa,
                    ]);
              
                 DB::commit(); 
                  Session::flash('message', __('asistencia.registrado_correctamente'));    
                }
                else
                {
                  Session::flash('message-error', __('asistencia.ya_tiene_ingreso'));  
                }


                
             }
             else if($tipo==1)
             {
                if($id_asistencia!=""){
                  DB::beginTransaction();
                  DB::table('asistencia')
                  ->where('id_usuario', Auth::user()->id)
                  ->where('id',$id_asistencia)
                  ->update(['fecha_salida' => date("Y-m-d H:i:s") ]);
                  DB::commit(); 
                Session::flash('message', __('asistencia.registrado_correctamente'));
                 }
                 else
                 {
                    Session::flash('message-error', __('asistencia.no_tiene_ingreso'));  
                 }
             }
            
            return redirect::to('/asistencia'); 
        } catch (Exception $e) {
          DB::rollback();
          return redirect('/asistencia')->with("message-error","NO PUDIMOS REGISTRAR SU INGRESO");      
        }
   
    }


      public function finalizar(Request $request)
    {

  $verificar=DB::select("SELECT id from asistencia WHERE id_usuario='".Auth::user()->id."' and fecha_salida is NULL order by id desc  limit 1");
   $id_asistencia="";
        foreach ($verificar as $usuario => $cond) {
            $id_asistencia=$cond->id;
            }

       try {

  
                if($id_asistencia!=""){
                  DB::beginTransaction();
                  DB::table('asistencia')->where('id_usuario', Auth::user()->id)->where('id',$id_asistencia)->update(['observaciones'=>$request['observacion'],'fecha_salida' => date("Y-m-d H:i:s") ]);
                  DB::commit(); 
                Session::flash('message', __('asistencia.registrado_correctamente'));





$usuario=DB::select("SELECT a.*,ad.nombre as 'usuario',a.observaciones,e.razon_social , a.fecha_ingreso as 'fecha_inicio',a.fecha_salida as 'fecha_fin'  from asistencia a,users ad,empresa e where e.id=ad.id_empresa and ad.id=a.id_usuario and a.id=".$id_asistencia); 
     $fecha_inicio="";
     $fecha_fin="";
     $id_usuario=""; 
      foreach ($usuario as $key => $value) {
        $fecha_inicio=$value->fecha_inicio;
        $fecha_fin=$value->fecha_fin;
        $id_usuario=$value->id_usuario;
      }

 


    $egreso=DB::select("SELECT e.*, t.nombre as 'tipo_egreso',c.nombre as 'cliente' from egreso e, tipo_ingreso_egreso t,cliente c 
        where e.id_cliente=c.id and e.id_empleado is null and e.id_tipo_ingreso_egreso=t.id and e.id_login='".$id_usuario."' and e.fecha >= '".$fecha_inicio."' and e.fecha<= '".$fecha_fin."'"); 

 
    
     $ingreso=DB::select("SELECT i.*, t.nombre as 'tipo_ingreso',c.nombre as 'cliente' from ingreso i, tipo_ingreso_egreso t,cliente c 
        where i.id_cliente=c.id  and i.id_tipo_ingreso_egreso=t.id and i.id_login='".$id_usuario."' and i.fecha >= '".$fecha_inicio."' and i.fecha<= '".$fecha_fin."'"); 
 
    $pdf=\PDF::loadView('asistencia.reporte_por_asistencia_pdf',['usuario'=>$usuario ,'ingreso'=>$ingreso,'egreso'=>$egreso]);

    Auth::logout();
    return $pdf->stream();




                 }
                 else
                 {
                    Session::flash('message-error', __('asistencia.no_tiene_ingreso'));  
                 }
            
            
            return redirect::to('/asistencia'); 
        } catch (Exception $e) {
          DB::rollback();
          return redirect('/asistencia')->with("message-error","NO PUDIMOS REGISTRAR SU INGRESO");      
        }
   
    }

    public function store(LoginRequest $request) {
        
      
      
    }

    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
