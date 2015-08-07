$(document).ready(function () {

// Funcion para los tooltips flotantes dentro del punto de ventas
    $(function () {
        $(document).tooltip({track: true});
    });
    
//Funcion de la libreria para controlar una ventana flotante, --No implentado--    
    $(function () {
        $("#dialog").dialog({closeOnEscape: true, position: {my: "top", at: "top", of: window}, resizable: false, minWidth: 1300, minHeigth: 800, autoOpen: false, show: {effect: "blind", duration: 250}, hide: {effect: "clip", duration: 250}});
        $(".opener").click(function () {
            $("#dialog").dialog("open");
        });
    });
    
//Controla el scroll up al llegar a tener mucho contenido y queremos volver rapidamente al tope de la pagina    
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });
    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });
    
//Contrala la redireccion del sistema para cambiar la clave    
    $('#bEditarInfo').on('click',function() {
       
       window.location = "/PuntoVentas/includes/registro/cambiaclave.php";
        
    });

//Control del login en la pagina de inicio, al momento de realizar el submit
    $('#formLogin').on('submit', function () {
        
        var tUsuario = document.getElementById("tUsuario").value;
        var tPass = document.getElementById("tPass").value;

//Se crea una variable formulario para el envio de datos
        var data = new FormData();

        data.append('user', tUsuario);
        data.append('pass', tPass);
        
//Mediante ajax se envian los datos al archivo de validacion y se retorna un mesaje de aprovacion o rechazo        
        $.ajax({
            url: 'includes/sys/validaciones/validarLogin.php',
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: true,
            success: function (data) {
                $("#mensajeAccion").attr('value',data); //Se agrega el valor retornado a la variable oculta en el index.php de inicio 

                if ($("#mensajeAccion").val() == "menu") { //Si el mensaje es menu es logro la validacion satifactoria y se redirecciona al archivo menu.php
                    window.location = "menu.php";

                } else if ($("#mensajeAccion").val() == "fallo") {//Si el mensaje es fallo se muestra un mejase con alertify de error color rojo

                    alertify.error('Error al validar el usuario', 0).dismissOthers();
                }
            }
        });
    });
});



