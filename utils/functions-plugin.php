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
