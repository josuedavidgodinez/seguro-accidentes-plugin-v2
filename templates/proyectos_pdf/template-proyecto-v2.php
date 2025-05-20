<?php

function SACAIG_template_seguro_accidentes_aig_v2(
    $profesion,
    $actividad_manual,
    $descr_trabajo_manual,
    $enf_cardiaca,
    $enf_cardiaca_descript,
    $enf_grave,
    $enf_grave_descript,
    $nombre_asegurado,
    $apellidos_asegurado,
    $codigo_postal_asegurado,
    $nombre_provincia_asegurado,
    $poblacion_asegurado,
    $direccion_asegurado,
    $identificador_asegurado,
    $email_asegurado,
    $telefono_asegurado,
    $fecha_nacimiento_asegurado,
    $iban_asegurado,
    $fecha_efecto_solicitada_asegurado,
    $nombre_tomador,
    $apellidos_tomador,
    $codigo_postal_tomador,
    $poblacion_tomador,
    $direccion_tomador,
    $identificador_tomador,
    $nombre_provincia_tomador,
    $email_tomador,
    $telefono_tomador,
    $fecha_nacimiento_tomador,
    $tipo_poliza,
    $beneficiarios
) {

    $nombre_completo_asegurado = $nombre_asegurado . ' ' . $apellidos_asegurado;
	$nombre_completo_tomador   = $nombre_tomador . ' ' . $apellidos_tomador;
	$actividad_manual_texto    = $actividad_manual == 'si' ? "$descr_trabajo_manual" : "No realiza trabajos manuales";
	$enf_cardiaca_texto        = $enf_cardiaca == 'si' ? "$enf_cardiaca_descript" : "No sufre enfermedades cardíacass";
	$enf_grave_texto           = $enf_grave == 'si' ? "$enf_grave_descript" : "No sufre enfermedades graves";


    $html_eleccion_polizas = "";
    ob_start();
    include __DIR__ . '/parts/table-options.php';
    $contenido_tabla = ob_get_clean();




	$html_beneficiarios = "";
	foreach ($beneficiarios as $i => $beneficiario) {
		$indice_real = $i+1;
		$nombre_beneficiario = $beneficiario['nombre'];
		$porcentaje_beneficiario = $beneficiario['porcentaje'];
		$html_beneficiarios .= 
		"
		<div class='row mb-1 pb-1'>
			<div class='col-4 pt-1'>Heredero $indice_real:</div>
			<div class='col-8 pt-1 bg-primary-transparent-1 text-secondary font-weight-light'>$nombre_beneficiario - <span class='text-primary font-weight-bold'>($porcentaje_beneficiario%)</span></div>
		</div>
		";
	}

    // Obtener la fecha de hoy en el formato deseado
    $fecha_hoy = date("d/m/Y");

    $fecha_al_anio = new DateTime();
    // Añadir 15 días
    $fecha_al_anio->modify('+15 days');
    // Formatear la fecha en el formato d/m/Y
    $fecha_al_anio_format = $fecha_al_anio->format('d/m/Y');

    
    // 1. Crear DateTime desde la cadena con formato día-mes-año
    $fecha_efecto = DateTime::createFromFormat('d-m-Y', $fecha_efecto_solicitada_asegurado);
    if (!$fecha_efecto) {
        // Manejo de error si el formato es inválido
        throw new Exception('Formato de fecha inválido, espera dd-mm-YYYY');
    }

    // 2. Clonar la fecha para no modificar el original (opcional)
    $fecha_final_cobertura = clone $fecha_efecto;

    // 3. Sumar un año
    $fecha_final_cobertura->modify('+1 year');

    // 4. Formatear en d/m/Y
    $fecha_final_cobertura_mod = $fecha_final_cobertura->format('d/m/Y');

    $data_poliza = SACAIG_poliza_selected($tipo_poliza);

    $precio_poliza = $data_poliza['precio'];
    $nombre_poliza = $data_poliza['nombre'];
    $limite = $data_poliza['limite'];
    $top_page = 8;

    ob_start();
    include __DIR__ . '/parts/frontpage.php';
    include __DIR__ . '/parts/content.php';
    $contenido_proyecto = ob_get_clean();


    // Return the final assembled HTML
    return $contenido_proyecto;
}
