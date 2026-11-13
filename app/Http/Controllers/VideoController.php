<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\Notificacion;
use Exception;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
     public function __construct() {
         $this->middleware('auth');
    }

    function index()
    {
            //ADMINISTRADOR DE TOD
          $video=DB::table('video')->where('id_empresa',Auth::user()->id_empresa)->orderby('id_empresa')->get();
        
       return view('video.index',["video"=>$video]);   
    }


        public function store(Request $request){
        	DB::beginTransaction(); 
        try {
        
                DB::table('video')->insert([
                  'nombre'=>$request['titulo'], 
                  'descripcion'=>$request['descripcion'],
                  'url'=>$request['url'],
                  'id_empresa'=>$request['id_empresa']
                  ]
                  );      
                DB::commit();
                return redirect('/video')->with("message","SE REGISTRO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/video')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      
    	}

    	public function update(Request $request){
    	DB::beginTransaction(); 
        try {
	         $pedido = DB::table('video')
	         ->where('id',$request['id_video_edit'])
	         ->update(['nombre'=>$request['titulo_edit'],'descripcion'=>$request['descripcion_edit'],'url'=>$request['url_edit'] ]);
                DB::commit();
                return redirect('/video')->with("message","SE ACTUALIZO CORRECTAMENTE");  

        } catch (Exception $e) {
          DB::rollback();
          return redirect('/video')->with("message-error","ERROR INTENTE NUEVAMENTE");      
        }      	
    		 
    	}

    function cargar_video($id_video){
        $apoderado=DB::select("SELECT * FROM video WHERE id=".$id_video);
        return response($apoderado);
    }         

}
