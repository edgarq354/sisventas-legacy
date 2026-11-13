<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Usuario;
use DB;


use Hash;
use Storage;
use Illuminate\Support\Facades\Validator;


class CopiaDeSeguridadController extends Controller
{

     public function __construct() {
         $this->middleware('auth');
    }


    function index()
    {

    $host=env('DB_HOST');
    $usuario=env('DB_USERNAME');
    $pasword=env('DB_PASSWORD');
    $nombreDeBaseDeDatos=env('DB_DATABASE');

 set_time_limit(5000);
    $tablasARespaldar = [];

        $tablas=DB::select("SHOW TABLES");

         foreach ($tablas as $key => $fila) {
            //recorre la lista de tablas y carga en la variable TABLASRESPALDAR
             foreach($fila as $key => $value) {
                $tablasARespaldar[] = $value;
             }


        }


    $contenido = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $nombreDeBaseDeDatos . "`\r\n--\r\n\r\n\r\n";

    foreach ($tablasARespaldar as $nombreDeLaTabla) {
        if (empty($nombreDeLaTabla)) {
            continue;
        }


        $datosQueContieneLaTabla=DB::select('SELECT * FROM `' . $nombreDeLaTabla . '`');

        $query_cantidad=DB::select('SELECT count(*) cantidad FROM information_schema.`COLUMNS`
                                    WHERE table_name =  "' . $nombreDeLaTabla . '"
                                    AND TABLE_SCHEMA = "'.env('DB_DATABASE').'"');


         foreach ($query_cantidad as $key => $fila) {
                     $cantidadDeCampos = $fila->cantidad;
                    }

                      $query_fila=DB::select('SELECT count(*) cantidad FROM   `' . $nombreDeLaTabla . '` ');


         foreach ($query_fila as $key => $fila) {
                     $cantidadDeFilas = $fila->cantidad;
                    }




$query_esquemaTabla=DB::select('SHOW CREATE TABLE `' . $nombreDeLaTabla . '` ');
/*

         foreach ($query_esquemaTabla as $key => $fila) {
                     $contenido .= "\n\n" . $fila->Create Table. ";\n\n";

                    }*/

            foreach ($query_esquemaTabla as $key => $fila ) {
               $itemArray = (array) $fila;

       $contenido .= "\n\n" .$itemArray['Create Table'].";\n\n";

            }



        //for ($i = 0, $contador = 0; $i < $cantidadDeCampos; $i++, $contador = 0) {
           // while ($fila = $datosQueContieneLaTabla->fetch_row()) {
            $contador = 0;
              foreach ($datosQueContieneLaTabla as $key => $row ) {
                $fila = (array) $row;

                //echo "El " . $datosQueContieneLaTabla[0]->modulo. " es " . $row->id;
                //La primera y cada 100 veces
                $output="";
                if ($contador % 100 == 0 || $contador == 0) {
                    $contenido .= "\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                    $output="\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                }
                $contenido .= "\n(";
                $output .= "\n(";




                    $j = 0;
                        foreach($fila as $key => $value) {

                            //$output .=  "[" . $key . "] => " . $value ."<br>";

                           $dato_fila = str_replace("\n", "\\n", addslashes($value));
                                        if (isset($dato_fila)) {
                                            $contenido .= '"' . $dato_fila . '"';
                                            $output .= '"' . $dato_fila . '"';

                                        } else {
                                            $contenido .= '""';
                                            $output .= '""';
                                        }
                                        if ($j < ($cantidadDeCampos - 1)) {
                                            $contenido .= ',';
                                            $output .= ',';
                                        }
                          $j++;
                        }




                $contenido .= ")";
                $output .= ")";
                # Cada 100...
                if ((($contador + 1) % 100 == 0 && $contador != 0) || $contador + 1 == $cantidadDeFilas) {
                    $contenido .= ";";
                    $output .= ";";
                } else {
                    $contenido .= ",";
                    $output .= ",";
                }

                //echo $output." [".$contador."]<br>";
                $contador = $contador + 1;
            }
        //}
        $contenido .= "\n\n\n";
    }
    $contenido .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

    # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
    $carpeta = __DIR__ . "/../../../public/respaldos";

   // echo $carpeta;

    if (!file_exists($carpeta)) {
        mkdir($carpeta);
    }

    # Calcular un ID único
    $id = uniqid();

    # También la fecha
    $fecha = date("Y-m-d");

    # Crear un archivo que tendrá un nombre como respaldo_2018-10-22_asd123.sql
    $nombreDelArchivo = sprintf('%s/respaldo_%s_%s.sql', $carpeta, $fecha, $id);
    $nombrelocalhost = sprintf('respaldos/respaldo_%s_%s.sql',  $fecha, $id);

   // echo "<a href='".$nombrelocalhost."'  >".$nombrelocalhost."</a>";

    #Escribir todo el contenido. Si todo va bien, file_put_contents NO devuelve FALSE
    //return file_put_contents($nombreDelArchivo, $contenido) !== false;
    $sw_registrar_archivo= file_put_contents($nombreDelArchivo, $contenido) !== false;







    //OBTENER LA LISTA DE ARCHIVOS DE UN DIRECTORIO
$directorio=$carpeta;
// Array en el que obtendremos los resultados
  $res = array();

  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($directorio, -1) != "/") $directorio .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir = @dir($directorio) or die("getFileList: Error abriendo el directorio $directorio para leerlo");
  while(($archivo = $dir->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo[0] == ".") continue;
      if(is_dir($directorio . $archivo)) {
          $res[] = array(
            "Nombre" =>  $archivo . "/",
            "Tamanio" => 0,
            "Modificado" => filemtime($directorio . $archivo)
          );
      } else if (is_readable($directorio . $archivo)) {
          $res[] = array(
            "Nombre" =>   $archivo,
            "Tamanio" => filesize($directorio . $archivo),
            "Modificado" => filemtime($directorio . $archivo)
          );
      }
  }
  $dir->close();

    //FINAL DE LA OBTENCION DE LOS ARCHIVOS DE LCADA DIRECTORIO


Session::flash('descargar_copia',$nombrelocalhost);
       return view('copiadeseguridad.index',[
        'enlace'=>$nombrelocalhost,
        'lista'=>$res
      ]);

    }



}
