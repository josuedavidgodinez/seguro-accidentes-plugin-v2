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
            src: url('fonts/Fieldwork-Geo-Regular.ttf') format("truetype");
            font-style: normal; 
            font-weight: normal; 
        }

        @font-face { 
            font-family: 'Fieldwork'; 
            src: url('fonts/Fieldwork-GeoThin.ttf') format("truetype");
            font-style: normal; 
            font-weight: 200; 
        }

        @font-face { 
            font-family: 'Fieldwork';
            src: url('fonts/Fieldwork-Geo-Bold.ttf') format("truetype"); 
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
		.bg-degraded {background: linear-gradient(90deg, rgba(197,233,235,1) 0%, rgba(255,255,255,1) 100%);}
		.border-width-custom-1 {border-width: 2px !important;}
		.border-width-custom-2 {border-width: 3px !important;}
		.border-semitransparent {border-color:#00969630 !important;}
	</style>
</head>
<body>
	<div class="container">
		<div class="row border-bottom border-primary border-width-custom-1">
			<div class="col-6 bg-degraded">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/ilustracion-accidentes.svg'; ?>" alt="Seguro de Accientes" style="width: 170px;" class="ml-4">
			</div>
			<div class="col-6 text-right mt-2 d-flex">
				<div class="align-self-center ml-auto">
					<p class="text-primary text-uppercase mb-0">Proyecto</p>
					<p class="font-weight-bold text-uppercase h5">Seguro Accientes</p>
					<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/logo-3mares-1.svg'; ?>" alt="Tres Mares Correduría de Seguros" style="width: 170px;" class="mt-2">
				</div>
			</div>
		</div>
		<div class="row bg-light my-3 py-3">
			<div class="col-4 font-small">
				<div class="row mb-1">
					<div class="col-5">
						Proyecto:
					</div>
					<div class="col-7 font-weight-light text-secondary">
						Seguro Accidentes
					</div>	
				</div>
				<div class="row">
					<div class="col-5">
						Mediador:
					</div>
					<div class="col-7 font-weight-light text-secondary">
						Tres Mares Correduría
					</div>	
				</div>			
			</div>
			<div class="col-4 font-small">
				<div class="row mb-1">
					<div class="col-5">
						Fecha proyecto:
					</div>
					<div class="col-7 font-weight-light text-secondary">
						<?= $fecha_hoy ?>
					</div>	
				</div>
				<div class="row">
					<div class="col-5">
						Cód. Mediador:
					</div>
					<div class="col-7 font-weight-light text-secondary">
						<?= SACAIG_CODIGO_MEDIADOR ?>
					</div>	
				</div>			
			</div>
			<div class="col-4 font-small">
				<div class="row mb-1">
					<div class="col-5">
						Fecha de validez:
					</div>
					<div class="col-7 font-weight-light text-secondary">
						 -
					</div>	
				</div>		
			</div>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>