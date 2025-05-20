<?php 

//CUMPLIMENTACIÓN DEL PDF CON LOS DATOS DEL FORMULARIO
use mikehaertl\pdftk\Pdf as MikeheartAIG;

function SACAIG_Cumplimentacion_firma_poliza_PDF(
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
   $provincia_asegurado, 
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
   $provincia_tomador,
   $tipo_poliza,
   $beneficio,
   $beneficiarios
){
   $directorioGuardado = SACAIG_PLUGIN_PATH. '/archivos/polizas-cumplimentadas/'; 

   $timestamp = time();
   $nombrepdf = $nombre_asegurado . "-". $timestamp . '.pdf';
   $rutaCompletaPDF = $directorioGuardado . $nombrepdf;
    
   $poliza1 = "";
   $poliza2 = "";
   $poliza3 = "";

   if($tipo_poliza == 1){
      $poliza1 = "X";
   } else if ($tipo_poliza == 2){
      $poliza2 = "X";
   } else if ($tipo_poliza == 3){
      $poliza3 = "X";
   }

   $beneficiariosStringArray = array_map(function($beneficiario) {
      $nombre = isset($beneficiario['nombre']) ? sanitize_text_field($beneficiario['nombre']) : 'Desconocido';
      $nif = isset($beneficiario['nif']) ? sanitize_text_field($beneficiario['nif']) : 'Desconocido';
      $porcentaje = isset($beneficiario['porcentaje']) ? number_format((float) $beneficiario['porcentaje'], 2) : '0.00';
      return "- NOMBRE: {$nombre} - NIF: {$nif}, Porcentaje: {$porcentaje}%";
   }, $beneficiarios);

   $beneficiariosString = implode("\n", $beneficiariosStringArray);
    
   $pdf = new MikeheartAIG(SACAIG_PLUGIN_PATH . '/templates/contrato-accidentes-aig.pdf');

   $result = $pdf->fillForm([
      'Fecha_Efecto' => $fecha_efecto_solicitada_asegurado,
      'Nombre_Tomador'=> $nombre_tomador.' '.$apellidos_tomador,
      'Domicilio_Tomador'=>$direccion_tomador,
      'Poblacion_Tomador'=> $poblacion_tomador,
      'NIF_Tomador' => $identificador_tomador,
      'CP_Tomador' => $codigo_postal_tomador,
      'Provincia_Tomador' => $provincia_tomador,
      'Nombre_Asegurado' => $nombre_asegurado.' '.$apellidos_asegurado,
      'Domicilio_Asegurado' => $direccion_asegurado,
      'Poblacion_Asegurado' => $poblacion_asegurado,
      'Fecha_Nac_Asegurado' => $fecha_nacimiento_asegurado,
      'Profesion_Asegurado' => $profesion,
      'Telefono_Asegurado' => $telefono_asegurado,
      'NIF_Asegurado' => $identificador_asegurado,
      'CP_Asegurado' => $codigo_postal_asegurado,
      'Provincia_Asegurado' => $provincia_asegurado,
      'Clas' => $poliza1,
      'Plus' => $poliza2,
      'Prem' => $poliza3,
      'datos_bancarios' => $iban_asegurado,
      'OPC1' => $actividad_manual,
      'OPC2' => $enf_cardiaca,
      'OPC3' => $enf_grave,
      'Beneficiarios' => $beneficio,
      'Nombre_Beneficiarios' => $beneficiariosString,
   ])->needAppearances()->saveAs($rutaCompletaPDF);

   if ($result === false) {
      $error = $pdf->getError();
      insu_registrar_error_insuguru("SACAIG_Cumplimentacion_firma_poliza_PDF", "No se ha podido completar la cumplimentación del contrato con los datos recogidos en el formulario. El error devuelto:".$error, SACAIG_INSU_PRODUCT_ID);
      return false;
   }else{

      $firmaResponse=[];

      // Llama a la función para iniciar el proceso de firma y captura la respuesta
      $firmaResponse = SACAIG_iniciar_proceso_firma($email_asegurado, $telefono_asegurado, $nombre_tomador, $apellidos_tomador, $nombrepdf, $identificador_tomador);
        
      // Verifica si la respuesta incluye un request_id
      if (isset($firmaResponse['request_id'])) {

         return $firmaResponse;
            
      } else {
         insu_registrar_error_insuguru("SACAIG_iniciar_proceso_firma", "No se pudo obtener el request_id de la respuesta de iniciar proceso de firma.", SACAIG_INSU_PRODUCT_ID);
         return null;
      }
        
      return null;
   }
    
   return null;
}
