<?php

   function SACAIG_get_transient_service($signature_id) {
      try {
   
         // Sanitizar el identificador
         $identifier = sanitize_text_field($signature_id);
   
         // Obtener el transient
         $datos = get_transient("SACAIG_".$identifier);

         if ( false === $datos ) {
             error_log('Transient no encontrado: ' . $identifier);
             return ([
                 'errores' => ['No se encontró ningún transient con ese identificador o expiró'],
                 'respuesta' => null
             ]);
         }
         delete_transient("SACAIG_".$identifier);

   
         // Si todo bien, enviamos los datos
         return ([
            'errores' => [],
            'respuesta' => $datos
         ]);
   
      } catch (\Throwable $th) {
        return ([
            'errores' => ['Se produjo un error al recuperar el transient'],
            'respuesta' => null
         ]);
      }
   }

    function SACAIG_save_transient_service() {
      try {
         if(!isset($_POST['signature_id'])){
            wp_send_json_error([
               'errores' => ['No especifico identificador de transient'],
               'respuesta'=>null
               ]);
         }
         // Limpieza básica de datos (mejor usar filtros específicos según tu caso)
         $post_data = array_map( 'sanitize_text_field', $_POST );

         // Convertir array a objeto PHP (stdClass)
         $objeto = (object) $post_data;
         $identifier = $objeto->signature_id;
         // Guardar como transient (1 horas)
         set_transient("SACAIG_".$identifier, $objeto, 1 * HOUR_IN_SECONDS );
            wp_send_json_success([
               'errores' => [],
               'respuesta'=>[
                  'mensaje'=> 'Transient almacenado con exito'
               ]
            ]);
      } catch (\Throwable $th) {
         wp_send_json_error([
            'errores' => ['Se produjo un error al guardar el transient'],
            'respuesta'=>null
            ]);
      }




   }