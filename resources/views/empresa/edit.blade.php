@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')








    <style>
        /* Always set the map height explicitly to define the size of the div
                   * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 300px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        .pac-container {
            font-family: Roboto;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

        #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #target {
            width: 345px;
        }
    </style>

    <style type="text/css">
        .li {
            float: left;
        }
    </style>

    <style type="text/css">
        /* ==== Rediseño formulario Empresa ==== */
        .empresa-edit {
            --ee-primary: #e0521d;        /* rojo-anaranjado (paleta restaurante) */
            --ee-primary-dark: #b53f12;
            --ee-accent: #f9a825;         /* amarillo */
            --ee-bg: #fbf6f2;
            --ee-border: #ecdfd6;
            --ee-text: #3a2c24;
            --ee-muted: #927c6e;
            font-size: 14px;
            color: var(--ee-text);
        }

        .empresa-edit * { box-sizing: border-box; }

        .ee-header {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 22px 26px;
            border-radius: 14px;
            background: linear-gradient(135deg, #c62828 0%, #ef6c00 55%, #f9a825 100%);
            color: #fff;
            box-shadow: 0 10px 25px -12px rgba(198, 40, 40, .55);
            margin-bottom: 22px;
        }

        .ee-header__icon {
            flex: 0 0 auto;
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .ee-header__info { flex: 1 1 auto; min-width: 0; }
        .ee-header__title { margin: 0; font-size: 20px; font-weight: 700; letter-spacing: .3px; }
        .ee-header__sub {
            margin: 4px 0 0;
            font-size: 13px;
            color: rgba(255, 255, 255, .82);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ee-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(255, 255, 255, .18);
            color: #fff;
        }
        .ee-badge .fa { font-size: 9px; }
        .ee-badge--on .fa { color: #48ffa8; }
        .ee-badge--off .fa { color: #ff9a9a; }

        .ee-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
            align-items: start;
        }

        .ee-card {
            grid-column: span 6;
            background: #fff;
            border: 1px solid var(--ee-border);
            border-radius: 14px;
            box-shadow: 0 4px 16px -10px rgba(45, 55, 72, .25);
            overflow: hidden;
        }
        .ee-card--full { grid-column: span 12; }

        @media (max-width: 991px) {
            .ee-card, .ee-card--full { grid-column: span 12; }
        }

        .ee-card__head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--ee-border);
            background: #fbfcfe;
        }
        .ee-card__head .fa {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: rgba(224, 82, 29, .1);
            color: var(--ee-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .ee-card__head h4 { margin: 0; font-size: 15px; font-weight: 700; }

        .ee-card__body { padding: 18px; }

        .ee-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px 16px;
        }
        .ee-fields .form-group { margin-bottom: 0; }
        .ee-fields .ee-col-2 { grid-column: span 2; }
        @media (max-width: 575px) {
            .ee-fields { grid-template-columns: 1fr; }
            .ee-fields .ee-col-2 { grid-column: span 1; }
        }

        .empresa-edit .form-group > label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--ee-muted);
            margin-bottom: 5px;
        }

        .empresa-edit .form-control {
            height: 40px;
            border-radius: 9px;
            border: 1px solid var(--ee-border);
            box-shadow: none;
            transition: border-color .15s, box-shadow .15s;
            background: #fff;
        }
        .empresa-edit textarea.form-control { height: auto; min-height: 80px; }
        .empresa-edit .form-control:focus {
            border-color: var(--ee-primary);
            box-shadow: 0 0 0 3px rgba(224, 82, 29, .15);
        }

        /* Media (logo / banner) */
        .ee-media {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }
        @media (max-width: 767px) { .ee-media { grid-template-columns: 1fr; } }

        .ee-media__box {
            border: 1px solid var(--ee-border);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            background: #fbfcfe;
        }
        .ee-media__box h5 {
            margin: 0 0 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--ee-muted);
        }
        .ee-media__preview {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 130px;
            background: #fff;
            border: 1px dashed #cbd5e0;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 12px;
        }
        .ee-media__preview img { max-width: 100%; max-height: 150px; border-radius: 8px; }

        .ee-upload {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 9px;
            background: var(--ee-primary);
            color: #fff;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: background .15s;
        }
        .ee-upload:hover { background: var(--ee-primary-dark); }
        .ee-upload input[type="file"] {
            position: absolute;
            width: 1px; height: 1px;
            opacity: 0; overflow: hidden;
        }

        /* Barra de acciones */
        .ee-actions {
            position: sticky;
            bottom: 0;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 22px;
            padding: 16px 18px;
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(6px);
            border: 1px solid var(--ee-border);
            border-radius: 14px;
            box-shadow: 0 -6px 20px -14px rgba(45, 55, 72, .4);
        }
        .ee-actions .btn {
            min-width: 140px;
            height: 42px;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .ee-actions .btn-primary { background: var(--ee-primary); border-color: var(--ee-primary); }
        .ee-actions .btn-primary:hover { background: var(--ee-primary-dark); border-color: var(--ee-primary-dark); }

        .ee-hint { font-size: 11px; color: var(--ee-muted); margin-top: 4px; }
        #nit_verificar { display: block; font-size: 11px; margin-top: 4px; }

        /* Switch on/off */
        .ee-switch {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            margin: 0;
            font-weight: 600;
            color: var(--ee-text);
            user-select: none;
        }
        .ee-switch input { position: absolute; opacity: 0; width: 0; height: 0; }
        .ee-switch__track {
            position: relative;
            flex: 0 0 auto;
            width: 46px;
            height: 26px;
            border-radius: 999px;
            background: #d7cbc2;
            transition: background .18s;
        }
        .ee-switch__track::after {
            content: "";
            position: absolute;
            top: 3px; left: 3px;
            width: 20px; height: 20px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
            transition: transform .18s;
        }
        .ee-switch input:checked + .ee-switch__track { background: var(--ee-primary); }
        .ee-switch input:checked + .ee-switch__track::after { transform: translateX(20px); }
        .ee-switch input:focus + .ee-switch__track { box-shadow: 0 0 0 3px rgba(224, 82, 29, .2); }

        .ee-token-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 12px;
            background: #f4ece5;
            color: var(--ee-muted);
        }
        .ee-token-status.is-active {
            background: rgba(56, 142, 60, .12);
            color: #2e7d32;
        }
    </style>


    <script src="range-slider.js"></script>
    <script>
        (function() {
            var selector = '[data-rangeSlider]',
                elements = document.querySelectorAll(selector);
            // Example functionality to demonstrate a value feedback
            function valueOutput(element) {
                var value = element.value,
                    output = element.parentNode.getElementsByTagName('output')[0];
                output.innerHTML = value;
            }
            for (var i = elements.length - 1; i >= 0; i--) {
                valueOutput(elements[i]);
            }
            Array.prototype.slice.call(document.querySelectorAll('input[type="range"]')).forEach(function(el) {
                el.addEventListener('input', function(e) {
                    valueOutput(e.target);
                }, false);
            });
            // Example functionality to demonstrate disabled functionality
            var toggleBtnDisable = document.querySelector('#js-example-disabled button[data-behaviour="toggle"]');
            toggleBtnDisable.addEventListener('click', function(e) {
                var inputRange = toggleBtnDisable.parentNode.querySelector('input[type="range"]');
                console.log(inputRange);
                if (inputRange.disabled) {
                    inputRange.disabled = false;
                } else {
                    inputRange.disabled = true;
                }
                inputRange.rangeSlider.update();
            }, false);
            // Example functionality to demonstrate programmatic value changes
            var changeValBtn = document.querySelector('#js-example-change-value button');
            changeValBtn.addEventListener('click', function(e) {
                var inputRange = changeValBtn.parentNode.querySelector('input[type="range"]'),
                    value = changeValBtn.parentNode.querySelector('input[type="number"]').value,
                    event = document.createEvent('Event');
                event.initEvent('change', true, true);
                inputRange.value = value;
                inputRange.dispatchEvent(event);
            }, false);
            // Example functionality to demonstrate programmatic buffer set
            var stBufferBtn = document.querySelector('#js-example-buffer-set button');
            stBufferBtn.addEventListener('click', function(e) {
                var inputRange = stBufferBtn.parentNode.querySelector('input[type="range"]'),
                    value = stBufferBtn.parentNode.querySelector('input[type="number"]').value;
                inputRange.rangeSlider.update({
                    buffer: value
                });
            }, false);
            // Example functionality to demonstrate destroy functionality
            var destroyBtn = document.querySelector('#js-example-destroy button[data-behaviour="destroy"]');
            destroyBtn.addEventListener('click', function(e) {
                var inputRange = destroyBtn.parentNode.querySelector('input[type="range"]');
                console.log(inputRange);
                inputRange.rangeSlider.destroy();
            }, false);
            var initBtn = document.querySelector('#js-example-destroy button[data-behaviour="initialize"]');
            initBtn.addEventListener('click', function(e) {
                var inputRange = initBtn.parentNode.querySelector('input[type="range"]');
                rangeSlider.create(inputRange, {});
            }, false);
            //update range
            var updateBtn1 = document.querySelector('#js-example-update-range button');
            updateBtn1.addEventListener('click', function(e) {
                var inputRange = updateBtn1.parentNode.querySelector('input[type="range"]');
                inputRange.rangeSlider.update({
                    min: 0,
                    max: 20,
                    step: 0.5,
                    value: 1.5,
                    buffer: 70
                });
            }, false);
            var toggleBtn = document.querySelector('#js-example-hidden button[data-behaviour="toggle"]');
            toggleBtn.addEventListener('click', function(e) {
                var container = e.target.previousElementSibling;
                if (container.style.cssText.match(/display[\s:]{1,3}none/)) {
                    container.style.cssText = '';
                } else {
                    container.style.cssText = 'display: none;';
                }
            }, false);
            // Basic rangeSlider initialization
            rangeSlider.create(elements, {
                // Callback function
                onInit: function() {},
                // Callback function
                onSlideStart: function(value, percent, position) {
                    console.info('onSlideStart', 'value: ' + value, 'percent: ' + percent, 'position: ' +
                        position);
                },
                // Callback function
                onSlide: function(value, percent, position) {
                    console.log('onSlide', 'value: ' + value, 'percent: ' + percent, 'position: ' +
                        position);
                },
                // Callback function
                onSlideEnd: function(value, percent, position) {
                    console.warn('onSlideEnd', 'value: ' + value, 'percent: ' + percent, 'position: ' +
                        position);
                }
            });
            rangeSlider.create(document.querySelector('#vertical'), {
                vertical: true
            });
        })();
    </script>


    <script type="text/javascript">
        $(document).on("submit", ".formulario_constitucion", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_constitucion") {
                var miurl = "subir_imagen_constitucion";
                var divresul = "notificacion_constitucion"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_constitucion').html(
                        '<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_constitucion").attr('src', $("#fotografia_constitucion").attr(
                        'src') + '?' + Math.random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_representante", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_representante") {
                var miurl = "subir_imagen_representante";
                var divresul = "notificacion_representante"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_representante').html(
                        '<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_representante").attr('src', $("#fotografia_representante").attr(
                        'src') + '?' + Math.random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_fundaempresa", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_fundaempresa") {
                var miurl = "subir_imagen_fundaempresa";
                var divresul = "notificacion_fundaempresa"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_fundaempresa').html(
                        '<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_fundaempresa").attr('src', $("#fotografia_fundaempresa").attr(
                        'src') + '?' + Math.random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_ci_representante", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_ci_representante") {
                var miurl = "subir_imagen_ci_representante";
                var divresul = "notificacion_ci_representante"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_ci_representante').html(
                        '<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_ci_representante").attr('src', $("#fotografia_ci_representante")
                        .attr('src') + '?' + Math.random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_licencia_gmlp", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_licencia_gmlp") {
                var miurl = "subir_imagen_licencia_gmlp";
                var divresul = "notificacion_licencia_gmlp"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_licencia_gmlp').html(
                        '<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_licenci_gmlp").attr('src', $("#fotografia_licenci_gmlp").attr(
                        'src') + '?' + Math.random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_nit", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_nit") {
                var miurl = "subir_imagen_nit";
                var divresul = "notificacion_nit"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_nit').html('<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_nit").attr('src', $("#fotografia_nit").attr('src') + '?' + Math
                        .random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_att", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_att") {
                var miurl = "subir_imagen_att";
                var divresul = "notificacion_att"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_att').html('<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_att").attr('src', $("#fotografia_att").attr('src') + '?' + Math
                        .random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_factura_luz", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_factura_luz") {
                var miurl = "subir_imagen_factura_luz";
                var divresul = "notificacion_factura_luz"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_factura_luz').html(
                        '<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_factura_luz").attr('src', $("#fotografia_factura_luz").attr('src') +
                        '?' + Math.random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_senapi", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_senapi") {
                var miurl = "subir_imagen_senapi";
                var divresul = "notificacion_senapi"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_senapi').html('<img src="' +
                            data + '" alt="" class="img-rounded img-thumbnail"  width="150px" />')
                        .addClass('success');
                    $("#fotografia_senapi").attr('src', $("#fotografia_senapi").attr('src') + '?' + Math
                        .random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });

        $(document).on("submit", ".formulario_corporativa", function(e) {
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if (nombreform == "f_subir_imagen_corporativa") {
                var miurl = "subir_imagen_corporativa";
                var divresul = "notificacion_corporativa"
            }
            //información del formulario
            var formData = new FormData($("#" + nombreform + "")[0]);

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
                beforeSend: function() {
                    $("#" + divresul + "").html($("#cargador_empresa").html());
                },
                //una vez finalizado correctamente
                success: function(data) {
                    alertify.success("Imagen agregada correctamente");
                    $("#" + divresul + "").html("Imagen agregada correctamente");
                    $('<li class="dropdown li"></li>').appendTo('#lista_corporativa').html(
                        '<img src="' + data +
                        '" alt="" class="img-rounded img-thumbnail"  width="150px" />').addClass(
                        'success');
                    $("#fotografia_corporativa").attr('src', $("#fotografia_corporativa").attr('src') +
                        '?' + Math.random());
                },
                //si ha ocurrido un error
                error: function(data) {
                    alertify.error("ha ocurrido un error");

                }
            });
        });
    </script>


    <div style="display: none;" id="cargador_empresa" align="center">
        <br>

        <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere...
            &nbsp;&nbsp;&nbsp;</label>

        <img src="../../images/cargando.gif" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Realizando tarea
            solicitada ...</label>

        <br>
        <hr style="color:#003" width="50%">
        <br>
    </div>

    <div class="row empresa-edit">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form method="POST" action="{{ route('empresa.update', $empresa[0]->id) }}" enctype="multipart/form-data" onkeypress="if(event.keyCode == 13) event.returnValue = false;">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_empresa" id="id_empresa" value="{{ $empresa[0]->id }}">

            <div class="ee-header">
                <div class="ee-header__icon"><i class="fa fa-building"></i></div>
                <div class="ee-header__info">
                    <h3 class="ee-header__title">{{ __('empresa.actualizar_empresa') }}</h3>
                    <p class="ee-header__sub">
                        {{ $empresa[0]->razon_social }}
                        @if(!empty($empresa[0]->nit)) &nbsp;·&nbsp; {{ __('empresa.nit') }} {{ $empresa[0]->nit }} @endif
                    </p>
                </div>
                @if($empresa[0]->estado == 1)
                    <span class="ee-badge ee-badge--on"><i class="fa fa-circle"></i> {{ __('empresa.activo') }}</span>
                @else
                    <span class="ee-badge ee-badge--off"><i class="fa fa-circle"></i> {{ __('empresa.inactivo') }}</span>
                @endif
            </div>

            {{-- Campos ocultos que se mantienen para el submit --}}
            <div hidden>
                <input type="text" name="estado" id="estado" value="{{ old('estado', $empresa[0]->estado) }}">
                <input type="text" name="credito" id="credito" value="1000">
                <input type="text" name="password" id="password" value="{{ old('password') }}">
                <input type="text" name="municipio" id="municipio" value="{{ old('municipio') }}">
            </div>

            <div class="ee-grid">

                {{-- ===== Datos Generales ===== --}}
                <div class="ee-card">
                    <div class="ee-card__head"><i class="fa fa-info-circle"></i><h4>{{ __('empresa.datos_generales') }}</h4></div>
                    <div class="ee-card__body">
                        <div class="ee-fields">
                            <div class="form-group">
                                <label for="nit">{{ __('empresa.nit') }}</label>
                                <input type="text" name="nit" id="nit" class="form-control" placeholder="{{ __('empresa.nit_placeholder') }}" maxlength="50" onkeyup="controlar()" onkeypress="return bloqueo_de_punto(event)" value="{{ old('nit', $empresa[0]->nit) }}">
                                <label id="nit_verificar" hidden style="color:#e53e3e">{{ __('empresa.nit_existe') }}</label>
                            </div>
                            <div class="form-group">
                                <label for="tipo">{{ __('empresa.tipo') }}</label>
                                <input type="text" name="tipo" id="tipo" class="form-control" placeholder="{{ __('empresa.tipo_placeholder') }}" maxlength="50" value="{{ old('tipo', $empresa[0]->tipo) }}">
                            </div>
                            <div class="form-group ee-col-2">
                                <label for="razon_social">{{ __('empresa.razon_social') }}</label>
                                <input type="text" name="razon_social" id="razon_social" class="form-control" placeholder="{{ __('empresa.razon_social_placeholder') }}" maxlength="50" value="{{ old('razon_social', $empresa[0]->razon_social) }}">
                            </div>
                            <div class="form-group ee-col-2">
                                <label for="whatsapp">{{ __('empresa.telefono_whatsapp') }}</label>
                                <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="{{ __('empresa.telefono_whatsapp_placeholder') }}" maxlength="15" value="{{ old('whatsapp', $empresa[0]->whatsapp) }}">
                            </div>
                            <div class="form-group ee-col-2">
                                <label for="direccion">{{ __('empresa.direccion') }}</label>
                                <textarea name="direccion" id="direccion" class="form-control" placeholder="{{ __('empresa.direccion_placeholder') }}" style="height:90px;">{{ old('direccion', $empresa[0]->direccion) }}</textarea>
                                <input type="hidden" name="latitud" value="{{ old('latitud') }}">
                                <input type="hidden" name="longitud" value="{{ old('longitud') }}">
                            </div>
                            <div class="form-group">
                                <label for="idioma">{{ __('empresa.idioma_label') }}</label>
                                @php $idiomaActual = old('idioma', $empresa[0]->idioma ?? 'es'); @endphp
                                <select name="idioma" id="idioma" class="form-control">
                                    <option value="es" {{ $idiomaActual == 'es' ? 'selected' : '' }}>Español</option>
                                    <option value="en" {{ $idiomaActual == 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Impresoras ===== --}}
                <div class="ee-card">
                    <div class="ee-card__head"><i class="fa fa-print"></i><h4>{{ __('empresa.config_impresoras') }}</h4></div>
                    <div class="ee-card__body">
                        <div class="ee-fields">
                            <div class="form-group">
                                <label for="servidor_impresora1">{{ __('empresa.servidor_impresora_1') }}</label>
                                <input type="text" name="servidor_impresora1" id="servidor_impresora1" class="form-control" placeholder="{{ __('empresa.servidor_1_placeholder') }}" value="{{ old('servidor_impresora1', $empresa[0]->servidor_impresora1) }}">
                            </div>
                            <div class="form-group">
                                <label for="impresora1">{{ __('empresa.nombre_impresora_1') }}</label>
                                <input type="text" name="impresora1" id="impresora1" class="form-control" placeholder="{{ __('empresa.impresora_1_placeholder') }}" value="{{ old('impresora1', $empresa[0]->impresora1) }}">
                            </div>
                            <div class="form-group">
                                <label for="servidor_impresora2">{{ __('empresa.servidor_impresora_2') }}</label>
                                <input type="text" name="servidor_impresora2" id="servidor_impresora2" class="form-control" placeholder="{{ __('empresa.servidor_2_placeholder') }}" value="{{ old('servidor_impresora2', $empresa[0]->servidor_impresora2) }}">
                            </div>
                            <div class="form-group">
                                <label for="impresora2">{{ __('empresa.nombre_impresora_2') }}</label>
                                <input type="text" name="impresora2" id="impresora2" class="form-control" placeholder="{{ __('empresa.impresora_2_placeholder') }}" value="{{ old('impresora2', $empresa[0]->impresora2) }}">
                            </div>
                            <div class="form-group">
                                <label for="impresora_nota_venta">{{ __('empresa.impresora_nota_venta') }}</label>
                                <input type="text" name="impresora_nota_venta" id="impresora_nota_venta" class="form-control" placeholder="{{ __('empresa.impresora_nota_venta_placeholder') }}" value="{{ old('impresora_nota_venta', $empresa[0]->impresora_nota_venta) }}">
                            </div>
                            <div class="form-group">
                                <label for="impresora_factura">{{ __('empresa.impresora_factura') }}</label>
                                <input type="text" name="impresora_factura" id="impresora_factura" class="form-control" placeholder="{{ __('empresa.impresora_factura_placeholder') }}" value="{{ old('impresora_factura', $empresa[0]->impresora_factura) }}">
                            </div>
                            <div class="form-group ee-col-2">
                                <label for="comentario_recibo">{{ __('empresa.comentario_recibo') }}</label>
                                <input type="text" name="comentario_recibo" id="comentario_recibo" class="form-control" placeholder="{{ __('empresa.comentario_recibo_placeholder') }}" value="{{ old('comentario_recibo', $empresa[0]->comentario_recibo) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Facturación (SIN) ===== --}}
                <div class="ee-card" @if($empresa[0]->con_factura == 0) hidden @endif>
                    <div class="ee-card__head"><i class="fa fa-file-text-o"></i><h4>{{ __('empresa.facturacion_sin') }}</h4></div>
                    <div class="ee-card__body">
                        <div class="ee-fields">
                            <div class="form-group">
                                <label for="actividad_economica">{{ __('empresa.actividad_economica') }}</label>
                                <input type="text" name="actividad_economica" id="actividad_economica" class="form-control" placeholder="{{ __('empresa.actividad_economica_placeholder') }}" value="{{ old('actividad_economica') }}">
                            </div>
                            <div class="form-group">
                                <label for="codigo_sistema">{{ __('empresa.codigo_sistema') }}</label>
                                <input type="text" name="codigo_sistema" id="codigo_sistema" class="form-control" placeholder="{{ __('empresa.codigo_sistema_placeholder') }}" value="{{ old('codigo_sistema') }}">
                            </div>
                            <div class="form-group">
                                <label for="modalidad_sin">{{ __('empresa.modalidad') }}</label>
                                <input type="text" name="modalidad_sin" id="modalidad_sin" class="form-control" placeholder="{{ __('empresa.modalidad') }}" value="{{ old('modalidad_sin') }}">
                            </div>
                            <div class="form-group">
                                <label for="tipo_emision_sin">{{ __('empresa.tipo_emision') }}</label>
                                <input type="text" name="tipo_emision_sin" id="tipo_emision_sin" class="form-control" placeholder="{{ __('empresa.tipo_emision_placeholder') }}" value="{{ old('tipo_emision_sin') }}">
                            </div>
                            <div class="form-group">
                                <label for="tipo_factura_sin">{{ __('empresa.tipo_factura') }}</label>
                                <input type="text" name="tipo_factura_sin" id="tipo_factura_sin" class="form-control" placeholder="{{ __('empresa.tipo_factura_placeholder') }}" value="{{ old('tipo_factura_sin') }}">
                            </div>
                            <div class="form-group">
                                <label for="tipo_documento_sector_sin">{{ __('empresa.tipo_documento_sector') }}</label>
                                <input type="text" name="tipo_documento_sector_sin" id="tipo_documento_sector_sin" class="form-control" placeholder="{{ __('empresa.tipo_documento_sector_placeholder') }}" value="{{ old('tipo_documento_sector_sin') }}">
                            </div>
                            <div class="form-group">
                                <label for="codigo_ambiente">{{ __('empresa.codigo_ambiente') }}</label>
                                <input type="text" name="codigo_ambiente" id="codigo_ambiente" class="form-control" placeholder="{{ __('empresa.codigo_ambiente_placeholder') }}" value="{{ old('codigo_ambiente') }}">
                            </div>
                            <div class="form-group" @if(Auth::user()->tipo_empresa == "RESTAURANTE") hidden @endif>
                                <label for="token_sin">{{ __('empresa.token_sin') }}</label>
                                <textarea name="token_sin" id="token_sin" class="form-control" placeholder="{{ __('empresa.token_sin_placeholder') }}" style="height:70px;">{{ old('token_sin') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Identidad Visual ===== --}}
                <div class="ee-card">
                    <div class="ee-card__head"><i class="fa fa-picture-o"></i><h4>{{ __('empresa.identidad_visual') }}</h4></div>
                    <div class="ee-card__body">
                        <div class="ee-media">
                            <div class="ee-media__box">
                                <h5>{{ __('empresa.logo') }}</h5>
                                <div class="ee-media__preview">
                                    <output id="list"></output>
                                    <img src="{{ !empty($empresa[0]->direccion_logo) ? asset($empresa[0]->direccion_logo) : asset('images/empresa_default.svg') }}" name="logo" id="foto_logo" class="img-thumbnail" style="border:0;padding:0;background:transparent;" onerror="this.onerror=null;this.src='{{ asset('images/empresa_default.svg') }}';">
                                </div>
                                <label class="ee-upload"><i class="fa fa-upload"></i> {{ __('empresa.cambiar_logo') }}
                                    <input type="file" name="logo" id="logo" accept="image/*">
                                </label>
                                <input type="hidden" name="direccion_logo" value="{{ $empresa[0]->direccion_logo }}">
                                <div class="ee-hint">{{ __('empresa.logo_hint') }}</div>
                            </div>
                            <div class="ee-media__box">
                                <h5>{{ __('empresa.banner') }}</h5>
                                <div class="ee-media__preview">
                                    <output id="listBaner"></output>
                                    @if ($empresa[0]->direccion_baner != "")
                                        <img src="{{ asset($empresa[0]->direccion_baner) }}" name="baner" id="foto_baner" class="img-thumbnail" style="border:0;padding:0;background:transparent;">
                                    @else
                                        <span style="color:#a0aec0;font-size:12px;">{{ __('empresa.sin_banner') }}</span>
                                        <img src="" name="baner" id="foto_baner" style="display:none;">
                                    @endif
                                </div>
                                <label class="ee-upload"><i class="fa fa-upload"></i> {{ __('empresa.cambiar_banner') }}
                                    <input type="file" name="baner" id="baner" accept="image/*">
                                </label>
                                <input type="hidden" name="direccion_baner" value="{{ $empresa[0]->direccion_baner }}">
                                <div class="ee-hint">{{ __('empresa.banner_hint') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Pago QR - Banco FIE ===== --}}
                @php
                    $qrOn        = old('pago_qr_bancofie', ($empresa[0]->pago_qr_bancofie ?? 0)) == 1;
                    $tieneClave  = !empty($empresa[0]->bancofie_password ?? null);
                    $tokenActivo = !empty($empresa[0]->bancofie_token ?? null);
                @endphp
                <div class="ee-card ee-card--full">
                    <div class="ee-card__head"><i class="fa fa-qrcode"></i><h4>{!! __('empresa.pago_qr_bancofie') !!}</h4></div>
                    <div class="ee-card__body">
                        <label class="ee-switch">
                            <input type="hidden" name="pago_qr_bancofie" value="0">
                            <input type="checkbox" name="pago_qr_bancofie" id="pago_qr_bancofie" value="1" {{ $qrOn ? 'checked' : '' }}>
                            <span class="ee-switch__track"></span>
                            <span class="ee-switch__label">{{ __('empresa.pago_qr_switch_label') }}</span>
                        </label>

                        <div id="bancofie_datos" class="ee-fields" style="margin-top:16px; {{ $qrOn ? '' : 'display:none;' }}">
                            <div class="form-group">
                                <label for="bancofie_usuario">{{ __('empresa.bancofie_usuario') }}</label>
                                <input type="text" name="bancofie_usuario" id="bancofie_usuario" class="form-control" autocomplete="off" placeholder="{{ __('empresa.bancofie_usuario_placeholder') }}" value="{{ old('bancofie_usuario', $empresa[0]->bancofie_usuario ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="bancofie_password">{{ __('empresa.bancofie_password') }}</label>
                                <input type="password" name="bancofie_password" id="bancofie_password" class="form-control" autocomplete="new-password" placeholder="{{ $tieneClave ? __('empresa.bancofie_password_placeholder_existing') : __('empresa.bancofie_password_placeholder_new') }}" value="">
                                <div class="ee-hint">
                                    <i class="fa fa-lock"></i>
                                    {{ __('empresa.bancofie_password_hint') }} @if($tieneClave) {{ __('empresa.bancofie_password_already_set') }} @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bancofie_id_servicio">{{ __('empresa.bancofie_id_servicio') }}</label>
                                <input type="number" name="bancofie_id_servicio" id="bancofie_id_servicio" class="form-control" placeholder="{{ __('empresa.bancofie_id_servicio_placeholder') }}" value="{{ old('bancofie_id_servicio', $empresa[0]->bancofie_id_servicio ?? '') }}">
                                <div class="ee-hint">{!! __('empresa.bancofie_id_servicio_hint') !!}</div>
                            </div>
                            <div class="form-group">
                                <label for="bancofie_callback">{{ __('empresa.bancofie_callback') }}</label>
                                <input type="text" name="bancofie_callback" id="bancofie_callback" class="form-control" placeholder="{{ __('empresa.bancofie_callback_placeholder') }}" value="{{ old('bancofie_callback', $empresa[0]->bancofie_callback ?? '') }}">
                            </div>
                            <div class="form-group ee-col-2">
                                <div class="ee-token-status {{ $tokenActivo ? 'is-active' : '' }}">
                                    <i class="fa {{ $tokenActivo ? 'fa-check-circle' : 'fa-clock-o' }}"></i>
                                    @if($tokenActivo)
                                        {{ __('empresa.bancofie_token_activo') }}
                                        @if(!empty($empresa[0]->bancofie_token_expira ?? null))
                                            &middot; {{ __('empresa.bancofie_token_expira') }} {{ $empresa[0]->bancofie_token_expira }}
                                        @endif
                                    @else
                                        {!! __('empresa.bancofie_sin_token') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /.ee-grid --}}


            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" hidden>


                <input type="hidden" name="id_fotocopia_constitucion_de_empresa" id="id_fotocopia_constitucion_de_empresa"
                    value=null>
                <input type="hidden" name="id_fotocopia_poder_del_representante_legal"
                    id="id_fotocopia_poder_del_representante_legal" value="">
                <input type="hidden" name="id_fotocopia_registro_fundaempresa" id="id_fotocopia_registro_fundaempresa"
                    value="">
                <input type="hidden" name="id_fotocopia_ci_del_representante_legal"
                    id="id_fotocopia_ci_del_representante_legal" value="">

                <input type="hidden" name="id_fotocopia_licencia_funcionamiento_gmlp"
                    id="id_fotocopia_licencia_funcionamiento_gmlp" value="">
                <input type="hidden" name="id_fotocopia_nit" id="id_fotocopia_nit" value="">
                <input type="hidden" name="id_fotocopia_resolucion_administrativa_att"
                    id="id_fotocopia_resolucion_administrativa_att" value="">
                <input type="hidden" name="id_fotocopia_factura_luz_agua_de_oficinas"
                    id="id_fotocopia_factura_luz_agua_de_oficinas" value="">
                <input type="hidden" name="id_imagen_corporativa" id="id_imagen_corporativa" value="">
                <input type="hidden" name="id_fotocopia_registro_senapi" id="id_fotocopia_registro_senapi"
                    value="">
                <input type="hidden" name="privilegio" id="privilegio" value="0">
                <div class="form-group" hidden>
    <label for="correo">correo:</label>
    <input type="text" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo" value="{{ old('correo') }}">
</div>

<div class="form-group" hidden>
    <label for="nro_registro_senapi">Nro Registro Senapi:</label>
    <input type="text" name="nro_registro_senapi" id="nro_registro_senapi" class="form-control" placeholder="Ingrese EL Nro Registro Senapi" value="{{ old('nro_registro_senapi') }}">
</div>

<div class="form-group" hidden>
    <label for="mision">Misión:</label>
    <textarea name="mision" id="mision" class="form-control" placeholder="Ingrese la Misión" style="height:100px;">{{ old('mision', $empresa[0]->mision) }}</textarea>
</div>

<div class="form-group" hidden>
    <label for="vision">Visión:</label>
    <textarea name="vision" id="vision" class="form-control" placeholder="Ingrese la Visión" style="height:100px;">{{ old('vision', $empresa[0]->vision) }}</textarea>
</div>

<div class="form-group" hidden>
    <label for="facebook">facebook:</label>
    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Ingrese su facebook" value="{{ old('facebook') }}">
</div>

<div class="form-group" hidden>
    <label for="nro_licencia_funcionamiento">nro_licencia_funcionamiento:</label>
    <input type="text" name="nro_licencia_funcionamiento" id="nro_licencia_funcionamiento" class="form-control" placeholder="Ingrese su nro_licencia_funcionamiento" onkeypress="return bloqueo_de_punto(event)" value="{{ old('nro_licencia_funcionamiento') }}">
</div>

<div class="form-group" hidden>
    <label for="nro_constitucion_de_empresa">Nro Constitucion De Empresa:</label>
    <input type="text" name="nro_constitucion_de_empresa" id="nro_constitucion_de_empresa" class="form-control" placeholder="Ingrese EL Nro Constitucion De Empresa" value="{{ old('nro_constitucion_de_empresa') }}">
</div>



            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

                <div class="form-group" hidden>
                    <label for="nro_poder_del_representante">Nro Poder Del Representante:</label>
                    <input type="text" name="nro_poder_del_representante" id="nro_poder_del_representante" class="form-control" placeholder="Ingrese EL Nro Poder Del Representante" value="{{ old('nro_poder_del_representante') }}">
                </div>

                <div class="form-group" hidden>
                    <label for="nro_registro_fundaempresa">Nro Registro Fundaempresa:</label>
                    <input type="text" name="nro_registro_fundaempresa" id="nro_registro_fundaempresa" class="form-control" placeholder="Ingrese EL Nro Registro Fundaempresa" value="{{ old('nro_registro_fundaempresa') }}">
                </div>

                <div class="form-group" hidden>
                    <label for="nro_resolucion_administrativa_att">Nro Resolucion Administrativa ATT:</label>
                    <input type="text" name="nro_resolucion_administrativa_att" id="nro_resolucion_administrativa_att" class="form-control" placeholder="Ingrese Nro Resolucion Administrativa ATT" value="{{ old('nro_resolucion_administrativa_att') }}">
                </div>

            </div>

            <div class="ee-actions">
                <a href="{{ url('/') }}" class="btn btn-danger"><i class="fa fa-times"></i> {{ __('empresa.cancelar') }}</a>
                <button type="submit" class="btn btn-primary" id="btn_registrar" onclick="btn_esconder()"><i class="fa fa-save"></i> {{ __('empresa.guardar_cambios') }}</button>
            </div>


            </form>



          <script src="js/empresa_actualizar.js"></script>

        </div>
    </div>

    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNTI7MFuYXiwGi3Opvcr8G3fJYE4ug4fc"></script>


    <script type="text/javascript">
        //CARGAR EL PERFIL DEL CONDUCTOR
        //CARGAR EL PERFIL DEL CONDUCTOR
        function archivo(evt) {
            var files = evt.target.files; // FileList object
            // Obtenemos la imagen del campo "file".
            for (var i = 0, f; f = files[i]; i++) {
                //Solo admitimos imágenes.
                if (!f.type.match('image.*')) {
                    continue;
                }

                var reader = new FileReader();

                reader.onload = (function(theFile) {
                    return function(e) {
                        // Insertamos la imagen
                        document.getElementById("list").innerHTML = [
                            '<img class="img-thumbnail img-responsive pull-left" src="', e.target.result,
                            '" title="', escape(theFile.name), '" width="200px" height="200px"/>'
                        ].join('');
                    };
                })(f);

                reader.readAsDataURL(f);
                $("#foto_logo").hide();
            }
        }

        function archivoBaner(evt) {
            var files = evt.target.files; // FileList object
            // Obtenemos la imagen del campo "file".
            for (var i = 0, f; f = files[i]; i++) {
                //Solo admitimos imágenes.
                if (!f.type.match('image.*')) {
                    continue;
                }

                var reader = new FileReader();

                reader.onload = (function(theFile) {
                    return function(e) {
                        // Insertamos la imagen
                        document.getElementById("listBaner").innerHTML = [
                            '<img class="img-thumbnail img-responsive pull-left" src="', e.target.result,
                            '" title="', escape(theFile.name), '" width="300px" height="200px"/>'
                        ].join('');
                    };
                })(f);

                reader.readAsDataURL(f);
                $("#foto_baner").hide();
            }
        }

        document.getElementById('logo').addEventListener('change', archivo, false);
        document.getElementById('baner').addEventListener('change', archivoBaner, false);

        // Pago QR - Banco FIE: mostrar/ocultar credenciales segun el switch
        (function() {
            var chk = document.getElementById('pago_qr_bancofie');
            var box = document.getElementById('bancofie_datos');
            if (chk && box) {
                chk.addEventListener('change', function() {
                    box.style.display = this.checked ? '' : 'none';
                });
            }
        })();
    </script>
@endsection
