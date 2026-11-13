@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('categoria.modal')



<script type="text/javascript">
	
	  //FOTO DE PERFIL

  $(document).on("submit",".formulario_perfil",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_perfil" ){ var miurl="subir_imagen_perfil";  var divresul="notificacion_perfil"}
        //información del formulario
        var formData = new FormData($("#"+nombreform+"")[0]);

        //hacemos la petición ajax   
        $.ajax({
            url: miurl,  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
              $("#"+divresul+"").html($("#cargador_empresa").html());                
            },
            //una vez finalizado correctamente
            success: function(data){
              alertify.success("Imagen agregada correctamente");
              $("#"+divresul+"").html("Imagen agregada correctamente");
                    
            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error("ha ocurrido un error") ;
                
            }
        });
    });
</script>
<div style="display: none;" id="cargador_empresa" align="center">
            <br>
         

         <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>

         <img src="images/cargando.gif" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Realizando tarea solicitada ...</label>

          <br>
         <hr style="color:#003" width="50%">
         <br>
       </div>

	
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
			<font size="6">CATEGORIA</font>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		  <a class='btn btn-success fa fa-plus' data-toggle="modal" data-target="#ModalCrearNuevo"> Agregar</a>
		</div>

      
<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="myTable">
					<thead>
						<th><center>Foto</center></th>
						<th><center>NOMBRE</center></th>
						<th><center>ESTADO</center></th>
						<th><center>PEDIDO</center></th>
						<th><center>...</center></th>				
					</thead>

					<tbody align="center" id="body_categoria">					
					@foreach($categoria as $usr)
					<tr>
						<td>
							<a href="../storage/{{$usr->direccion_imagen}}"  target="_blank"><img  src="../storage/{{$usr->direccion_imagen}}"   width="100px" height="100px"  class="img-thumbnail"></a> 
						</td>
						<td>{{ $usr->nombre}}</td>
						<td>@if($usr->estado==1)
							<i class="fa fa-circle  fa-red" style="color:green;" aria-hidden="true"></i>
							@else
							<i class="fa fa-circle  " style="color:red;" aria-hidden="true"></i>
							@endif
						</td>
						<td>@if($usr->estado_pedido==1)
							<label style="color: green;">REALIZA</label>
							@else
							<label style="color: red;">NO REALIZA</label>
							@endif
						</td>
						<td>
						<BUTTON class='btn btn-success fa fa-eye ' data-toggle="modal" onclick="cargar_categoria({{$usr->id}});" data-target="#ModalEditar"> </BUTTON>
							</td>
							 
					</tr>
					@endforeach
					</tbody>

					<tbody align="center" id="body_conductor_2">
					</tbody>					
				</table>
				</div>

			</div>


		</div>
	</div>

   {!!Html::script('js/categoria_edit.js')!!}
@endsection
