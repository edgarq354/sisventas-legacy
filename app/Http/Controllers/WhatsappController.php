<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use Illuminate\Support\Facades\DB;

   
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductoRequest;


class WhatsappController extends Controller
{

     public function __construct() {
         $this->middleware('auth');
    }
 

    function servicio_whatsapp_lugar($id_lugar)
    {
  
          $producto=DB::select("SELECT 
            mensaje_whatsapp.*,
            usuario.nombre,
            usuario.apellido,
            usuario.celular,
            usuario.direccion_imagen 
            FROM `mensaje_whatsapp` 
            inner join usuario on(mensaje_whatsapp.id_usuario=usuario.id) 
            where mensaje_whatsapp.id_empresa=".$id_lugar);
  

       return view('servicio_whatsapp.index',[
        'whatsapp'=>$producto,
        'id_empresa'=>$id_lugar
      ]);   

    }




 
}
