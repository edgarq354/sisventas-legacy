  

function buscar_por_dia(){
    var fecha=$("#fecha").val();
         $.get('get_pedidos_estadistica_dia/'+fecha , function (response) {
              var fecha= new Array();  
              var cantidad_finalizado=new Array();
              var cantidad_cancelado=new Array();
              var cantidad_sin_aceptar=new Array();
              var cantidad_sin_finalizar=new Array();

              for (var i = 0; i < response.length; i++) {  
                fecha[i]=response[i].fecha;
                var n1=parseInt(response[i].cantidad_finalizado);
                var n2=parseInt(response[i].cantidad_cancelado);
                var n3=parseInt(response[i].cantidad_sin_aceptar);
                var n4=parseInt(response[i].cantidad_sin_finalizar);
                cantidad_finalizado.push(n1);
                cantidad_cancelado.push(n2);
                cantidad_sin_aceptar.push(n3);
                cantidad_sin_finalizar.push(n4);
                }
                 $('#estadistica_pedido_dia').highcharts({
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
        
       var fecha=$("#fecha").val();
         $.get('get_pedidos_estadistica_dia/'+fecha , function (response) {
              var fecha= new Array();  
              var cantidad_finalizado=new Array();
              var cantidad_cancelado=new Array();
              var cantidad_sin_aceptar=new Array();
              var cantidad_sin_finalizar=new Array();

              for (var i = 0; i < response.length; i++) {  
                fecha[i]=response[i].fecha;
                var n1=parseInt(response[i].cantidad_finalizado);
                var n2=parseInt(response[i].cantidad_cancelado);
                var n3=parseInt(response[i].cantidad_sin_aceptar);
                var n4=parseInt(response[i].cantidad_sin_finalizar);
                cantidad_finalizado.push(n1);
                cantidad_cancelado.push(n2);
                cantidad_sin_aceptar.push(n3);
                cantidad_sin_finalizar.push(n4);
                }
                 $('#estadistica_pedido_dia').highcharts({
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
