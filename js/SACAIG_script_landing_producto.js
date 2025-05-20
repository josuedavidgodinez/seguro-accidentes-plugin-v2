// Este archivo es para todo el js relativo a la landing principal del producto
$ = jQuery.noConflict();

$(document).ready(function() {

    // Eliminar selectedProductId de sessionStorage al cargar la página
    sessionStorage.removeItem('selectedProductPrice');

    $('.btn_seleccion_opt_ciber_secundario').on('click', function () {
        
        const btnSecundario = $(this);
        let id_disparo = btnSecundario.data('disparo_id');

        $(`#${id_disparo}`).trigger('click');
    });

	// Selección de una opción en la landing de producto
    $('.acc-selector').click(function(event) {
        // Obtener el id del elemento clicado
        let id_completo = $(this).attr('id');

        console.log(id_completo)

        // Eliminar la parte 'btn_precio_' del id
        let id_parcial = id_completo.replace('btn_precio_', '');

        // Eliminar cualquier valor existente en sessionStorage con la misma clave
        sessionStorage.removeItem('selectedProductId');

        // Guardar el id_parcial en sessionStorage
        sessionStorage.setItem('selectedProductId', id_parcial);

        window.location.href = '/contratar-seguro-accidentes-sacaig/';

    });
});