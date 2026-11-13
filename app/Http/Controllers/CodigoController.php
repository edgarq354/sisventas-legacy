<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;	
use App\Ajuste;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CodigoController extends Controller
{
	public function __construct() {
         $this->middleware('auth');
    }
    //
    public function index()
    {
    		$codigo=DB::table('codigo')->select('*')
      ->orderBy('id','desc')
      ->get();
       return view('codigo.index',["codigo"=>$codigo]);
    }
    public function edit($id)
    {
      $codigo = DB::select("SELECT * FROM codigo WHERE id='".$id."' ");
    	$codigo_usuario = DB::select("SELECT c.*,u.nombre,u.apellido,u.direccion_imagen,u.celular,p.fecha FROM codigo c, usuario u, usuario_codigo p WHERE  c.id=p.id_codigo and u.id=p.id_usuario and c.id='".$id."' ");
       return view('codigo.edit',['codigo'=>$codigo,'usuario_codigo'=>$codigo_usuario]);
    }
     public function update(Request $Request)
    {
    	 DB::table('codigo')->where('id', $Request['id'])
       ->update([
        'monto'=>$Request['monto'],
          'fecha_inicio'=>$Request['fecha_inicio'],
          'fecha_fin'=>$Request['fecha_fin'],
          'usuario'=>$Request['usuario'],
		     	'unico'=>$Request['unico']
		     	]);

            Session::flash('message','SE ACTUALIZO CORRECTAMENTE');
            return Redirect::to('/codigo');          
    }
    public function create()
    { 
    	$ajuste=DB::table('ajuste')->select('*')
      ->where('ajuste.id_empresa', Auth::user()->id_empresa)
      ->orderBy('anio','desc')
      ->paginate(3);
       return view('ajuste.create',["ajuste"=>$ajuste]);
    }
    public function devolucion_de_pago(Request $request)
    {
    	return "Devolucion de pago";
    }
     public function editar_pago($ci)
    {
    	 $conductor = DB::select("SELECT * FROM conductor where conductor.ci=".$ci);
       return view('ajuste.pago_de_conductor.edit',compact('conductor',$conductor));
    }
	public function ajuste_pago_conductor(Request $request)
    {
    	 if(Auth::user()->privilegio==1){
            $buscar_conductor=DB::select("SELECT * FROM conductor");
            $conductor=DB::table('conductor')->orderby('id_empresa')->get();            
    } else {
        $buscar_conductor=DB::select("SELECT c.*,v.codigo_empresa FROM conductor c,vehiculo v 
          where v.placa=c.ci and c.id_empresa=".Auth::user()->id_empresa);          
        $conductor=DB::table('conductor')->select('*')->where('conductor.id_empresa', 
          Auth::user()->id_empresa)->orderby('nombre')->get();
    }
    return view('ajuste.pago_de_conductor.index',["conductor"=>$conductor],compact('buscar_conductor',$buscar_conductor));
    	
    }

    public function Actualizar_Conductor_Pago(Request $request){
      if(Auth::user()->privilegio>=0){
    	try {
    	 DB::beginTransaction();
                DB::table('conductor')->where('ci', $request['ci'])->update([
                  'tipo_de_pago' => $request['tipo_de_pago'], 
                  'monto_frecuencia' => $request['monto_frecuencia'],
                  'fecha_inicio_pago'=> $request['fecha_inicio_pago'],
                  'fecha_fin_pago'=> $request['fecha_fin_pago']]);
           DB::commit();    
            Session::flash('message','ACTUALIZADO CORRECTAMENTE');
            return Redirect::to('/ajuste_pago_conductor');          
        } catch (Exception $e) {
          DB::rollback();
         return redirect('/editar_pago/'.$request['ci'])->with("message-error","ERROR INTENTE NUEVAMENTE");
        }  
        }
        else{
        	 return redirect('/editar_pago/'.$request['ci'])->with("message-error","ERROR INTENTE NUEVAMENTE");
        }            
    }

    public function store(Request $Request){
    	  try {
          $contador=0;
          $total=$Request['cantidad'];
        while($contador<$total)
        {
          DB::beginTransaction();
          DB::table('codigo')->insert([
          'monto'=>$Request['monto'],
          'fecha_inicio'=>$Request['fecha_inicio'],
          'fecha_fin'=>$Request['fecha_fin'],
          'usuario'=>$Request['usuario'],
          'unico'=>$Request['unico']
          ]);
           DB::commit();     
          $contador++;
        }
          



            Session::flash('message','CODIGO CREADO CORRECTAMENTE');
            return redirect::to('/codigo'); 
 		 
 		} catch (Exception $e) {
          DB::rollback();
          return redirect('/codigo')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }
   
    }
       public function show($id){
       return "En proceso";  
    }
}
