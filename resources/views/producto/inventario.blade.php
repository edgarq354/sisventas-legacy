@extends ('layouts.inicio')
@section('contenido')
    @include('alerts.success')
    @include('alerts.request')
    @include('alerts.errors')
    @include('partials.dashboard_style')

    <style type="text/css">
        #tabla_sin_imprimir{ font-size:12.5px; }
        #tabla_sin_imprimir thead th{ padding:8px 10px !important; font-size:11px; text-transform:uppercase; letter-spacing:.4px;
            background:#fdf0e7; color:#c62828; border-bottom:2px solid #efe4da; text-align:left; }
        #tabla_sin_imprimir tbody td{ padding:6px 10px !important; vertical-align:middle; }
        #tabla_sin_imprimir tbody tr:hover{ background:#fdfaf7; }
        #tabla_sin_imprimir .badge{ font-size:10.5px; padding:3px 8px; border-radius:999px; }
        #tabla_sin_imprimir td.num{ text-align:right; white-space:nowrap; }
        .inv-ok{ font-weight:600; color:#2e7d32; }
    </style>

    <script type="text/javascript">
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () { document.getElementById('output').src = reader.result; };
            reader.readAsDataURL(event.target.files[0]);
        };
        var loadFile_actualizar = function (event) {
            var reader = new FileReader();
            reader.onload = function () { document.getElementById('output_actualizar').src = reader.result; };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>

    @php
        $bajos = collect($producto)->filter(fn($p) => $p->peso <= $p->peso_minimo)->count();
    @endphp

    <div class="dash">

        <div class="dash-hero" style="margin-bottom:16px;">
            <div class="dash-hero__icon"><i class="fa fa-cubes"></i></div>
            <div>
                <h3 class="dash-hero__title">Inventario</h3>
                <p class="dash-hero__sub">{{ count($producto) }} productos · {{ $bajos }} con stock bajo</p>
            </div>
            <div class="dash-hero__spacer"></div>
            <a class="btn btn-default" href="{{ URL::to('rptMinimos') }}" style="border-radius:10px;font-weight:600;">
                <i class="fa fa-exclamation-triangle"></i> Por terminarse
            </a>
            <a class="btn btn-warning" href="inventario_imprimir" style="border-radius:10px;font-weight:700;">
                <i class="fa fa-print"></i> Imprimir
            </a>
        </div>

        <div class="dash-card">
            <div class="dash-card__head"><i class="fa fa-list"></i> Productos</div>
            <div class="dash-card__body dash-card__body--flush">
                <div class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped table-hover" style="background:white;margin:0;" id="tabla_sin_imprimir">
                        <thead>
                            <th style="width:60px;"><center>ID</center></th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th style="text-align:right;">Cantidad</th>
                            <th style="text-align:right;">Precio</th>
                        </thead>
                        <tbody id="body_video">
                            @foreach ($producto as $usr)
                                <tr>
                                    <td><center>{{ $usr->id }}</center></td>
                                    <td>{{ $usr->nombre }}</td>
                                    <td>{{ $usr->descripcion }}</td>
                                    <td>{{ $usr->nombre_tipo_producto }}</td>
                                    <td class="num">
                                        @if ($usr->peso > $usr->peso_minimo)
                                            <span class="inv-ok">{{ $usr->peso }}</span>
                                        @else
                                            <span class="badge btn-danger">{{ $usr->peso }}</span>
                                        @endif
                                    </td>
                                    <td class="num">{{ $usr->precio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

<script src="{{ asset('js/producto_actualizar.js') }}"></script>
