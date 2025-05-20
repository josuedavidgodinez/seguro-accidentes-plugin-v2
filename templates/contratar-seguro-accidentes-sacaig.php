<?php

	get_header();

	echo do_shortcode('[turnstile_protect]');

	//Botonos de volver y salir
	require( SACAIG_PLUGIN_PATH . 'parts/salir-proceso.php' ) ;
	//Pantalla de loading 
	require( SACAIG_PLUGIN_PATH . 'parts/loader-simple.php' );

	global $wpdb;

	//Traemos las profesiones
	$table_name = $wpdb->prefix . 'profesiones_accidentes_riesgos';

	// Realizar la consulta
	$results = $wpdb->get_results("SELECT id, profesion FROM $table_name");
?>



<div id="primary" class="content-area viajes-inter step-funct-forms">
	<main id="main" class="site-main product-temp" role="main">

		<!-- COMIENZA BLOQUE IZQUIERDO -->
		<div class="bloque-sin-left principal-left">

			<div class="container-mini-tarif-viajes">

				<!-- COMIENZA EL FORMULARIO -->
				<form id="form-contratacion-aig" action="/firma-seguro-accidentes" method="POST" class="form-validado multistep-asg" novalidate>

					<img class="img-sgviajes" src="<?= SACAIG_IMAGEN_PLUGIN; ?>" alt="Calcula el precio de tu <?= SACAIG_PRODUCTO_NOMBRE; ?>">

					<?php 
						// Incluir el archivo desde la carpeta "parts"
						include( SACAIG_PLUGIN_PATH . 'parts/steps-form.php' );
					?>	



					<!-- PANTALLA 1 -->
					<div id="step-form-anim-1">

						<h2 class="title-viajes">Acerca de tu perfil de riesgo</h2>
						<p class="mb-0">Para diseñar tu seguro ideal, necesitamos conocer tu actividad principal.</p>

						<div class="text-start franja franja-forms-multstp">
							
							<div class="card-forms">								
								<div class="row g-4">
									<div class="col-12">
										<label for="profesion" class="form-label">Profesión</label>
										<select name="profesion" id="profesion" class="j2 form-control insulead-profesion" autocomplete="off" required>
											<option value="" selected disabled>Selecciona tu profesión actual</option>
											<?php 
												foreach ($results as $row) {
												    echo '<option value="' . esc_attr($row->id) . '">' . esc_html($row->profesion) . '</option>';
												}
											 ?>
										</select>
									</div>

								</div>
							</div>	

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg">Siguiente paso</div>
							</div>

						</div>

					</div>
					<!-- FIN PANTALLA 1 -->



					<!-- PANTALLA 2 -->
					<div id="step-form-anim-2">
						<h2 class="title-viajes">¿Realizas algún tipo de trabajo manual?</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">

								<div class="row g-4">
									<label for="actividad_maual" class="form-label label_radio_buttons"></label>
								    <div class="d-flex justify-content-center boxi-rb flex-wrap flex-md-nowrap justify-content-center two-points-multsp m-auto">
								    	<div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="actividad_maual" class="form-check-input" id="actividad_maual_yes" value="si" required>							        
									        <label for="actividad_maual_yes">
									        	Sí
									    	</label>
									    </div>
									    <div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="actividad_maual" class="form-check-input" id="actividad_maual_no" value="no" required checked>
									        <label for="actividad_maual_no">
									        	No
									        </label>
									    </div>
								    </div>	  
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="suma-asegurada-step">Siguiente paso</div>
							</div>
						</div>

					</div>
					<!-- FIN PANTALLA 2 -->


					<!-- PANTALLA 3 -->
					<div id="step-form-anim-3">
						<h2 class="title-viajes">Indica que tipo de trabajo manual realizas</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">								
								<div class="row g-4">
									<div class="col-12 caja_exp">
										<label for="descr_trabajo_manual" class="form-label"></label>
										<textarea class="form-control" name="descr_trabajo_manual" id="descr_trabajo_manual" placeholder="Trata de ser lo más descriptivo posible" required></textarea>
									</div>
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="suma-asegurada-step">Siguiente paso</div>
							</div>
						</div>
						
					</div>
					<!-- FIN PANTALLA 3 -->


					<!-- PANTALLA 4 -->
					<div id="step-form-anim-4">
						<h2 class="title-viajes">¿Has padecido o padeces algún tipo de enfermedad cardíaca?</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">

								<div class="row g-4">
									<label for="enf_cardiaca" class="form-label label_radio_buttons"></label>
								    <div class="d-flex justify-content-center boxi-rb flex-wrap flex-md-nowrap justify-content-center two-points-multsp m-auto">
								    	<div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="enf_cardiaca" class="form-check-input" id="enf_cardiaca_yes" value="si" required>							        
									        <label for="enf_cardiaca_yes">
									        	Sí
									    	</label>
									    </div>
									    <div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="enf_cardiaca" class="form-check-input" id="enf_cardiaca_no" value="no" required checked>
									        <label for="enf_cardiaca_no">
									        	No
									        </label>
									    </div>
								    </div>	  
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="suma-asegurada-step">Siguiente paso</div>
							</div>
						</div>

					</div>
					<!-- FIN PANTALLA 4 -->


					<!-- PANTALLA 5 -->
					<div id="step-form-anim-5">
						<h2 class="title-viajes">Facilítanos información detallada acerca de tu enfermedad cardíaca</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">								
								<div class="row g-4">
									<div class="col-12 caja_exp">
										<label for="enf_cardiaca_descript" class="form-label"></label>
										<textarea class="form-control" name="enf_cardiaca_descript" id="enf_cardiaca_descript" placeholder="Trata de ser lo más descriptivo posible" required></textarea>
									</div>
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="suma-asegurada-step" required>Siguiente paso</div>
							</div>
						</div>
						
					</div>
					<!-- FIN PANTALLA 5 -->

					<!-- PANTALLA 6 -->
					<div id="step-form-anim-6">
						<h2 class="title-viajes">¿Tienes algún tipo de enfermedad grave o discapacidad?</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">

								<div class="row g-4">
									<label for="enf_grave" class="form-label label_radio_buttons"></label>
								    <div class="d-flex justify-content-center boxi-rb flex-wrap flex-md-nowrap justify-content-center two-points-multsp m-auto">
								    	<div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="enf_grave" class="form-check-input" id="enf_grave_yes" value="si" required>							        
									        <label for="enf_grave_yes">
									        	Sí
									    	</label>
									    </div>
									    <div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="enf_grave" class="form-check-input" id="enf_grave_no" value="no" required checked>
									        <label for="enf_grave_no">
									        	No
									        </label>
									    </div>
								    </div>	  
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="suma-asegurada-step">Siguiente paso</div>
							</div>
						</div>

					</div>
					<!-- FIN PANTALLA 6 -->


					<!-- PANTALLA 7 -->
					<div id="step-form-anim-7">
						<h2 class="title-viajes">Facilítanos información detallada acerca de tus problemas de salud y/o discapacidad</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">								
								<div class="row g-4">
									<div class="col-12 caja_exp">
										<label for="enf_grave_desctip" class="form-label"></label>
										<textarea class="form-control" name="enf_grave_desctip" id="enf_grave_desctip" placeholder="Trata de ser lo más descriptivo posible" required></textarea>
									</div>
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="suma-asegurada-step">Siguiente paso</div>
							</div>
						</div>
						
					</div>
					<!-- FIN PANTALLA 7 -->

					
					<!-- PANTALLA 8 -->
					<div id="step-form-anim-8">
						<h2 class="title-viajes">Datos persona asegurada</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">					
								<div class="row g-4">

								    <div class="col-12 col-md-6">
										<label for="nombre" class="form-label">Nombre</label>
										<input type="text" class="form-control name-vrf insulead-nombre" name="nombre" maxlength="100" placeholder="Ejemplo: Juan" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="apellidos" class="form-label">Primer apellido</label>
										<input type="text" class="form-control apellidos-vrf insulead-apellidos" name="apellidos" maxlength="150" placeholder="Ejemplo: Pérez" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="apellidos-autorizado-2" class="form-label">Segundo apellido</label>
										<input type="text" class="form-control apellidos-vrf insulead-apellidos" name="apellidos-autorizado-2" maxlength="150" placeholder="Ejemplo: López" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="codigo_postal" class="form-label">Código Postal</label>
										<input type="number" class="form-control codigo_postal_vrf insulead-codigo-postal" name="codigo_postal" id="codigo_postal" placeholder="Ejemplo: 28001" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="provincia" class="form-label">Provincia</label>
										<select name="provincia" id="provincia" class="select2 form-control provincia_vrf insulead-provincia" required>
											<option selected disabled value="">Selecciona tu provincia</option>
											<option value="01">Álava</option>
											<option value="02">Albacete</option>
											<option value="03">Alicante</option>
											<option value="04">Almería</option>
											<option value="33">Asturias</option>
											<option value="05">Ávila</option>
											<option value="06">Badajoz</option>
											<option value="08">Barcelona</option>
											<option value="09">Burgos</option>
											<option value="10">Cáceres</option>
											<option value="11">Cádiz</option>
											<option value="39">Cantabria</option>
											<option value="12">Castellón</option>
											<option value="13">Ciudad Real</option>
											<option value="14">Córdoba</option>
											<option value="16">Cuenca</option>
											<option value="17">Gerona</option>
											<option value="18">Granada</option>
											<option value="19">Guadalajara</option>
											<option value="20">Guipúzcoa</option>
											<option value="21">Huelva</option>
											<option value="22">Huesca</option>
											<option value="07">Islas Balears</option>
											<option value="23">Jaén</option>
											<option value="15">La Coruña</option>
											<option value="26">La Rioja</option>
											<option value="35">Las Palmas</option>
											<option value="24">León</option>
											<option value="25">Lérida</option>
											<option value="27">Lugo</option>
											<option value="28">Madrid</option>
											<option value="29">Málaga</option>
											<option value="30">Murcia</option>
											<option value="31">Navarra</option>
											<option value="32">Orense</option>
											<option value="34">Palencia</option>
											<option value="36">Pontevedra</option>
											<option value="37">Salamanca</option>
											<option value="38">Santa Cruz de Tenerife</option>
											<option value="40">Segovia</option>
											<option value="41">Sevilla</option>
											<option value="42">Soria</option>
											<option value="43">Tarragona</option>
											<option value="44">Teruel</option>
											<option value="45">Toledo</option>
											<option value="46">Valencia</option>
											<option value="47">Valladolid</option>
											<option value="48">Vizcaya</option>
											<option value="49">Zamora</option>
											<option value="50">Zaragoza</option>
										</select>
									</div>

									<div class="col-12 col-md-6">
										<label for="poblacion" class="form-label">Población</label>
										<input type="text" class="form-control insulead-poblacion" name="poblacion" id="poblacion" maxlength="100" placeholder="Ejemplo: Madrid" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="dirección" class="form-label">Dirección</label>
										<input type="text" class="form-control insulead-direccion" name="dirección" id="dirección" maxlength="100" placeholder="Ejemplo: Calle Gran Vía 22 - 2º B" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="identificador" class="form-label">NIF/NIE</label>
										<input type="text" class="form-control identificador-vrf insulead-identificacion" name="identificador" id="identificador" placeholder="Ejemplo: 12345678X" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="email" class="form-label">Email</label>
										<input type="email" class="form-control email-vrf insulead-email" name="email" id="email" placeholder="Ejemplo: mail@gmail.com" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="telefono" class="form-label">Teléfono Móvil</label>
										<input type="tel" class="form-control telefono-vrf insulead-telefono" name="telefono" id="telefono" placeholder="Ejemplo: 655 123 456" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
										<input type="text" class="form-control fecha_nacimient_vrf insulead-fecha-nacimiento" name="fecha_nacimiento" id="fecha_nacimiento_input" placeholder="Selecciona una fecha" required>
									</div>
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="btn-paso-8">Siguiente paso</div>
							</div>

						</div>	
					</div>
					<!-- FIN PANTALLA 8 -->

					<!-- PANTALLA 9 -->
					<div id="step-form-anim-9">
						<h2 class="title-viajes">¿Los datos del tomador son diferentes a los del asegurado?</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">

								<div class="row g-4">
									<label for="tomador_diferente" class="form-label label_radio_buttons"></label>
								    <div class="d-flex justify-content-center boxi-rb flex-wrap flex-md-nowrap justify-content-center two-points-multsp m-auto">
								    	<div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="tomador_diferente" class="form-check-input" id="tomador_diferente_yes" value="si" required>							        
									        <label for="tomador_diferente_yes">
									        	Sí
									    	</label>
									    </div>
									    <div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="tomador_diferente" class="form-check-input" id="tomador_diferente_no" value="no" required checked>
									        <label for="tomador_diferente_no">
									        	No
									        </label>
									    </div>
								    </div>	  
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg">Siguiente paso</div>
							</div>
						</div>

					</div>
					<!-- FIN PANTALLA 9 -->

					<!-- PANTALLA 10 -->
					<div id="step-form-anim-10">
						<h2 class="title-viajes">Datos del tomador</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">					
								<div class="row g-4">

									<div class="col-12 col-md-6">
										<label for="tipo_tomador" class="form-label">Tipo de tomador</label>
				                        <select name="tipo_tomador" id="tipo_tomador" class="j2-no-search form-control" required>
				                        	<option value="" selected disabled>Selecciona una opción</option>
											<option value="fisica" selected >Persona física</option>
											<option value="juridica">Persona jurídica</option>
										</select>
				                    </div>

				                    <div class="col-12 col-md-6">
				                        <label for="identificador_tomador" class="form-label">NIF/NIE</label>
				                        <input type="text" class="form-control identificador-vrf" name="identificador_tomador" id="identificador_tomador" placeholder="Ejemplo: 12345678X" required>
				                    </div>
									<div class="col-12 col-md-6">
				                        <label for="nombre_tomador" class="form-label">Nombre</label>
				                        <input type="text" class="form-control name-vrf" name="nombre_tomador" id="nombre_tomador" required maxlength="200" placeholder="Ejemplo: Antonio">
				                    </div>

				                    <div class="col-12 col-md-6">
				                        <label for="apellidos_tomador" class="form-label">Apellidos</label>
				                        <input type="text" class="form-control apellidos-vrf" name="apellidos_tomador" id="apellidos_tomador" required maxlength="200" placeholder="Ejemplo: Pérez Rodríguez">
				                    </div>

				                    <div class="col-12 col-md-6">
				                        <label for="codigo_postal_tomador" class="form-label">Código Postal</label>
				                        <input type="number" class="form-control" name="codigo_postal_tomador" id="codigo_postal_tomador" placeholder="Ejemplo: 28001" required>
				                    </div>

				                    <div class="col-12 col-md-6">
				                        <label for="poblacion_tomador" class="form-label">Población</label>
				                        <input type="text" class="form-control" name="poblacion_tomador" id="poblacion_tomador" maxlength="100" placeholder="Ejemplo: Madrid" required>
				                    </div>

				                    <div class="col-12 col-md-6">
				                        <label for="dirección_tomador" class="form-label">Dirección</label>
				                        <input type="text" class="form-control" name="dirección_tomador" id="dirección_tomador" maxlength="100" placeholder="Ejemplo: Calle Gran Vía 22 - 2º B" required>
				                    </div>

									<div class="col-12 col-md-6">
										<label for="email_tomador" class="form-label">Email</label>
										<input type="email" class="form-control email-vrf" name="email_tomador" id="email_tomador" placeholder="Ejemplo: mail@gmail.com" required>
									</div>

									<div class="col-12 col-md-6">
										<label for="telefono_tomador" class="form-label">Teléfono Móvil</label>
										<input type="tel" class="form-control telefono-vrf" name="telefono_tomador" id="telefono_tomador" placeholder="Ejemplo: 655 123 456" required>
									</div>

									<div class="col-12 col-md-6 nac-tomador-div">
										<label for="fecha_nacimiento_tomador" class="form-label">Fecha de nacimiento</label>
										<input type="text" class="form-control fecha_nacimient_vrf" name="fecha_nacimiento_tomador" id="fecha_nacimiento_tomador" placeholder="Selecciona una fecha" required>
									</div>

								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg">Siguiente paso</div>
							</div>

						</div>	
					</div>
					<!-- FIN PANTALLA 10 -->

					

					<!-- PANTALLA 11 -->
					<div id="step-form-anim-11">
						<h2 class="title-viajes">¿Quieres establecer los herederos legales de tu póliza de accidentes?</h2>

						<p>En caso de no hacerlo serán el cónyuge; en su defecto sus hijos/as a partes iguales; en su defecto sus padres a partes iguales y en su defecto sus herederos legales.</p>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">

								<div class="row g-4">
									<label for="establece_herederos" class="form-label label_radio_buttons"></label>
								    <div class="d-flex justify-content-center boxi-rb flex-wrap flex-md-nowrap justify-content-center two-points-multsp m-auto">
								    	<div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="establece_herederos" class="form-check-input" id="establece_herederos_yes" value="si" required >							        
									        <label for="establece_herederos_yes">
									        	Sí
									    	</label>
									    </div>
									    <div class="radio-button-container text-start col-md-6 col-12">
									        <input type="radio" name="establece_herederos" class="form-check-input" id="establece_herederos_no" value="no" required checked>
									        <label for="establece_herederos_no">
									        	No
									        </label>
									    </div>
								    </div>	  
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="suma-asegurada-step">Siguiente paso</div>
							</div>
						</div>

					</div>
					<!-- FIN PANTALLA 11 -->

					<!-- PANTALLA 12 -->
					<div id="step-form-anim-12">
						<h2 class="title-viajes">Datos de los herederos</h2>
						<p>Completa los datos del tomador, que has indicado que <b>quieres que sea diferente del asegurado</b>.</p>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">					
								<div id="beneficiarios-box" class="col-12 mt-3">
									<div class="beneficiarios-inputs row g-3 align-items-center">
										<div class="col-6">
											<label for="nombre_benf_1" class="form-label">Nombre y apellidos</label>
											<input type="text" class="form-control" name="nombre_benf_1" id="nombre_benf_1">
										</div>
										<div class="col-4">
											<label for="nif_benf_1" class="form-label">DNI/NIE</label>
											<input type="text" class="form-control identificador-vrf" name="nif_benf_1" id="nif_benf_1">
										</div>
										<div class="col-2">
											<label for="porc_benf_1" class="form-label">%</label>
											<input type="number" class="form-control text-center" name="porc_benf_1" id="porc_benf_1" min=1 max=100>
										</div>

										<span class="anadir-beneficiario">Añadir beneficiario</span>
									</div>
								</div>

							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="sg-paso-8">Siguiente paso</div>
							</div>


						</div>	
					</div>
					<!-- FIN PANTALLA 12 -->

					<!-- PANTALLA 13 -->
					<div id="step-form-anim-13">
						<h2 class="title-viajes">Fecha efecto seguro</h2>

						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms">					
								<div class="row g-4 d-flex justify-content-center">
								    <div class="col-12 col-md-6">
										<label for="fecha_efecto_solicitada" class="form-label"></label>
										<input type="text" class="form-control" name="fecha_efecto_solicitada" id="fecha_efecto_solicitada" placeholder="Selecciona una fecha" required>
									</div>

								</div>

							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div class="btn btn-primary btn-next-form btn-next-paso-asg" id="sg-paso-13">Siguiente paso</div>
							</div>

						</div>	
					</div>
					<!-- FIN PANTALLA 13 -->

					<!-- PANTALLA 14 -->
					<div id="step-form-anim-14">

						<h2 class="title-viajes">Datos de pago de tu seguro</h2>
						<div class="text-start franja franja-forms-multstp">	
							<div class="card-forms mb-3">

								<div class="row g-4">

									<div class="col-12 mb-4">
										<label for="iban" class="form-label">IBAN</label>
										<input type="text" class="form-control iban-vrf" name="iban" id="iban"  placeholder="Ejemplo: ES21 1465 0100 72 2030876293" required>
									</div>

									<div class="col-12 form-check form-switch">
										<input type="checkbox" id="suscripcion_cond" class="form-check-input" name="suscripcion_cond" checked>
								    	<label for="suscripcion_cond">He leído y acepto la Información Precontractual y el Contrato del Seguro (incluidas las cláusulas limitativas destacadas en negrita), los Términos y Condiciones de Contratación a Distancia y la Política de Privacidad</label><br><br>
									</div>

									<div class="col-12 form-check form-switch">
										<input type="checkbox" id="declaracion_datos" class="form-check-input" name="declaracion_datos" checked>
								    	<label for="declaracion_datos">Declaras que son exactos los datos que has facilitado, siendo responsable de las inexactitudes de los mismos, de acuerdo con el artículo 10 de la Ley de Contrato de Seguro, estando obligado a comunicar a la Entidad Aseguradora cualquier variación que se produzca durante la vigencia del seguro.</label><br><br>
									</div>

									<div class="col-12 form-check form-switch">
										<input type="checkbox" id="suscripcion_pub" class="form-check-input" name="suscripcion_pub" checked>
								    	<label for="suscripcion_pub">Acepto el envío de publicidad incluso por medios electrónicos, una vez terminada la relación contractual.</label><br><br>
									</div>
								
								</div>
							</div>

							<div class="d-flex box-next-step-asg justify-content-center"> 
								<div id="sg-paso-14" class="btn btn-primary btn-rosa disabled">Finalizar la contratación</div>
							</div>

						</div>
					</div>
					<!-- FIN PANTALLA 14 -->

					<?php 
						if (wp_is_mobile()) {
							require( SACAIG_PLUGIN_PATH . 'parts/mobile-bottom-resume.php' ) ;	
						}

					?>

			
				</form>
				<!-- FIN FORM -->

				<div class="mult-mini-footer">
					<?php 
						//Footer viajes
						require(SACAIG_PLUGIN_PATH . 'parts/mini-footer.php');
					 ?>
				</div>

			</div>
			<!-- FIN container-mini-tarif-viajes -->

		</div>
		<!-- FIN BLOQUE IZQUIERDO -->


		<div class="box-aside-multistp">
			<?php 
				require( SACAIG_PLUGIN_PATH . 'parts/aside.php' ) ;
			?>
		</div>

	<?php 
		get_footer();