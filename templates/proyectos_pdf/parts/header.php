
	<div class="container">
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
		.bg-degraded {background: linear-gradient(90deg, rgba(197,233,235,1) 0%, rgba(255,255,255,1) 100%);}
		.border-width-custom-1 {border-width: 2px !important;}
		.border-width-custom-2 {border-width: 3px !important;}
		.border-semitransparent {border-color:#00969630 !important;}
	</style>
		<div class="row border-bottom border-primary border-width-custom-1 pb-0">
			<div class="col-6 bg-degraded">
				<img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/ilustracion-accidentes.svg'; ?>" style="width: 200px;" class="ml-4">
			</div>
			<div class="col-6 text-right mt-1 d-flex">
				<div class="align-self-center ml-auto">
					<p class="text-primary text-uppercase mb-0">Proyecto</p>
					<p class="font-weight-bold text-uppercase h5">Seguro Accidentes</p>
					<img src="<?= WPCONFIG_LOGO_ORIGINAL_EMPRESA; ?>"  style="width: 180px;" class="mt-2">
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
						Accidentes
					</div>	
				</div>
				<div class="row">
					<div class="col-5">
						Mediador:
					</div>
					<div class="col-7 font-weight-light text-secondary">
						<?=WPCONFIG_NAME_EMPRESA; ?>
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
						<?=$fecha_al_anio_format; ?>
					</div>	
				</div>		
			</div>
		</div>
	</div>
