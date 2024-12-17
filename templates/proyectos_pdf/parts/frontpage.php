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
		.bg-primary-transparent-1 {background: #00969610;}
		.bg-primary-transparent-2 {background: #00969620;}
		.border-width-custom-1 {border-width: 2px !important;}
		.border-width-custom-2 {border-width: 3px !important;}
		.border-semitransparent {border-color:#00969630 !important;}
	</style>
</head>
<body>
	<div class="container mt-5 pt-3">
		<div class="row justify-content-center mb-3" >
			<div class="col-3">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/logo-3mares-1.svg'?>" alt="Nombre Empresa Seguros" class="w-100">
			</div>
		</div>
		<div class="row justify-content-center mt-4">
			<div class="col-5">
				<h6 class="text-primary text-uppercase mb-0">Proyecto</h6>
				<h1 class="font-weight-bold text-uppercase mb-5">Seguro Accidentes</h1>
			</div>
		</div>
		<div class="row justify-content-center mb-3">
			<div class="col-5">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/ilustracion-accidentes.svg'?>" class="w-100">
			</div>	
		</div>
		<div class="row justify-content-center">
			<div class="col-6 border-top border-primary border-width-custom-1 pt-4 px-5">
				<div class="row mb-2">
					<div class="col-6">
						Nombre y apellidos:
					</div>
					<div class="col-6 font-weight-light text-secondary">
					<?=$nombre_completo_asegurado; ?>
					</div>	
				</div>
				<div class="row mb-2">
					<div class="col-6">
						Riesgo:
					</div>
					<div class="col-6 font-weight-light text-secondary">
						Lorem ipsum
					</div>	
				</div>	
				<div class="row mb-2">
					<div class="col-6">
						Lorem ipsum:
					</div>
					<div class="col-6 font-weight-light text-secondary">
						Lorem ipsum
					</div>	
				</div>	
				<div class="row mb-2">
					<div class="col-6">
						Lorem ipsum:
					</div>
					<div class="col-6 font-weight-light text-secondary">
						Lorem ipsum
					</div>	
				</div>			
			</div>
		</div>
		<div class="row mt-5 pt-5 justify-content-center">
			<div class="col-9 mt-4">
				<p class="font-weight-light font-small text-center">Concertado seguro de Responsabilidad Civil según art. 27 Ley 26/2006 del 17 de Julio.</p>
			</div>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>