<?php
/**
 * Template para los servicios que se ofrecen
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

$producto = get_queried_object();
get_header();

$fondo_coberturas = get_field('color_fondo_coberturas');
$fondo_z_libre = get_field('color_zona_libre');
$fondo_ventajas = get_field('color_fondo_puntos_dolor');
$fondo_faqs = get_field('color_fondo_faqs');
$fondo_adjuntos = get_field('color_fondo_docs_adjuntos');

if ($fondo_faqs == "verde") {
	$classfa = "siropesr";
}else{
	$classfa = "";
}



?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main product-temp comp-polizas-rs" role="main">

			<div class="container">
				<section class="franja pt-5 blco-1-topg">
					<div class="d-flex flex-row flex-wrap align-items-center align-items-md-center justify-items-between">
						<div class="col-12 col-md-6 text-start" id="text-val-b">
							<header>
								<h1 class="h1-servicios"><?php the_title(); ?></h1>
							</header>
							<?php 
								$is_mobile = wp_is_mobile(); 
								if (!$is_mobile): ?>
								    <h3 class="text-primary"><?php the_field('subtitulo'); ?></h3>
								    <div class="ban-prod">
										<?php the_field('texto_presentacion'); ?>
									</div>
							<?php endif; ?>
						</div>
						<div class="col-12 col-md-6" id="img-producto">
							<?php 
								$imagen_cat = get_the_post_thumbnail('','entry-image',array( 'class' => 'img-responsive' ,'title' => get_the_title()));;
								echo $imagen_cat;
							 ?>
						</div>
					</div>
				</section>
			</div>

			<div class="container-maxi comp-coberturas mt-2">
				<div class="franja pb-0 pt-0">
					<h2 class="title-pol-disp">Un seguro de accidentes a tu medida.</h2>
					<p>Porque cada vida es única, protegemos lo que realmente importa para ti.</p>
				</div>
				<?php 
					if (wp_is_mobile()) {
					    require SACAIG_PLUGIN_PATH. 'parts/coberturas-mobile.php';
					} else {
					    require SACAIG_PLUGIN_PATH. 'parts/coberturas-desktop.php';
					}
				?>

				<div class="text-start pb-4 pt-4 pe-4 ps-4 caja-seguro-medida">
					<div class="d-flex">
						<div class="col-md-8 col-12">
							<div class="h3">¿No es el seguro que estabas buscando?</div>
							<p class="d-none d-md-block">Si este producto no se adapta a tus necesidades, podemos ofrecerte opciones personalizadas que estamos convencidos te interesarán.</p>
							<a href="#" data-bs-toggle="modal" data-bs-target="#ModalLlamarLateral" class="btn btn-rosa">Te llamamos</a>
						</div>
						<div class="col-md-4 d-none d-md-block text-center">
							<img src="https://universopelo.com/wp-content/uploads/2024/05/Searching-4.svg" alt="Contrata un seguro a medida">
						</div>
					</div>
				</div>
				
			</div>

			<div class="container-fluid verde-franja mt-5">
				<!-- Incluimos la sección 3 iconos -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-iconos.php'); ?>							
			</div>

			<div class="container-fluid">
				<!-- Incluimos la sección de contenido libre -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-contenido-libre.php'); ?>
			</div>

			<div class="container-fluid" style="background:<?= ColorHexC($fondo_coberturas); ?>">
				<!-- Incluimos la sección coberturas -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-coberturas.php'); ?>	
			</div>

			<div class="container-fluid" style="background:<?= ColorHexC($fondo_z_libre); ?>">
				<!-- Incluimos la sección coberturas -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-zona-libre.php'); ?>	
			</div>

			<div class="container-fluid" style="background:<?= ColorHexC($fondo_ventajas); ?>">
				<!-- Incluimos la sección ventajas -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-ventajas.php'); ?>
			</div>

			<div class="container-fluid <?= $classfa; ?>" style="background:<?= ColorHexC($fondo_faqs); ?>">
				<!-- Incluimos la sección faqs -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-faqs.php'); ?>	
			</div>

			<div class="container-fluid" style="background:<?= ColorHexC($fondo_adjuntos); ?>">
				<!-- Incluimos la sección docs.adjuntos -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-adjuntos.php'); ?>
			</div>

			<div class="container-fluid">
				<!-- Incluimos la sección docs.adjuntos -->
				<?php include(get_template_directory() .'/parts/parts-productos/part-prod-vinculados.php'); ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->


<?php
get_footer();



