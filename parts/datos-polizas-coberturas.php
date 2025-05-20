<?php 
    
    //Variables a pasar del producto
    $nombre = ['Classic','Plus','Premier'];

    $imagenes_polizas = [SACAIG_PLUGIN_URL."/img/Treasure Check 1.svg",SACAIG_PLUGIN_URL."/img/User Secure.svg",SACAIG_PLUGIN_URL."/img/Money Shield.svg"];

    $precios = ["92","173","265"];

    $anotaciones_precio = ["€/año","€/año","€/año"];

    $anotacion_poliza = ["","",""];

    $url_condicionado = "";

    //Coberturas
    $coberturas = [
        [
            'titulo' => 'Fallecimiento por accidente',
            'valores' => ['150.000 €', '250.000 €', '350.000 €']
        ],
        [
            'titulo' => 'Fallecimiento simultáneo de ambos cónyuges por accidente de circulación <img src="'.SACAIG_PLUGIN_URL.'/img/icono-info.svg" class="icono-info-class" data-toggle="tooltip" title="Capital adicional al inicial de la póliza">',
            'valores' => ['+ 50.000 €', '+ 50.000 €', '+ 50.000 €']
        ],
        [
            'titulo' => 'Fallecimiento por infarto de miocardio por accidente laboral',
            'valores' => ['100.000 €', '100.000 €', '100.000 €']
        ],
        [
            'titulo' => 'Invalidez permanente absoluta por accidente',
            'valores' => ['150.000 €', '250.000 €', '350.000 €']
        ],
        [
            'titulo' => 'Invalidez permanente parcial por accidente (según baremo)',
            'valores' => ['150.000 €', '250.000 €', '350.000 €']
        ],
        [
            'titulo' => 'Invalidez permanente absoluta pora accidente de circulación',
            'valores' => ['200.000 €', '300.000 €', '400.000 €']
        ],
        [
            'titulo' => 'Indemnización por hijos dependientes',
            'valores' => ['2.000 €', '2.000 €', '2.000 €']
        ],
        [
            'titulo' => 'Indemnización diaria por hospitalización',
            'valores' => ['50 €', '50 €', '50 €']
        ],
        [
            'titulo' => 'Gastos de reforma de la vivienda en caso de invalidez permanente por accidente',
            'valores' => ['5.000 €', '5.000 €', '5.000 €']
        ],
        [
            'titulo' => 'Invalidez parcial',
            'valores' => ['Incluida', 'Incluida', 'Incluida']
        ],
        [
            'titulo' => 'Accidentes en motos de cualquier cilindrada',
            'valores' => ['Incluida', 'Incluida', 'Incluida']
        ]
    ];


    $class_width = count($nombre) === 2 ? 'second-width' : 'third-width';



 ?>