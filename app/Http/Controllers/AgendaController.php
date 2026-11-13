<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgendaEvento;
use App\Http\Requests;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AgendaController extends Controller
{

	public function index(){
		 $agenda = AgendaEvento::all();
         $buscar_empleado= DB::select("SELECT ci,nombre,paterno,materno FROM empleado WHERE id_empresa='".Auth::user()->id_empresa."'");
         $buscar_conductor= DB::select("SELECT ci,nombre,paterno,materno FROM conductor WHERE id_empresa='".Auth::user()->id_empresa."'");
        
		return view('agenda.index',compact('agenda'),['buscar_empleado'=>$buscar_empleado,'buscar_conductor'=>$buscar_conductor]);
	}
    public function ver()
    {
        $data = array(); //declaramos un array principal que va contener los datos
        
        $id = AgendaEvento::all()->lists('id'); //listamos todos los id de los eventos
        $titulo = AgendaEvento::all()->lists('titulo'); //lo mismo para lugar y fecha
        $fechaIni = AgendaEvento::all()->lists('fechaIni');
        $fechaFin = AgendaEvento::all()->lists('fechaFin');
        $allDay = AgendaEvento::all()->lists('todoeldia');
        $background = AgendaEvento::all()->lists('color');
        $borde = AgendaEvento::all()->lists('borde');
        $borde = AgendaEvento::all()->lists('id_empleado');
        $borde = AgendaEvento::all()->lists('id_conductor');
        $count = count($id); //contamos los ids obtenidos para saber el numero exacto de eventos
 		
 		$agenda= DB::select("SELECT * FROM agenda WHERE id_empresa='".Auth::user()->id_empresa."'");
 			
 			$i=0;
            foreach ($agenda as $key => $value) {
            	$data[$i] = array(
            	"title"=>$value->titulo, //obligatoriamente "title", "start" y "url" son campos requeridos
                "start"=>$value->fechaIni, //por el plugin asi que asignamos a cada uno el valor correspondiente
                "end"=>$value->fechaFin,
                "allDay"=>$value->todoeldia,
                "backgroundColor"=>$value->color,
                "borderColor"=>'',
                "id"=>$value->id,
                "id_empleado"=>$value->id_empleado,
                "id_conductor"=>$value->id_conductor,
                "tipo_agenda"=>$value->tipo_agenda
            		);
            	$i++;
            }
        
 
        json_encode($data); //convertimos el array principal $data a un objeto Json 
       return $data; //para luego retornarlo y estar listo para consumirlo
    }

    public function guardar(Request $request){
        //Valores recibidos via ajax
        $title = $request['titulo'];
        $start = $request['fecha_inicio'];
        $end = $request['fecha_fin'];
        $back = '#218CCE';
        $tipo_agenda = $request['tipo_agenda'];

       
        DB::commit();      


          try {
          DB::beginTransaction(); 
            if($tipo_agenda==0){
            DB::table('agenda')->insert([ 'titulo' => $title, 'fechaIni' => $start,'fechaFin'=>$end,'todoeldia'=>'1','color'=>$back,'id_empresa'=>Auth::user()->id_empresa ]); 
            }else if($tipo_agenda==2){
                 $back = '#C9A220';
                $id_empleado = $request['id_empleado'];
                  //REGISTRA AGENDA DEL CONDUCTOR.
              DB::table('agenda')->insert([ 'titulo' => $title, 'fechaIni' => $start,'fechaFin'=>$end,'todoeldia'=>'1','color'=>$back,'id_empleado'=>$id_empleado,'tipo_agenda'=>$tipo_agenda,'id_empresa'=>Auth::user()->id_empresa ]); 
            }else if($tipo_agenda==1){
                $back = '#D25A32';
                $id_conductor = $request['id_conductor'];
                //REGISTRA AGENDA DEL EMPLEADO
                DB::table('agenda')->insert([ 'titulo' => $title, 'fechaIni' => $start,'fechaFin'=>$end,'todoeldia'=>'1','color'=>$back,'id_conductor'=>$id_conductor,'tipo_agenda'=>$tipo_agenda,'id_empresa'=>Auth::user()->id_empresa ]);
            }
       
            DB::commit();

        } catch (Exception $e) {
          DB::rollback();
        }
   }

    

   public function update(){
        //Valores recibidos via ajax
        $id = $_POST['id'];
        $title = $_POST['title'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $allDay = $_POST['allday'];
        $back = $_POST['background'];

        $evento=AgendaEvento::find($id);
        if($end=='NULL'){
            $evento->fechaFin=NULL;
        }else{
            $evento->fechaFin=$end;
        }
        $evento->fechaIni=$start;
        $evento->todoeldia=$allDay;
        $evento->color=$back;
        $evento->titulo=$title;
        //$evento->fechaFin=$end;

        $evento->save();
   }

   public function delete(){
        //Valor id recibidos via ajax
        $id = $_POST['id'];

        AgendaEvento::destroy($id);
   }
}
