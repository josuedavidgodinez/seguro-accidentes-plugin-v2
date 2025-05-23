
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<title>Plantilla PDF Presupuesto Seguro</title>
	<style type="text/css">
		 @font-face { 
            font-family: 'Fieldwork'; 
            src: url('<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/fonts/Fieldwork-Geo-Regular.ttf'?>') format("truetype");
            font-style: normal; 
            font-weight: normal; 
        }

        @font-face { 
            font-family: 'Fieldwork'; 
			src: url('<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/fonts/Fieldwork-GeoThin.ttf'?>') format("truetype");
            font-style: normal; 
            font-weight: 200; 
        }

        @font-face { 
            font-family: 'Fieldwork';
			src: url('<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/fonts/Fieldwork-Geo-Bold.ttf'?>') format("truetype");
            font-style: normal;
            font-weight: bold; 
        }
        body {color:#004481; font-family: 'Fieldwork', sans-serif; font-style: normal; }
		.text-primary {color:#009696 !important;}
		.text-secondary {color:#777 !important;}
		.text-danger {color:#ff2f76 !important;}
		.border {border-color:#004481 !important}
		.border-primary {border-color:#009696 !important;}
		.border-danger {border-color:#ff2f76 !important;}

		.font-small {font-size:0.8rem;}
		.font-smaller {font-size:0.6rem ;}
		.font-weight-semibold {font-weight: 600 !important;}
		.bg-primary-solid {background: #009696 !important;}
		.bg-primary-transparent-1 {background: #00969610;}
		.bg-primary-transparent-2 {background: #00969620;}
		.border-width-custom-1 {border-width: 2px !important;}
		.border-width-custom-2 {border-width: 3px !important;}
		.border-semitransparent {border-color:#00969630 !important;}
		.card-image img{
			width: 54.6px;
			height: 61.6px;
		}

		.icon-facts {
  			width: 52.2px;
			height: 52.2px;
		    position: absolute;
		    left: -1.5rem;
		    top: -1.2rem;
			background-repeat: no-repeat;
		}

		.why-icon{
			width: 90px;
			height: 90px;
		}

		.compromiso-icon{
			width: 100px;
			height: 100px;
		}

		.plan-selected {
			border-right: 2px solid #FF2F76 !important;
			border-left: 2px solid #FF2F76 !important;
		}
		.plan-selected.first {
		    background: #FF2F76;
		    padding-top: 5px;
		    border-radius: 8px 8px 0 0;
		    border: 2px solid #FF2F76;
		}
		.plan-selected.last {
			border-bottom: 2px solid #FF2F76;
			padding-bottom: 24px !important;
			border-radius: 0 0 8px 8px;
		}
		table {border-collapse: separate;}
		
		.card {
		    width: 31.3333% !important;
		    margin-right: 3%;
		}
		.card.last {
			margin-right: 0;
		}
	</style>
</head>
<body>
	<div style="page-break-after:always;"></div>
	<!-- PÁG 1 -->
	 <?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-cobertura-1.svg'?>" alt="Datos del asegurado">
				Datos del asegurado
			</div>			
		</div>
		<div class="row my-4 ml-1 pt-2">
			<div class="col" >
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Nombre y apellidos:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$nombre_completo_asegurado; ?> </div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">NIF:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$identificador_asegurado; ?> </div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Dirección:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$direccion_asegurado; ?> </div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Teléfono:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$telefono_asegurado; ?> </div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Correo electrónico:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$email_asegurado; ?> </div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Fecha de nacimiento:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$fecha_nacimiento_asegurado; ?> </div>
				</div>
			</div>			
		</div>
	</section>

	<section class="container mt-5">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-2.svg'?>" alt="Datos del tomador">
				Datos del tomador
			</div>			
		</div>
		<div class="row my-4 ml-1 pt-2">
			<div class="col" >
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Nombre y apellidos:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$nombre_completo_tomador; ?> </div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">NIF:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"> <?=$identificador_tomador; ?> </div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Dirección:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$direccion_tomador; ?></div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Teléfono:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$telefono_tomador; ?></div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Correo electrónico:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$email_tomador; ?></div>
				</div>
				<?php if (isset($fecha_nacimiento_tomador) && $fecha_nacimiento_tomador != ""): ?>
					<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Fecha de nacimiento:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$fecha_nacimiento_tomador; ?></div>
				</div>
				<?php endif ?>
			</div>			
		</div>
	</section>

	<section class="container mt-5">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-3.svg'?>" alt="Perfil del asegurado">
				Perfil del asegurado
			</div>			
		</div>
		<div class="row my-4 ml-1 pt-2">
			<div class="col" >
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Profesión:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$profesion; ?></div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Trabajo manual:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$actividad_manual_texto; ?></div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Enfermedades cardíacas:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$enf_cardiaca_texto; ?></div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Enfermedades graves/minusvalías:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$enf_grave_texto; ?></div>
				</div>
			</div>			
		</div>
	</section>

	<section class="container mt-5">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-4.svg'?>" alt="Declaración de Herederos">
				Declaración de Herederos
			</div>			
		</div>
		<div class="row my-4 ml-1 pt-2">
			<div class="col" >
				<?=$html_beneficiarios?>
			</div>			
		</div>
	</section>
	<div style="margin-top: 40px">
	<?php
		$page = 2;

	 ?>
	</div>


	<div style="page-break-after:always;"></div>
	<!-- PÁG 2 -->
	<?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-5.svg'?>" alt="Garantías y capitales asociados">
				Garantías y capitales asociados
			</div>			
		</div>
		<div class="row my-4 ml-1 pt-2">
			<div class="col" >
			    <?=$contenido_tabla?>
    			</div>			
		</div>
	</section>
	<div style="margin-top: 280px">
	<?php
		$page = 3;
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/footer.php' );
	 ?>
	</div>

	<div style="page-break-after:always;"></div>
	<!-- PÁG 3 -->
	<?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-6.svg'?>" alt="Ejemplos">
				Ejemplos de lo que este seguro haría por ti
			</div>			
		</div>
		<div class="row mt-5 mb-4 ml-1 pt-2">
			<div class="card bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a1.svg'?>" alt="Protección para tu familia en caso de accidente fatal"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Protección para tu familia en caso de accidente fatal</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si falleces en un accidente de tráfico, tu familia recibirá la suma asegurada para su tranquilidad.</div>
				</div>
			</div>
			<div class="card bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a2.svg'?>" alt="Invalidez permanente tras un accidente laboral"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Invalidez permanente tras un accidente laboral</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si un accidente te causa invalidez permanente por accidente laboral, recibirás compensación económica.</div>
				</div>
			</div>
			<div class="card last bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a3.svg'?>" alt="Apoyo para tu familia si ambos padres faltan"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Apoyo para tu familia si ambos padres faltan</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si tú y tu pareja fallecéis en un accidente, tus hijos recibirán una indemnización extra para su cuidado.</div>
				</div>
			</div>
		</div>
		<div class="row  mb-4 ml-1 pt-2">
			<div class="card bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a4.svg'?>" alt="Compensación diaria si estás hospitalizado"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Compensación diaria si estás hospitalizado</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si tras un accidente pasas más de 5 días en el hospital, recibirás una ayuda económica diaria durante tu estancia.</div>
				</div>
			</div>
			<div class="card bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a5.svg'?>" alt="Adecuamos tu hogar si quedas con invalidez"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Adecuamos tu hogar si quedas con invalidez</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si necesitas adaptar tu casa por invalidez tras un accidente, cubrimos los gastos de reforma para tu comodidad.</div>
				</div>
			</div>
			<div class="card last bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a6.svg'?>" alt="Te cubrimos si te lesionas haciendo deporte"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Te cubrimos si te lesionas haciendo deporte</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si te accidentas practicando deporte recreativo cubierto, recibirás una indemnización por tus lesiones.</div>
				</div>
			</div>
		</div>

		<div class="row  mb-4 ml-1 pt-2">
			<div class="card bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a7.svg'?>" alt="Compensación diaria si estás hospitalizado"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Te cubrimos en tus viajes fuera de España</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si tienes un accidente viajando fuera, estás cubierto hasta 90 días seguidos al año para tu tranquilidad.</div>
				</div>
			</div>
			<div class="card bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a8.svg'?>" alt="Adecuamos tu hogar si quedas con invalidez"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Te apoyamos si pierdes visión o audición</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si tras un accidente pierdes vista o audición, recibirás una indemnización acorde al grado de pérdida.</div>
				</div>
			</div>
			<div class="card last bg-light border-light">
				<div class="row p-3 ">
					<div class="card-title pt-2 px-2 d-flex">
						<div class="card-image"><img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/a9.svg'?>" alt="Te cubrimos si te lesionas haciendo deporte"></div>
						<div class="card-title align-self-center font-weight-bold h6 mx-2 my-auto">Extra para tus hijos si llegas a faltar</div>
				  </div>
					<div class="col-12 font-weight-light mt-3">Si falleces, tus hijos menores recibirán una indemnización extra para su futuro, además de la suma asegurada.</div>
				</div>
			</div>
		</div>
		
	</section>
	<div style="margin-top: 215px">
	 <?php
		$page = 4;
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/footer.php' );
	 ?>
	</div>


	<div style="page-break-after:always;"></div>
	<!-- PÁG 4 -->
	<?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-7.svg'?>" alt="Condiciones de contratación">
				Condiciones de contratación
			</div>			
		</div>
		<div class="row my-4 ml-1 pt-2 mb-5">
			<div class="col mb-5" >
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Período de cobertura:</div>

					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light">Del <span class="font-weight-normal"><?=$fecha_efecto_solicitada_asegurado?></span> al <span class="font-weight-normal"><?=$fecha_final_cobertura_mod?></span></div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Periodicidad de pago:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light">Anual</div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Importe primer recibo:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$precio_poliza?> €/año</div>
				</div>
				<div class="row mb-1 pb-1">
					<div class="col-4 pt-1">Prima total anual:</div>
					<div class="col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light"><?=$precio_poliza?> €/año</div>
				</div>
			</div>			
		</div>
		<div class="row my-5 ml-3 pt-3 px-2 bg-light">
			<div class="col font-weight-light font-small">
				<p>Este documento no es una póliza y por tanto no vincula contractualmente a la Correduria. Tres Mares se compromete a mantener el precio indicado en este proyecto hasta el 27/09/2024, siempre que los datos utilizados para la cotización no varíen y puedan ser contrastados documentalmente.</p>
				<p>La aceptación y el inicio de la cobertura se producirá en el momento en que se formalice la correspondiente póliza de seguro y se haga efectivo el pago del primer recibo por parte del Tomador.</p>
				<p>Para más información, puede consultar si lo desea la Nota Informativa Previa a la contratación y el IPID.</p>
			</div>
		</div>
	</section>

	<section class="container mt-5">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-8.svg'?>" alt="¿Por qué elegir Tres Mares?">
				¿Por qué elegir Tres Mares?
			</div>			
		</div>
		<div class="row">
			<div class="col-4 text-center p-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/tres-mares-icon-why-1.svg'?>" alt="Seguros para aquello que necesites" class="mb-2 why-icon">
				<h4 class="font-weight-bold">Seguros para aquello que necesites</h4>
				<p class="text-dark font-weight-light">Desde un seguro de vida a uno para tu nueva nave espacial</p>
			</div>
			<div class="col-4 text-center p-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/tres-mares-icon-why-2.svg'?>" alt="Las mejores opciones entre las que elegir" class="mb-2 why-icon">
				<h4 class="font-weight-bold">Las mejores opciones entre las que elegir</h4>
				<p class="text-dark font-weight-light">Colaboramos con las compañías más importantes del mercado</p>
			</div>
			<div class="col-4 text-center p-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/tres-mares-icon-why-3.svg'?>" alt="Seguros para aquello que necesites" class="mb-2 why-icon">
				<h4 class="font-weight-bold">Gestionamos tus siniestros</h4>
				<p class="text-dark font-weight-light">Peleamos para que tus intereses estén bien protegidos</p>
			</div>
		</div>
	</section>
	<div style="margin-top: 165px">
	 <?php
		$page = 5;
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/footer.php' );
	 ?>
	</div>


	<div style="page-break-after:always;"></div>
	<!-- PÁG 5 -->
	<?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-9.svg'?>" alt="Compromisos tres mares">
				Compromisos Tres Mares
			</div>			
		</div>
		<div class="row">
			<div class="col-4 text-center px-5 pt-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/tres-mares-icon-compromiso-1.svg'?>" alt="Las mejores compañías de seguros" class="mb-4 compromiso-icon" >
				<h3 class="font-weight-bold text-danger h2">1</h3>
				<h4 class="font-weight-bold">Las mejores compañías de seguros</h4>
				<p class="text-dark font-weight-light">Te facilitamos la decisión de elegir una compañía de seguros. Trabajamos solo con aseguradoras top.</p>
			</div>
			<div class="col-4 text-center px-5 pt-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/tres-mares-icon-compromiso-2.svg'?>" alt="Cambia de correduría sin cambiar de compañía" class="mb-4 compromiso-icon" >
				<h3 class="font-weight-bold text-danger h2">2</h3>
				<h4 class="font-weight-bold">Cambia de correduría sin cambiar de compañía</h4>
				<p class="text-dark font-weight-light">Te ayudamos con tus seguros independientemente de con quien tengas tus  pólizas.</p>
			</div>
			<div class="col-4 text-center px-5 pt-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/tres-mares-icon-compromiso-3.svg'?>" alt="Ahorro más allá de lo económico" class="mb-4 compromiso-icon" >
				<h3 class="font-weight-bold text-danger h2">3</h3>
				<h4 class="font-weight-bold">Ahorro más allá de lo económico</h4>
				<p class="text-dark font-weight-light">Queremos lo mejor para ti. Por eso luchamos porque tus intereses prevalezcan.</p>
			</div>
			<div class="col-4 text-center px-5 pt-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/Businessman Card 3.svg'?>" alt="Compartimos intereses" class="mb-4 compromiso-icon" >
				<h3 class="font-weight-bold text-danger h2">4</h3>
				<h4 class="font-weight-bold">Compartimos intereses</h4>
				<p class="text-dark font-weight-light">Desde un seguro de vida a uno para tu nueva nave espacial.</p>
			</div>
			<div class="col-4 text-center px-5 pt-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/Problem Solving 1.svg'?>" alt="Te ahorramos a investigar" class="mb-4 compromiso-icon" >
				<h3 class="font-weight-bold text-danger h2">5</h3>
				<h4 class="font-weight-bold">Te ahorramos a investigar</h4>
				<p class="text-dark font-weight-light">No dejamos de analizar e indagar sobre garantías y coberturas para ofrecerte lo mejor de lo mejor en tu póliza.</p>
			</div>
			<div class="col-4 text-center px-5 pt-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/Going Onwards With Optimism 5.svg'?>" alt="Te ayudamos a vivir mejor" class="mb-4 compromiso-icon" >
				<h3 class="font-weight-bold text-danger h2">6</h3>
				<h4 class="font-weight-bold">Te ayudamos a vivir mejor</h4>
				<p class="text-dark font-weight-light">Luchamos para que disfrutes una vida tranquila, protegido frente a viento y marea.</p>
			</div>
		</div>
	</section>

	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-10.svg'?>" alt="Compañías con las que colaboramos">
				Compañías con las que colaboramos
			</div>			
		</div>
		<div class="row mt-4 justify-content-center">
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/logogenerali.svg'?>" alt="Generali Seguros" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/logoaxa.svg'?>" alt="Axa" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/zurich-logo-asd.svg'?>" alt="Zurich" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/sanitas-en-color.svg'?>" alt="Sanitas" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/catalana-occidente-Convertido.svg'?>" alt="Catalana Occidente" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/dkv-color-af.svg'?>" alt="DKV" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/caser-seguros-Convertido-1.svg'?>" alt="Caser" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/allianz-2-1-1.svg'?>" alt="Allianz" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/adeslas-colorsdg.svg'?>" alt="Adeslas" class="img-fluid">
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/reale logo.svg'?>" alt="Reale" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/mapfre-logo-1.svg'?>" alt="Mapfre" class="img-fluid">
			</div>			
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/pelayo-Convertido.svg'?>" alt="Pelayo" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/liberty-seguros-Convertido.svg'?>" alt="Liberty Seguros" class="img-fluid">
			</div>
			<div class="col-1">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/logoasisa.svg'?>" alt="Asisa" class="img-fluid">
			</div>
		</div>
	</section>
	<div style="margin-top: 50px">
	 <?php
		$page = 6;
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/footer.php' );
	 ?>
	</div>

	<div style="page-break-after:always;"></div>
	<!-- PÁG 6 -->
	<?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-10.svg'?>" alt="Información previa">
				Información previa
			</div>			
		</div>
		<div class="row my-5">
			<div class="col">
				<span class="text-primary">¿En qué consiste este tipo de seguro?</span> <span class="font-weight-light text-dark">Concebido como complemento del seguro Multirriesgo familia-hogar y diseñado  especialmente para cubrir las necesidades asegurativas de edificios de viviendas tanto si están distribuidos en copropiedad como si  están destinados a alquiler.  También se podrán suscribir.</span>
			</div>
		</div>
		<div class="row pt-5 pb-2 border-top border-semitransparent">
			<div class="col-6 border-right border-semitransparent pr-5">
				<h4 class="text-center font-weight-bold text-primary">¿Qué se asegura?</h4>
				<div class="d-flex flex-row mt-5">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/check-1.png'?>" alt="check" style="width: 18px;">
					</div>
					<div class="mt-1">
						<h6>Cobertura 24 Horas</h6>
						<p class="text-dark font-weight-light font-small">Cubre las 24 horas del día, todos los días del año. También si se viaja al extranjero.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/check-1.png'?>" alt="check" style="width: 18px;">
					</div>
					<div class="mt-1">
						<h6>Deportes</h6>
						<p class="text-dark font-weight-light font-small">Quedan incluidos la práctica de cualquier deporte como amateur. Sin incluir la práctica como profesional ni competición federativa</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/check-1.png'?>" alt="check" style="width: 18px;">
					</div>
					<div class="mt-1">
						<h6>Cobertura motos</h6>
						<p class="text-dark font-weight-light font-small">Quedan incluidos los accidentes de motocicleta de cualquier cilindrada.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/check-1.png'?>" alt="check" style="width: 18px;">
					</div>
					<div class="mt-1">
						<h6>Fallecimiento / Invalidez Permanente Absoluta por Accidente</h6>
						<p class="text-dark font-weight-light font-small">Si como consecuencia de un accidente cubierto por la póliza, se produjera el Fallecimiento inmediatamente	o en el plazo de un año a contar desde la fecha	del	accidente</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/check-1.png'?>" alt="check" style="width: 18px;">
					</div>
					<div class="mt-1">
						<h6>Fracturas</h6>
						<p class="text-dark font-weight-light font-small">Se indemnizará al asegurado con la suma estipulada para la lesión producida en la tabla de indemnizaciones de la póliza.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/check-1.png'?>" alt="check" style="width: 18px;">
					</div>
					<div class="mt-1">
						<h6>Gastos de reforma de la vivienda o vehículo en caso de Invalidez Permanente Absoluta por Accidente</h6>
						<p class="text-dark font-weight-light font-small">Se	pagará	el	80%	del	coste	de	reformas	realizadas	en	la  vivienda	habitual	o	en	el	vehículo,	tanto	para	realizar	sus  actividades	diarias,	como	para	permanecer	dentro	de	su	hogar  y	moverse	por	él.</p>
					</div>
				</div>
			</div>
			<div class="col-6 pl-5">
				<h4 class="text-center font-weight-bold text-danger">¿Qué No se asegura?</h4>
				<div class="d-flex flex-row mt-5">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/block.svg'?>" alt="block" style="width: 18px;">
					</div>
					<div class="mt-1">
						<p class="text-dark font-weight-light font-small">La	participación	del	Asegurado	en	acciones	delictivas,  provocaciones,	riñas	y	duelos,	carreras,	apuestas	o	cualquier  actuación/empresa	arriesgada	o	temeraria.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/block.svg'?>" alt="block" style="width: 18px;">
					</div>
					<div class="mt-1">
						<p class="text-dark font-weight-light font-small">La	práctica	como	profesional	o	federado	de	cualquier	deporte,  así	como	en	todo	caso	aquellas	actividades	enumeradas	en	el  Contrato	de	seguro.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/block.svg'?>" alt="block" style="width: 18px;">
					</div>
					<div class="mt-1">
						<p class="text-dark font-weight-light font-small">Acontecimientos	de	guerra,	aun	cuando	no	haya	sido  declarada,	rebeliones,	revoluciones,	tumultos	populares,  terremotos,	inundaciones,	huracanes	y	erupciones	volcánicas.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/block.svg'?>" alt="block" style="width: 18px;">
					</div>
					<div class="mt-1">
						<p class="text-dark font-weight-light font-small">Los	accidentes	sufridos	por	el	Asegurado	en	estado	de  embriaguez,	o	bajo	la	acción	de	drogas	narcóticas,  euforizantes,	psicotrópicas	de	carácter	prohibido.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/block.svg'?>" alt="block" style="width: 18px;">
					</div>
					<div class="mt-1">
						<p class="text-dark font-weight-light font-small"> Imprudencias	o	negligencias	graves.</p>
					</div>
				</div>
				<h4 class="text-center font-weight-bold text-dark mt-5 pt-5 border-top border-semitransparent"> ¿Existen	restricciones	en	lo	que  respecta	a	la	cobertura?</h4>
				<div class="d-flex flex-row mt-5">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/alert.svg'?>" alt="Alerta" style="width: 18px;">
					</div>
					<div class="mt-1">
						<p class="text-dark font-weight-light font-small">El	Tomador	de	la	póliza	deberá	tener	entre	18	y	70	años.</p>
					</div>
				</div>
				<div class="d-flex flex-row mt-3">
					<div class="mr-4">
						<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/alert.svg'?>" alt="Alerta" style="width: 18px;">
					</div>
					<div class="mt-1">
						<p class="text-dark font-weight-light font-small">Los límites	económicos	y	temporales	que	figuren	en	las  Condiciones	Generales	y/o	Particulares.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div style="margin-top: -5px">
	 <?php
		$page = 7;
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/footer.php' );
	 ?>
	</div>

	<div style="page-break-after:always;"></div>
	<!-- PÁG 7 -->
	<?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-12.svg'?>" alt="Anotaciones legales">
				Algunas anotaciones legales que deberías leer
			</div>			
		</div>
		<div class="row my-5">
			<div class="col">
				<h6 class="text-primary">Las cosas, claras.</h6>
				<p class="font-weight-light">
				  Este presupuesto ha sido emitido por <?php echo WPCONFIG_NAME_EMPRESA; ?>, con CIF B39524087 y con domicilio en <?php echo WPCONFIG_DIRECCION_EMPRESA; ?>, inscrita en el Registro de la Dirección General de Seguros y Fondos de Pensiones con el número [J2457]. Puede consultar nuestra inscripción en el registro en la página web de la DGSFP: <a href="https://dgsfp.mineco.gob.es/">https://dgsfp.mineco.gob.es/</a>.
				</p>

				<p class="font-weight-light">
				  La comercialización de este producto de Accidentes, la realiza <?php echo WPCONFIG_NAME_EMPRESA; ?> como entidad colaboradora de Aunna Broker Correduría de Seguros, con CIF B87345070 y con domicilio en Calle Doctor Fleming nº 53, 28036 – Madrid, inscrita en el Registro de la Dirección General de Seguros y Fondos de Pensiones con el número [J3310].
				</p>

				<p class="font-weight-light">
				  Este presupuesto tiene carácter meramente informativo y no constituye una oferta en firme ni el inicio de un contrato de seguro. Las condiciones definitivas estarán sujetas a la aceptación de la compañía aseguradora correspondiente.
				</p>

				<p class="font-weight-light">
				  De conformidad con el Reglamento (UE) 2016/679 (Reglamento General de Protección de Datos) y la Ley Orgánica 3/2018 de Protección de Datos Personales y garantía de los derechos digitales, le informamos de que los datos proporcionados serán tratados con la finalidad de gestionar el presente presupuesto. El responsable del tratamiento de los datos es <?php echo WPCONFIG_NAME_EMPRESA; ?>. Puede ejercer sus derechos de acceso, rectificación, supresión, oposición, limitación y portabilidad mediante comunicación escrita a <?php echo WPCONFIG_MAIL_EMPRESA; ?> o en <?php echo WPCONFIG_DIRECCION_EMPRESA; ?>.
				</p>

				<p class="font-weight-light">
				  Si tiene alguna discrepancia o incidencia relacionada con nuestros servicios, puede dirigirse a nuestro Departamento de Atención al Cliente en <?php echo WPCONFIG_MAIL_EMPRESA_PARA_PUBLICO; ?> o llamando al <?php echo WPCONFIG_TELEFONO_EMPRESA; ?>.
				</p>

				<p class="font-weight-light">
				  Si no hemos satisfecho sus demandas o expectativas, puede dirigir su queja o reclamación por escrito a nuestro Servicio de Atención al Cliente (Aunna Broker Correduría de Seguros) con dirección en Calle Doctor Fleming nº 53, 28036 – Madrid y email atencionalcliente@aunnaasociacion.es.
				</p>

				<p class="font-weight-light">
				  Dicho servicio resolverá las quejas o reclamaciones a la mayor brevedad. Asimismo, tiene derecho a presentar una reclamación ante el Servicio de Reclamaciones de la Dirección General de Seguros y Fondos de Pensiones, si lo considera oportuno.
				</p>

				<p class="font-weight-light">
				  Este presupuesto será válido durante un plazo de [15] días a partir de la fecha de emisión, salvo modificaciones en las condiciones generales y particulares de las aseguradoras involucradas.
				</p>

				<p class="font-weight-light">Legislación y condiciones aplicables:</p>
				<ul>
				  <li>Ley 50/80 de Contrato de Seguro, de 8 de octubre.</li>
				  <li>Ley 20/2015 de 14 de julio de Ordenación, Supervisión y Solvencia de las Entidades Aseguradoras y Reaseguradoras.</li>
				  <li>Ley 7/2004, de 29 de octubre, en lo relativo a la regulación del estatuto legal del Consorcio de Compensación de Seguros.</li>
				  <li>Cualquier otra norma que durante la vigencia de la póliza pueda ser aplicable.</li>
				  <li>Las coberturas de la póliza se regirán por las condiciones particulares, generales, y especiales en su caso, de la póliza de seguro.</li>
				</ul>

			</div>
		</div>
	</section>
	<div style="margin-top: 125px">
	 <?php
		$page = 8;
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/footer.php' );
	 ?>
	</div>


	<div style="page-break-after:always;"></div>
	<!-- PÁG 7 -->
	<?php
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/header.php' );
	 ?>
	<section class="container mt-4">
		<div class="row bg-primary-solid ml-4 pt-1">
			<div class="col text-white text-uppercase pl-5">
				<img class="icon-facts" src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-section-12.svg'?>" alt="Anotaciones legales">
				Algunas anotaciones legales que deberías leer
			</div>			
		</div>
		<div class="row my-5">
			<div class="col">
				<h6 class="text-primary">NOTA INFORMATIVA SOBRE COLABORACION EN DISTRIBUCION</h6>
				<p class="font-weight-light"></p>

				<p class="font-weight-light">
				  Que conforme a la normativa de distribución de seguros y reaseguros privados se informa que para el contrato de seguro ofrecido/propuesto por IBROK 2010, CORREDURIA DE SEGUROS S.L. actúa bajo responsabilidad de AUNNA BROKER CORREDURIA DE SEGUROS S.L.U. 100% participada de AUNNA ASOCIACION DE EMPRESARIOS CORREDORES DE SEGUROS. Siendo AUNNA BROKER quien figura como mediador en el contrato bajo la clave que tiene asignada en la Aseguradora.
				</p>

				<p class="font-weight-light">
				  IBROK 2010, CORREDURIA DE SEGUROS S.L. con clave autorizada J-0071-CAC, mantiene una relación mercantil de colaboración con AUNNA BROKER CORREDURIA DE SEGUROS S.L.U., sita en C/ Doctor Fleming 53, 28036 - Madrid y con C.I.F. B87345070, dedicada a la actividad de correduría de seguros y autorizada por la Dirección General de Seguros y Fondos de Pensiones con la clave J3310 y correctamente inscrita en el Registro administrativo de distribuidores de seguros, que puede Vd. comprobar en la página web de la Dirección General de Seguros y Fondos de Pensiones: <a href="http://www.dgsfp.mineco.es">www.dgsfp.mineco.es</a>.
				</p>

				<p class="font-weight-light">
				  AUNNA BROKER tiene suscrita póliza de Responsabilidad Civil Profesional Hispania Global Underwriting, agencia de suscripción, y dispone de capacidad financiera legalmente establecida. Cumple todos los requisitos referidos a la honorabilidad profesional y comercial exigibles a su órgano de administración y a la persona responsable de la distribución.
				</p>

				<p class="font-weight-light">
				  AUNNA BROKER cuenta con un departamento de atención al cliente externalizado, encargado de atender y resolver sus quejas y reclamaciones, a través de AUNNA ASOCIACION DE EMPRESARIOS CORREDORES DE SEGUROS, cuyos datos son los siguientes: AUNNA DEPARTAMENTO DE ATENCION AL CLIENTE, C/ Doctor Fleming 53, 28036 Madrid, email atencionalcliente@aunnaasociacion.es, telf. 910 339 615.
				</p>

				<p class="font-weight-light">
				  Para los contratos suscritos en colaboración con AUNNA BROKER, ambas corredurías han establecido el tratamiento de sus datos de carácter personal como corresponsables del tratamiento de datos, de conformidad con lo previsto en el art. 26.1 del Reglamento (UE) 2016/679, teniendo usted derecho a solicitar a ambos la política de tratamiento de datos y el ejercicio de sus derechos.
				</p>

				<p class="font-weight-light">
				  Los corredores/corredurías de seguros son los únicos profesionales facultados para asesorarle desde la más estricta independencia e imparcialidad, respecto de las entidades aseguradoras. Es por ello que las ofertas que sometemos a su consideración han sido basadas en un análisis objetivo, consistente en analizar de forma generalizada un número suficiente de contratos de seguros ofrecidos por entidades aseguradoras que operan en el mercado, considerando que corresponde a su petición dentro de una valoración de méritos para buscar una correcta cobertura a sus requerimientos y necesidades.
				</p>

				<p class="font-weight-light">
				  El corredor/correduría informa igualmente al cliente del contenido del artº 21 de la Ley 50/1980, de Contrato de Seguro, de forma tal que las comunicaciones que el mediador curse a la aseguradora surtirán los mismos efectos como si las realizara el propio interesado (tomador).
				</p>

				<p class="font-weight-light">
				  Mediante el presente escrito, y en méritos del principio de autonomía de la voluntad de las partes, el cliente otorga consentimiento expreso y autoriza al corredor/correduría para que éste pueda solicitar cotizaciones, modificar o rescindir los contratos de seguros en vigor y mediar y celebrar en su nombre nuevos contratos de seguro, para la mejor protección de los derechos del cliente.
				</p>

			</div>
		</div>
	</section>
	<div style="margin-top: 75px">
	 <?php
		$page = 9;
	 	include( SACAIG_PLUGIN_PATH . 'templates/proyectos_pdf/parts/footer.php' );
	 ?>
	</div>
	 
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
