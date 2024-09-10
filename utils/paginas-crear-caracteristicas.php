<?php 
	// Array de los datos de las páginas
	$empresa_name = get_option('sacaig_name_empresa', 'Nombre de Empresa por Defecto');

	$SACAIG_paginas = array(
	    array(
	        'slug' => 'contratar-seguro-accidentes-sacaig',
	        'title' => 'Contrata tu seguro de accidentes para profesionales',
	        'content' => '',
	        'meta_title' => '',
	        'meta_description' => '',
	        'indexable' => true,
	        'visible_in_search' => false
	    ),
	    array(
	        'slug' => 'firma-seguro-accidentes',
	        'title' => 'Confirma tu seguro de accidentes',
	        'content' => '',
	        'meta_title' => '',
	        'meta_description' => '',
	        'indexable' => false,
	        'visible_in_search' => false
	    ),
	    array(
	        'slug' => 'agradecimiento-seguro-sagcaig',
	        'title' => 'Gracias por contratar tu seguro con ' . esc_html($empresa_name),
	        'content' => '',
	        'meta_title' => '',
	        'meta_description' => '',
	        'indexable' => false,
	        'visible_in_search' => false
	    )
	);


 ?>