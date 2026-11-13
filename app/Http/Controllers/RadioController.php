<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RadioRequest;
use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class RadioController extends Controller
{
      public function __construct() {
         $this->middleware('auth');
    }

    function index() {          
        if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0|| Auth::user()->privilegio == 10|| Auth::user()->privilegio == 11) {
            $radio=DB::select("SELECT r.*,u.nombre FROM radio r,users u WHERE  u.id=r.id_login and r.id_empresa='".Auth::user()->id_empresa."'  ORDER BY r.fecha asc");
            return view('radio.index', compact('radio', $radio));            
        } else {
            return view('errors.404');                        
        }
    }
    function edit($id) {          
       
            $radio=DB::select("SELECT * FROM radio WHERE id_empresa='".Auth::user()->id_empresa."' and id='".$id."'");
            return view('radio.edit', compact('radio', $radio));            
    }
    public function create() {            
        return view('radio.create');
    }

    public function store(RadioRequest $request){

        try {
      DB::beginTransaction();
       
            DB::table('radio')->insert([
                'id' => $request['id'],   
                'descripcion' => $request['descripcion'],   
                'estado' => $request['estado'],   
                'marca' => $request['marca'],   
                'modelo' => $request['modelo'],   
                'id_empresa' => $request['id_empresa'],   
                'id_login' => $request['id_login']]  
            );           
            

              DB::commit();     
            Session::flash('message','SE REGISTRO CORRECTAMENTE');
            return Redirect::to('/radio'); 
            
      }catch (Exception $e) {
          DB::rollback();
          return redirect('/radio')->with("message-error","ERROR INTENTE NUEVAMENTE");      
      }   
    }
    public function show()
    { if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2 || Auth::user()->privilegio == 0) {
            $radio = DB::table('radio')->select('*')->paginate(40);
            $buscar_radio=DB::select("SELECT * FROM radio order by nombre asc");
            return view('radio.index', compact('radio', $radio,'buscar_radio',$buscar_radio));            
        } else {
            return view('errors.404');                        
        }
    }

    public function update( Request $request){
        
        DB::table('radio')->where('id', $request['id_radio_edit'])->update([
            'descripcion'=>$request['descripcion_edit'],
            'marca' => $request['marca_edit'],   
            'modelo' => $request['modelo_edit'],
            'estado'=>$request['estado_edit'],
             ]);

        Session::flash('message','ACTUALIZADO CORRECTAMENTE');
            return Redirect::to('/radio');  
    }

    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL CUNDUCTOR
    function verificar_id_radio($id){
        $radio=DB::select("SELECT count(*)as contador,c.* FROM radio c where c.id=".$id);
        return response($radio);
    }

      public function personal_baja(Request $request){ 
                try{
                DB::table('radio')->where('id', $request['id_personal'])->update(['estado' => '6','fecha_retiro'=>date('Y-m-j H-m-00')]);  
                DB::table('historial_radio')->insert(['descripcion' =>$request['descripcion'],'id_personal'=>$request['id_personal'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'0']);
                Session::flash('message','SE DIO DE BAJA');
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO REALIZAR LA BAJA EL VEHICULO');
                }
                return Redirect::to('/radio');  
   }

     public function personal_alta(Request $request){ 
            try{
                DB::table('radio')->where('id', $request['id_personal'])->update(['estado' => '1','fecha_retiro'=>date('Y-m-j H-m-00')]); 
               DB::table('historial_radio')->insert(['descripcion' =>$request['descripcion'],'id_personal'=>$request['id_personal'],'id_login'=>Auth::user()->id, 'fecha' => $request['fecha'],'tipo'=>'1']);
                Session::flash('message','SE DIO DE ALTA');
                }
                catch(Exception $e)
                {
                   Session::flash('message-error','NO SE PUEDO REALIZAR LA ALTA EL VEHICULO');
                }
                
             return Redirect::to('/radio');  
       }

    public function historial_radio($id_radio){
    $historial=DB::select("SELECT h.*,u.nombre as 'usuario' FROM historial_radio h, users u where  u.id=h.id_login and h.id_radio='".$id_radio."'");
   $radio=DB::select("SELECT r.*,u.nombre FROM radio r,users u WHERE  u.id=r.id_login and r.id='".$id_radio."' ");
    return View('radio.historial_radio',['historial'=>$historial,'radio'=>$radio]);
   }   

    function cargar_radio($id_radio){
        $apoderado=DB::select("SELECT * FROM radio WHERE id=".$id_radio);
        return response($apoderado);
    }  
}
