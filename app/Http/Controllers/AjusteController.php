<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
 
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 


class AjusteController extends Controller
{
	public function __construct() {
          $this->middleware('auth');
    }
    //
    public function index()
    {

      if(Auth::user()->privilegio==3){
          
                $producto=DB::select("SELECT * FROM producto  where estado = 1 and peso<= peso_minimo and  id_lugar= ".Auth::user()->id_empresa. " limit 15 "); 

                $ventas=DB::select("SELECT IFNULL(SUM(monto_total), 0) as monto_total from nota_venta where estado='Procesado' and id_empresa=".Auth::user()->id_empresa );

                $ventas_mes=DB::select("SELECT IFNULL(SUM(monto_total), 0) as monto_total, 
                  MONTH(NOW())  AS mes
                  from nota_venta 
                  where month(fecha)= month(now()) and year(fecha)= year(now()) and estado='Procesado' and id_empresa=".Auth::user()->id_empresa );

                $caja=DB::select(" SELECT c.*,
                a.usuario,
                c.monto_abrir+c.monto_abrir_qr+
      (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Procesado','Qr','QrFie' ) and nv.id_caja=c.id) 
      + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id  and dc.estado in('Procesado'))
      - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
       - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where nc.estado='Procesado' and nc.id_caja=c.id)
       -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado')) as 'monto_total' 
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

          $mes = nombre_mes((int) $numero_mes);

        return view('inicio.index_normal',[
        'producto'=>$producto,
        'monto_total'=>$monto_total,
        'monto_total_mes'=>$monto_total_mes,
        'monto_caja'=>$monto_caja,
        'mes'=>$mes ]); 
      }else{ 
                $producto=DB::select("SELECT * FROM producto  where estado = 1 and peso<= peso_minimo and  id_lugar= ".Auth::user()->id_empresa. " limit 15"); 

				$producto_compra=DB::select("SELECT p.*,(select sum(dcc.peso) from detalle_compra dcc, nota_compra ncc 
				where dcc.id_producto=p.id 
				and dcc.id_nota_compra=ncc.id
				and ncc.id_empresa=".Auth::user()->id_empresa." 
				and date(ncc.fecha)= date(now()))  as peso_dia,

				(select sum(dcc.peso) from detalle_compra dcc, nota_compra ncc 
				where dcc.id_producto=p.id 
				and dcc.id_nota_compra=ncc.id
				and ncc.id_empresa=".Auth::user()->id_empresa." 
				and month(date(ncc.fecha))= month(now())
				and year(date(ncc.fecha))=year(now())) as peso_mes

				from producto p, detalle_compra dc, nota_compra nc, tipo_producto tp 
				where p.id_tipo_producto=tp.id 
				and dc.id_producto=p.id 
				and nc.id=dc.id_nota_compra 
				and month(date(nc.fecha))= month(date(now())) 
				and year(date(nc.fecha))=year(now()) 
				and nc.id_empresa=".Auth::user()->id_empresa. " group by p.id");

                $ventas=DB::select("SELECT IFNULL(SUM(monto_total), 0) as monto_total from nota_venta where estado='Procesado' and id_empresa= ".Auth::user()->id_empresa);

                $ventas_mes=DB::select("SELECT IFNULL(SUM(monto_total), 0) as monto_total, 
                  MONTH(NOW())  AS mes
                  from nota_venta 
                  where month(fecha)= month(now()) and year(fecha)= year(now()) and estado='Procesado' and id_empresa=".Auth::user()->id_empresa );

                $caja=DB::select(" SELECT c.*,
      a.usuario,
      c.monto_abrir+c.monto_abrir_qr+
      (select IFNULL(sum(nv.monto_total),0) from nota_venta nv  where nv.estado in ('Procesado','Qr','QrFie' ) and nv.id_caja=c.id) 
      + (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por cobrar' and dc.id_caja=c.id)
      + (select IFNULL(sum(dc.monto),0) from ingreso dc  where  dc.id_caja=c.id  and dc.estado in('Procesado'))
      - (select IFNULL(sum(dc.monto),0) from detalle_cobranza dc  where dc.forma_pago in ('Procesado','Qr' )  and dc.estado_cobranza='Por pagar' and dc.id_caja=c.id)
       - (select IFNULL(sum(nc.monto_total),0) from nota_compra nc  where nc.estado='Procesado' and nc.id_caja=c.id)
       -(select IFNULL(sum(g.precio_gasto),0) from gasto g where g.id_caja=c.id and g.estado in ('Procesado')) as 'monto_total' 
            FROM caja c,users a 
            where c.id_usuario=a.id 

            and c.id_usuario=" . Auth::user()->id. " 
             and c.id_empresa=" . Auth::user()->id_empresa . " 
             order by c.id desc limit 1" );  

                

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

          $mes = nombre_mes((int) $numero_mes);

        return view('ajuste.index',[
        'producto'=>$producto,
        'monto_total'=>$monto_total,
        'monto_total_mes'=>$monto_total_mes,
        'monto_caja'=>$monto_caja,
		'producto_compra'=>$producto_compra,
        'mes'=>$mes ]); 
     }

    }
    public function edit($anio)
    {
    	$ajuste = DB::select("SELECT * FROM ajuste WHERE ajuste.anio='".$anio."' and id_empresa='".Auth::user()->id_empresa."'");
       return view('ajuste.edit',compact('ajuste',$ajuste));
    }
     public function update(Request $Request)
    {
    	 DB::table('ajuste')->where('anio', $Request['anio'])->where('id_empresa',Auth::user()->id_empresa)->update([
		     	'frecuencia_dia'=>$Request['frecuencia_dia'],
		     	'frecuencia_semana'=>$Request['frecuencia_semana'],
		     	'frecuencia_mes'=>$Request['frecuencia_mes'],
		     	'retraso_dia'=>$Request['retraso_dia'],
          'pro_navidad'=>$Request['pro_navidad'],
		     	'tiempo_visualizacion_conductor'=>$Request['tiempo_visualizacion_conductor'],
		     	'pro_accidente'=>$Request['pro_accidente'],
		     	'ahorro'=>$Request['ahorro'],
		     	'id_empresa'=>$Request['id_empresa'],
		     	'dia_cobro'=>$Request['dia_cobro'],
		     	'cantidad_tolerancia_cobro'=>$Request['cantidad_tolerancia_cobro'],
		     	'numero_inicio_recibo'=>$Request['inicio_recibo'],
		     	'numero_fin_recibo'=>$Request['fin_recibo'],
		     	'numero_inicio_factura'=>$Request['inicio_factura'],
		     	'numero_fin_factura'=>$Request['fin_factura']
		     	]);

    	  DB::table('frecuencia')->where('tipo',"DIA")->where('id_empresa', $Request['id_empresa'])->where( DB::raw('YEAR(fecha_inicio)'),$Request['anio'])->update([
		     	'monto'=>$Request['frecuencia_dia'],
		     	]);
    	  DB::table('frecuencia')->where('tipo',"SEMANA")->where('id_empresa', $Request['id_empresa'])->where( DB::raw('YEAR(fecha_inicio)'),$Request['anio'])->update([
		     	'monto'=>$Request['frecuencia_semana'],
		     	]);
    	  DB::table('frecuencia')->where('tipo',"MES")->where('id_empresa', $Request['id_empresa'])->where( DB::raw('YEAR(fecha_inicio)'),$Request['anio'])->update([
		     	'monto'=>$Request['frecuencia_mes'],
		     	]);
    	  


            Session::flash('message', __('ajuste.actualizado_recibo', ['inicio' => $Request['inicio_recibo'], 'fin' => $Request['fin_recibo']]));
            return Redirect::to('/ajuste');          
    }
    public function create()
    { 
    	$ajuste=DB::table('ajuste')->select('*')->where('ajuste.id_empresa', Auth::user()->id_empresa)
      ->orderBy('anio','desc')
      ->paginate(3);
       return view('ajuste.create',["ajuste"=>$ajuste]);
    }

    public function store(Request $Request){
    	  try {
      DB::beginTransaction();
    	 $verificar=DB::select("SELECT COUNT(anio)as contador from ajuste WHERE ajuste.anio=".$Request['anio']);
        foreach ($verificar as $key => $value) {
          $contador=$value->contador;
        }
    	if($contador==0){
    		  DB::table('ajuste')->insert([
		     	'frecuencia_dia'=>$Request['frecuencia_dia'],
		     	'frecuencia_semana'=>$Request['frecuencia_semana'],
		     	'frecuencia_mes'=>$Request['frecuencia_mes'],
		     	'retraso_dia'=>$Request['retraso_dia'],
		     	'pro_navidad'=>$Request['pro_navidad'],
		     	'pro_accidente'=>$Request['pro_accidente'],
		     	'ahorro'=>$Request['ahorro'],
		     	'id_empresa'=>$Request['id_empresa'],
		     	'anio'=>$Request['anio'],
		     	'dia_cobro'=>$Request['dia_cobro'],
		     	'cantidad_tolerancia_cobro'=>$Request['cantidad_tolerancia_cobro'],
		     	'numero_inicio_recibo'=>$Request['inicio_recibo'],
		     	'numero_fin_recibo'=>$Request['fin_recibo'],
		     	'numero_inicio_factura'=>$Request['inicio_factura'],
		     	'numero_fin_factura'=>$Request['fin_factura'],
		     	]);
     			 

     			 //REGISTRAR FRECUENCIA DE DIA AL AÑO
    		  $numero=1;
					$fecha = $Request['anio'].'-01-01';
					$anio_inicio=date('Y',strtotime($fecha));
					$anio_fin=$anio_inicio+1;
						while($anio_inicio<$anio_fin)
						{
						//	echo "fecha:".$fecha."    dia:".$numero."<br>";
							  DB::table('frecuencia')->insert([
						     	'id_empresa'=>$Request['id_empresa'],
						     	'fecha_inicio'=>$fecha,
						     	'fecha_fin'=>$fecha,
						     	'numero'=>$numero,
						     	'monto'=>$Request['frecuencia_dia'],
						     	'tipo'=>'DIA',
						     	]);
     		

						$fecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
						$fecha = date ( 'Y-m-j' ,$fecha);
						$anio_inicio=date('Y',strtotime($fecha));
						$numero+=1;
						}

     			   		  	 //REGISTRAR FRECUENCIA POR SEMANA AL AÑO
					$fecha = $Request['anio'].'-01-01';
					$anio_inicio=date('Y',strtotime($fecha));
					$anio_fin=$anio_inicio+1;
			        
			        $dia=date("j",strtotime ( $fecha ));
					$mes=date("m",strtotime ( $fecha ));
					$anio=date("Y",strtotime ( $fecha ));
				    $numero_semana=date("W",mktime(0,0,0,$mes,$dia,$anio));
				    
					    if($numero_semana==52)
					    {
					     $fecha = strtotime ( '+1 week' , strtotime ( $fecha ) ) ;  
					     $fecha=date ( 'Y-m-j' ,$fecha);
					    }
					    
				    
						while($anio_inicio<$anio_fin)
						{       
					        $dia=date("j",strtotime ( $fecha ));
							$mes=date("m",strtotime ( $fecha ));
							$anio=date("Y",strtotime ( $fecha ));
					        $numero_semana=date("W",mktime(0,0,0,$mes,$dia,$anio));
					        $numero_dia=date("w", mktime(0, 0, 0,6, 3, 2017));
					        
					        $primer=0;
					        $ultimo=0;
					        if($numero_dia>0)
					        {
					          $primer=$numero_dia-1;   
					          $ultimo=7-$numero_dia;   
					        }
					        else
					        {
					            $primer=7;
					            $ultimo=0;
					        }
					        
					        $fecha_inicio=strtotime ( '-'.$primer.' day' , strtotime ( $fecha ) ) ;
					        $fecha_fin=strtotime ( '+'.$ultimo.' day' , strtotime ( $fecha ) ) ;
					        $fecha_inicio=date ( 'Y-m-j' ,$fecha_inicio);
					        $fecha_fin=date ( 'Y-m-j' ,$fecha_fin);
							// echo "semana inicio=".$fecha_inicio."   semana fin=".$fecha_fin." Numero de semana=".$numero_semana."<br>";
						
							  DB::table('frecuencia')->insert([
						     	'id_empresa'=>$Request['id_empresa'],
						     	'fecha_inicio'=>$fecha_inicio,
						     	'fecha_fin'=>$fecha_fin,
						     	'numero'=>$numero_semana,
						     	'monto'=>$Request['frecuencia_semana'],
						     	'tipo'=>'SEMANA',
						     	]);

						$fecha = strtotime ( '+1 week' , strtotime ( $fecha ) ) ;
						$fecha = date ( 'Y-m-j' ,$fecha);
						$anio_inicio=date('Y',strtotime($fecha));
						}

/*

    		     //REGISTRAR FRECUENCIA POR MES AL AÑO
					$fecha = $Request['anio'].'-01-01';
					$anio_inicio=date('Y',strtotime($fecha));
					$anio_fin=$anio_inicio+1;
						while($anio_inicio<$anio_fin)
					    {
							$fecha_fin=strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
					        $fecha_fin=date ( 'Y-m-j' ,$fecha_fin);
					        $dia_antes=strtotime ( '-1 day' , strtotime ( $fecha_fin ) ) ;
					        $fecha_fin=date ( 'Y-m-j' ,$dia_antes);
					        $numero=date('m',strtotime($fecha));
						//	echo "INICIO DE MES=".$fecha." FIN=".date ( 'Y-m-j' ,$dia_antes)." numero=".$numero."<br>";

							 DB::table('frecuencia')->insert([
						     	'id_empresa'=>$Request['id_empresa'],
						     	'fecha_inicio'=>$fecha,
						     	'fecha_fin'=>$fecha_fin,
						     	'numero'=>$numero,
						     	'monto'=>$Request['frecuencia_mes'],
						     	'tipo'=>'MES',
						     	]);
						$fecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
						$fecha = date ( 'Y-m-j' ,$fecha);
						$anio_inicio=date('Y',strtotime($fecha));
						}

    */		  	 


     			 DB::commit();     
            Session::flash('message', __('ajuste.ajuste_registrado'));
            return redirect::to('/ajuste');
 		}
 		else
 		{
            Session::flash('message-error', __('ajuste.ya_tiene_ajuste_anio'));
            return redirect::to('/ajuste');
 		}
 		} catch (Exception $e) {
          DB::rollback();
          return redirect('/ajuste')->with("message-error", __('ajuste.error_intente_nuevamente'));
        }
   
    }
       public function show($id){
       return "En proceso";  
    }
}