<?php

// FUNCIÓN PARA ENVIAR EL CORREO DE CONFIRMACIÓN AL USUARIO
function SACAIG_EnvioCorreoPoliza_cliente($email_asegurado) {
   // Definición de headers
   $headers = array(
      'Content-Type: text/html; charset=UTF-8',
      'From: ' . sanitize_email(WPCONFIG_MAIL_EMPRESA),
      'Reply-To: ' . sanitize_email(WPCONFIG_MAIL_EMPRESA),
   );

   // Asunto del correo
   $asunto = "Póliza Seguro de Accidentes - " . WPCONFIG_NAME_EMPRESA;

   ob_start();

   $template_path = SACAIG_PLUGIN_PATH .'templates/plantilla-email.php';

   if (file_exists($template_path)) {
      require_once $template_path;
   } else {
      error_log("La plantilla de correo no existe: " . $template_path);
      return false;
   }

   $mensaje = ob_get_clean();

   // Enviar el correo
   $wp_mail_result = wp_mail($email_asegurado, $asunto, $mensaje, $headers);

   // Registro de errores si ocurre algún problema
   if (!$wp_mail_result) {
      $error_message = 'Error al enviar correos a: ' . json_encode(array(
         'email_asegurado' => $email_asegurado,
         'correo_correduria' => WPCONFIG_MAIL_EMPRESA
      ));

      insu_registrar_error_insuguru("SACAIG_EnvioCorreoPoliza", $error_message, SACAIG_INSU_PRODUCT_ID);


      return false;
   }


   return true;
}

// Callback para enviar el correo vía AJAX
function SACAIG_enviar_correo_poliza_callback_service($data) {
   // Verifica que los parámetros se hayan pasado correctamente
   if (isset($data['email_to_asegurar'])) {

      $email_asegurado = sanitize_email($data['email_to_asegurar']);

      // Llama a la función para enviar el correo
      $resultado = SACAIG_EnvioCorreoPoliza_cliente($email_asegurado);

      if ($resultado) {
         return 1;
      } else {
        return 0;
      }
   } else {
      return 0;
   }

   wp_die();
}

// Callback para enviar el correo vía AJAX
function SACAIG_enviar_correo_poliza_companias_callback_service($data) {
   // Verifica que los parámetros se hayan pasado correctamente
   if (isset($data['email_to_asegurar'],  $data['signature_id'], $data['request_id'], $data['signatory_id'], $data['name_to_asegurar'])) {
      // sanitizar inputs
      $email_asegurado = sanitize_email($data['email_to_asegurar']);
      $signature_id = intval($data['signature_id']); // asegúrate de que sea numérico
      $request_id = intval($data['request_id']);     // lo mismo aquí
      $signatory_id = intval($data['signatory_id']);
      $nombre_asegurado = sanitize_text_field($data['name_to_asegurar']);

      // Programar el cron job para enviar el correo en 2 minutos
      $time_to_execute = time() + 120; // 120 segundos = 2 minutos

      // Programar evento único, pasando los datos necesarios como argumento
      wp_schedule_single_event($time_to_execute, 'SACAIG_enviar_correo_poliza_evento', array(
         'email_asegurado' => $email_asegurado,
         'signature_id' => $signature_id,
         'request_id' => $request_id,
         'signatory_id' => $signatory_id,
         'nombre_asegurado' => $nombre_asegurado
      ));

      return 1;
   } else {
      return 0;
   }

   wp_die();
}