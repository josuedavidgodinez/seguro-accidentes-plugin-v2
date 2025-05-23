<?php
/*
Plugin Name: Seguro de accidentes para profesionales con AIG
Text Domain: seguro-accidentes-aig
Plugin URI:  https://ariseweb.es
Description: Tarificación y contratación del seguro de accidentes con AIG mediante firma digital y envío de PDF de la compañía
Version:     1.0
Author:      Ariseweb
Author URI:  https://ariseweb.es
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


// Si Composer autoload existe, incluirlo.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}


// Definición de constantes básicas del plugin
define('SACAIG_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SACAIG_PLUGIN_URL', plugins_url('/', __FILE__));


define('SACAIG_TEMPLATE_LANDING_PRODUCTO', 'templates/landing-producto-template.php');
define('SACAIG_TEMPLATE_EMAIL', 'templates/plantilla-email.php');
define('SACAIG_PRODUCTO_NOMBRE', "Seguro de Accidentes");
define('SACAIG_INSU_PRODUCT_ID', '2');



/***
 * VARIABLES A REVISAR ANTES DE ACTIVAR EL PLUGIN*
 ***/
define('SACAIG_SLUG_LANDING_PRODUCTO', 'seguros-de-accidentes');
define('SACAIG_CODIGO_MEDIADOR', 006530);
define('SACAIG_IMAGEN_PLUGIN', SACAIG_PLUGIN_URL."/img/icono-acciedentes.svg");


//Constantes de lleidanet para la firma
define('URL_API_ILEIDA_START_SACAIG', 'https://api.lleida.net/cs/v1/start_signature');
define('URL_API_ILEIDA_GET_SACAIG', 'https://api.lleida.net/cs/v1/get_document');
define('API_USER_ILEIDA_SACAIG', 'ibrok');
define('API_PASS_ILEIDA_SACAIG', '}Tn,V9quqP');
define('API_TEMPLATE_ILEIDA_SACAIG', '88305');
define('API_URL_REDIRECT_SACAIG', 'agradecimiento-seguro-sagcaig');

/***
 * VARIABLES A REVISAR ANTES DE ACTIVAR EL PLUGIN*
 ***/


//Requerimos archivos con las funcionalidades de completar el pdf (poliza) y crear la firma.
require_once SACAIG_PLUGIN_PATH .'utils/functions-firma.php';
require_once SACAIG_PLUGIN_PATH .'utils/transient-services.php';
require_once SACAIG_PLUGIN_PATH .'api/status-firma.php';
require_once SACAIG_PLUGIN_PATH .'api/obtener-pdf.php';
require_once SACAIG_PLUGIN_PATH .'api/firma-api.php';

//Requerimos archivos con las funcionalidades de crear un proyecto.
require_once SACAIG_PLUGIN_PATH .'templates/proyectos_pdf/template-proyecto-v2.php';


require_once SACAIG_PLUGIN_PATH .'utils/generacion-proyecto.php';

//Requerimos archivos con las funcionalidades propias del plugin.
require_once SACAIG_PLUGIN_PATH .'utils/functions-plugin.php';


//Hook activación insuguru
function SACAIG_insu_activar_plugin_insuguru() {

   // Obtener el basename del plugin
   $plugin_basename = plugin_basename(__FILE__);
   insu_activar_plugin_insuguru($plugin_basename, SACAIG_INSU_PRODUCT_ID);

   sacaig_register_endpoints();
   flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'SACAIG_insu_activar_plugin_insuguru');



//Hook desactivación insuguru
function SACAIG_insu_desactivar_plugin_insuguru() {

   $plugin_basename = plugin_basename(__FILE__);
   insu_desactivar_plugin_insuguru($plugin_basename, SACAIG_INSU_PRODUCT_ID);

   flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'SACAIG_insu_desactivar_plugin_insuguru');



// Verificación de plugins requeridos
function SACAIG_check_required_plugins() {
   $required_plugins = [
      'seo-by-rank-math/rank-math.php' => 'Rank Math SEO',
      'asegura-core/asegura-core.php' => 'Asegura Core',
      'insuguru-wp-plugin/insuguru-wp-plugin.php' => 'Insuguru Plugin',
      'turnstile-asegura-security/turnstile-asegura-security.php' => 'Turnstyle Security'
   ];

   $missing_plugins = [];

   foreach ($required_plugins as $plugin => $name) {
      if (!is_plugin_active($plugin)) {
         $missing_plugins[] = $name;
      }
   }

   // Verificar si Composer está instalado y si el archivo composer.json existe
   $composer_json_path = plugin_dir_path(__FILE__) . 'composer.json';
   if (!file_exists($composer_json_path)) {
      $missing_plugins[] = 'Composer y dependencias de Composer';
   } else {
      // Verificar si Composer está disponible en el servidor
      exec('composer --version', $output, $return_var);
      if ($return_var !== 0) {
         $missing_plugins[] = 'Composer no está instalado en el servidor';
      } else {
         // Ejecutar Composer install
         exec('composer install', $output, $return_var);
         if ($return_var !== 0) {
            wp_die(
               __('No se pudieron instalar las dependencias de Composer. Verifique su instalación de Composer.', 'text-domain'),
               __('Error en Composer', 'text-domain'),
               array('back_link' => true)
            );
         }
      }
   }

   if (!empty($missing_plugins)) {
      deactivate_plugins(plugin_basename(__FILE__));
      wp_die(
         sprintf(__('Este plugin requiere los siguientes plugins: %s. Por favor, actívalos o instálalos primero.', 'text-domain'), implode(', ', $missing_plugins)),
         __('Plugins requeridos no encontrados', 'text-domain'),
         array('back_link' => true)
      );
   }
}




/************  Creamos cualquier tabla necesaria para el plugin *********/
function SACAIG_crear_tablas_plugin() {

   global $wpdb;

   $charset_collate = $wpdb->get_charset_collate();
   $tabla_productos = $wpdb->prefix . 'profesiones_accidentes_riesgos';

   // Verifica si la tabla ya existe
   if ($wpdb->get_var("SHOW TABLES LIKE '$tabla_productos'") != $tabla_productos) {
      $sql = "CREATE TABLE $tabla_productos (
       id mediumint(9) NOT NULL AUTO_INCREMENT,
      profesion varchar(255) NOT NULL,
      riesgo varchar(10) NOT NULL,
      PRIMARY KEY (id)
      ) $charset_collate;";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

      dbDelta($sql);

      // Listado de profesiones a crear
      $profesiones = array(
         array('profesion' => 'A.P.I.' , 'riesgo' => '1'),
         array('profesion' => 'Abogado' , 'riesgo' => '1'),
         array('profesion' => 'Acomodador' , 'riesgo' => '1'),
         array('profesion' => 'Acróbata (en el suelo)' , 'riesgo' => 'SC'),
         array('profesion' => 'Actor' , 'riesgo' => '2'),
         array('profesion' => 'Actor  (Especialista)' , 'riesgo' => 'SC'),
         array('profesion' => 'Actuario' , 'riesgo' => '1'),
         array('profesion' => 'Acuchillador de Suelos' , 'riesgo' => '2'),
         array('profesion' => 'Administrador de Lotería' , 'riesgo' => '1'),
         array('profesion' => 'Administrador de Propiedades Rurales' , 'riesgo' => '1'),
         array('profesion' => 'Administrativo' , 'riesgo' => '1'),
         array('profesion' => 'Aduanas (Agentes)' , 'riesgo' => '2'),
         array('profesion' => 'Afilador' , 'riesgo' => '2'),
         array('profesion' => 'Agente de Cambio y Bolsa' , 'riesgo' => '1'),
         array('profesion' => 'Agente de Seguros' , 'riesgo' => '1'),
         array('profesion' => 'Agente Ventas' , 'riesgo' => '1'),
         array('profesion' => 'Agricultor/Ganadero' , 'riesgo' => '2'),
         array('profesion' => 'Agrimensor' , 'riesgo' => '2'),
         array('profesion' => 'Agroforestal' , 'riesgo' => '2'),
         array('profesion' => 'Agrónomo' , 'riesgo' => '2'),
         array('profesion' => 'Aislamiento (suelos y paredes)' , 'riesgo' => '2'),
         array('profesion' => 'Ajustador' , 'riesgo' => '2'),
         array('profesion' => 'Albañil' , 'riesgo' => '2'),
         array('profesion' => 'Alfarero' , 'riesgo' => '2'),
         array('profesion' => 'Alicatador' , 'riesgo' => '2'),
         array('profesion' => 'Almacenista' , 'riesgo' => '2'),
         array('profesion' => 'Almidón (Fabricación)' , 'riesgo' => '2'),
         array('profesion' => 'Ama de Casa' , 'riesgo' => 'SC'),
         array('profesion' => 'Analista' , 'riesgo' => '2'),
         array('profesion' => 'Analista Laboratorio' , 'riesgo' => '2'),
         array('profesion' => 'Andamiaje  (Instalador)' , 'riesgo' => '2'),
         array('profesion' => 'Anestesista' , 'riesgo' => '1'),
         array('profesion' => 'Anodizador/Cromador' , 'riesgo' => '2'),
         array('profesion' => 'Antenista de Emisoras Radio y Televisión' , 'riesgo' => '2'),
         array('profesion' => 'Anticuario' , 'riesgo' => '1'),
         array('profesion' => 'Aparejador' , 'riesgo' => '2'),
         array('profesion' => 'Apicultor' , 'riesgo' => '2'),
         array('profesion' => 'Armador de buques' , 'riesgo' => '2'),
         array('profesion' => 'Armero' , 'riesgo' => '2'),
         array('profesion' => 'Arqueólogo' , 'riesgo' => '2'),
         array('profesion' => 'Arquitecto' , 'riesgo' => '1'),
         array('profesion' => 'Arquitecto (Visita a Obras)' , 'riesgo' => '2'),
         array('profesion' => 'Artesano' , 'riesgo' => '2'),
         array('profesion' => 'Artículos en Punto (Fabricación)' , 'riesgo' => '2'),
         array('profesion' => 'Artista' , 'riesgo' => 'SC'),
         array('profesion' => 'Ascensorista' , 'riesgo' => '2'),
         array('profesion' => 'Asentador Mercado' , 'riesgo' => '2'),
         array('profesion' => 'Aserrador' , 'riesgo' => '2'),
         array('profesion' => 'Asesor Fiscal' , 'riesgo' => '1'),
         array('profesion' => 'Asfaltador' , 'riesgo' => '2'),
         array('profesion' => 'Asfalto (Fabricación)' , 'riesgo' => '2'),
         array('profesion' => 'Asistente Social' , 'riesgo' => '1'),
         array('profesion' => 'Astillero' , 'riesgo' => '2'),
         array('profesion' => 'Astrónomo' , 'riesgo' => '1'),
         array('profesion' => 'ATS' , 'riesgo' => '2'),
         array('profesion' => 'ATS Centro Psiquiátrico' , 'riesgo' => '2'),
         array('profesion' => 'Auditor' , 'riesgo' => '1'),
         array('profesion' => 'Automóviles (Venta y Alquiler)' , 'riesgo' => '1'),
         array('profesion' => 'Auxiliar (Farmacia)' , 'riesgo' => '1'),
         array('profesion' => 'Auxiliar de Clínica' , 'riesgo' => '1'),
         array('profesion' => 'Auxiliar de Vuelo' , 'riesgo' => '2'),
         array('profesion' => 'Avicultor' , 'riesgo' => '2'),
         array('profesion' => 'Ayudante de Cocina' , 'riesgo' => '2'),
         array('profesion' => 'Ayudante de Ingeniero' , 'riesgo' => '1'),
         array('profesion' => 'Ayudante de Obras Públicas' , 'riesgo' => '2'),
         array('profesion' => 'Azafato/a de Congresos/Ferias' , 'riesgo' => '2'),
         array('profesion' => 'Azafato/a, Auxiliar de vuelo' , 'riesgo' => '2'),
         array('profesion' => 'Azúcar (Fabricación y Refinado)' , 'riesgo' => '2'),
         array('profesion' => 'Bailarín/a' , 'riesgo' => '2'),
         array('profesion' => 'Banca en General' , 'riesgo' => '1'),
         array('profesion' => 'Banderillero' , 'riesgo' => 'SC'),
         array('profesion' => 'Barman' , 'riesgo' => '2'),
         array('profesion' => 'Barnizador' , 'riesgo' => '2'),
         array('profesion' => 'Barrendero' , 'riesgo' => '2'),
         array('profesion' => 'Basurero' , 'riesgo' => '2'),
         array('profesion' => 'Bedel' , 'riesgo' => '1'),
         array('profesion' => 'Bibliotecario' , 'riesgo' => '1'),
         array('profesion' => 'Biólogo y bioquímico' , 'riesgo' => '2'),
         array('profesion' => 'Bodeguero' , 'riesgo' => '2'),
         array('profesion' => 'Bombero' , 'riesgo' => 'SC'),
         array('profesion' => 'Bordador/a' , 'riesgo' => '1'),
         array('profesion' => 'Botánico' , 'riesgo' => '2'),
         array('profesion' => 'Botones' , 'riesgo' => '2'),
         array('profesion' => 'Bracero' , 'riesgo' => 'SC'),
         array('profesion' => 'Buzo (en Lago)' , 'riesgo' => 'SC'),
         array('profesion' => 'Buzo Profesional' , 'riesgo' => 'SC'),
         array('profesion' => 'Caddy (Golf)' , 'riesgo' => '2'),
         array('profesion' => 'Cajero' , 'riesgo' => '1'),
         array('profesion' => 'Calderero' , 'riesgo' => '2'),
         array('profesion' => 'Callista' , 'riesgo' => '2'),
         array('profesion' => 'Cámara de Televisión' , 'riesgo' => '2'),
         array('profesion' => 'Camarero  (Propietario)' , 'riesgo' => '2'),
         array('profesion' => 'Camarero (Empleado)' , 'riesgo' => '2'),
         array('profesion' => 'Camisero' , 'riesgo' => '1'),
         array('profesion' => 'Cantante' , 'riesgo' => 'SC'),
         array('profesion' => 'Cantero (Con Explosivos)' , 'riesgo' => 'SC'),
         array('profesion' => 'Cantero (Sin Explosivos)' , 'riesgo' => 'SC'),
         array('profesion' => 'Capataz (solo Dirección y Vigilancia)' , 'riesgo' => '2'),
         array('profesion' => 'Capitán de Buque de Pasaje' , 'riesgo' => 'SC'),
         array('profesion' => 'Capitán de Buque Mercante' , 'riesgo' => 'SC'),
         array('profesion' => 'Carbonero' , 'riesgo' => '2'),
         array('profesion' => 'Cargador' , 'riesgo' => 'SC'),
         array('profesion' => 'Carniceros' , 'riesgo' => '4'),
         array('profesion' => 'Carpintero ' , 'riesgo' => '2'),
         array('profesion' => 'Carreteras (Construcción) ' , 'riesgo' => '2'),
         array('profesion' => 'Carrocero ' , 'riesgo' => '2'),
         array('profesion' => 'Cartero ' , 'riesgo' => '2'),
         array('profesion' => 'Casas de cambio ' , 'riesgo' => '1'),
         array('profesion' => 'Casino ' , 'riesgo' => '1'),
         array('profesion' => 'Catedrático (Clases Teóricas) ' , 'riesgo' => '1'),
         array('profesion' => 'Cazador ' , 'riesgo' => 'SC'),
         array('profesion' => 'Celador ' , 'riesgo' => '2'),
         array('profesion' => 'Cemento (Fabr. Con Extrac Sin Explos) ' , 'riesgo' => '2'),
         array('profesion' => 'Cemento (Fabr. Con Extrac. Con Explos)' , 'riesgo' => 'SC'),
         array('profesion' => 'Censor Jurado de Cuentas ' , 'riesgo' => '1'),
         array('profesion' => 'Cerrajero ' , 'riesgo' => '2'),
         array('profesion' => 'Cestero' , 'riesgo' => '2'),
         array('profesion' => 'Chapador ' , 'riesgo' => '2'),
         array('profesion' => 'Chapista ' , 'riesgo' => '2'),
         array('profesion' => 'Charcutero' , 'riesgo' => '2'),
         array('profesion' => 'Chatarrero' , 'riesgo' => '2'),
         array('profesion' => 'Chocolatero' , 'riesgo' => '2'),
         array('profesion' => 'Chófer  (Personal)' , 'riesgo' => '2'),
         array('profesion' => 'Churrero' , 'riesgo' => '2'),
         array('profesion' => 'Cincelador' , 'riesgo' => '4'),
         array('profesion' => 'Cinematografía (Personal Técnico) ' , 'riesgo' => '2'),
         array('profesion' => 'Cocinero' , 'riesgo' => '2'),
         array('profesion' => 'Colocadores de Pavimento (Moqueta)' , 'riesgo' => '2'),
         array('profesion' => 'Colocadores de Pavimento (Parquet,..)' , 'riesgo' => '2'),
         array('profesion' => 'Comadrona' , 'riesgo' => '2'),
         array('profesion' => 'Comercial ' , 'riesgo' => '1'),
         array('profesion' => 'Comestibles (Tienda) ' , 'riesgo' => '2'),
         array('profesion' => 'Comisionista ' , 'riesgo' => '2'),
         array('profesion' => 'Compositor ' , 'riesgo' => '1'),
         array('profesion' => 'Conductor ' , 'riesgo' => '2'),
         array('profesion' => 'Conductor Camión' , 'riesgo' => '2'),
         array('profesion' => 'Conductor de Maquinaria Pesada ' , 'riesgo' => '2'),
         array('profesion' => 'Confección de Prendas de Vestir ' , 'riesgo' => '2'),
         array('profesion' => 'Confitero ' , 'riesgo' => '2'),
         array('profesion' => 'Consejero Delegado ' , 'riesgo' => '1'),
         array('profesion' => 'Conserje ' , 'riesgo' => '2'),
         array('profesion' => 'Consignatorio Buques (Vigilanc Carg/Descarga) ' , 'riesgo' => '2'),
         array('profesion' => 'Consignatorio de Buques (Oficinas) ' , 'riesgo' => '1'),
         array('profesion' => 'Construcción' , 'riesgo' => '2'),
         array('profesion' => 'Constructor' , 'riesgo' => '2'),
         array('profesion' => 'Constructor-gerente' , 'riesgo' => '2'),
         array('profesion' => 'Consultor ' , 'riesgo' => '1'),
         array('profesion' => 'Contable ' , 'riesgo' => '1'),
         array('profesion' => 'Contección Textil ' , 'riesgo' => '4'),
         array('profesion' => 'Contratista de Obras Con Trabajo manual ' , 'riesgo' => '2'),
         array('profesion' => 'Contratista de Obras Sin Trabajo Manual ' , 'riesgo' => '2'),
         array('profesion' => 'Control de Producción ' , 'riesgo' => '2'),
         array('profesion' => 'Controlador' , 'riesgo' => '2'),
         array('profesion' => 'Corredor Seguros' , 'riesgo' => '1'),
         array('profesion' => 'Costurera ' , 'riesgo' => '2'),
         array('profesion' => 'Cristalero ' , 'riesgo' => '2'),
         array('profesion' => 'Decorador' , 'riesgo' => '2'),
         array('profesion' => 'Delineante' , 'riesgo' => '1'),
         array('profesion' => 'Dentista' , 'riesgo' => '1'),
         array('profesion' => 'Dependiente en tienda, comercio, boutique' , 'riesgo' => '1'),
         array('profesion' => 'Deportista Profesional' , 'riesgo' => 'SC'),
         array('profesion' => 'Dermatólogo' , 'riesgo' => '1'),
         array('profesion' => 'Descargador' , 'riesgo' => 'SC'),
         array('profesion' => 'Deshollinador' , 'riesgo' => '2'),
         array('profesion' => 'Detective' , 'riesgo' => '2'),
         array('profesion' => 'Dibujante' , 'riesgo' => '1'),
         array('profesion' => 'Diplomático' , 'riesgo' => '1'),
         array('profesion' => 'Directivo ' , 'riesgo' => '1'),
         array('profesion' => 'Director' , 'riesgo' => '1'),
         array('profesion' => 'Director Administración' , 'riesgo' => '1'),
         array('profesion' => 'Disc Jockey' , 'riesgo' => '2'),
         array('profesion' => 'Diseñador' , 'riesgo' => '1'),
         array('profesion' => 'Distribuidor-Reparto' , 'riesgo' => '2'),
         array('profesion' => 'Droguero (Con Materias Inflamables)' , 'riesgo' => '2'),
         array('profesion' => 'Droguero (Sin Materias Inflamables)' , 'riesgo' => '1'),
         array('profesion' => 'Ebanista' , 'riesgo' => '2'),
         array('profesion' => 'Eclesiástico' , 'riesgo' => '1'),
         array('profesion' => 'Economista' , 'riesgo' => '1'),
         array('profesion' => 'Editor (Con Trabajo Manual)' , 'riesgo' => '2'),
         array('profesion' => 'Editor (Sin Trabajo Manual)' , 'riesgo' => '1'),
         array('profesion' => 'Electricista' , 'riesgo' => '2'),
         array('profesion' => 'Electricista (Tendidos de Líneas)' , 'riesgo' => 'SC'),
         array('profesion' => 'Embajador o Cónsul' , 'riesgo' => '1'),
         array('profesion' => 'Embalador' , 'riesgo' => '2'),
         array('profesion' => 'Embaldosador' , 'riesgo' => '2'),
         array('profesion' => 'Embutido (Elaboración)' , 'riesgo' => '2'),
         array('profesion' => 'Empapelador' , 'riesgo' => '2'),
         array('profesion' => 'Empleado  Funeraria' , 'riesgo' => '2'),
         array('profesion' => 'Empleado  Hostelería' , 'riesgo' => '2'),
         array('profesion' => 'Empleado Circo Atracciones' , 'riesgo' => 'SC'),
         array('profesion' => 'Empleado de Central Nuclear' , 'riesgo' => 'SC'),
         array('profesion' => 'Empleado de la Construcción' , 'riesgo' => '2'),
         array('profesion' => 'Empleado Fábrica / Taller' , 'riesgo' => '2'),
         array('profesion' => 'Empleado Gasolinera / Garaje' , 'riesgo' => '2'),
         array('profesion' => 'Empleado Oficina' , 'riesgo' => '1'),
         array('profesion' => 'Empleados de Limpieza' , 'riesgo' => '2'),
         array('profesion' => 'Encargado de Obras' , 'riesgo' => '2'),
         array('profesion' => 'Encofrador' , 'riesgo' => '2'),
         array('profesion' => 'Encuadernador (Con Taller Mecánico)' , 'riesgo' => '2'),
         array('profesion' => 'Enfermera / Ats / Due' , 'riesgo' => '2'),
         array('profesion' => 'Enologo' , 'riesgo' => '2'),
         array('profesion' => 'Entarimador' , 'riesgo' => '2'),
         array('profesion' => 'Enterrador' , 'riesgo' => '2'),
         array('profesion' => 'Entrenador de Deportes' , 'riesgo' => 'SC'),
         array('profesion' => 'Envasador' , 'riesgo' => '2'),
         array('profesion' => 'Enyesador' , 'riesgo' => '2'),
         array('profesion' => 'Escaparatista' , 'riesgo' => '2'),
         array('profesion' => 'Escayolista' , 'riesgo' => '2'),
         array('profesion' => 'Escritor (Sin Desplazamiento)' , 'riesgo' => '1'),
         array('profesion' => 'Escultor' , 'riesgo' => '2'),
         array('profesion' => 'Esmaltador' , 'riesgo' => '2'),
         array('profesion' => 'Espeleólogo' , 'riesgo' => '2'),
         array('profesion' => 'Estanquero' , 'riesgo' => '1'),
         array('profesion' => 'Esteticien' , 'riesgo' => '2'),
         array('profesion' => 'Estibador' , 'riesgo' => '2'),
         array('profesion' => 'Estomatólogo' , 'riesgo' => '1'),
         array('profesion' => 'Estudiante' , 'riesgo' => '1'),
         array('profesion' => 'Fabricación Caucho' , 'riesgo' => '2'),
         array('profesion' => 'Farmacéutico' , 'riesgo' => '1'),
         array('profesion' => 'Feriante' , 'riesgo' => '2'),
         array('profesion' => 'Ferreteria' , 'riesgo' => '2'),
         array('profesion' => 'Ferroviario' , 'riesgo' => '2'),
         array('profesion' => 'Filólogo' , 'riesgo' => '1'),
         array('profesion' => 'Fiscal' , 'riesgo' => '1'),
         array('profesion' => 'Físico (Excepto Nuclear)' , 'riesgo' => '2'),
         array('profesion' => 'Fisioterapeuta' , 'riesgo' => '2'),
         array('profesion' => 'Floricultor' , 'riesgo' => '2'),
         array('profesion' => 'Florista' , 'riesgo' => '1'),
         array('profesion' => 'Fontanero' , 'riesgo' => '2'),
         array('profesion' => 'Forense' , 'riesgo' => '1'),
         array('profesion' => 'Forjador' , 'riesgo' => '2'),
         array('profesion' => 'Fotógrafo' , 'riesgo' => '2'),
         array('profesion' => 'Fresador' , 'riesgo' => '2'),
         array('profesion' => 'Frutero' , 'riesgo' => '2'),
         array('profesion' => 'Fumigador' , 'riesgo' => '2'),
         array('profesion' => 'Funcionario' , 'riesgo' => '1'),
         array('profesion' => 'Funcionario de Prisiones' , 'riesgo' => '2'),
         array('profesion' => 'Fundidor' , 'riesgo' => '2'),
         array('profesion' => 'Ganadero' , 'riesgo' => '2'),
         array('profesion' => 'Geólogo' , 'riesgo' => '2'),
         array('profesion' => 'Gerente Empresa (Con Trabajo Manual)' , 'riesgo' => '2'),
         array('profesion' => 'Gerente Empresa (Sin Trabajo Manual)' , 'riesgo' => '1'),
         array('profesion' => 'Gestor Administrativo' , 'riesgo' => '1'),
         array('profesion' => 'Ginecólogo' , 'riesgo' => '1'),
         array('profesion' => 'Gobernanta' , 'riesgo' => '2'),
         array('profesion' => 'Grabador Artístico' , 'riesgo' => '2'),
         array('profesion' => 'Graduado Social' , 'riesgo' => '1'),
         array('profesion' => 'Gruista' , 'riesgo' => '2'),
         array('profesion' => 'Guarda (Sin Arma de Fuego)' , 'riesgo' => 'SC'),
         array('profesion' => 'Guarda de Cementerio' , 'riesgo' => '2'),
         array('profesion' => 'Guarda de Jardines y Parques' , 'riesgo' => '2'),
         array('profesion' => 'Guarda de Museos' , 'riesgo' => '2'),
         array('profesion' => 'Guarda de Seguridad (con Arma de Fuego)' , 'riesgo' => 'SC'),
         array('profesion' => 'Guarda Forestal' , 'riesgo' => '2'),
         array('profesion' => 'Guardería Infantil' , 'riesgo' => '2'),
         array('profesion' => 'Guía Turístico' , 'riesgo' => '2'),
         array('profesion' => 'Herrero' , 'riesgo' => '2'),
         array('profesion' => 'Higienista dental' , 'riesgo' => '1'),
         array('profesion' => 'Hojalatero' , 'riesgo' => '2'),
         array('profesion' => 'Horticultor' , 'riesgo' => '2'),
         array('profesion' => 'Hostelería ' , 'riesgo' => '2'),
         array('profesion' => 'Iluminación espectáculos' , 'riesgo' => 'SC'),
         array('profesion' => 'Impermeabilizador' , 'riesgo' => '2'),
         array('profesion' => 'Impresor ' , 'riesgo' => '2'),
         array('profesion' => 'Informático ' , 'riesgo' => '1'),
         array('profesion' => 'Ingeniero ' , 'riesgo' => '2'),
         array('profesion' => 'Ingeniero Técnico ' , 'riesgo' => '2'),
         array('profesion' => 'Inspector Administrativo ' , 'riesgo' => '1'),
         array('profesion' => 'Inspector de Hacienda ' , 'riesgo' => '2'),
         array('profesion' => 'Inspector de Matadero ' , 'riesgo' => '2'),
         array('profesion' => 'Inspector de Mercado ' , 'riesgo' => '2'),
         array('profesion' => 'Inspector de Seguros ' , 'riesgo' => '1'),
         array('profesion' => 'Inspector de Ventas ' , 'riesgo' => '2'),
         array('profesion' => 'Inspector Policía' , 'riesgo' => 'SC'),
         array('profesion' => 'Instalador en general ' , 'riesgo' => '2'),
         array('profesion' => 'Intendente Mercantil' , 'riesgo' => '1'),
         array('profesion' => 'Intérpetre' , 'riesgo' => '1'),
         array('profesion' => 'Investigador  Privado' , 'riesgo' => '2'),
         array('profesion' => 'Jardinero' , 'riesgo' => '2'),
         array('profesion' => 'Joyero' , 'riesgo' => '1'),
         array('profesion' => 'Joyero (Fabricación)' , 'riesgo' => '2'),
         array('profesion' => 'Jubilado' , 'riesgo' => 'SC'),
         array('profesion' => 'Juez, Magistrado' , 'riesgo' => '1'),
         array('profesion' => 'Laminador' , 'riesgo' => '2'),
         array('profesion' => 'Lampista (Instalac. de Antenas)' , 'riesgo' => 'SC'),
         array('profesion' => 'Lampista (Taller, Obras)' , 'riesgo' => '2'),
         array('profesion' => 'Lana (Fabricación de Tejidos)' , 'riesgo' => '2'),
         array('profesion' => 'Lavandería' , 'riesgo' => '2'),
         array('profesion' => 'Lechero' , 'riesgo' => '2'),
         array('profesion' => 'Leñador' , 'riesgo' => 'SC'),
         array('profesion' => 'Lexicógrafo' , 'riesgo' => '1'),
         array('profesion' => 'Librero' , 'riesgo' => '2'),
         array('profesion' => 'Limpiabotas' , 'riesgo' => '2'),
         array('profesion' => 'Limpiador (Exteriores Con Andamios)' , 'riesgo' => '2'),
         array('profesion' => 'Limpiador (Interiores/Exteriores Sin Andamios)' , 'riesgo' => '2'),
         array('profesion' => 'Limpieza' , 'riesgo' => '2'),
         array('profesion' => 'Litógrafo' , 'riesgo' => '2'),
         array('profesion' => 'Locutor' , 'riesgo' => '1'),
         array('profesion' => 'Locutorio' , 'riesgo' => '1'),
         array('profesion' => 'Logopeda' , 'riesgo' => '1'),
         array('profesion' => 'Manicura' , 'riesgo' => '2'),
         array('profesion' => 'Manipulador de Alimentos' , 'riesgo' => '2'),
         array('profesion' => 'Maquillador/a' , 'riesgo' => '2'),
         array('profesion' => 'Maquinista Ferroviario' , 'riesgo' => '2'),
         array('profesion' => 'Marino' , 'riesgo' => 'SC'),
         array('profesion' => 'Mariscador' , 'riesgo' => 'SC'),
         array('profesion' => 'Marmolista' , 'riesgo' => '2'),
         array('profesion' => 'Marroquinería' , 'riesgo' => '2'),
         array('profesion' => 'Masajista' , 'riesgo' => '2'),
         array('profesion' => 'Matarife' , 'riesgo' => '2'),
         array('profesion' => 'Matemático' , 'riesgo' => '1'),
         array('profesion' => 'Mecánico' , 'riesgo' => '2'),
         array('profesion' => 'Mecanógrafo/a' , 'riesgo' => '1'),
         array('profesion' => 'Médico' , 'riesgo' => '1'),
         array('profesion' => 'Médico  Especialista' , 'riesgo' => '1'),
         array('profesion' => 'Médico de Cabecera' , 'riesgo' => '1'),
         array('profesion' => 'Medico de Centro Psiquiatrico' , 'riesgo' => '2'),
         array('profesion' => 'Médico de Urgencias' , 'riesgo' => '1'),
         array('profesion' => 'Médico Estético' , 'riesgo' => '1'),
         array('profesion' => 'Médico Hospital' , 'riesgo' => '1'),
         array('profesion' => 'Médico Neumólogo' , 'riesgo' => '1'),
         array('profesion' => 'Mensajero' , 'riesgo' => '2'),
         array('profesion' => 'Mensajeros de Furgoneta' , 'riesgo' => '2'),
         array('profesion' => 'Militar' , 'riesgo' => 'SC'),
         array('profesion' => 'Minero' , 'riesgo' => 'SC'),
         array('profesion' => 'Modelo' , 'riesgo' => '2'),
         array('profesion' => 'Modista' , 'riesgo' => '2'),
         array('profesion' => 'Monitor de Deportes' , 'riesgo' => '2'),
         array('profesion' => 'Montador' , 'riesgo' => '2'),
         array('profesion' => 'Montador Andamios' , 'riesgo' => '2'),
         array('profesion' => 'Mosso  d’Escuadra' , 'riesgo' => 'SC'),
         array('profesion' => 'Mozo de Almacén' , 'riesgo' => '2'),
         array('profesion' => 'Mozo de Equipaje' , 'riesgo' => '2'),
         array('profesion' => 'Mudanzas' , 'riesgo' => '2'),
         array('profesion' => 'Músico' , 'riesgo' => '2'),
         array('profesion' => 'Neurólogo' , 'riesgo' => '1'),
         array('profesion' => 'Notario' , 'riesgo' => '1'),
         array('profesion' => 'Nutricionista' , 'riesgo' => '1'),
         array('profesion' => 'Obrero  Const.Taller/Fábrica' , 'riesgo' => '2'),
         array('profesion' => 'Oculista' , 'riesgo' => '1'),
         array('profesion' => 'Odontólogo' , 'riesgo' => '1'),
         array('profesion' => 'Oftalmólogo' , 'riesgo' => '1'),
         array('profesion' => 'Operario' , 'riesgo' => '2'),
         array('profesion' => 'Operario / Empleado Fábrica / Taller' , 'riesgo' => '2'),
         array('profesion' => 'Óptico' , 'riesgo' => '1'),
         array('profesion' => 'Ordenanza' , 'riesgo' => '2'),
         array('profesion' => 'Orfebre' , 'riesgo' => '2'),
         array('profesion' => 'Ortopédico' , 'riesgo' => '1'),
         array('profesion' => 'Osteópata' , 'riesgo' => '2'),
         array('profesion' => 'Otorrinolaringólogo' , 'riesgo' => '1'),
         array('profesion' => 'Panadero con Elaboración' , 'riesgo' => '4'),
         array('profesion' => 'Párroco' , 'riesgo' => '1'),
         array('profesion' => 'Pastelero' , 'riesgo' => '3'),
         array('profesion' => 'Pedagogo' , 'riesgo' => '1'),
         array('profesion' => 'Pediatra' , 'riesgo' => '1'),
         array('profesion' => 'Pedicuro' , 'riesgo' => 'SC'),
         array('profesion' => 'Peletero' , 'riesgo' => '2'),
         array('profesion' => 'Peluquería canina' , 'riesgo' => '2'),
         array('profesion' => 'Peluquero' , 'riesgo' => '2'),
         array('profesion' => 'Periodista' , 'riesgo' => '1'),
         array('profesion' => 'Perito' , 'riesgo' => '2'),
         array('profesion' => 'Persianista' , 'riesgo' => '2'),
         array('profesion' => 'Pescadero' , 'riesgo' => '2'),
         array('profesion' => 'Pescador  ' , 'riesgo' => '2'),
         array('profesion' => 'Piloto Aerotaxi' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto de Aviación Comercial' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto de Aviación NO Comercial' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto de Helicópteros ' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto de Pruebas ' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto Foto Cartografía' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto Fumigación Campos' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto Prof. Helic. Plat Marinas ' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto Prof. Helic. Salvamento' , 'riesgo' => 'SC'),
         array('profesion' => 'Piloto Prof. Publicist' , 'riesgo' => 'SC'),
         array('profesion' => 'Pintor (Artístico) ' , 'riesgo' => 'SC'),
         array('profesion' => 'Pintor CON trabajos en altura ' , 'riesgo' => 'SC'),
         array('profesion' => 'Pintor SIN trabajos en altura ' , 'riesgo' => 'SC'),
         array('profesion' => 'Pirotécnico' , 'riesgo' => 'SC'),
         array('profesion' => 'Pocero (Con Uso De Explosivos)' , 'riesgo' => 'SC'),
         array('profesion' => 'Pocero (Sin Uso de Explosivos)' , 'riesgo' => 'SC'),
         array('profesion' => 'Podador ' , 'riesgo' => '2'),
         array('profesion' => 'Podólogo ' , 'riesgo' => '2'),
         array('profesion' => 'Policía Municipal' , 'riesgo' => 'SC'),
         array('profesion' => 'Policía Nacional ' , 'riesgo' => 'SC'),
         array('profesion' => 'Policía Nacional (Geos/Antiterroristas)    ' , 'riesgo' => 'SC'),
         array('profesion' => 'Policía Nacional (Patrulla) ' , 'riesgo' => 'SC'),
         array('profesion' => 'Policía Nacional Resto ' , 'riesgo' => 'SC'),
         array('profesion' => 'Policía Secreta' , 'riesgo' => 'SC'),
         array('profesion' => 'Policía Secreta/Estupefacientes ' , 'riesgo' => 'SC'),
         array('profesion' => 'Policías (en general), Guardia Civil' , 'riesgo' => 'SC'),
         array('profesion' => 'Político' , 'riesgo' => '2'),
         array('profesion' => 'Portero de inmueble' , 'riesgo' => '2'),
         array('profesion' => 'Practicante' , 'riesgo' => '2'),
         array('profesion' => 'Práctico de Puerto' , 'riesgo' => '4'),
         array('profesion' => 'Procurador' , 'riesgo' => '1'),
         array('profesion' => 'Profesión sin Riesgo (sin trabajo manual) ' , 'riesgo' => '1'),
         array('profesion' => 'Profesor ' , 'riesgo' => '1'),
         array('profesion' => 'Profesor (Autoescuela)' , 'riesgo' => '3'),
         array('profesion' => 'Profesor (Deportes) ' , 'riesgo' => '3'),
         array('profesion' => 'Profesor de Autoescuela ' , 'riesgo' => '3'),
         array('profesion' => 'Profesor de Idiomas ' , 'riesgo' => '1'),
         array('profesion' => 'Profesor de Música ' , 'riesgo' => '1'),
         array('profesion' => 'Profesor de Tenis ' , 'riesgo' => '3'),
         array('profesion' => 'Protésico Dental ' , 'riesgo' => '2'),
         array('profesion' => 'Psicólogo ' , 'riesgo' => '1'),
         array('profesion' => 'Psicomotricista ' , 'riesgo' => '1'),
         array('profesion' => 'Psiquiatra ' , 'riesgo' => '1'),
         array('profesion' => 'Publicidad (Agente) ' , 'riesgo' => '1'),
         array('profesion' => 'Puericultor ' , 'riesgo' => '2'),
         array('profesion' => 'Químico ' , 'riesgo' => '1'),
         array('profesion' => 'Químico (Con Uso de Materias Inflamables) ' , 'riesgo' => '4'),
         array('profesion' => 'Químico (Sin Uso de Materias Inflamables) ' , 'riesgo' => '3'),
         array('profesion' => 'Quiropráctico ' , 'riesgo' => '2'),
         array('profesion' => 'Radiólogo ' , 'riesgo' => '2'),
         array('profesion' => 'Radiotécnico (Sin Instalacion De Antenas ' , 'riesgo' => '2'),
         array('profesion' => 'Radiotécnico (Sin Instalacion De Antenas)' , 'riesgo' => '2'),
         array('profesion' => 'Recepcionista ' , 'riesgo' => '1'),
         array('profesion' => 'Registrador de la Propiedad ' , 'riesgo' => '1'),
         array('profesion' => 'Rejoneador ' , 'riesgo' => 'SC'),
         array('profesion' => 'Relaciones Públicas' , 'riesgo' => '1'),
         array('profesion' => 'Relojero' , 'riesgo' => '2'),
         array('profesion' => 'Reparador    (Electrodomésticos/sonido)' , 'riesgo' => '2'),
         array('profesion' => 'Repartidor' , 'riesgo' => '2'),
         array('profesion' => 'Reportero' , 'riesgo' => '2'),
         array('profesion' => 'Reportero en Zonas de Conflicto' , 'riesgo' => 'SC'),
         array('profesion' => 'Representante de Artistas' , 'riesgo' => '1'),
         array('profesion' => 'Representante de Comercio' , 'riesgo' => '2'),
         array('profesion' => 'Restaurador' , 'riesgo' => '2'),
         array('profesion' => 'Sacerdote' , 'riesgo' => '1'),
         array('profesion' => 'Sastre/Modista' , 'riesgo' => '2'),
         array('profesion' => 'Secretario de Juzgado' , 'riesgo' => '1'),
         array('profesion' => 'Secretario/a' , 'riesgo' => '1'),
         array('profesion' => 'Serigrafista' , 'riesgo' => '2'),
         array('profesion' => 'Siderúrgico' , 'riesgo' => '2'),
         array('profesion' => 'Sociólogo' , 'riesgo' => '1'),
         array('profesion' => 'Socorrista' , 'riesgo' => '2'),
         array('profesion' => 'Soldador' , 'riesgo' => '2'),
         array('profesion' => 'Submarinista' , 'riesgo' => 'SC'),
         array('profesion' => 'Talador' , 'riesgo' => 'SC'),
         array('profesion' => 'Tapicero' , 'riesgo' => '2'),
         array('profesion' => 'Taquillero' , 'riesgo' => '1'),
         array('profesion' => 'Taxidermista' , 'riesgo' => '2'),
         array('profesion' => 'Taxista' , 'riesgo' => '2'),
         array('profesion' => 'Técnico  Audio-Video' , 'riesgo' => '2'),
         array('profesion' => 'Técnico de Laboratorio' , 'riesgo' => '2'),
         array('profesion' => 'Técnico de Radio/Televisión' , 'riesgo' => '2'),
         array('profesion' => 'Técnico en Electrónica' , 'riesgo' => '2'),
         array('profesion' => 'Técnico Sanitario Diverso' , 'riesgo' => '2'),
         array('profesion' => 'Telefonista' , 'riesgo' => '2'),
         array('profesion' => 'Tendero' , 'riesgo' => '2'),
         array('profesion' => 'Tintorero' , 'riesgo' => '2'),
         array('profesion' => 'Tipógrafo' , 'riesgo' => '2'),
         array('profesion' => 'Topógrafo' , 'riesgo' => '2'),
         array('profesion' => 'Torero' , 'riesgo' => 'SC'),
         array('profesion' => 'Tornero' , 'riesgo' => '2'),
         array('profesion' => 'Traductor' , 'riesgo' => '1'),
         array('profesion' => 'Transportista (Mat. Pelig./Inflamables)' , 'riesgo' => 'SC'),
         array('profesion' => 'Transportista (Materias No Peligrosas)' , 'riesgo' => '2'),
         array('profesion' => 'Transportista/Montador' , 'riesgo' => '2'),
         array('profesion' => 'Trapecista' , 'riesgo' => 'SC'),
         array('profesion' => 'Traumatólogo' , 'riesgo' => '1'),
         array('profesion' => 'Urólogo' , 'riesgo' => '1'),
         array('profesion' => 'Vendedor  Establecimiento' , 'riesgo' => '1'),
         array('profesion' => 'Vendedores  Ambulantes' , 'riesgo' => 'SC'),
         array('profesion' => 'Veterinario' , 'riesgo' => '2'),
         array('profesion' => 'Viajante' , 'riesgo' => '2'),
         array('profesion' => 'Vidriero' , 'riesgo' => '2'),
         array('profesion' => 'Vigilante ' , 'riesgo' => 'SC'),
         array('profesion' => 'Visitador Médico' , 'riesgo' => '2'),
         array('profesion' => 'Viticultor' , 'riesgo' => '2'),
         array('profesion' => 'Zapatero en Reparación' , 'riesgo' => '2')
      );

      // Usamos un bucle para iterar sobre el array de profesiones
      foreach ($profesiones as $profesion) {
         $wpdb->insert(
            $tabla_productos,
               array(
                  'profesion' => $profesion['profesion'],
                  'riesgo' => $profesion['riesgo']
               ),
               array(
                  '%s',
                  '%s'
               )
         );
      }
   }
}

register_activation_hook(__FILE__, 'SACAIG_crear_tablas_plugin');



/********** Eliminar las tablas creadas en caso de desinstalar o desactivar el plugin ***********/
function SACAIG_eliminar_tablas_plugin() {

   global $wpdb;

   $tabla_productos = $wpdb->prefix.'profesiones_accidentes_riesgos';

   // Elimina la tabla si existe
   $wpdb->query("DROP TABLE IF EXISTS $tabla_productos");
}


register_uninstall_hook(__FILE__, 'SACAIG_eliminar_tablas_plugin');



/*******   Redirección de la plantilla del CPT para que se muestre la definida por este plugin ************/
function SACAIG_redirect_cpt_template($template) {

   global $post;

   if (!$post || !is_singular('productos')) return $template;

   $is_slug_correct = isset($post->post_name) && $post->post_name == SACAIG_SLUG_LANDING_PRODUCTO;

   if ($post->post_type == 'productos' && $is_slug_correct) {
      $custom_template = plugin_dir_path(__FILE__) . SACAIG_TEMPLATE_LANDING_PRODUCTO;
      if (file_exists($custom_template)) return $custom_template;
      else error_log('La plantilla personalizada SACAIG_TEMPLATE_LANDING_PRODUCTO no se encuentra.');
   }

   return $template;
}

add_filter('single_template', 'SACAIG_redirect_cpt_template');




/**
 * Registramos los endpoints basados en las páginas
 */
function SACAIG_register_endpoints() {
   // Listado de páginas del plugin
    require SACAIG_PLUGIN_PATH .'utils/paginas-crear-caracteristicas.php';

   foreach ($SACAIG_paginas as $pagina) {
      add_rewrite_endpoint($pagina['slug'], EP_ROOT);
   }
}

add_action('init', 'SACAIG_register_endpoints');



/**
 * Ruta del endpoint y carga de plantilla
 */
function SACAIG_endpoint_template() {
   global $wp;

   // Listado de páginas del plugin
   require SACAIG_PLUGIN_PATH .'utils/paginas-crear-caracteristicas.php';

   foreach ($SACAIG_paginas as $pagina) {
      if (isset($wp->query_vars[$pagina['slug']])) {
            // Cargar la plantilla específica para cada endpoint
            $template_path = plugin_dir_path(__FILE__) . 'templates/' . $pagina['slug'] . '.php';

            if (file_exists($template_path)) {
               include $template_path;
            } else {
               // Plantilla por defecto si no existe el archivo específico
               echo '<h1>' . esc_html($pagina['title']) . '</h1>';
               echo '<p>' . esc_html($pagina['content']) . '</p>';
               echo $template_path;
            }

            exit;
        }
    }
}
add_action('template_redirect', 'SACAIG_endpoint_template');




/****** 
 * METADATOS Y DEMÁS EN RANKMATH 
 * ****/
function SACAIG_rankmath_title( $title ) {
   global $wp;

   // Listado de páginas del plugin
   require SACAIG_PLUGIN_PATH .'utils/paginas-crear-caracteristicas.php';

   foreach ( $SACAIG_paginas as $pagina ) {
      if ( isset( $wp->query_vars[$pagina['slug']] ) ) {
         // Si se ha definido meta_title en el array, lo usamos; 
         // en caso contrario usamos 'title' como fallback
         if ( !empty( $pagina['meta_title'] ) ) {
            return $pagina['meta_title'];
         }
         return $pagina['title'];
      }
   }

   return $title;
}

add_filter( 'rank_math/frontend/title', 'SACAIG_rankmath_title', 10, 1 );


/**
 * Cambiar la Meta Description en Rank Math
 */
function SACAIG_rankmath_description( $description ) {
   global $wp;

   // Listado de páginas del plugin
   require SACAIG_PLUGIN_PATH .'utils/paginas-crear-caracteristicas.php';

   foreach ( $SACAIG_paginas as $pagina ) {
      if ( isset( $wp->query_vars[$pagina['slug']] ) ) {
         if ( !empty( $pagina['meta_description'] ) ) {
            return $pagina['meta_description'];
         }
      }
   }

   return $description;
}

add_filter( 'rank_math/frontend/description', 'SACAIG_rankmath_description', 10, 1 );



/**
 * Cambiar la meta "robots" (index/noindex)
 */
function SACAIG_rankmath_robots( $robots ) {
   global $wp;

   // Listado de páginas del plugin
   require SACAIG_PLUGIN_PATH .'utils/paginas-crear-caracteristicas.php';

   foreach ( $SACAIG_paginas as $pagina ) {
      if ( isset( $wp->query_vars[$pagina['slug']] ) ) {
         // Si el array marca 'indexable' como false, devolvemos array('noindex','nofollow')
         if ( !$pagina['indexable'] ) {
            return array( 'noindex', 'nofollow' );
         }
      }
   }

   // En caso contrario, devolvemos el array original que nos llegue
   return $robots;
}

add_filter( 'rank_math/frontend/robots', 'SACAIG_rankmath_robots', 10, 1 );




/******* Encolado de estilos y scripts necesarios para el plugin ********/
function SACAIG_check_required_page() {
   global $wp;

   // Listado de páginas del plugin
   require SACAIG_PLUGIN_PATH .'utils/paginas-crear-caracteristicas.php';

   $is_required_page = false;

   // Recorre cada slug de la lista y comprueba si existe en $wp->query_vars
   foreach ($SACAIG_paginas as $pagina) {
      if ( isset($wp->query_vars[$pagina['slug']]) ) {
         $is_required_page = true;
         break;
      }
   }

   return $is_required_page;
}


function SACAIG_consejos_enqueue_styles() {

   if (SACAIG_check_required_page()) {

      if (!wp_style_is('sweetalert2-css', 'enqueued')) {
         wp_enqueue_style('sweetalert2-css', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css');
      }

      if (!wp_style_is('SACAIG_styles', 'enqueued')) {
         wp_enqueue_style('SACAIG_styles', plugin_dir_url(__FILE__) . 'css/SACAIG_estilos.css', array(), '1.0');
      }
   }

   if (get_post_field('post_name', get_post()) == SACAIG_SLUG_LANDING_PRODUCTO) {
      if (!wp_style_is('SACAIG_css-landing', 'enqueued')) {
         wp_enqueue_style('SACAIG_css-landing', plugin_dir_url(__FILE__) . 'css/SACAIG_estilos_landing.css', array(), '1.0');
      }
   }
}

add_action('wp_enqueue_scripts', 'SACAIG_consejos_enqueue_styles', 100);



function SACAIG_api_plugin_enqueue_scripts() {
   if (SACAIG_check_required_page()) {
      insu_encolar_script_insuguru(SACAIG_INSU_PRODUCT_ID);

      if (!wp_script_is(SACAIG_SLUG_LANDING_PRODUCTO.'-script', 'enqueued')) {
         wp_enqueue_script(SACAIG_SLUG_LANDING_PRODUCTO.'-script', plugins_url('/js/SACAIG_scripts.js', __FILE__), array('jquery'), filemtime(SACAIG_PLUGIN_PATH.'/js/SACAIG_scripts.js'), true);
         wp_localize_script(SACAIG_SLUG_LANDING_PRODUCTO.'-script', 'miAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'url_producto' => SACAIG_SLUG_LANDING_PRODUCTO,
         ));
      }

      if (!wp_script_is('moment-js', 'enqueued')) {
         wp_enqueue_script('moment-js', 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js', array(), '2.29.1', true);
      }

      if (!wp_script_is('sweetalert2-js', 'enqueued')) {
         wp_enqueue_script('sweetalert2-js', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), '11.0.17', false);
      }
   }

   if (get_post_field('post_name', get_post()) == SACAIG_SLUG_LANDING_PRODUCTO) {
      if (!wp_script_is('js-landing', 'enqueued')) {
         wp_enqueue_script('js-landing', plugins_url('/js/SACAIG_script_landing_producto.js', __FILE__), array('jquery'), '1.0', true);
      }
   }
}

add_action('wp_enqueue_scripts', 'SACAIG_api_plugin_enqueue_scripts');




/******** AJAX PROCESA LA GENERACIÓN DEL PROECTO ************/
function SACAIG_generar_proyecto() {

   // Inicializa el array de respuesta
   $response = [];

   // Verifica que el campo 'poliza' esté presente y no esté vacío
   if (!isset($_POST['poliza']) || empty($_POST['poliza'])) {
      $response['error'] = __('No se proporcionó la póliza', 'seguro-accidentes-aig');
   } else {
      $tipo_poliza = $_POST['poliza'];
      $profesion = sacaig_profesiones_byid($_POST['profesion']);
      $actividad_maual = $_POST['actividad_maual'] ;
      $descr_trabajo_manual = $_POST['descr_trabajo_manual'] ?? "";
      $enf_cardiaca = $_POST['enf_cardiaca'];
      $enf_cardiaca_descript = $_POST['enf_cardiaca_descript'] ?? "";
      $enf_grave = $_POST['enf_grave'];
      $enf_grave_desctip = $_POST['enf_grave_desctip'] ?? "";

      //Datos del asegurado
      $nombre_asegurado = $_POST['nombre'];
      $apellidos_asegurado = ucfirst($_POST['apellidos'])." ".ucfirst($_POST['apellidos-autorizado-2']);
      $codigo_postal_asegurado = $_POST['codigo_postal'];
      $provincia_asegurado = $_POST['provincia'];
      $poblacion_asegurado = $_POST['poblacion'];
      $direccion_asegurado = $_POST['dirección'];
      $identificador_asegurado = $_POST['identificador'];
      $email_asegurado = $_POST['email'];
      $telefono_asegurado = $_POST['telefono'];
      $fecha_nacimiento_asegurado = $_POST['fecha_nacimiento'];
      $iban_asegurado = $_POST['iban'];
      $fecha_efecto_solicitada_asegurado = $_POST['fecha_efecto_solicitada'];

      $identificador_tomador = isset($_POST['identificador_tomador']) ?  $_POST['identificador_tomador'] : null;

      $identificador_tomador = trim($identificador_tomador);

      $identificador_tomador = $identificador_tomador!='' ? $identificador_tomador : null;
      // Datos del tomador
      $tomador = $identificador_tomador ? true : false;
      $beneficiarios = isset($_POST['beneficiarios']) ? true : false;
      $nombre_tomador = $_POST['nombre_tomador'] ?? "";
      $apellidos_tomador = $_POST['apellidos_tomador'] ?? "";
      $codigo_postal_tomador = $_POST['codigo_postal_tomador'] ?? "";
      $poblacion_tomador = $_POST['poblacion_tomador'] ?? "";
      $direccion_tomador = $_POST['dirección_tomador'] ?? "";
      $identificador_tomador = $_POST['identificador_tomador'] ?? "";
      $email_tomador = $_POST['email_tomador'] ?? "";
      $telefono_tomador = $_POST['telefono_tomador'] ?? "";
      $fecha_nacimiento_tomador = $_POST['fecha_nacimiento_tomador'] ?? "";
      $provincia_tomador = $provincia_asegurado;

      //Si el tomador es la misma persona que se esta asegurando, se copian los datos en las variables
      if (!$tomador) {
         $nombre_tomador = $nombre_asegurado;
         $apellidos_tomador = $apellidos_asegurado;
         $codigo_postal_tomador = $codigo_postal_asegurado;
         $poblacion_tomador = $poblacion_asegurado;
         $direccion_tomador = $direccion_asegurado;
         $identificador_tomador = $identificador_asegurado;
         $email_tomador = $email_asegurado;
         $telefono_tomador = $telefono_asegurado;
         $fecha_nacimiento_tomador = $fecha_nacimiento_asegurado;
      }

      //Si el button beneficiario fue activado, se le agrega una X al string
      $beneficio = "";

      if($beneficiarios){
         $beneficio = "X";
      }

        
      //Sobre los beneficiarios
      $beneficiarios = array();

      // Itera para obtener hasta 4 beneficiarios (dependiendo de si están definidos o no)
      for ($i = 1; $i <= 4; $i++) {
         $nombre_beneficiario = $_POST["nombre_benf_$i"] ?? "";
         $nif_beneficiario = $_POST["nif_benf_$i"] ?? "";
         $porcentaje_beneficiario = $_POST["porc_benf_$i"] ?? "";

         // Verifica si al menos se proporcionó un nombre para considerar que hay un beneficiario
         if (!empty($nombre_beneficiario)) {
             // Crea un arreglo asociativo con la información del beneficiario
             $beneficiario = array(
                 "nombre" => $nombre_beneficiario,
                 "nif" => $nif_beneficiario,
                 "porcentaje" => $porcentaje_beneficiario
             );

             // Agrega el beneficiario al arreglo principal
             $beneficiarios[] = $beneficiario;
         }
      }   

     $nombre_provincia_asegurado = SACAIG_obtenerNombreProvincia($provincia_asegurado);
     $nombre_provincia_tomador = SACAIG_obtenerNombreProvincia($provincia_tomador);

     // GENERAMOS EL PROYECTO DE LA TARIFICACIÓN CON LOS DATOS DEL USUARIO
      $url_proyecto_producto = SACAIG_Generar_proyecto_PDF(
         $profesion,
         $actividad_maual,
         $descr_trabajo_manual,
         $enf_cardiaca,
         $enf_cardiaca_descript,
         $enf_grave,
         $enf_grave_desctip,
         ucwords($nombre_asegurado),
         $apellidos_asegurado,
         $codigo_postal_asegurado,
         $nombre_provincia_asegurado,
         $poblacion_asegurado,
         $direccion_asegurado,
         formatearIdentificador($identificador_asegurado),
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
         formatearIdentificador($identificador_tomador),
         $nombre_provincia_tomador,
         $email_tomador,
         $telefono_tomador,
         $fecha_nacimiento_tomador,
         $tipo_poliza,
         $beneficiarios
      );

      
   }

   $response = ['url_proyecto'=> $url_proyecto_producto];


   // Envía la respuesta en formato JSON
   return wp_send_json_success([
      'errores' => [],
      'respuesta'=>$response
   ]);
}


add_action('wp_ajax_SACAIG_generar_proyecto', 'SACAIG_generar_proyecto');
add_action('wp_ajax_nopriv_SACAIG_generar_proyecto', 'SACAIG_generar_proyecto');

/******** AJAX  CUMPLIMENTACIÓN DE LA PÓILIZA Y SU FIRMA ************/
function SACAIG_procesar_poliza() {

   // Inicializa el array de respuesta
   $response = [];

   // Verifica que el campo 'poliza' esté presente y no esté vacío
   if (!isset($_POST['poliza']) || empty($_POST['poliza'])) {
      $response['error'] = __('No se proporcionó la póliza', 'seguro-accidentes-aig');
   } else {
      $tipo_poliza = $_POST['poliza'];
      $profesion = sacaig_profesiones_byid($_POST['profesion']);
      $actividad_maual = $_POST['actividad_maual'] ;
      $descr_trabajo_manual = $_POST['descr_trabajo_manual'] ?? "";
      $enf_cardiaca = $_POST['enf_cardiaca'];
      $enf_cardiaca_descript = $_POST['enf_cardiaca_descript'] ?? "";
      $enf_grave = $_POST['enf_grave'];
      $enf_grave_desctip = $_POST['enf_grave_desctip'] ?? "";

      //Datos del asegurado
      $nombre_asegurado = $_POST['nombre'];
      $apellidos_asegurado = ucfirst($_POST['apellidos'])." ".ucfirst($_POST['apellidos-autorizado-2']);
      $codigo_postal_asegurado = $_POST['codigo_postal'];
      $provincia_asegurado = $_POST['provincia'];
      $poblacion_asegurado = $_POST['poblacion'];
      $direccion_asegurado = $_POST['dirección'];
      $identificador_asegurado = $_POST['identificador'];
      $email_asegurado = $_POST['email'];
      $telefono_asegurado = $_POST['telefono'];
      $fecha_nacimiento_asegurado = $_POST['fecha_nacimiento'];
      $iban_asegurado = $_POST['iban'];
      $fecha_efecto_solicitada_asegurado = $_POST['fecha_efecto_solicitada'];

      $identificador_tomador = isset($_POST['identificador_tomador']) ?  $_POST['identificador_tomador'] : null;

      $identificador_tomador = trim($identificador_tomador);

      $identificador_tomador = $identificador_tomador!='' ? $identificador_tomador : null;
      // Datos del tomador
      $tomador = $identificador_tomador ? true : false;
      $beneficiarios = isset($_POST['beneficiarios']) ? true : false;
      $nombre_tomador = $_POST['nombre_tomador'] ?? "";
      $apellidos_tomador = $_POST['apellidos_tomador'] ?? "";
      $codigo_postal_tomador = $_POST['codigo_postal_tomador'] ?? "";
      $poblacion_tomador = $_POST['poblacion_tomador'] ?? "";
      $direccion_tomador = $_POST['dirección_tomador'] ?? "";
      $identificador_tomador = $_POST['identificador_tomador'] ?? "";
      $email_tomador = $_POST['email_tomador'] ?? "";
      $telefono_tomador = $_POST['telefono_tomador'] ?? "";
      $fecha_nacimiento_tomador = $_POST['fecha_nacimiento_tomador'] ?? "";
      $provincia_tomador = $provincia_asegurado;

      //Si el tomador es la misma persona que se esta asegurando, se copian los datos en las variables
      if (!$tomador) {
         $nombre_tomador = $nombre_asegurado;
         $apellidos_tomador = $apellidos_asegurado;
         $codigo_postal_tomador = $codigo_postal_asegurado;
         $poblacion_tomador = $poblacion_asegurado;
         $direccion_tomador = $direccion_asegurado;
         $identificador_tomador = $identificador_asegurado;
         $email_tomador = $email_asegurado;
         $telefono_tomador = $telefono_asegurado;
         $fecha_nacimiento_tomador = $fecha_nacimiento_asegurado;
      }

      //Si el button beneficiario fue activado, se le agrega una X al string
      $beneficio = "";

      if($beneficiarios){
         $beneficio = "X";
      }

        
      //Sobre los beneficiarios
      $beneficiarios = array();

      // Itera para obtener hasta 4 beneficiarios (dependiendo de si están definidos o no)
      for ($i = 1; $i <= 4; $i++) {
         $nombre_beneficiario = $_POST["nombre_benf_$i"] ?? "";
         $nif_beneficiario = $_POST["nif_benf_$i"] ?? "";
         $porcentaje_beneficiario = $_POST["porc_benf_$i"] ?? "";

         // Verifica si al menos se proporcionó un nombre para considerar que hay un beneficiario
         if (!empty($nombre_beneficiario)) {
             // Crea un arreglo asociativo con la información del beneficiario
             $beneficiario = array(
                 "nombre" => $nombre_beneficiario,
                 "nif" => $nif_beneficiario,
                 "porcentaje" => $porcentaje_beneficiario
             );

             // Agrega el beneficiario al arreglo principal
             $beneficiarios[] = $beneficiario;
         }
      }   

     $nombre_provincia_asegurado = SACAIG_obtenerNombreProvincia($provincia_asegurado);
     $nombre_provincia_tomador = SACAIG_obtenerNombreProvincia($provincia_tomador);


      //Ejecuta el método SACAIG_Cumplimentacion_poliza_PDF para generar el PDF final y manejar la firma
      $firmaResponse = SACAIG_Cumplimentacion_firma_poliza_PDF(
         $profesion,
         $actividad_maual,
         $descr_trabajo_manual,
         $enf_cardiaca,
         $enf_cardiaca_descript,
         $enf_grave,
         $enf_grave_desctip,
         ucwords($nombre_asegurado),
         $apellidos_asegurado,
         $codigo_postal_asegurado,
         $nombre_provincia_asegurado,
         $poblacion_asegurado,
         $direccion_asegurado,
         formatearIdentificador($identificador_asegurado),
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
         formatearIdentificador($identificador_tomador),
         $nombre_provincia_tomador,
         $tipo_poliza,
         $beneficio,
         $beneficiarios
      );
        

     //Verificamos si la respuesta de la firma es exitosa
      if ($firmaResponse && isset($firmaResponse['request_id']) && isset($firmaResponse['signature_id']) && isset($firmaResponse['signatory_id'])) {
         $response['success'] = true;
         $response['firmaResponse'] = $firmaResponse;
      } else {
         $response['error'] = __('No se pudo completar el proceso de firma.', 'seguro-do-zurich');
         error_log('No se pudo completar el proceso de firma.'.$firmaResponse);
      }
      
   }

   $response = ['respuesta_firma' => $firmaResponse];
   $data_usr_tomador = ['nombre_completo' => ucwords($nombre_asegurado)." ".$apellidos_asegurado, 'email'=> $email_asegurado];


   // Envía la respuesta en formato JSON
   return wp_send_json_success([
      'errores' => [],
      'respuesta'=>$response,
      'datos_user' => $data_usr_tomador
   ]);
}


add_action('wp_ajax_SACAIG_procesar_poliza', 'SACAIG_procesar_poliza');
add_action('wp_ajax_nopriv_SACAIG_procesar_poliza', 'SACAIG_procesar_poliza');



//PETICIÓN AJAX PARA COMPROBAR MEDIANTE AJAX EL ESTADO DE UNA PETICIÓN DE FIRMA DIGITAL CON LLEIDA NET
function SACAIG_statusFirma() {
   $signature_id = $_POST['signature_id'];
   $request_id = $_POST['request_id'];
   $signatory_id = $_POST['signatory_id'];
   $nombre_asegurado = $_POST['name_asegurado'];

   $respuesta = SACAIG_obtener_estado_firma($request_id, $signature_id);

   $statusbool = array(); 

   if (isset($respuesta['status']) && $respuesta['status'] === 'Success') {
      if (isset($respuesta['signature_status']) && $respuesta['signature_status'] === 'signed') {
         $statusbool['status'] = true;
         
         wp_send_json_success($statusbool);

      } else {
         $statusbool['status'] = false;
         wp_send_json_success($statusbool);
      }
   }else {
      insu_registrar_error_insuguru("SACAIG_statusFirma", "No se encontró información del firmante.", SACAIG_INSU_PRODUCT_ID);
      wp_send_json_error();
   }
}

add_action('wp_ajax_SACAIG_verifica_status_proc_firma', 'SACAIG_statusFirma');
add_action('wp_ajax_nopriv_SACAIG_verifica_status_proc_firma', 'SACAIG_statusFirma');








/********** CÓDIGO PARA ENVIAR EL CORREO DE SOLICITUD DE CONTRATACIÓN A LA COMPÁÑÍA Y UNA COPIA A LA CORREDURÍA **********/
function SACAIG_EnvioCorreoPolizaCompania($email_asegurado, $link_poliza) {
   // Definición de headers
   $headers = [
      'Content-Type: text/html; charset=UTF-8',
      'From: "'. esc_html__(WPCONFIG_NAME_EMPRESA) .'" <'. sanitize_email(WPCONFIG_MAIL_EMPRESA) .'>',
      'Reply-To: ' . sanitize_email(WPCONFIG_MAIL_EMPRESA),
   ];

   // Correos que reciben confirmación
   // $correos_reciben_confirmación = [
   //    'soporte@aunnabroker.es',
   //    'suscripcion@aunnabroker.es',
   //    sanitize_email(WPCONFIG_MAIL_EMPRESA)
   // ];

   $correos_reciben_confirmación = [
      'arisewebe@gmail.com',
      'coralondepua@gmail.com',
      sanitize_email(WPCONFIG_MAIL_EMPRESA)
   ];

   // Asunto
   $asunto1 = "Nueva contratación Seguro de Accidentes AIG – " . WPCONFIG_NAME_EMPRESA;

   // Generar el contenido HTML
   ob_start();
   require_once trailingslashit(SACAIG_PLUGIN_PATH) . 'templates/template-mail-compania.php';
   $mensaje1 = ob_get_clean();

   // Envío
   $wp_mail_result2 = wp_mail($correos_reciben_confirmación, $asunto1, $mensaje1, $headers);

   if (! $wp_mail_result2) {
      insu_registrar_error_insuguru(
         "SACAIG_EnvioCorreoPolizaCompania",
         "Error al enviar correo: " . json_encode($wp_mail_result2),
         SACAIG_INSU_PRODUCT_ID
      );
      wp_send_json_error('Error al enviar el correo.');
   }

   wp_send_json_success('Correo enviado exitosamente.');
}




// Función que será ejecutada por el cron job
function SACAIG_enviar_correo_poliza_cron($email_asegurado, $signature_id, $request_id, $signatory_id, $nombre_asegurado) {

   // Obtener el documento firmado
   $file_path = SACAIG_obtener_documento_firmado_por_URL($request_id, $signature_id, $signatory_id, $nombre_asegurado);

   // Obtener el directorio base de wp-content
   $wp_content_dir = WP_CONTENT_DIR; // Ruta absoluta a 'wp-content'
   $wp_content_url = content_url();  // URL completa a 'wp-content'

   // Reemplaza la ruta del sistema con la URL correcta del sitio dinámicamente
   $file_url = str_replace($wp_content_dir, $wp_content_url, $file_path);

   // Procesar el archivo (por ejemplo, parcheo de la contratación)
   insu_patch_contratacion_insuguru($file_url, $signature_id);

   // Enviar el correo con la URL del archivo
   $resultado = SACAIG_EnvioCorreoPolizaCompania($email_asegurado, $file_url);

   if (!$resultado) {
      error_log('Error al enviar el correo a ' . $email_asegurado);
   }
}

// Asociar la función al hook del cron
add_action('SACAIG_enviar_correo_poliza_evento', 'SACAIG_enviar_correo_poliza_cron',10, 5);



// función para guardar transients
function SACAIG_save_transient() {
   return SACAIG_save_transient_service();
}
add_action('wp_ajax_SACAIG_save_transient', 'SACAIG_save_transient');
add_action('wp_ajax_nopriv_SACAIG_save_transient', 'SACAIG_save_transient');