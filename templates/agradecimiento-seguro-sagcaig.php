<?php 

get_header();

 ?>


<div id="primary" class="content-area viajes-inter" style="margin-top:-50px;">
<main id="main" class="site-main product-temp" role="main">

    <div class="container-mini-tarif-viajes">
        <img class="img-sgviajes thabnks-step" src="<?= AC_PLUGIN_URL."/img/gracias_1.svg"; ?>">

        <h2 class="title-viajes">¡Todo listo! La solicitud ha sido procesada correctamente.</h2>
        <p><i>Muchas gracias por confiar en <?= SACAIG_NAME_EMPRESA; ?>.</i></p>
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