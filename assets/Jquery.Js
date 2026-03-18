jQuery(function ($) {

    // Efecto fade-in al cargar la pagina
    $(".container, .container-fluid").first().hide().fadeIn(500);

    // Confirmar antes de eliminar
    $("form").on("submit", function () {
        var btn = $(this).find("button[type=submit], input[type=submit]");
        var texto = btn.val() || btn.text();

        if (texto.toLowerCase().indexOf("eliminar") !== -1 || texto.toLowerCase().indexOf("si,") !== -1) {
            return confirm("¿Estas seguro?");
        }
    });

    // Resaltar fila de tabla al pasar el raton
    $("table tbody tr").hover(
        function () { $(this).css("opacity", "0.8"); },
        function () { $(this).css("opacity", "1"); }
    );

});
 