<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <title>CONDUCTOR PDF</title>
 <!--link href="css/reporte.css" type="text/css" rel="stylesheet"  -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/AdminLTE.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/_all-skins.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" media="screen" />
<style type="text/css">
body{
        font-size: 12px;
        font-family:Elegance, sans-serif;
       }
</style>
</head>

<body>

      @foreach($conductor as $con)
      <div  style="width: 400px; border: 1px solid #000; border-radius: 1px; margin-top: 15px; margin-left: 15px; padding-bottom: 20px; ">
         <table border="0"  cellpadding="2" cellspacing="1" width="400px" >
          <tr>
          <td colspan="2" align="center">
             <img src=<?php echo "".asset('/images/logo.png');?> width="350px" height="100px" >
          </td>
          </tr>
           
          <tr>
            <td align="left">
           <img src=<?php echo "".asset('/images/icono.png');?> width="160px" height="160px" >
            </td>
            
            <td align="left">             
            <?php
            $codigo=$con->ci."clasico";
            $codificado=base64_encode($codigo);
            ?>
              <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->margin(0)->generate($codificado)) !!} " /> 

            </td>
          </tr>
        </table>
        </div>
    
      @endforeach
  
</body>
</html>