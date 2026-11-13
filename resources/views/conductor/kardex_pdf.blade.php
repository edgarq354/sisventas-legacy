<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>CONDUCTOR PDF</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->

 <!--       background: url('http://104.198.220.70/TaxiCorp_V1/storage{{$contenido}}') no-repeat 30% 20%; -->
<style type="text/css">
body{
        font-size: 14px;
        font-family:Elegance, sans-serif;
       }
      #div{
       background: url(<?php echo "".asset('../storage'.$contenido);?> ) no-repeat 30% 20%;
         position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0.1;
      }
      
     table{
      border-spacing:0px;
     }
     #tabla{
      border: 1px solid #000;
     }
     html {
  margin-top: 0mm;
}

</style>
</head>



  
<body >
 <div style="width: 750px;" >
        <div id="div" ></div>
        <!-- content -->
    
  <table style="width: 750px;" border="0"  id="tabla">
    <tr style="background: #1b5e20; color: white;" >
      <td style="padding: 5px;">
        <img src=<?php echo "".asset('../storage'.$contenido);?> width="80px" height="80px"  >
        
      </td>
      <td>
        <div align="center">
          <h1>KARDEX CONDUCTOR</h1>
        </div>
      </td>
      <td align="right">
        <img src=<?php echo "".asset('../public/images/icono.png');?> width="80px" height="80px"  >
      </td>
    </tr>


    <tr style="">
      <td colspan="3" style="padding-left: 15px; padding-top: 20px; padding-bottom: 5px;">
        
        <table  style="width: 750px;" border="0">
        <tr>
          <td colspan="4"><u><b>DATOS PERSONALES</b></u></td>
           <td rowspan="6">
               <table align="center" border="0" style="width: 100%; height: 150px; margin-top:-15px;  margin-right: 15px;">
                      <tr>
                       <td align="right" >
                        <?php
                        $codigo=$conductor[0]->ci."taxivalle";
                        $codificado=base64_encode($codigo);
                        ?>
                         <!-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(130)->generate($codificado)) !!} " />  -->
                         <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->margin(0)->size(145)->generate($codificado)) !!} " />
                        </td>

                        <td align="right" style="width: 140px;">
                      <!--   <img src="http://104.198.220.70/TaxiCorp_V1/public/{{$conductor[0]->direccion_imagen}}" width="80px" height="80px" style="border-radius: 5px;">    -->
                          <img src=<?php echo "".asset('../public/'.$conductor[0]->direccion_imagen);?> width="135px" height="135px" >

                        </td>
                       
                      </tr>
                    </table>

            </td>
        </tr>
          <tr>
            <td>C.I:</td>
            <td><b>{{$conductor[0]->ci}} {{$conductor[0]->expedido}}</b></td>
            <td colspan="2"></td>
           
          </tr>

          <tr>
            <td>NOMBRE:</td>
            <td><b>{{$conductor[0]->nombre}}</b></td>

            <td style="padding-left: 10px;"> CELULAR:</td>
            <td><b>{{$conductor[0]->celular}}</b></td>
          </tr>

          <tr>
            <td>PATERNO:</td>
            <td><b>{{$conductor[0]->paterno}}</b></td>
            <td style="padding-left: 10px;"> SEXO:</td>
            <td><b>{{$conductor[0]->sexo}}</b></td>
          </tr>

          <tr>
            <td>MATERNO:</td>
            <td><b>{{$conductor[0]->materno}}</b></td>
            <td>FECHA NAC.:</td>
            <td><b>{{$conductor[0]->fecha_nacimiento}}</b></td>
           
          </tr>

          


          

          <tr>
            <td colspan="4">TELEFONO FIJO:</td>
          </tr>
          <tr>
            <td style="color:white;">.</td>
          </tr>
          <tr >
            <td > DOMICILIO:</td>
            <td colspan="4" ><b>{{$conductor[0]->direccion}}</b></td>
          </tr>
          <tr>
            <td colspan="5">REFERENCIA:</td>
          </tr>
          
        </table>
      
        
      </td>

      <td>
        
      </td>
    </tr>







        <tr>
      <td  style="padding-left: 15px; width: 100%; height: 130px;" colspan="3">
        <table border="0" style="width: 100%" >
          <tr>
            <td>
                  <table border="0" >
                   <tr>
                        <td colspan="2"><u><b>DATOS DE LA EMPRESA</b></u></td>
                             
                      </tr>
                      <tr>
                        <td>COD. INTERNO:</td>
                        <td>
                          @if($cantidad_asignacion>0)
                          <b>{{$asignacion[0]->codigo_empresa}}</b>
                          @endif
                        </td>      
                      </tr>

                      <tr>
                        <td>FECHA INGRESO:</td>
                        <td><b>{{$conductor[0]->fecha_registro}}</b></td>
                      </tr>

                      <tr>
                        <td>ESTADO:</td>
                        <td></td>
                      </tr>

                      <tr>
                        <td>TIPO:</td>
                        <td></td>
                      </tr>
                    </table>
            </td>
              <td>

               <table align="right"  style="margin-right: 20px;">
                 
                 <tr>
                   <td>LIC</td>
                   <td style="border: 1px solid #000; background: white; width: 18px; height: 18px; color: black;">*</td>
                 </tr>
                 <tr>
                   <td>CI</td>
                   <td style="border: 1px solid #000; background: white; width: 18px; height: 18px; color: black;">*</td>
                 </tr>
              
               </table>
                   
              </td>

               <td>

               
                   
              </td>
          </tr>
        </table>
       
      </td>
      
    </tr>







    <tr style="background: #1b5e20;  color: white;">
      <td colspan="3">
        <table border="0" style="width: 100%;">
          <tr>
            <td style="padding-bottom: 0px; padding-top: 5px;">
        <div align="left"><b>COD.
      @if($cantidad_asignacion>0)
        <span style="border: 1px solid #000; background: white;color: black;  padding: 1px; border-radius: 5px;">{{$asignacion[0]->codigo_empresa}}</span>
      @endif
       </b></div>
     </td>
      <td  style="padding-bottom: 0px; padding-top: 5px;">
         <div align="left"><b>
      {{$conductor[0]->nombre}} {{$conductor[0]->paterno}} {{$conductor[0]->materno}}
      </b></div>
      </td>
    
   
    <td  style="padding-bottom: 0px; padding-top: 5px;">
      <div align="right"><b>{{$empresa[0]->razon_social}}</b></div> 

     
      </td>
          </tr>
        </table>
      </td>
      
    </tr>
  </table>



 </div>
</body>
</html>