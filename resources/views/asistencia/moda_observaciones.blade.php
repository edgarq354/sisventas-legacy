<div class="modal fade" id="modal_finalizar" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" 
          data-dismiss="modal" 
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" >{{ __('asistencia.registro_finalizacion_dia') }}</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('url' => 'asistencia/finalizar'))}}  
        <div class="form-group">
        {!!Form::label('conclusion',__('asistencia.pregunta_observacion'))!!}
        {!!Form::text('observacion',null,['class'=>'form-control','placeholder'=>__('asistencia.placeholder_observacion')])!!}
      </div>

      </div>
      
          <div class="modal-footer">

            {!!Form::submit(__('asistencia.registrar'),['class'=>'btn btn-primary','id'=>'btn_actualizar','onclick'=>'btn_esconder()'])!!}
            </form>
            <button data-dismiss="modal"  class="btn btn-danger">{{ __('asistencia.cancelar') }}</button>
        </div>

    </div>
  </div>
</div>