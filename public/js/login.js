
function verificar(){
    var email=$('input[name=email]').val();
    var password=$('input[name=password]').val();
    var token=$('#token').val();
    $.ajax({
            url:"login",
                headers: {'X-CSRF-TOKEN': token},
                 type: 'POST',
                  dataType: 'json',
                   data: {email:email, password:password},
              });
    
}

function ocultar(){
  $("#btn_ingresar").hide();
}
/*
function Copiar_Contra(){
  $("#contrasena").val($("#password").val());
}
*/

function ver_pass(){
  password=$('input[name=password]').val();
   var type = $("#password").attr("type");
  if (password != "") {
    if(type == "password"){
      $("#password").attr('type', 'text');
    $("#contrasena").val($("#password").val()); 
    
    }else
    {
      $("#password").attr('type', 'password');
    }
  } 
}

function mouseUp(){
  $("#contrasena").hide();
  $("#password").show();
}
