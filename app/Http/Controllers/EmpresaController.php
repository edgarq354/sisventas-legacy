<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Telefono;
use App\Http\Requests;
use App\Http\Requests\EmpresasRequest;
use App\Http\Requests\EmpresasClienteRequest;
use App\Http\Requests\CambiarPasswordRequest;
use App\Notificacion;
use Illuminate\Support\Facades\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;




class EmpresaController extends Controller {

    public function __construct() {
         $this->middleware('auth');
    }



    public function subir_logo_empresa(Request $request)
    {
        $archivo = $request->file('archivo');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
          //  $imagen = $request['archivo'];

                      //  $this->eliminar_fotocopias_de_empresa(Auth::user()->id_empresa);

                      //  $this->crear_archivos($imagen, $direccion_fotocopias_corporativa);

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_Corporativa-".$request['nit1'].".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="../storage/Imagen_Empresa/".$nuevo_nombre;


                        $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'IMAGEN CORPORATIVA', 'numero' => $request['nit1'] ]); //GUARDO FOTOCOPIA

                        DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia, 'direccion' => $rutadelaimagen ]); //GUARDO FOTO
                        DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_imagen_corporativa'=>$id_fotocopia]);






                                return view("mensajes.msj_correcto")->with("msj","Imagen agregada correctamente");


        }
    }

        public function historial_pedidos_empresa_2(Request $Request )
    {

        $fecha_inicio=$Request['fecha_inicio'];
        $fecha_fin=$Request['fecha_fin'];
        $id_empresa=$Request['id_empresa'];
        $estado=$Request['estado_opcion'];
        if($estado==1){
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";
        }else if($estado==2){
            //BUSCAR TODOS LOS PEDIDOS COMPLETADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==3){
            //BUSCAR TODOS LOS PEDIDOS CANCELADOS

            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado>=5 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==4){
            //BUSCAR TODOS LOS PEDIDOS CON DEUDA  INCLUIDO LOS CANCELADOS.
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado_pago_empresa=0 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==5){
            //BUSCAR TODOS TODOS LOS PEDIDOS CON DEUDA PERO SIN LOS CANCELADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE  pedido.estado_pago_empresa=0 and pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }else if($estado==6){
            //BUSCA TODOS LOS PEDIDOS PAGADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado_pago_empresa=1 and  pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id desc";

        }


    $pedidos = DB::select($consulta);

      $administrador=DB::select("SELECT u.*,e.razon_social,e.id from usuario u, empresa e where e.id_administrador=u.id and e.id='".$id_empresa."'");
     $fechas = DB::select("SELECT date('".$fecha_inicio."') as fecha_inicio, date('".$fecha_fin."') as fecha_fin");
      //


        return view('empresa.cliente.historial_pedidos_empresa',["fechas"=>$fechas,'pedidos'=>$pedidos,'administrador'=>$administrador,'estado'=>$estado,'otra'=>1]);
    }

    function historial_pedidos_empresa($id_empresa)
    {
    $pedidos = DB::select("SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND date(pedido.fecha_pedido) >= date( DATE_SUB(curdate(), INTERVAL + 29 DAY)) AND date(pedido.fecha_pedido) =date(now())  order by pedido.id desc");
      $administrador=DB::select("SELECT u.*,e.razon_social,e.id from usuario u, empresa e where e.id_administrador=u.id and e.id='".$id_empresa."'");
      $fechas = DB::select("SELECT date(DATE_SUB(curdate(), INTERVAL + 29 DAY)) as fecha_inicio, date(now()) as fecha_fin");
      $estado=1;

       return view('empresa.cliente.historial_pedidos_empresa',["fechas"=>$fechas,'pedidos'=>$pedidos,'administrador'=>$administrador,'estado'=>$estado,'otra'=>0]);
    }




   public function get_historial_pedidos_excel($fecha_inicio,$fecha_fin,$estado,$id_empresa){
   //DATA
        if($estado==1){
            //BUSCAR TODOS LOS PEDIDOS.
        $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";
        }else if($estado==2){
            //BUSCAR TODOS LOS PEDIDOS COMPLETADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario, vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }else if($estado==3){
            //BUSCAR TODOS LOS PEDIDOS CANCELADOS

            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado>=5 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }else if($estado==4){
            //BUSCAR TODOS LOS PEDIDOS CON DEUDA  INCLUIDO LOS CANCELADOS.
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado_pago_empresa=0 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }else if($estado==5){
            //BUSCAR TODOS TODOS LOS PEDIDOS CON DEUDA PERO SIN LOS CANCELADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
          pedido.calificacion_conductor,pedido.calificacion_vehiculo
            from pedido,vehiculo,conductor,usuario
         WHERE  pedido.estado_pago_empresa=0 and pedido.estado=2 and pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }else if($estado==6){
            //BUSCA TODOS LOS PEDIDOS PAGADOS
            $consulta="SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,vehiculo.codigo_empresa,pedido.tipo_pedido_empresa,pedido.id_empresa_cliente,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,pedido.latitud,pedido.longitud,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,pedido.estado_pago_empresa,
            pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario
         WHERE pedido.estado_pago_empresa=1 and  pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id_empresa." AND
         date(pedido.fecha_pedido) >='".$fecha_inicio."' AND date(pedido.fecha_pedido) <='".$fecha_fin."' order by pedido.id asc";

        }


    $pedidos = DB::select($consulta);

     Excel::create('Lista de dueda de empresa',function($excel)use ($pedidos,$fecha_inicio,$fecha_fin){
      $excel->sheet('Servicios', function($sheet)use ($pedidos,$fecha_inicio,$fecha_fin){


  //HEADER
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');

        $sheet->row(1,['LISTADO']);
        $sheet->row(2,['FECHA DE INICIO: '.$fecha_inicio]);
        $sheet->row(3,['FECHA FIN: '.$fecha_fin]);
        $sheet->row(4,['NRO','FECHA','MOVIL','CONDUCTOR','USUARIO','REFERENCIA','MONTO']);

$sumatoria=0;
          foreach($pedidos as $pago){
          $row=[];
          $row[0]=$pago->id;
          $row[1]=$pago->fecha_pedido;
          $row[2]=$pago->codigo_empresa;
          $row[3]=$pago->conductor;
          $row[4]=$pago->usuario;
          $row[5]=$pago->direccion;
          $row[6]=$pago->monto_empresa;
          $sheet->appendRow($row);
          $sumatoria+=$pago->monto_empresa;
        }
        $row=[];
        $row[0]="";
          $row[1]="";
          $row[2]="";
          $row[3]="";
          $row[4]="";
          $row[5]="TOTAL";
          $row[6]=$sumatoria;
          $sheet->appendRow($row);

              });
             })->export('xls');
    }



    function index() {
        if (Auth::user()->privilegio == 0 || Auth::user()->privilegio == 2) {
             $empresa = DB::select("SELECT e.*,u.nombre,u.paterno,u.materno,0 as 'deuda' from empresa e, cliente u where u.id=e.id_administrador and e.tipo='CLIENTE' ");


            return view('empresa.index', ['empresa'=>$empresa]);
        }
         else {
            return view('errors.404');
        }
    }

    public function create() {
            $pais=DB::select("SELECT id,nombre from pais");
            $departamento=DB::select("SELECT nombre,id from departamento");
            $administrador=DB::select("SELECT u.id,u.nombre,u.paterno,u.materno,u.telefono from cliente u ");

        return view('empresa.create',['administrador'=>$administrador,'pais'=>$pais,'departamento'=>$departamento]);
    }

    public function store(EmpresasClienteRequest $request) {
      try {
            $id_empresa="";
            $paga_iva=0;
            $paga_it=0;
            $con_factura=0;

            if($request['con_factura']){
                $con_factura=1;
            }

            if($request['paga_iva'])
            {
                $paga_iva=1;
            }
            if($request['paga_it'])
            {
                $paga_it=1;
            }


            $id_empresa=DB::table('empresa')->insertGetId(
                ['nit'=>$request['nit'],
                'tipo'=>'CLIENTE',
                'razon_social'=>$request['razon_social'],
                'direccion'=>$request['direccion'],
                'latitud'=>$request['latitud'],
                'longitud'=>$request['longitud'],
                'correo'=>$request['correo'],
                'id_pais'=>$request['id_pais'],
                'id_departamento'=>$request['id_departamento'],
                'whatsapp'=>$request['whatsapp'],
                'telefono'=>$request['telefono'],
                'estado'=>$request['estado'],
                'credito'=>$request['credito'],
                'id_administrador'=>$request['id_administrador'],
                'ci_representante_legal'=>'11111',
                'id_administrador'=>$request['id_administrador'],
                'con_factura'=>$con_factura,
                'iva'=>$request['iva'],
                'it'=>$request['it'],
                'paga_iva'=>$paga_iva,
                'paga_it'=>$paga_it,
                'quien_paga_iva'=>$request['quien_paga_iva'],
                'quien_paga_it'=>$request['quien_paga_it'],
                'servidor_impresora1' => '',
                'servidor_impresora2' => '',
                'servidor_nota_venta' => '',
                'servidor_factura' => '',
                'impresora1' => '',
                'impresora2' => '',
                ]);

                //INSERTAR SUCURSAL 1
                $id_sucursal = DB::table('sucursal')->insertGetId(
                    [
                      'codigo' => 0,
                      'nombre' => 'SUCURSAL 0',
                      'municipio' => $request['direccion'],
                      'direccion' => $request['direccion'],
                      'telefono' => $request['telefono'],
                      'cuis' => '0000',
                      'codigo_punto_venta' => '0000',
                      'id_empresa' => $id_empresa
                    ]
                  );

                //INSERTAR USUARIO ADMINISTRADOR
                DB::table('users')->insert([
                    'nombre' =>$request['nit'],
                    'usuario' => $request['nit'],
                    'id_sucursal' => $id_sucursal,
                    'password' => Hash::make($request['nit']),
                    'privilegio' => 0,
                    'id_empresa' => $id_empresa
                ]);

                DB::commit();

                Session::flash('message', 'EMPRESA CREADO CORRECTAMENTE');
                return Redirect::to('/empresa');


      } catch (Exception $e) {
          DB::rollback();
          return redirect('/empresa/create')->with("message-error","ERROR INTENTE NUEVAMENTE");
      }
    }

//crear un archivo en una direccion junto a su archivo.
    function crear_archivos($imagen, $direccion){
        $gestor = fopen($imagen, "r");
        $contenido = fread($gestor, filesize($imagen));
        $contenido = base64_encode($contenido);
        fclose($gestor);
        file_put_contents($direccion, $contenido);
    }
//elimina los archivos de una dicha direccion.
    function eliminar_archivo($direccion)
    {
        if(file_exists($direccion))
       {
       $fh = fopen($direccion, 'a');
        fwrite($fh, '');
        fclose($fh);
        unlink($direccion);
        }
    }

    function verificar_nit($nit){
        $result=DB::select("SELECT count(*)as contador FROM empresa where empresa.nit=".$nit);
        return response($result);
    }

//Elimina todas las fotocopias junto a  las fotos registradas en la fotocopia
    function eliminar_fotocopias_de_empresa($id_empresa){
        $fotocopia=DB::select("SELECT f.* from fotocopia f,empresa e  where  f.id=e.id_imagen_corporativa and e.id='".$id_empresa."'");
        $id_fotocopia="";
        foreach ($fotocopia as $key => $value) {
         $foto=DB::select("SELECT f.* from foto f,fotocopia fo  where f.id_fotocopia=fo.id and fo.id='".$value->id."'");
            foreach ($foto as $key => $fo) {
                $this->eliminar_archivo($fo->direccion);
            }
            DB::table('foto')->where('id_fotocopia',$value->id)->delete();
            $id_fotocopia=$value->id;
        }

        DB::table('empresa')->where('id', $id_empresa)->update(['id_imagen_corporativa'=>NULL]);
        DB::table('fotocopia')->where('id',$id_fotocopia)->delete();
    }

    public function edit($id) {


        $empresa2=DB::select("SELECT * from empresa  where id='".$id."' limit 1");
        $tipo_empresa="";
        //$administrador_libre=DB::select("SELECT u.id,u.nombre,u.paterno,u.materno,u.telefono from cliente u ");
        //$administrador=DB::select("SELECT u.id,u.nombre,u.paterno,u.materno,u.telefono from cliente u, empresa e where e.id_administrador=u.id and e.id=".$id);

       foreach ($empresa2 as $emp => $value) {
        $tipo_empresa=$value->tipo;
        }

          if($tipo_empresa=="CLIENTE"){
            return view('empresa.edit', [ 'empresa' => $empresa2/*
            return view('empresa.cliente.edit', [ 'empresa' => $empresa2/*
            'administrador_libres'=>$administrador_libre,
            'administrador'=>$administrador*/
        ]);
         }else{
            return view('empresa.edit', ['empresa' => $empresa2/*,
            'administrador_libres'=>$administrador_libre,
            'administrador'=>$administrador*/
        ]);
         }
    }


    public function Actualizar_Empresa_Cliente(EmpresasCLienteRequest $request){
        //Actualizar empresa cliente 2024
        $paga_iva=0;
            $paga_it=0;
            $con_factura=0;

            if($request['con_factura']){
                $con_factura=1;
            }

            if($request['paga_iva'])
            {
                $paga_iva=1;
            }
            if($request['paga_it'])
            {
                $paga_it=1;
            }

        DB::table('empresa')->where('id', $request['id_empresa'])->update([
            'nit' => $request['nit'],
            'razon_social' => $request['razon_social'],
            'direccion' => $request['direccion'],
            'latitud' => $request['latitud'],
            'longitud' => $request['longitud'],
            'correo' => $request['correo'],
            'whatsapp' => $request['whatsapp'],
            'telefono' => $request['telefono'],
            'servidor_impresora1' => $request['servidor_impresora1'],
            'servidor_impresora2' => $request['servidor_impresora2'],
            'impresora1' => $request['impresora1'],
            'impresora2' => $request['impresora2'],
            'impresora_nota_venta' => $request['impresora_nota_venta'],
            'impresora_factura' => $request['impresora_factura'],
            'con_factura'=>$con_factura,
                'iva'=>$request['iva'],
                'it'=>$request['it'],
                'paga_iva'=>$paga_iva,
                'paga_it'=>$paga_it,
                'quien_paga_iva'=>$request['quien_paga_iva'],
                'quien_paga_it'=>$request['quien_paga_it'],
                'estado'=>$request['estado'],
             ]);



        Session::flash('message', 'EMPRESA ACTUALIZADA CORRECTAMENTE');

            return Redirect::to('/empresa');
    }





//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_constitucion(Request $request)
    {
        $archivo = $request->file('perfil_imagen_constitucion');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_constitucion_de_empresa and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_CONSTITUCION-EMPRESA-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'CONSTITUCION DE LA EMPRESA', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_constitucion_de_empresa'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../".$rutadelaimagen;


        }
    }

//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_representante(Request $request)
    {
        $archivo = $request->file('perfil_imagen_representante');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_poder_del_representante_legal and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_PODER-REPRESENTANTE-LEGAL-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'PODER DEL REPRESENTANTE LEGAL', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_poder_del_representante_legal'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../storage".$rutadelaimagen;


        }
    }
//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_fundaempresa(Request $request)
    {
        $archivo = $request->file('perfil_imagen_fundaempresa');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_registro_fundaempresa and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_REGISTRO-FUNDAEMPRESA-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'REGISTRO EN FUNDAEMPRESA', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_registro_fundaempresa'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../storage".$rutadelaimagen;


        }
    }

//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_ci_representante(Request $request)
    {
        $archivo = $request->file('perfil_imagen_ci_representante');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_ci_del_representante_legal and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_CI-REPRESENTANTE-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'CI DEL REPRESENTANTE LEGAL', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_ci_del_representante_legal'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../storage".$rutadelaimagen;


        }
    }

//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_licencia_gmlp(Request $request)
    {
        $archivo = $request->file('perfil_imagen_licencia_gmlp');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_licencia_funcionamiento_gmlp and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_GMLP-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'LICENCIA DE FUNCIONAMIENTO DE GMLP', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_licencia_funcionamiento_gmlp'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../storage".$rutadelaimagen;


        }
    }

//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_nit(Request $request)
    {
        $archivo = $request->file('perfil_imagen_nit');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_nit and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_NIT-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'RESOLUCION ADMINISTRATIVA DE ATT', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_nit'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../storage".$rutadelaimagen;


        }
    }


//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_att(Request $request)
    {
        $archivo = $request->file('perfil_imagen_att');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_resolucion_administrativa_att and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_RESOLUCION-ADMINISTRATICA-ATT-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'RESOLUCION ADMINISTRATIVA DE ATT', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_resolucion_administrativa_att'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../storage".$rutadelaimagen;


        }
    }

//CODIGO PARA AJAX. SUBIR IMAGENES DE FACTURA DE LUZ O AGUA
    public function subir_imagen_factura_luz(Request $request)
    {
        $archivo = $request->file('perfil_imagen_factura_luz');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_factura_luz_agua_de_oficinas and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_FACTURA-LUZ-AGUA-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'FACTURA DE LUZ O AGUA', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_factura_luz_agua_de_oficinas'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../storage".$rutadelaimagen;


        }
    }
 //CODIGO PARA AJAX. SUBIR IMAGENES DE SENAPI
    public function subir_imagen_senapi(Request $request)
    {
        $archivo = $request->file('perfil_imagen_senapi');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_fotocopia_registro_senapi and e.id='".Auth::user()->id_empresa."'");
            $cantidad=0;
            $id_fotocopia=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_REGISTRO-SENAPI-".Auth::user()->id_empresa."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){
                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'REGISTRO EN SENAPI', 'numero' => $request['numero']]);
                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['numero']]);
                    }
                    DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);

                    DB::table('empresa')->where('id',Auth::user()->id_empresa)->update(['id_fotocopia_registro_senapi'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO


                                return "../../../storage".$rutadelaimagen;


        }
    }
//CODIGO PARA AJAX. SUBIR IMAGENES DE SENAPI
    public function subir_imagen_corporativa(Request $request)
    {

          $archivo = $request->file('perfil_imagen_corporativa');
        $input  = array('image' => $archivo) ;
        $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:900');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails())
        {
          return view("mensajes.msj_rechazado")->with("msj","El archivo no es una imagen valida");
        }
        else
        {
            $fotos_rua=DB::select("SELECT max(fo.id) as 'cantidad',fo.id_fotocopia,fo.id from foto fo,fotocopia f, empresa e WHERE fo.id_fotocopia=f.id and f.id=e.id_imagen_corporativa and e.id='".$request['id_empresa']."'");
            $cantidad=0;
            $id_fotocopia=0;
            $id_foto=0;
            foreach ($fotos_rua as $key => $value) {
              $cantidad=$value->cantidad;
              $id_fotocopia=$value->id_fotocopia;
              $id_foto=$value->id;
            }

            $cantidad+=1;

                        $nombre_original=$archivo->getClientOriginalName();
                            $extension=$archivo->getClientOriginalExtension();
                            $nuevo_nombre="Imagen_LOGO-CORPORATIVA-".$request['id_empresa']."-".$cantidad.".".$extension;
                            $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                            $rutadelaimagen="/Imagen_Empresa/".$nuevo_nombre;


            if($cantidad==1){

                    $id_fotocopia=DB::table('fotocopia')->insertGetId([ 'nombre' => 'LOGO CORPORATIVA', 'numero' =>$request['id_empresa']]);
                     DB::table('foto')->insert(['id_fotocopia' => $id_fotocopia,'id'=>$cantidad, 'direccion' => $rutadelaimagen]);
                     DB::table('empresa')->where('id',$request['id_empresa'])->update(['id_imagen_corporativa'=>$id_fotocopia]); //ACTUALIZO LOS FOREIGN KEY DEL VEHICULO

                    }
                    else{
                     DB::table('fotocopia')->where('id',$id_fotocopia)->update(['numero'=>$request['id_empresa']]);
                      DB::table('foto')->where('id_fotocopia',$id_fotocopia)->where('id',$id_foto)->update(['direccion'=>$rutadelaimagen]);
                    }




                                return "../../../storage".$rutadelaimagen;
            }
        }


    public function actualizar_administrador(Request $request) {
        $verificar = DB::select('SELECT count(*) count,empresa.id from empresa where empresa.usuario="' . $request->usuario . '"');
        if ($verificar[0]->count == 0) {
            DB::table('empresa')->where('id', $request['id_empresa'])->update(['razon_social'=>$request['razon_social'], 'usuario' => $request['usuario'] ]);
            Session::flash('message', 'ADMINISTRADOR ACTUALIZADO CORRECTAMENTE');
            return Redirect::to('/');
        } else {
            if ($request->usuario == $request->usuario_aux) {
                DB::table('empresa')->where('id', $request['id_empresa'])->update(['razon_social'=>$request['razon_social'], 'usuario' => $request['usuario'] ]);
                Session::flash('message', 'ADMINISTRADOR ACTUALIZADO CORRECTAMENTE');
                return Redirect::to('/');
            } else {
                Session::flash('message-error', 'YA EXISTE ESE USUARIO, INTENTE NUEVAMENTE');
                return Redirect::to('/');
            }
        }
    }

    public function actualizar_administrativo(Request $request) {
        $verificar = DB::select('SELECT count(*) count,empresa.nit from empresa where empresa.usuario="' . $request->usuario . '"');
        if ($verificar[0]->count == 0) {
            DB::table('empresa')->where('nit', $request['id_empresa'])->update(['nombre' => $request['nombre'],'nit'=>$request['nit'], 'direccion' => $request['direccion'], 'telefono' => $request['telefono'], 'celular' => $request['celular'], 'usuario' => $request['usuario'] ]);
            Session::flash('message', 'ADMINISTRATIVO ACTUALIZADO CORRECTAMENTE');
            return Redirect::to('/administrativos');
        } else {
            if ($request->usuario == $request->usuario_aux) {
                DB::table('empresa')->where('nit', $request['id_empresa'])->update(['nombre' => $request['nombre'],'nit'=>$request['nit'], 'direccion' => $request['direccion'], 'telefono' => $request['telefono'], 'celular' => $request['celular'], 'usuario' => $request['usuario'] ]);
                Session::flash('message', 'ADMINISTRATIVO ACTUALIZADO CORRECTAMENTE');
                return Redirect::to('/administrativos');
            } else {
                Session::flash('message-error', 'YA EXISTE ESE USUARIO, INTENTE NUEVAMENTE');
                return Redirect::to('/administrativos');
            }
        }
    }


    public function update(Request $request) {

/*
      $direccion_perfil="";
      if ($request['imagen_rep_legal'] != "") {

        $gestor = fopen($request['imagen_rep_legal'], "r");
        $contenido = fread($gestor, filesize($request['imagen_rep_legal']));
        $contenido =$contenido;
        fclose($gestor);
        $direccion_perfil = "Imagen_Duenio/Perfil-".$request['ci_representante_legal'].".png";
        file_put_contents($direccion_perfil, $contenido);
      }elseif ($request['direccion_imagen'] != "") {
        $direccion_perfil = $request['direccion_imagen'];
      }
 */

      //Insertar Imagen del vehiculo
                        $direccion_logo="";
                        if ($request['logo'] != "") {

                          $archivo = $request->file('logo');
                          $input  = array('image' => $archivo) ;
                          $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
                          $validacion = Validator::make($input,  $reglas);
                          if ($validacion->fails()){
                            echo "Error";
                          }
                          else
                          {
                          $nombre_original=$archivo->getClientOriginalName();
                          $extension=$archivo->getClientOriginalExtension();
                          $nuevo_nombre="logo-".$request['id_empresa'].".".$extension;
                          $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                          $direccion_logo="Imagen_Empresa/".$nuevo_nombre;
                          
                          }
                        }else{
                            $direccion_logo=$request['direccion_logo'];
                        }


                         $direccion_baner="";
                        if ($request['baner'] != "") {

                          $archivo = $request->file('baner');
                          $input  = array('image' => $archivo) ;
                          $reglas = array('image' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:15000');
                          $validacion = Validator::make($input,  $reglas);
                          if ($validacion->fails()){
                            echo "Error";
                          }
                          else
                          {
                          $nombre_original=$archivo->getClientOriginalName();
                          $extension=$archivo->getClientOriginalExtension();
                          $nuevo_nombre="baner-".$request['id_empresa'].".".$extension;
                          $r1=Storage::disk('Imagen_Empresa')->put($nuevo_nombre,  \File::get($archivo) );
                          $direccion_baner="Imagen_Empresa/".$nuevo_nombre;
                          }
                        }else{
                            $direccion_baner=$request['direccion_baner'];
                        }


   //Pago QR - Banco FIE
   $pago_qr_bancofie = ($request->input('pago_qr_bancofie') == 1) ? 1 : 0;
   $empresa_actual   = DB::table('empresa')->where('id', $request['id_empresa'])->first();
   $bancofie_password = $empresa_actual->bancofie_password ?? null; //por defecto se conserva la actual
   if ($request->filled('bancofie_password')) {
       $bancofie_password = Crypt::encryptString($request->input('bancofie_password'));
   }
   if ($pago_qr_bancofie == 0) {
       $bancofie_password = $empresa_actual->bancofie_password ?? null; //no se toca si se desactiva
   }

   DB::table('empresa')->where('id', $request['id_empresa'])->update([
    'direccion_logo' => $direccion_logo,
    'direccion_baner' => $direccion_baner,
    'pago_qr_bancofie' => $pago_qr_bancofie,
    'bancofie_usuario' => $request['bancofie_usuario'],
    'bancofie_password' => $bancofie_password,
    'bancofie_id_servicio' => $request['bancofie_id_servicio'] ?: null,
    'bancofie_callback' => $request['bancofie_callback'] ?: null,
    'nit' => $request['nit'],
    'tipo'=>$request['tipo'],
    'razon_social' => $request['razon_social'],
    'nro_licencia_funcionamiento' => $request['nro_licencia_funcionamiento'],
    'usuario' => $request['usuario'],
    'nro_constitucion_de_empresa' => $request['nro_constitucion_de_empresa'],
    'direccion' => $request['direccion'],
    'latitud' => $request['latitud'],
    'longitud' => $request['longitud'],
    'correo' => $request['correo'],
    'mision' => $request['mision'],
    'vision' => $request['vision'],
    'facebook' => $request['facebook'],
    'whatsapp' => $request['whatsapp'],
    'id_pais' => $request['id_pais'],
    'id_departamento' => $request['id_departamento'],
    'id_asociacion' => $request['id_asociacion'],
    'nro_poder_del_representante' => $request['nro_poder_del_representante'],
    'nro_registro_fundaempresa' => $request['nro_registro_fundaempresa'],
    'nro_resolucion_administrativa_att' => $request['nro_resolucion_administrativa_att'],
    'municipio'=>$request['municipio'],
    'actividad_economica'=>$request['actividad_economica'],
    'codigo_sistema'=>$request['codigo_sistema'],
    'token_sin'=>$request['token_sin'],
    'modalidad_sin'=>$request['modalidad_sin'],
    'tipo_emision_sin'=>$request['tipo_emision_sin'],
    'tipo_factura_sin'=>$request['tipo_factura_sin'],
    'tipo_documento_sector_sin'=>$request['tipo_documento_sector_sin'],
    'codigo_ambiente'=>$request['codigo_ambiente'],
    'servidor_impresora1' => $request['servidor_impresora1'],
            'servidor_impresora2' => $request['servidor_impresora2'],
            'impresora1' => $request['impresora1'],
            'impresora2' => $request['impresora2'],
            'impresora_nota_venta' => $request['impresora_nota_venta'],
            'impresora_factura' => $request['impresora_factura'],
            'comentario_recibo' => $request['comentario_recibo'],
]);


        Session::flash('message', 'EMPRESA ACTUALIZADA CORRECTAMENTE');
        if (Auth::user()->privilegio == 0) {
            return Redirect::to('/empresa/'.Auth::user()->id_empresa.'/edit');
        }else{
            return Redirect::to('/empresa');
        }
    }





      function get_datos_de_empresa_pagina($id_empresa){
           //OBTIENE LOS DATOS DE LA EMPRESAS PARA PODER MOSTRAR EN LA PAGINA WEB
        $empresa=DB::select("SELECT nit, tipo,razon_social,direccion,latitud,longitud,correo,mision,vision,facebook,whatsapp from empresa where id='".$id_empresa."'");
        $propietario=DB::select("SELECT d.nombre,d.paterno,d.materno,d.celular,d.correo,d.direccion_imagen from duenio d, empresa e where e.ci_representante_legal=d.ci and  e.id='".$id_empresa."'");
        $imagen_corporativa=DB::select("SELECT fo.direccion from foto fo, fotocopia f, empresa e where fo.id_fotocopia=f.id and e.id_imagen_corporativa=f.id and  e.id='".$id_empresa."'");
        $telefono=DB::select("SELECT numero from telefono where id_empresa='".$id_empresa."'");

        $row = array('empresa' => $empresa,'propietario'=>$propietario,'telefono'=>$telefono,'imagen_corporativa'=>$imagen_corporativa );
        return response($row);
    }



    public function cargar_empresa($id){
        $empresa=DB::select("SELECT *from empresa where empresa.id=".$id);
        return response($empresa);
    }
    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL DEL REPRESENTANTE LEGAL
    function verificar_ci_representante($ci){
        $duenio=DB::select("SELECT count(*)as contador,duenio.* FROM duenio where duenio.ci=".$ci);
        return response($duenio);
    }



 function Cambiar_Password(CambiarPasswordRequest $request) {
        DB::table('users')->where('id', $request['id_usuario'])->update(['password' => Hash::make($request['password'])]);
        Session::flash('message', 'CONTRASEÑA MODIFICADA');
        switch ($request['privilegio']) {
            case '1':
                return Redirect::to('/administrador');
                break;
            case '2':
                return Redirect::to('/administrativos');
                break;
            case '0':
                return Redirect::to('/usuarios');
                break;
            case '3':
                return Redirect::to('/usuarios');
                break;
            case '10':
                return Redirect::to('/usuarios');
                break;
            case '11':
                return Redirect::to('/usuarios');
                break;
            case '12':
                return Redirect::to('/usuarios');
                break;
            default:
                return Redirect::to('/usuarios');
                break;
        }

    }

     function Cambiar_Administrador(ActualizarAdministradorRequest $request) {
        DB::table('empresa')->where('id', $request['id_empresa'])->update(['id_administrador' => $request['id_administrador']]);

                //enviar notificacion
                $mPushNotification = getPush('CENTRAL',"Señor Usuario: Ha sido registrado como Aministrador de su Empresa.",null,"taxi","","","0","0","7");
                $tokens = array();
                $conductor=DB::select("SELECT token  from usuario WHERE  id=".$request['id_administrador']);
                foreach ($conductor as $key => $con) {
                     array_push($tokens, $con->token);
                    }
                  $devicetoken = $tokens;
                $sw_notificacion=send($tokens,$mPushNotification);
                //fin de envio de notificacion

        Session::flash('message', 'ADMINISTRADOR MODIFICADO');
         return Redirect::to('/empresa');
    }

function Cambiar_Password_empresa(CambiarPasswordRequest $request) {
        DB::table('users')->where('id', $request['id_usuario'])->update(['password' => Hash::make($request['password'])]);
        Session::flash('message', 'CONTRASEÑA MODIFICADA');
        switch ($request['privilegio']) {
            case '0':
                return Redirect::to('/usuarios/empresa');
                break;
            case '3':
                return Redirect::to('/usuarios/empresa');
                break;
        }

    }

 function Telefono_Empresa($id) {
        $telefono=DB::select("SELECT * from telefono WHERE telefono.id_empresa=".$id);
        return response($telefono);
    }


    //CARGAR PARA VERIFICAR SI EXISTE EL CI DEL PROPIETARIO
    function verificar_ci_representante_legal($ci){
      $direccion="";
        $direccion_im=DB::select("SELECT count(*)as cont, duenio.* FROM duenio where duenio.ci=".$ci);
        if ($direccion_im[0]->cont != 0) {
          if ($direccion_im[0]->direccion_imagen != "") {
            $direccion = file_get_contents($direccion_im[0]->direccion_imagen);
          }
        }
        $duenio=DB::select("SELECT count(*)as contador,'".$direccion."' as imagen,duenio.* FROM duenio where duenio.ci=".$ci);
        return response($duenio);
    }

    function existe_representante_legal($ci){
        $sw=false;
         $direccion_im=DB::select("SELECT count(*)as cont FROM duenio where duenio.ci=".$ci);
        if ($direccion_im[0]->cont != 0) {
            $sw=true;
        }
        return $sw;
    }


////////////////////////////////////////////////////////////////////////////////
//////////////////HISTORIAL DE CARRERAS DE LAS EMPRESAS/////////////////////////
////////////////////////////////////////////////////////////////////////////////

    //MUESTRA LA PLANTILLA DE HISTORIAL DE PEDIDOS DE UNA EMPRESA
    public function show($id){
        if (Auth::user()->privilegio != 0) {
            $empresa = DB::select("SELECT * from empresa where id = " . $id);
           $fechas = DB::select("SELECT DATE_SUB(curdate(), INTERVAL + 29 DAY) as fecha_inicio, curdate() as fecha_fin");
           return view('empresa.historial_carrera',['empresa'=>$empresa], compact('fechas'));
        } else {
               return view('errors.404');
        }
    }
    //MUESTRA LA PLANTILLA DE HISTORIAL DE CARRERA
    public function historial_pedido_empresa($id, $fecha_inicio, $fecha_fin, $estado){
        $empresa = DB::select("SELECT pedido.id, conductor.ci,conductor.expedido,
         CONCAT(conductor.nombre,' ',conductor.paterno,' ',conductor.materno)as conductor,
         vehiculo.placa,vehiculo.marca, CONCAT(usuario.nombre,' ',usuario.apellido) as usuario,
         date_format(pedido.fecha_pedido,'%d-%m-%Y %h:%i %p')as fecha_pedido,pedido.direccion,pedido.monto_total,pedido.monto_empresa,pedido.monto_conductor,
         pedido.detalle_cancelo_usuario,pedido.detalle_cancelo_conductor,pedido.direccion,pedido.clase_vehiculo,pedido.estado,
         pedido.calificacion_conductor,pedido.calificacion_vehiculo
           from pedido,vehiculo,conductor,usuario
         WHERE pedido.id_vehiculo=vehiculo.placa AND pedido.id_conductor=conductor.ci AND usuario.id=pedido.id_usuario  AND pedido.id_empresa_cliente=".$id." AND
         pedido.fecha_pedido BETWEEN '".$fecha_inicio."' AND DATE_SUB('".$fecha_fin."',INTERVAL -1 DAY) order by pedido.fecha_pedido");
       return response($empresa);
    }

    public function ubicacion_empresa()
    {
        $empresa=DB::select("SELECT latitud,longitud from empresa where id=".Auth::user()->id_empresa);
        return response($empresa);
    }

    function empresa_asociacion($id_empresa_asociacion) {
        if (Auth::user()->privilegio == 1 || Auth::user()->privilegio == 2) {
            $empresa=DB::table('empresa')
                ->select('empresa.*')
                ->paginate(10);
            return view('empresa.index', ['empresa'=>$empresa,'buscar_empresa'=>$empresa]);
        }else if (Auth::user()->privilegio == 10) {
            $empresa=DB::table('empresa')
                ->where('empresa.id_asociacion','=',$id_empresa_asociacion)
                ->select('empresa.*')
                ->paginate(10);
            return view('empresa.federacion.empresas', ['empresa'=>$empresa,'buscar_empresa'=>$empresa]);

        }else if(Auth::user()->privilegio == 11){
            $empresa=DB::table('empresa')
                ->where('empresa.id_asociacion','=',Auth::user()->id_empresa)
                ->select('empresa.*')
                ->paginate(10);
            return view('empresa.index', ['empresa'=>$empresa,'buscar_empresa'=>$empresa]);

        }
         else {
            return view('errors.404');
        }
    }

    function usuarios_empresa_por_id($id_empresa){

    if(Auth::user()->privilegio == 0){
            $usuario=DB::table('users')->select('*')->orderby('nombre')->where('id_empresa',$id_empresa)->get();
            return view('empresa.cliente.usuarios',compact('usuario',$usuario));
        } else {
            return view('errors.404');
        }
    }

    
}
