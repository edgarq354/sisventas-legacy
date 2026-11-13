
function buscar_por_anio(){
  var anio=$("#anio").val();
   $.get('get_pedidos_estadistica_anio/'+anio , function (response) {
              var fecha= new Array();  
              var cantidad_finalizado=new Array();
              var cantidad_cancelado=new Array();
              var cantidad_sin_aceptar=new Array();
              var cantidad_sin_finalizar=new Array();

              for (var i = 0; i < response.length; i++) {  
                var m=""; 
              if(response[i].mes==1){
                m="Enero";
              }else if(response[i].mes==2){
                  m="Febrero";
              }else if(response[i].mes==3){
                m="Marzo";
              }else if(response[i].mes==4){
                 m="Abril";
              }else if(response[i].mes==5){
                m="Mayo";
              }else if(response[i].mes==6){
                m="Junio";
              }else if(response[i].mes==7){
                m="Julio";
              }else if(response[i].mes==8){
                m="Agosto";
              }else if(response[i].mes==9){
                m="Septiembre";
              }else if(response[i].mes==10){
               m="Octubre";  
              }else if(response[i].mes==11){
                m="Noviembre"; 
              }else if(response[i].mes==12){
                m="Diciembre";
              }

                

                fecha[i]=m;
                var n1=parseInt(response[i].cantidad_finalizado);
                var n2=parseInt(response[i].cantidad_cancelado);
                var n3=parseInt(response[i].cantidad_sin_aceptar);
                var n4=parseInt(response[i].cantidad_sin_finalizar);
                cantidad_finalizado.push(n1);
                cantidad_cancelado.push(n2);
                cantidad_sin_aceptar.push(n3);
                cantidad_sin_finalizar.push(n4);
                }
                 $('#estadistica_pedido_anio').highcharts({
                title:{text:'Informe de Pedidos'},
                 xAxis:{categories:fecha},
                 yAxis: {title: {text: 'Cantidad'}},
                 tooltip:{valueSuffix:''},
                 legend:{layout:'vertical',align:'right',verticalAlign:'middle',borderWidth:0},
                 series:[{type: 'spline',name: 'Pedido finalizado',data: cantidad_finalizado},{type: 'spline',name: 'Pedido cancelado',data: cantidad_cancelado},{type: 'spline',name: 'Pedido sin aceptar',data: cantidad_sin_aceptar},{type: 'spline',name: 'Pedido sin finalizar',data: cantidad_sin_finalizar},],
                 plotOptions:{line: {dataLabels: { enabled: true},enableMouseTracking: true}}
               });  
        }); 
  }

$(document).ready(function(){

 

     $(function($){
 

       var anio=$("#anio").val();
         $.get('get_pedidos_estadistica_anio/'+anio , function (response) {
              var fecha= new Array();  
              var cantidad_finalizado=new Array();
              var cantidad_cancelado=new Array();
              var cantidad_sin_aceptar=new Array();
              var cantidad_sin_finalizar=new Array();

              for (var i = 0; i < response.length; i++) { 
              var m=""; 
              if(response[i].mes==1){
                m="Enero";
              }else if(response[i].mes==2){
                  m="Febrero";
              }else if(response[i].mes==3){
                m="Marzo";
              }else if(response[i].mes==4){
                 m="Abril";
              }else if(response[i].mes==5){
                m="Mayo";
              }else if(response[i].mes==6){
                m="Junio";
              }else if(response[i].mes==7){
                m="Julio";
              }else if(response[i].mes==8){
                m="Agosto";
              }else if(response[i].mes==9){
                m="Septiembre";
              }else if(response[i].mes==10){
               m="Octubre";  
              }else if(response[i].mes==11){
                m="Noviembre"; 
              }else if(response[i].mes==12){
                m="Diciembre";
              }

                

                fecha[i]=m;
                var n1=parseInt(response[i].cantidad_finalizado);
                var n2=parseInt(response[i].cantidad_cancelado);
                var n3=parseInt(response[i].cantidad_sin_aceptar);
                var n4=parseInt(response[i].cantidad_sin_finalizar);
                cantidad_finalizado.push(n1);
                cantidad_cancelado.push(n2);
                cantidad_sin_aceptar.push(n3);
                cantidad_sin_finalizar.push(n4);
                }
                 $('#estadistica_pedido_anio').highcharts({
                title:{text:'Informe de Pedidos'},
                 xAxis:{categories:fecha},
                 yAxis: {title: {text: 'Cantidad'}},
                 tooltip:{valueSuffix:''},
                 legend:{layout:'vertical',align:'right',verticalAlign:'middle',borderWidth:0},
                 series:[{type: 'spline',name: 'Pedido finalizado',data: cantidad_finalizado},{type: 'spline',name: 'Pedido cancelado',data: cantidad_cancelado},{type: 'spline',name: 'Pedido sin aceptar',data: cantidad_sin_aceptar},{type: 'spline',name: 'Pedido sin finalizar',data: cantidad_sin_finalizar},],
                 plotOptions:{line: {dataLabels: { enabled: true},enableMouseTracking: true}}
               });  
        }); 


       
  
     });




});



