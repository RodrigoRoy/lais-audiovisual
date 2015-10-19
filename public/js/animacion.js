// Cuando el documento esté listo se realizan todas las llamadas a las funciones que involucran al formulario.
	//Iniciar el navbar
$( ".navegador" ).css( "background-color", "transparent");
$(document).ready(function(){       
            var scroll_pos = 0;
            //$(document).scroll(function() { 
                scroll_pos = $(this).scrollTop();
                if(scroll_pos > 80) {
                    $(".navegador").css("background-color", "rgba(0,0,0,.8)");
                }else{
                    $( ".navegador" ).css( "background-color", "transparent");
                }
            //});


});