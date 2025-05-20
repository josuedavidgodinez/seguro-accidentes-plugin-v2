<?php

function SACAIG_iniciar_proceso_firma($email, $telefono, $nombre, $apellido, $filename, $NIF) {
    //Se manda a llamar la api de start-signature
    
    $url = URL_API_ILEIDA_START_SACAIG;
    $username = API_USER_ILEIDA_SACAIG;
    $password = API_PASS_ILEIDA_SACAIG;

    // Verificar si el teléfono ya tiene un código de país
	if (preg_match('/^\+\d+/', $telefono)) {
	    // Si el número ya tiene un código de país, no hacer nada
	    $telefono_formateado = $telefono;
	} else {
	    // Si no tiene código de país, añadir +34
	    $telefono_formateado = '+34' . $telefono;
	}
    // Especifica la ruta completa al archivo
    $filePath = SACAIG_PLUGIN_PATH. '/archivos/polizas-cumplimentadas/' . $filename;

    $base64Content='';

    // Verifica si el archivo existe y léelo
    if (file_exists($filePath)) {
        //Obtiene el contenido archivo del path
        $fileContent = file_get_contents($filePath);

        //Se realiza un encode64 del contenido
        $base64Content = base64_encode($fileContent);
    } else {
        insu_registrar_error_insuguru("SACAIG_iniciar_proceso_firma", "El archivo no existe.", SACAIG_INSU_PRODUCT_ID);
    }


    //El body del request que se va a hacer a la api
    $body = array(
        'request' => 'START_SIGNATURE', 
        'user' => $username,
        'password' => $password,
        'signature' => array(
            'contract_id' => $NIF,
            'config_id' => API_TEMPLATE_ILEIDA_SACAIG,
            'level' => array(
                array(
                    'level_order' => '1',
                    'required_signatories_to_complete_level' => '2',
                    'signatories' => array(
                        array(
                            'email' => $email,
                            'phone' => $telefono,
                            'name' => $nombre,
                            'surname' => $apellido,
                            "external_id" => "1",
                            'url_redirect' => (home_url( '/' ) . API_URL_REDIRECT_SACAIG)

                        ),
                    ),
                ),
            ),
            'file' => array(
                array(
                    'filename' => $filename,
                    'content' => $base64Content,
                    'sign_on_landing' => 'Y',
                    'file_group' => '',
                    'signature_position' => array(
                        array(
                            "signatory_external_id" => "1",
                            'page' => 'last',
                            'x' => 20.0,
                            'y' => 267.0,
                            'height' => 20,
                            'width' => 30,
                            'rotation' => 0,
                        ),
                    ),
                ),
            ),
        ),
    );
    
    $args = array(
        'method' => 'POST',
        'headers' => array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode($body),
        'timeout' => '45',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking' => true,
    );

    //se hace un POST con la URL de la API, y la variable args que viene con el body de request de la firma
    $response = wp_remote_post($url, $args);
    
    //Si el responde devuelve un error, entra directo
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        insu_registrar_error_insuguru("SACAIG_iniciar_proceso_firma", "Algo salió mal al solicitar la firma digital: $error_message", SACAIG_INSU_PRODUCT_ID);
    } else {
        //determina el reponde_code en base al wp_remote_retrieve_response_code del response
        $response_body = wp_remote_retrieve_body($response);
        $response_code = wp_remote_retrieve_response_code($response);

        //200 es el valor que debe devolver el codigo si es el correcto
        if ($response_code == 200) {
            $decoded_response = json_decode($response_body, true);

            // Verifica si la respuesta incluye un request_id
            if (isset($decoded_response['request_id'])) {
                
                //Obtenemos los valores en especifico segun sus niveles de como responda la API
                $request_id = strval($decoded_response['request_id']);
                $signature_id = strval($decoded_response['signature']['signature_id']); // Convertir a cadena
                $signatory_id = strval($decoded_response['signature']['signatories'][0]['signatory_id']); // Convertir a cadena
                $url_redirect = strval($decoded_response['signature']['signatories'][0]['url']); // Convertir a cadena

                return [
                    //Retornamos estas 3 variables al metodo llenar-pdf.php
                    'request_id' => $request_id,
                    'signature_id' => $signature_id,
                    'signatory_id'=> $signatory_id,
                    'url_redirect'=> $url_redirect
                ];
            } else {
                    insu_registrar_error_insuguru("SACAIG_iniciar_proceso_firma", "La respuesta devuelta por LLeida Net no incluye un request id", SACAIG_INSU_PRODUCT_ID);
            }
        } else {
            insu_registrar_error_insuguru("SACAIG_iniciar_proceso_firma", "Respuesta inesperada: Código de estado $response_code", SACAIG_INSU_PRODUCT_ID);
        }
    }
}
