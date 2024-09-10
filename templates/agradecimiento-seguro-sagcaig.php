<?php 

get_header(); 

?>

<div id="primary" class="content-area viajes-inter">
    <main id="main" class="site-main product-temp" role="main">

        <div class="container-mini-tarif-viajes">

            <img class="img-sgviajes" src="<?php echo esc_url(SACAIG_IMAGEN_PLUGIN); ?>" alt="<?php esc_attr_e('Calcula el precio de tu ', 'seguro-accidentes-aig'); ?><?php echo esc_html(SACAIG_PRODUCTO_NOMBRE); ?>">

            <h2 class="title-viajes">¡Todo listo! Tu seguro de accidentes ha sido confirmado</h2>

            <p><i>Muchas gracias por confiar en nosotros.</i></p>

            <div class="card-forms">
                
                <p class="mb-3">Hemos solicitado la emisión de tu póliza a la compañía. En breve recibirás la confirmación o no de la emisión. <b>Entre tanto la solicitud no otorga cobertura.</b></p>
                
                <a href="/listado-seguros/" class="btn btn-primary btn-viajes">Ver otros seguros</a>
            </div>
        </div>
            

        <?php 
        // Footer viajes
        require(SACAIG_PLUGIN_PATH . 'parts/mini-footer.php');

        get_footer();
    
