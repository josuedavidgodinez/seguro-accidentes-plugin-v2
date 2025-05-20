<?php 


//AL PROPORCIONALES EL ID DE UNA PROFESION DEVUELVE LA INFORMACIÓN ASOCIADA
function obtener_informacion_profesion($id) {
    // Acceso global a la variable $wpdb de WordPress
    global $wpdb;

    // Usar el prefijo de la tabla configurado en WordPress
    $tabla = $wpdb->prefix . 'profesiones_accidentes_riesgos';

    // Preparar la consulta SQL para evitar inyecciones SQL
    $query = $wpdb->prepare("SELECT * FROM {$tabla} WHERE id = %d", $id);

    // Ejecutar la consulta
    $resultado = $wpdb->get_row($query);

    // Verificar si se encontró algún resultado
    if (null !== $resultado) {
        return $resultado;
    } else {
        return 'No se encontró información para el ID proporcionado.';
    }
}


function SACAIG_obtenerNombreProvincia($idSelect) {
    // Definimos un array asociativo con los códigos de las provincias y sus nombres
    $provincias = [
        "01" => "Álava",
        "02" => "Albacete",
        "03" => "Alicante",
        "04" => "Almería",
        "33" => "Asturias",
        "05" => "Ávila",
        "06" => "Badajoz",
        "08" => "Barcelona",
        "09" => "Burgos",
        "10" => "Cáceres",
        "11" => "Cádiz",
        "39" => "Cantabria",
        "12" => "Castellón",
        "13" => "Ciudad Real",
        "14" => "Córdoba",
        "16" => "Cuenca",
        "17" => "Gerona",
        "18" => "Granada",
        "19" => "Guadalajara",
        "20" => "Guipúzcoa",
        "21" => "Huelva",
        "22" => "Huesca",
        "07" => "Islas Balears",
        "23" => "Jaén",
        "15"=> "La Coruña",
        "26" => "La Rioja",
        "35" => "Las Palmas",
        "24" => "León",
        "25" => "Lérida",
        "27" => "Lugo",
        "28" => "Madrid",
        "29" => "Málaga",
        "30" => "Murcia",
        "31" => "Navarra",
        "32" => "Orense",
        "34" => "Palencia",
        "36" => "Pontevedra",
        "37" => "Salamanca",
        "38" => "Santa Cruz de Tenerife",
        "40" => "Segovia",
        "41" => "Sevilla",
        "42" => "Soria",
        "43" => "Tarragona",
        "44" => "Teruel",
        "45" => "Toledo",
        "46" => "Valencia",
        "47" => "Valladolid",
        "48" => "Vizcaya",
        "49" => "Zamora",
        "50" => "Zaragoza"
   ];
   
   return $provincias[$idSelect];
}


//DEVUELVE EN UNA PETICIÓN AJAX LA INFORMACIÓN RESPECTO A UNA PROFESIÓN.
function verificar_profesion_ajax() {
    // Obtener el ID de la profesión desde la solicitud AJAX
    $id_profesion = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Llamar a la función que ya tienes
    $info_profesion = obtener_informacion_profesion($id_profesion);

    // Devolver la respuesta en formato JSON
    echo json_encode($info_profesion);

    // Finalizar la ejecución para evitar la impresión de una respuesta adicional
    wp_die();
}

add_action('wp_ajax_verificar_profesion', 'verificar_profesion_ajax');
add_action('wp_ajax_nopriv_verificar_profesion', 'verificar_profesion_ajax');




// Función que determina el precio del seguro contratado y su nombre en función del id
function SACAIG_poliza_selected($id_poliza) {
    $data = [];

    switch ($id_poliza) {
        case '1':
            $data = ['nombre' => 'Classic', 'precio' => 92, 'limite' => '150.000 €'];
            break;

        case '2':
            $data = ['nombre' => 'Plus', 'precio' => 173, 'limite' => '250.000 €'];
            break;

        case '3':
            $data = ['nombre' => 'Premier', 'precio' => 265, 'limite' => '350.000 €'];
            break;

        default:
            $data = ['nombre' => 'Desconocido', 'precio' => 0, 'limite' => 'N/A']; // Opción por defecto
            break;
    }

    return $data;
}


// Función que devuelve la profesión en función del ID seleccionado
function sacaig_profesiones_byid($idprofesion) {
    global $wpdb; // Accedemos a la base de datos global de WordPress

    // Definimos el nombre de la tabla (asegurándonos de usar el prefijo de tablas de WP)
    $table_name = $wpdb->prefix . 'profesiones_accidentes_riesgos';

    // Preparamos la consulta para obtener la profesión por su ID
    $profesion = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT profesion FROM $table_name WHERE id = %d", 
            $idprofesion
        )
    );

    // Devolvemos el valor de la profesión o un mensaje si no se encuentra
    if ($profesion) {
        return $profesion;
    } else {
        return 'Profesión no encontrada';
    }
}



/**
 * Formatea un NIF, CIF o NIE para que la letra final esté en mayúscula.
 * ***/
function formatearIdentificador($identificador) {
    // Convertimos todo el string a mayúsculas.
    return strtoupper($identificador);
}



/**
 * Oculta con asteriscos todos los caracteres de un IBAN
 * excepto los 4 primeros y los 6 últimos.
 *
 * @param string $iban El IBAN a formatear.
 * @return string El IBAN con el formato oculto.
 */
function ocultarIbanGP($iban) {
    $longitud = strlen($iban);
    
    // Si la longitud es menor o igual a 10, no se puede aplicar la ocultación.
    if ($longitud <= 10) {
        return $iban;
    }
    
    // Obtener los 4 primeros y 6 últimos caracteres.
    $primeros = substr($iban, 0, 4);
    $ultimos = substr($iban, -6);
    
    // Calcular la cantidad de caracteres a ocultar.
    $numeroAsteriscos = $longitud - 10;
    $asteriscos = str_repeat('*', $numeroAsteriscos);
    
    return $primeros . $asteriscos . $ultimos;
}
