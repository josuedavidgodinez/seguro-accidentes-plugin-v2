<?php 
    $path = __DIR__ . '/..';
    require_once  $path .'/utils/transient-services.php';
    require_once  $path .'/utils/correos-services.php';

    ignore_user_abort(true); // El script sigue aunque el usuario cierre el navegador
    set_time_limit(0); // Evita que el script se detenga por timeout

    $signature_id = $_GET['signature_id'];
    $signatory_id = $_GET['signatory_id'];
    //obtenemos transient
    $respuesta_transient=SACAIG_get_transient_service($signature_id);
    if(!is_null($respuesta_transient['respuesta'])){
    $datos_transient=$respuesta_transient['respuesta'];


    //registramos en Insuguru
    $respuesta_insuguru=insu_contratacion_insuguru($datos_transient, $datos_transient->INSU_WP_ARISE_RATE, null, null  , $signature_id);

    //enviamos correo a la compañia con documento firmado
    $request_correo_compania=get_object_vars($datos_transient);
    $respuesta_correo_compania = SACAIG_enviar_correo_poliza_companias_callback_service($request_correo_compania);

    //envio de correo al cliente
    $respuesta_correo_cliente = SACAIG_enviar_correo_poliza_callback_service($request_correo_compania);
    
    }
    get_header();

 ?>


<div id="primary" class="content-area viajes-inter" style="margin-top:-50px;">
<main id="main" class="site-main product-temp" role="main">

    <div class="container-mini-tarif-viajes">
        <img class="img-sgviajes thabnks-step" src="<?= AC_PLUGIN_URL."/img/gracias_1.svg"; ?>">

        <h2 class="title-viajes">¡Todo listo! La solicitud ha sido procesada correctamente.</h2>
        <p><i>Muchas gracias por confiar en <?= WPCONFIG_NAME_EMPRESA; ?>.</i></p>
        <div class="card-forms">
            
            <p>Hemos enviado a tu correo una <b>copia de la solicitud de seguro de accidentes,</b> y en breve nos pondremos en contacto contigo. </p>

            <p>Recuerda revisar tu bandeja de entrada (y, por si acaso, la <b>carpeta de spam</b>).</p>

            <p><b>Importante:</b> Recuerda que hasta que te lo confirmemos, todavía no tienes cobertura.</p>
            
            <a href="/listado-seguros/" class="btn btn-primary btn-viajes mt-4 btn-rosa">Ver otros seguros</a>
        </div>
    </div>


<?php
get_footer();
?>