<?php

header('content-type: image/jpeg');
  foreach($conductor as $con){
            
            $codigo=$con->ci."clasico";
            $codificado=base64_encode($codigo);
            $codigo="data:image/png;base64,".base64_encode(QrCode::format('png')->size(500)->margin(0)->generate($codificado));
            echo " <img src='".$codigo."' />"; 
     }
?>