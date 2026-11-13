@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors') 
 

<input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>">
<input type="hidden" id="nombre_usuario" text="{{Auth::user()->nombre}}" />
<!-- INICIAR     CHAT  -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people  col-lg-3 col-md-4 col-sm-5 col-xs-12">
          <div class="headind_srch" style="margin:0px;padding: 10px 0px 10px 0px;">
             
          <input type="text" id="buscar_nombre" class="write_msg" 
          onkeyup="buscar_pasajero();" placeholder="Buscar..." style="color:black; border-radius:25px; padding:5px; border: medium none; margin:0px;     width: 100%;" />   
            
            <div class="srch_bar">
            </div>
          </div>

          <div class="inbox_chat">
            <div class="chat_list active_chat">
            <div id="usuarios_completo">
            </div>
            </div>
          </div>
        </div>

        <div class="mesgs   col-lg-8 col-md-7 col-sm-6 col-xs-12"  >
          
          <div class="headind_srch" style="width:100%;">
            <div class="recent_heading" style="width:100%;">
               <img src="images/ic_perfil.png" alt="Perfil" id="im_perfil" style="width: 40px;  height: 40px; ">   <label id="nombre_pasajero" style="color: #fff; font-size: 21px; margin: auto; font-weight: normal;">CHAT</label>
            </div>
            <div class="srch_bar">
            </div>
          </div>

          <div class="msg_history" >
            <div id="chat_completo" style="overflow-y: auto;">
            </div>
           
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" id="mensaje" class="write_msg" placeholder="Escribir Mensaje" />
              <button class="msg_send_btn" type="button" onclick="enviar_mensaje();"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
<!-- FINALIZAR  https://bootsnipp.com/snippets/nNg98   CHAT  -->



   {!!Html::script('js/usuario_chat_completo.js')!!}
 

   
@endsection






























<!--style-->
<style type="text/css">
  
.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}

.inbox_people {
 
  background-color: rgba(0,0,0,.2);
  float: left;
  overflow: hidden;
  width: 40%;  

  border-radius: 15px 15px 0 0 !important;
      border-bottom: 0 !important;
}
.inbox_msg {
  
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #fff;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#fff; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#000; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ 
  overflow:hidden; 
  clear:both;
  background-color: rgba(0,0,0,.2);
  border-radius: 15px 15px 15px 15px !important;
 padding: 10px;
 margin-top: 5;
 

}

.chat_list {
  border-bottom: 0px solid #c4c4c4;
  margin: 0;
  padding: 0px 0px 0px;
}
.inbox_chat {
     height: 550px; 
     overflow-y: scroll;
}

.active_chat{ 
cursor:pointer;

}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  color: #000;
  font-size: 14px;
  padding: 5px 10px 5px 12px;
  width: 100%;

    margin-top: auto;
    margin-bottom: auto;
    margin-right: 10px;
    border-radius: 25px;
    background-color: #82ccdd;
    position: relative;
 
}
.time_date {
  color: #fff;
  display: block;
  font-size: 12px;
  margin: 0px 0 10;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 5px 5px 0 5px;
  margin-left: 20;
  width: 55%;
  height: 500px;
      border-radius: 15px !important;
      background-color: rgba(0,0,0,0.4) !important;
}

 .sent_msg p {
  font-size: 14px;
  margin: 0; 
  color:#000;
  padding: 5px 10px 5px 12px;
  width:100%;

   margin-top: auto;
    margin-bottom: auto;
    margin-right: 10px;
    border-radius: 25px;
    background-color: #78e08f;
    position: relative;
}
.outgoing_msg{
 overflow:hidden; 
 margin:0px 0 0px;
}
.sent_msg {
  float: right;
  width: 46%;
}



.input_msg_write input {
   background-color: #fff;
  border: medium none; 
  font-size: 15px;
  min-height: 48px;
  width: 100%;
  color: #000;
  padding-left: 5px;


     border-radius: 15px 15px 15px 15px !important;
      border-top: 0 !important;

}

.type_msg {
  border-top: 0px solid #c4c4c4;
  position: relative;
  margin-top: 0px;
}

.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
  margin-right:10px;
}
.messaging { 
  padding: 5 5 5px 5;
    background: #7F7FD5;
         background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
          background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
}
.msg_history {
  height: 97%;
  overflow-y: auto;
  padding: 5px 5px 0 5px;
}
</style>