function mostrarPantallaCargando() {
    $('body').prepend('<div id="pantallaCargando"></div>')
    $('#pantallaCargando').addClass('pantallaCargando');
}

function ocultarPantallaCargando() {
    $('#pantallaCargando').remove();
}

// Cuando se vaya invocar codigo Ajax se muestra la pantalla de cargando
$(document).ajaxStart(function () {
    mostrarPantallaCargando();
});

// Cuando se termine de ejecutar el codigo Ajax se oculta la pantalla de cargando
// *** Si alguna sentencia detiene la ejecución en algun momento del Ajax esta función no se ejecuta hasta que termine el Ajax
$(document).ajaxStop(function () {
    ocultarPantallaCargando();
});
