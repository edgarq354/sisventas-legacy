<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;	
use App\Ajuste;	
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
	public function __construct() {
         $this->middleware('auth');
    }
    //
    public function index()
    {
    	 
 
                $producto=DB::select("SELECT * FROM producto  where estado = 1 and peso<= peso_minimo and  id_lugar= ".Auth::user()->id_empresa. " limit 15"); 

                $ventas=DB::select("SELECT IFNULL(SUM(monto_total), 0) as monto_total from nota_venta where estado='Procesado' ");

                $ventas_mes=DB::select("SELECT IFNULL(SUM(monto_total), 0) as monto_total, 
                  MONTH(NOW())  AS mes
                  from nota_venta 
                  where month(fecha)= month(now()) and estado='Procesado' ");

                $caja=DB::select(" SELECT c.*,
                a.usuario,c.monto_abrir
                +(select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado='Procesado' and nv.id_caja=c.id)
                 - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where  nc.estado='Procesado' and nc.id_caja=c.id)
                 -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id) as 'monto_total' 
                      FROM caja c,users a 
                      where c.id_usuario=a.id 
                      AND c.estado='Abierta' 
                      and c.id_usuario=" . Auth::user()->id. " 
                       and c.id_empresa=" . Auth::user()->id_empresa . " 
                       order by c.id desc limit 1");  



            $monto_total=0; 
          $monto_total_mes=0; 
          $numero_mes=0;
          $monto_caja=0; 
            foreach ($ventas as $key => $ing) {
                $monto_total=$ing->monto_total;
            }
          foreach ($ventas_mes as $key => $ing) {
            $monto_total_mes=$ing->monto_total;
            $numero_mes=$ing->mes;
          }

          foreach ($caja as $key => $ing) {
            $monto_caja=$ing->monto_total;
          }

          $mes="";
          switch ($numero_mes) {
            case 1: $mes="ENERO"; break;
            case 2: $mes="FEBRERO"; break;
            case 3: $mes="MARZO"; break;
            case 4: $mes="ABRIL"; break;
            case 5: $mes="MAYO"; break;
            case 6: $mes="JUNIO"; break;
            case 7: $mes="JULIO"; break;
            case 8: $mes="AGOSTO"; break;
            case 9: $mes="SEPTIEMBRE"; break;
            case 10: $mes="OCTUBRE"; break;
            case 11: $mes="NOVIEMBRE"; break;
            case 12: $mes="DICIEMBRE"; break;
          }
        

          

        return view('inicio.index_normal',[
        'producto'=>$producto,
        'monto_total'=>$monto_total,
        'monto_total_mes'=>$monto_total_mes,
        'monto_caja'=>$monto_caja,
        'mes'=>$mes ]); 
  
    }
    
}
