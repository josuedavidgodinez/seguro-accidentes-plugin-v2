<?php 

//GENERACIÓN DEL PROYECTO DEL PRODUCTO 
use Knp\Snappy\Pdf as SnappyPdf;

function SACAIG_Generar_proyecto_PDF(
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
){
    $timestamp = time();
    $nombrepdf = sanitize_file_name($nombre_asegurado . '_' . $timestamp . '.pdf');

    // Generar el HTML utilizando la plantilla
    $html = SACAIG_template_seguro_accidentes_aig_v2(
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
    );

    // Inicializar Snappy
    $snappy = new SnappyPdf('/usr/bin/wkhtmltopdf'); 

    // Obtener la ruta de la carpeta dentro del plugin
   	$plugin_dir = dirname(plugin_dir_path(__FILE__), 1); 
	$pdf_dir = $plugin_dir . '/archivos/proyectos/';

    // Crear la carpeta si no existe
    if (!file_exists($pdf_dir)) {
        wp_mkdir_p($pdf_dir);
    }

    // Definir la ruta completa del PDF
    $pdf_path = $pdf_dir . $nombrepdf;

    // Generar el PDF desde HTML y guardarlo en el sistema de archivos
    try {
        $snappy->generateFromHtml($html, $pdf_path, 
        [
            'dpi' => 300,      // Alta calidad
            'page-size' => 'A4',
            'zoom' => 1.0,
            'enable-local-file-access' => true  // Habilitar acceso a archivos locales
        ]
    );
        $pdf_url = SACAIG_PLUGIN_URL. 'archivos/proyectos/' . $nombrepdf;

        return $pdf_url;

    } catch (Exception $e) {
        insu_registrar_error_insuguru("SACAIG_Generar_proyecto_PDF", "Error generando PDF: " . $e->getMessage(), SACAIG_INSU_PRODUCT_ID);

        return false;
    }
}