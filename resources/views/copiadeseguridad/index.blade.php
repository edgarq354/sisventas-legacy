@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')
    @include('alerts.descargar_copia')








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

    <script type="text/javascript">
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>


    <script type="text/javascript">
        var loadFile_actualizar = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output_actualizar');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>


    </script>


    <div class="row">




        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


            <h3> {{ __('copiadeseguridad.titulo') }}</h3>

            <hr style="height: 1px; background-color: black;">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">




                <div class="panel-body">
                    <table class="table table-striped table-bordered table-condensed table-hover" style="background: white"
                        id="myTable">
                        <thead>
                            <th>
                                <center>{{ __('copiadeseguridad.col_id') }}</center>
                            </th>
                            <th>{{ __('copiadeseguridad.col_nombre') }}</th>
                            <th>{{ __('copiadeseguridad.col_tamanio') }}</th>
                            <th>
                                <center>...</center>
                            </th>

                        </thead>

                        <tbody align="left" id="body_video">
                            <?php $id = 1; ?>
                            @foreach ($lista as $fila)
                                <tr>
                                    <td>
                                        {{ $id++ }}
                                    </td>
                                    <td>
                                        {{ $fila['Nombre'] }}
                                    </td>
                                    <td>
                                        {{ $fila['Tamanio'] }}
                                    </td>

                                    <td>
                                        <a href="respaldos/{{ $fila['Nombre'] }}" download>{{ __('copiadeseguridad.descargar') }}</a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>


                    </table>
                </div>
            </div>
        @endsection
