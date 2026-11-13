
    <!-- Modal ABRIR CAJA -->
    <div id="ModalAbrirCaja" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header" style="background: #3c8dbc;; color: white">
                    <h3 class="modal-title">{{ __('caja.abrir_caja_titulo') }}</h3>
                </div>
                <input id="estado_caja_abrir" value=""  type="hidden"/>

                <div class="modal-body">


                    <form action="{{ route('caja.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="monto_abrir_bk" id="monto_abrir_bk"  value="0">
                        <input type="hidden" name="monto_abrir_qr_bk" id="monto_abrir_qr_bk"  value="0">
                        <input type="hidden" name="id_caja_padre" id="id_caja_padre"  value="0">
                        <div class="form-group">
                            {{ __('caja.caja_label') }}
                            <select name="caja" class="form-control selectpicker text-uppercase" id="caja" onchange="cargarCajaMonto();">
                                @foreach ($cajas_disponibles as $caja)
                                <option value="{{ $caja->descripcion }}">{{ $caja->descripcion }}</option>
                                @endforeach
                            </select>

                        </div>


                        <div class="form-group">
                            {{ __('caja.monto_abrir_efectivo') }}
                            <input type="decimal" name="monto_abrir" id="monto_abrir" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            {{ __('caja.monto_abrir_qr') }}
                            <input type="decimal" name="monto_abrir_qr" id="monto_abrir_qr" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            {{ __('caja.nota_abrir') }}
                            <input type="decimal" name="nota_abrir"  class="form-control" value="">
                        </div>

                    </div>
                </div>



                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="btn_actualizar"
                        onclick="btn_esconder()">
                        {{ __('caja.abrir_caja_titulo') }}
                    </button>

                    </form>

                    <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
                    <button data-dismiss="modal" class="btn btn-danger">{{ __('caja.cancelar') }}</button>
                </div>
            </div>
        </div>
    </div>



    
<!-- Modal -->
<div id="ModalCierreCaja2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header" style="background:  red; color: white">
                <h3 class="modal-title">{{ __('caja.cerrar_caja_titulo') }}</h3>
            </div>

          
            <form 
                action="{{ route('caja.update', ['caja' => 'null']) }}" 
                method="POST" 
                enctype="multipart/form-data" 
                name="formulario_actualizar" 
                onkeypress="if(event.keyCode == 13) event.returnValue = false;">
                
                @csrf
                @method('PUT')
            <div class="modal-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 

                    
                   
                        <input type="hidden" name="id" id="idCaja">
 

                        <div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="cajaCierre">{{ __('caja.caja_label') }}</label>
                                <input type="text" name="caja" id="cajaCierre" class="form-control" placeholder="" value="{{ old('caja') }}">
                            </div>

                            <div class="form-group">
                                <label for="usuario">{{ __('caja.usuario_label') }}</label>
                                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="{{ __('caja.placeholder_tipo_producto') }}" value="{{ old('usuario', 0) }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="fechaAbrir">{{ __('caja.fecha_abierta') }}</label>
                                <input type="text" name="fechaAbrir" id="fechaAbrir" class="form-control" value="{{ old('fechaAbrir', 0) }}">
                            </div>

                                <div class="form-group">
                                    <label for="montoAbrir">{{ __('caja.monto_abrir_efectivo') }}</label>
                                    <input type="number" step="0.01" value="0" id="montoAbrir" name="monto_abrir" class="form-control"
                                        style="border-color: #10f908; box-shadow: none;" readonly />
                                </div>

                                <div class="form-group">
                                    <label for="montoAbrirQr">{{ __('caja.monto_abrir_qr') }}</label>
                                    <input type="number" step="0.01" value="0" id="montoAbrirQr" name="monto_abrir_qr" class="form-control"
                                        style="border-color: #10f908; box-shadow: none;" readonly />
                                </div>



                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="montoCierre">{{ __('caja.monto_cerrar_efectivo') }}</label>
                                <input type="number" step="0.01" value="0" id="montoCierre" name="monto_cierre"
                                    style="border-color: #f9b908; box-shadow: none;" class="form-control" onchange="calcularMontoCierre();" />
                            </div>

                            <div class="form-group">
                                <label for="montoCierreQr">{{ __('caja.monto_cerrar_qr') }}</label>
                                <input type="number" step="0.01" value="0" id="montoCierreQr" name="monto_cierre_qr"
                                    class="form-control" onchange="calcularMontoCierre();" />
                            </div>

                            <div class="form-group">
                                <label for="montoCierreTotal">{{ __('caja.monto_cerrar_total') }}</label>
                                <input type="number" step="0.01" value="0" id="montoCierreTotal" name="monto_cierre_total"
                                    style="border-color: #f9b908; box-shadow: none;" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="notaAbrir">{{ __('caja.nota_abrir') }}</label>
                                <input type="text" value="" id="notaAbrir" name="nota_abrir" class="form-control" readonly />
                            </div>

                            <div class="form-group">
                                <label for="notaCerrar">{{ __('caja.nota_cerrar') }}</label>
                                <input type="text" value="" id="notaCerrar" name="nota_cierre" class="form-control" />
                            </div>
                        </div>


                        
                      

                      

                        
                        
                       
                       
                </div>
            </div>


            <div class="modal-footer">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <button type="submit"
                        class="btn btn-success"
                        id="btn_actualizar"
                        onclick="btn_esconder()">
                        {{ __('caja.cerrar_caja_titulo') }}
                    </button>

                    </form>
                    <!--button class="btn btn-primary"  onclick="crearalimento()" id="btnregistrar">REGISTRAR</button-->
                    <button data-dismiss="modal" class="btn btn-danger">{{ __('caja.cancelar') }}</button>
 
                </div>
            </div>
        </div>
    </div>
</div>
