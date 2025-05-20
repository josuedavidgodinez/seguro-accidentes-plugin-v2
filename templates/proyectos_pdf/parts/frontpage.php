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
		.caja-fondo{background:#00969626; height:135px; max-width:90%;border-radius:15px; margin-top:625px;padding-top:5px;}
		h1.title_pdf{font-size:40px;}
		.logo-compania-fp{width: 100%;margin-top:30px}
		.mt-455{margin-top:200px;}
		.titl-elb{font-size:18px; color:#009696; margin-right:35px; font-weight:normal; position:relative; top:15px;}
		.txt-cj-fond{color:#004481;font-weight:bold; font-size: 35px; text-transform: uppercase; padding-top:50px; padding-left:}
	</style>
</head>
<body>
	<div class="container mt-5 pt-3">
		<div class="row justify-content-start mt-455">
			<div class="col-12">
				<h6 class="text-primary text-uppercase mb-0">Proyecto</h6>
				<h1 class="font-weight-bold text-uppercase title_pdf mb-5">Seguro Accidentes</h1>
			</div>
		</div>
		<div class="row justify-content-center mb-3">
			<div class="col-10">
				<img src="<?= WPCONFIG_LOGO_ORIGINAL_EMPRESA; ?>" class="logo-compania-fp">
			</div>	
		</div>
		<div class="row justify-content-center">
			<div class="col-12 caja-fondo text-center">
				<div class="row txt-cj-fond justify-content-center">
					<span class="titl-elb">Elaborado para</span> <?=$nombre_tomador; ?> <?=$apellidos_tomador; ?>
				</div>			
			</div>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>