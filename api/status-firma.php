<?php

function SACAIG_obtener_estado_firma($request_id,$signature_id) {
    
    $username = API_USER_ILEIDA_SACAIG;
    $password = API_PASS_ILEIDA_SACAIG;

    // Preparar el cuerpo de la solicitud
    $body = json_encode([
        "request" => "GET_SIGNATURE_STATUS",
        "request_id" => $request_id,
        "user" => $username,
        "password" => $password,
        "signature_id" => $signature_id,
    ]);


    // Preparar los argumentos de la solicitud, incluyendo el encabezado con la API Key
    $args = [
        'method'      => 'POST',
        'headers'     => [
            'Content-Type'  => 'application/json; charset=utf-8',
            'Accept'        => 'application/json',
        ],
        'body'        => $body,
        'data_format' => 'body',
    ];

    // Realizar la solicitud POST
    $response = wp_remote_post('https://api.lleida.net/cs/v1/get_signature_status', $args);

    // Verificar si la solicitud fue exitosa
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        insu_registrar_error_insuguru("SACAIG_obtener_estado_firma", "Algo salió mal: $error_message", SACAIG_INSU_PRODUCT_ID);
        return "Algo salió mal: $error_message";
    } else {
        // Decodificar y retornar la respuesta
        $response_body = wp_remote_retrieve_body($response);

        return json_decode($response_body, true);
    }
}

