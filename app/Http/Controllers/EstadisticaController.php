<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;  
use App\Ajuste; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EstadisticaController extends Controller
{
   
  public function __construct() {
         $this->middleware('auth');
    }
    public function index()
    {
        return view('estadistica.index');
    }
    public function puntos_de_solicitud()
    {
         $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");  
        return View('estadistica.puntos_de_solicitud',['fechas'=>$fechas]);
    }
    public function anios_con_mas_solicitud()
    {
        $fechas = DB::select("SELECT year(fecha_pedido)as 'anio' from pedido group by anio");  
        return View('estadistica.anios_con_mas_solicitud',['fechas'=>$fechas]);
    }
    public function mes_con_mas_solicitud()
    {
        $fechas = DB::select("SELECT year(fecha_pedido)as 'anio' from pedido group by anio");  
        return View('estadistica.mes_con_mas_solicitud',['fechas'=>$fechas]);
    }
     public function dia_con_mas_solicitud()
    {
        return View('estadistica.dia_con_mas_solicitud' );
    }
    public function entre_fecha_con_mas_solicitud()
    {
        return View('estadistica.entre_fecha_con_mas_solicitud' );
    }



       function get_pedidos_estadistica_anio($anio){
        $pedido=DB::select("SELECT MONTH(pp.fecha_pedido)as 'mes',(select count(*) from pedido p,conductor c where p.estado=2 and p.id_conductor=c.ci and year(p.fecha_pedido)='".$anio."' and month(p.fecha_pedido)=mes )as 'cantidad_finalizado' ,(select count(*) from pedido p,conductor c where p.estado>2 and p.id_conductor=c.ci and year(p.fecha_pedido)='".$anio."' and month(p.fecha_pedido)=mes )as 'cantidad_cancelado',(select count(*) from pedido p where p.estado=0 and p.id_conductor is null and year(p.fecha_pedido)='".$anio."' and month(p.fecha_pedido)=mes )as 'cantidad_sin_aceptar',(select count(*) from pedido p,conductor c where p.estado<2 and p.id_conductor=c.ci  and year(p.fecha_pedido)='".$anio."' and month(p.fecha_pedido)=mes )as 'cantidad_sin_finalizar' from pedido pp where year(pp.fecha_pedido)='".$anio."' GROUP by mes order by mes asc");
        return response($pedido);              
    }

       function get_pedidos_estadistica_mes($anio,$mes){
        $pedido=DB::select("SELECT date(pp.fecha_pedido)as 'fecha',(select count(*) from pedido p,conductor c where p.estado=2 and p.id_conductor=c.ci and date(p.fecha_pedido)=date(fecha)  )as 'cantidad_finalizado' ,(select count(*) from pedido p,conductor c where p.estado>2 and p.id_conductor=c.ci and date(p.fecha_pedido)=date(fecha) )as 'cantidad_cancelado',(select count(*) from pedido p where p.estado=0 and p.id_conductor is null and date(p.fecha_pedido)=date(fecha) )as 'cantidad_sin_aceptar',(select count(*) from pedido p,conductor c where p.estado<2 and p.id_conductor=c.ci  and date(p.fecha_pedido)=date(fecha))as 'cantidad_sin_finalizar' from pedido pp where year(pp.fecha_pedido)='".$anio."' and month(pp.fecha_pedido)='".$mes."' GROUP by fecha order by fecha asc");
        return response($pedido);              
    }

     function get_pedidos_estadistica_dia($fecha){
        $pedido=DB::select("SELECT hour(pp.fecha_pedido)as 'fecha',(select count(*) from pedido p,conductor c where p.estado=2 and p.id_conductor=c.ci and date(p.fecha_pedido)=date('".$fecha."') and hour(p.fecha_pedido)=fecha)as 'cantidad_finalizado' ,(select count(*) from pedido p,conductor c where p.estado>2 and p.id_conductor=c.ci and date(p.fecha_pedido)=date('".$fecha."') and hour(p.fecha_pedido)=fecha)as 'cantidad_cancelado',(select count(*) from pedido p where p.estado=0 and p.id_conductor is null and date(p.fecha_pedido)=date('".$fecha."') and hour(p.fecha_pedido)=fecha )as 'cantidad_sin_aceptar',(select count(*) from pedido p,conductor c where p.estado<2 and p.id_conductor=c.ci  and date(p.fecha_pedido)=date('".$fecha."') and hour(p.fecha_pedido)=fecha )as 'cantidad_sin_finalizar' from pedido pp where date(pp.fecha_pedido)='".$fecha."'    GROUP by fecha order by fecha asc");
        return response($pedido);              
    }

      function get_pedidos_estadistica_entre_fecha($fecha_inicio,$fecha_fin){
        $pedido=DB::select("SELECT date(pp.fecha_pedido)as 'fecha',(select count(*) from pedido p,conductor c where p.estado=2 and p.id_conductor=c.ci and date(p.fecha_pedido)=date(fecha) )as 'cantidad_finalizado' ,(select count(*) from pedido p,conductor c where p.estado>2 and p.id_conductor=c.ci and date(p.fecha_pedido)=date(fecha) )as 'cantidad_cancelado',(select count(*) from pedido p where p.estado=0 and p.id_conductor is null and date(p.fecha_pedido)=date(fecha) )as 'cantidad_sin_aceptar',(select count(*) from pedido p,conductor c where p.estado<2 and p.id_conductor=c.ci  and date(p.fecha_pedido)=date(fecha))as 'cantidad_sin_finalizar' from pedido pp where date(pp.fecha_pedido)>='".$fecha_inicio."' and date(pp.fecha_pedido)<='".$fecha_fin."' GROUP by fecha order by fecha asc");
        return response($pedido);              
    }



}
