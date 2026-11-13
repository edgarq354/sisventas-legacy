<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotificacionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;


class ChatController extends Controller
{
    
    public function __construct() {
         $this->middleware('auth');
    }

    function index(){
        if(Auth::user()->privilegio == 0){
            
            return view('chat.index');
        } else {
            return view('errors.404');                                                
        }
    }
  
    function edit($id_usuario)
    {
      
       return view('chat.index' );
    }
   

    
}
