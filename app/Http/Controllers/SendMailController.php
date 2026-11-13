<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

use Illuminate\Support\Facades\Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\Http\Controllers\Controller;

class SendMailController extends Controller
{
   public function __construct() {
         $this->middleware('auth');
    }

	function index(){
  
       
       return view('sendmail.index');        
	}
  
  
	public function create(){
        return view('vehiculo.create');	
    }
 
    public function store(Request $request){
    $emails = array($request['email']);
    $input = ['telefono'=>'75602869','lugar'=>'santa cruz','url'=>'www.taxi-corp.com'];

Mail::send('sendmail.mensaje', $input, 
    function($message) use ($emails, $input) {
        $message
        ->from('soporte@taxi-corp.com', 'taxi-corp')
        ->subject('Fmi iPhone ');

        $message->to($emails);
});
        Session::flash('message','Mensaje enviado correctamente');
        return view('sendmail.index');
    }

   
    public function edit($placa){
       return view('vehiculo.edit',['duenio'=>$duenio],compact('vehiculo',$vehiculo));
    }

    public function update(VehiculoUpdateRequest $request){
return view('sendmail.index');        
     } 
}
