$(document).ready(function () {


    $(function () {
        $(document).tooltip({track: true});
    });
    $(function () {
        $("#dialog").dialog({closeOnEscape: true, position: {my: "top", at: "top", of: window}, resizable: false, minWidth: 1300, minHeigth: 800, autoOpen: false, show: {effect: "blind", duration: 250}, hide: {effect: "clip", duration: 250}});
        $(".opener").click(function () {
            $("#dialog").dialog("open");
        });
    });
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
    
    $('#bEditarInfo').on('click',function() {
       
       window.location = "/PuntoVentas/includes/registro/cambiaclave.php";
        
    });

    $('#formLogin').on('submit', function () {
        var tUsuario = document.getElementById("tUsuario").value;
        var tPass = document.getElementById("tPass").value;

        var data = new FormData();

        data.append('user', tUsuario);
        data.append('pass', tPass);
        $.ajax({
            url: 'includes/sys/validaciones/validarLogin.php',
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: true,
            success: function (data) {
                $("#mensajeAccion").attr('value',data);

                if ($("#mensajeAccion").val() == "menu") {
                    window.location = "menu.php";

                } else if ($("#mensajeAccion").val() == "fallo") {

                    alertify.error('Error al validar el usuario', 0).dismissOthers();
                }
            }
        });
    });
});



