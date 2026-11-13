@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
@include('tipo_producto.modal')



<script type="text/javascript">
	
	  //FOTO DE PERFIL

  $(document).on("submit",".formulario_tipo",function(e){
        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");

        if(nombreform=="f_subir_imagen_tipo" ){ var miurl="subir_imagen_tipo";  var divresul="notificacion_tipo"}
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
              alertify.success(@json(__('tipo_producto.imagen_agregada')));
              $("#"+divresul+"").html(@json(__('tipo_producto.imagen_agregada')));

            },
            //si ha ocurrido un error
            error: function(data){
               alertify.error(@json(__('tipo_producto.ha_ocurrido_error'))) ;
                
            }
        });
    });
</script>

<div style="display: none;" id="cargador_empresa" align="center">
            <br>
         

         <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;{{ __('tipo_producto.espere') }} &nbsp;&nbsp;&nbsp;</label>

         <img src="images/cargando.gif" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">{{ __('tipo_producto.realizando_tarea') }}</label>

          <br>
         <hr style="color:#003" width="50%">
         <br>
       </div>



    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <font size="6">{{ __('tipo_producto.categoria_titulo') }}</font>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" align="right">
                    <a class='btn btn-primary' href='categoria_imprimir'><i class="fa fa-print"></i>
                        {{ __('tipo_producto.imprimir') }}</a>

                    <a class='btn btn-success ' data-toggle="modal" data-target="#ModalCrearNuevo"> <i
                            class="fa fa-plus"></i>{{ __('tipo_producto.agregar') }}</a>
                </div>


<div class="panel-body">
    <div class="table-responsive" style="overflow-x:inherit">
				<table class="table table-striped table-bordered table-condensed table-hover" style="background: white" id="tabla_sin_imprimir">
					<thead>
						<th><center>{{ __('tipo_producto.col_id') }}</center></th>
						<th><center>{{ __('tipo_producto.col_nombre') }}</center></th>
						<th><center>{{ __('tipo_producto.col_estado') }}</center></th>
						<th><center>...</center></th>
						
					</thead>

					<tbody align="center" id="body_tipo_producto">					
					@foreach($tipo_producto as $usr)
					<tr>
						<td>{{ $usr->id}}</td> 
						<td>{{ $usr->nombre}}</td>
						<td>@if($usr->estado==1)
							<i class="fa fa-circle  fa-red" style="color:green;" aria-hidden="true"></i>
							@else
							<i class="fa fa-circle  " style="color:red;" aria-hidden="true"></i>
							@endif
						</td>
						 
						<td>
						<BUTTON class='btn btn-success fa fa-edit ' data-toggle="modal" onclick="cargar_tipo_producto({{$usr->id}});" data-target="#ModalEditar"> </BUTTON>
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
 
   <script src="{{ asset('js/categoria_edit.js') }}"></script>
@endsection
