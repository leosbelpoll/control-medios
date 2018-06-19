$(document).ready(function () {

    $('table').addClass('table table-hover');

    $('select').select2({
        language: "es"
    });

    $('input[type="date"]').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    $('.icono').css('margin-right', '10px');

    $('.icono-mostrar').tooltip({
        placement: 'top',
        title: 'Mostrar'
    });

    //TODO ponerle la tilde a la "o" de operacion que no tenia como
    $('.icono-operacion').tooltip({
        placement: 'top',
        title: 'Realizar operacion'
    });

    $('.icono-adicionar').tooltip({
        placement: 'top',
        title: 'Adicionar'
    });

    $('.icono-editar').tooltip({
        placement: 'top',
        title: 'Editar'
    });

    $('.icono-eliminar').tooltip({
        placement: 'top',
        title: 'Eliminar'
    });

    $('.icono-info').tooltip({
        placement: 'top',
        title: 'Información'
    });

});