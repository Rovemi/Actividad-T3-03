$(document).ready(function(){
    $('#acceder').validate({
       rules: {          
          correo: {
             required: true,
             email: true
          },
          pass: {
            required: true,            
         }
       },
       messages: {           
          correo: "Por favor ingresa un correo válido",
          pass: {
             required: "Por favor ingresa una contraseña",             
          }
       },
       errorElement: "em",
       highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
       },
       unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );  
       }
    });

    $('#crearuser').validate({
        rules: {
            nombre: {
                required: true,                
             },
             apellidos: {
               required: true,            
            },
            phone: {
               required: true,
            },
            dir: {
              required: true,          
            },          
           email: {
              required: true,
              email: true
           },
           contra: {
             required: true,            
          },
          concontra: {
             required: true,             
             equalTo: "#contra"
          }
        },
        messages: {  
           nombre: "Por favor, ingresa un nombre",         
           apellidos: "Por favor, ingresa tus apellidos",
           phone: "Por favor ingresa un número de teléfono",                   
           dir: "Por favor, ingresa tu dirección",
           email: "Por favor ingresa un correo válido",
           contra: "Por favor ingresa una contraseña",
           concontra: {
             required: "Ingresa una contraseña por favor",
             equalTo: "Las contraseñas no coinciden"
           }           
        },
        errorElement: "em",
        highlight: function ( element, errorClass, validClass ) {
           $( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
           $( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );  
        } 
     });

 });


/*function comenzar(){    
    var iniciarsesion = document.getElementById("iniciar");
    iniciarsesion.addEventListener( "click", ini, false );    
}

function ini(){
    var form = $(".acceder");
    form.bind("submit", function(){
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data:form.serialize(),
            beforeSend: function(){

            },
            complete: function(data){
                
            },
            success: function(data){
                if(data=="true"){
                    document.location.href="principal.php";
                }else{
                    document.alert("error");
                }
            },
            error: function(data){
                
            }
        });
    });
}

window.addEventListener("load", comenzar, false);*/