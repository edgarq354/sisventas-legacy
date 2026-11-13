@if (Session::has('descargar_copia'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>

        Copia de seguridad exitosamente <a class="btn btn-warning" href="{!! URL::to(Session::get('descargar_copia')) !!}" aria-hidden="true"><i
                class="fa fa-print" aria-hidden="true" download></i> DESCARGAR</a>
    </div>
@endif
