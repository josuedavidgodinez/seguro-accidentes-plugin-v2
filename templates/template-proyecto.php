<?php
function SACAIG_template_seguro_accidentes_aig(

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
    $nombre_provincia_asegurado,
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
    $nombre_provincia_tomador,
    $tipo_poliza,
    $beneficio,
    $beneficiarios
){

    // Obtener la fecha de hoy en el formato deseado
    $fecha_hoy = date("d/m/Y");

    $data_poliza = SACAIG_poliza_selected($tipo_poliza);

    $precio_poliza = $data_poliza['nombre'];
    $nombre_poliza = $data_poliza['precio'];
    $limite = $data_poliza['limite'];


    return <<<EOF
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <title>Plantilla PDF Presupuesto Seguro</title>
        <style type="text/css">
            body {color:#004481; font-family: 'Fieldwork', sans-serif;}
            .text-primary {color:#009696 !important;}
            .text-secondary {color:#333 !important;}
            .text-danger {color:#ff2f76 !important;}
            .border {border-color:#004481 !important}
            .border-primary {border-color:#009696 !important;}
            .border-danger {border-color:#ff2f76 !important;}

            .font-small {font-size:0.8rem;}
            .font-smaller {font-size:0.6rem ;}
            .font-weight-semibold {font-weight: 600 !important;}
            .bg-primary-transparent-1 {background: #00969610;}
            .bg-primary-transparent-2 {background: #00969620;}
            .border-width-custom-1 {border-width: 2px !important;}
            .border-width-custom-2 {border-width: 3px !important;}
            .border-semitransparent {border-color:#00969630 !important;}
        </style>
    </head>
    <body>


        <!--PÁG 1 -->
        <div class="container">
            <div class="row justify-content-center my-5 pt-5">
                <div class="col-3">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/logo-3mares-1.svg" alt="" width="200px" height="auto">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-5">
                    <h1 class="font-weight-bold text-center mb-5">Proyecto de seguro de Accidentes</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                    <p class="text-danger mb-0 font-small">Tomador:</p>
                    <p class="text-primary font-weight-bold h5">$nombre_asegurado $apellidos_asegurado</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-5">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/streamlinehq-solving-problem-1-product-400.svg" width="400px" height="auto">
                </div>  
            </div>
            <div class="row justify-content-center pb-5" >
                <div class="col-5 font-weight-bold text-center">
                    <p class="mb-0">Ronda de Nelle 85, 15007 A Coruña</p>
                    <p class="mb-0"><a href="mailto:sanchezansede@sanchezansede.com" class="text-primary">sanchezansede@sanchezansede.com</a></p>
                    <p class="mb-0">981 140 166</p>
                    <p class="text-primary">658 950 377</p>
                </div>
            </div>
            <div class="row  pt-5  justify-content-center" style="margin-bottom:300px; margin-top:300px">
                <div class="col-9">
                    <p class="text-secondary font-smaller text-center">Coberturas y servicios sujetos a los términos y condiciones aplicables al seguro que elijas. Este presupuesto se ha realizado a partir de la información que nos has facilitado, incluida tu historia siniestral, y no tiene valor contractual. </p>
                </div>
            </div>
        </div>
        <div style="page-break-after:always;"></div>




        <!--PÁG 2 -->
        <div class="container pt-3">
            <div class="row header pb-3 border-bottom  border-primary border-width-custom-2"> <!--ENCABEZADO-->
                <div class="col-9">

                    <p class="font-smaller mb-0"><span class="font-weight-bold">Fecha</span>: $fecha_hoy</p>
                    <p class="font-smaller mb-0"><span class="font-weight-bold">Validez del proyecto</span>: XX días</p>
                </div>
                <div class="col-3 text-right">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/logo-3mares-1.svg" alt="Nombre Empresa Seguros" class="img-fluid" style="width: 150px;">

                </div>
            </div>

            <div class="row my-5">
                <div class="col ml-2">
                    <h2 class="font-weight-bold h5 border border-primary rounded border-width-custom-1 py-2 px-3 mb-4 bg-primary-transparent-2">Datos mediador:</h2>
                    <div class="row m-1">
                        <div class="col-3">
                            <p class="font-weight-bold">Entidad aseguradora: </p>
                        </div>
                        <div class="col-9">
                            <p>Plus Ultra, Seguros Generales y Vida, S.A. de Seguros y Reaseguros, Sociedad Unipersonal</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Sede social:  </p>
                        </div>
                        <div class="col-9">
                            <p>Plaza de las Cortes, 8. 28014 (Madrid)</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Tipo de mediador: </p>
                        </div>
                        <div class="col-9">
                            <p>Corredor</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Nombre:  </p>
                        </div>
                        <div class="col-9">
                            <p>SANCHEZ ANSEDE,SL</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Dirección: </p>
                        </div>
                        <div class="col-9">
                            <p>RDA. Nelle, 85</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Teléfono: </p>
                        </div>
                        <div class="col-9">
                            <p>981272187</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Localidad:</p>
                        </div>
                        <div class="col-9">
                            <p>A CORUÑA</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col ml-2">
                    <h2 class="font-weight-bold h5 border border-primary rounded border-width-custom-1 py-2 px-3 mb-4 bg-primary-transparent-2">Datos del asegurado:</h2>
                    <div class="row m-1">
                        <div class="col-3">
                            <p class="font-weight-bold">Tomador: </p>
                        </div>
                        <div class="col-9">
                            <p>$nombre_asegurado $apellidos_asegurado</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">CIF/NIF:  </p>
                        </div>
                        <div class="col-9">
                            <p>$identificador_asegurado</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Dirección tomador: </p>
                        </div>
                        <div class="col-9">
                            <p>$direccion_asegurado - $poblacion_asegurado - $codigo_postal_asegurado - $nombre_provincia_asegurado</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Actividad profesional:  </p>
                        </div>
                        <div class="col-9">
                            <p>$profesion</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Teléfono: </p>
                        </div>
                        <div class="col-9">
                            <p>$telefono_asegurado</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-4">
                <div class="col ml-2">
                    <h2 class="font-weight-bold h5 border border-primary rounded border-width-custom-1 py-2 px-3 mb-4 bg-primary-transparent-2">Propuesta:</h2>
                    <div class="row m-1">
                        <div class="col-3">
                            <p class="font-weight-bold">Forma de pago: </p>
                        </div>
                        <div class="col-9">
                            <p>Domiciliación bancaria, pago anual.</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Prima neta social de la póliza:  </p>
                        </div>
                        <div class="col-9">
                            <p>$precio_poliza (iva inc.)</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">IBAN Domiciliación: </p>
                        </div>
                        <div class="col-9">
                            <p>$iban_asegurado</p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold">Póliza seleccionada: </p>
                        </div>
                        <div class="col-9">
                            <p class="font-weight-bold text-danger">$nombre_poliza</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end my-5">
                <div class=" border border-primary bg-primary-transparent-1 mt-2 mb-5" style="border-radius: 20px 0 0 0;padding-right: 250px;">
                    <p class="font-weight-bold my-4 mx-5 h5"><span class="text-primary">Dedicamos tiempo a tu</span> <span class="text-danger">tranquilidad</span>
                    
                </div>
                
            </div>

            <div class="row footer pt-3 border-top border-primary border-width-custom-2"> <!--PIE DE PÁGINA-->
                <div class="col-10">

                </div>
                <div class="col-2">
                    <p class="font-smaller mb-0 text-center">Página X de Y</p>
                </div>
            </div>
        </div>
         <div style="page-break-after:always;"></div>




        <!--PÁG 3 -->
        <div class="container pt-3">
            <div class="row header pb-3 border-bottom  border-primary border-width-custom-2"> <!--ENCABEZADO-->
                <div class="col-9">

                    <p class="font-smaller mb-0"><span class="font-weight-bold">Fecha</span>: $fecha_hoy</p>
                    <p class="font-smaller mb-0"><span class="font-weight-bold">Validez del proyecto</span>: XX días</p>
                </div>
                <div class="col-3 text-right">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/logo-3mares-1.svg" alt="Nombre Empresa Seguros" class="img-fluid" style="width: 150px;">

                </div>
            </div>

            <div class="row justify-content-between mt-3">
                <div class="col-6 mt-5">
                    <h2 class="font-weight-bold h3">Coberturas y capitales</h2>
                    <p class="text-primary h5">Apoyo, capital y soporte en los momentos difíciles</p>
                    <p class="text-secondary">Con cobertura sobre invalidez y muerte por accidente fortuito en cualquier circunstancia.</p>
                </div>
                <div class="col-3">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/streamline-icon-health-insurance-5@400x400.svg" class="img-fluid">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Fallecimiento por accidente</p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">$limite</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Fallecimiento simultáneo de ambos cónyuges por accidente de circulación</p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">+ 50.000 €</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Fallecimiento por infarto de miocardio por accidente laboral  </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">100.000 €</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Invalidez permanente absoluta por accidente</p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 font-small mb-2">350.000€</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Invalidez permanente parcial por accidente (según baremo) </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">350.000€</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Invalidez permanente absoluta pora accidente de circulación </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">400.000€</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Indemnización por hijos dependientes </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">2.000€</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Indemnización diaria por hospitalización </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">50€</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Gastos de reforma de la vivienda en caso de invalidez permanente por accidente </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">5.000€</p>
                </div>
            </div>
            <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Invalidez parcial  </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">Incluida</p>
                </div>
            </div>
             <div class="row">
                <div class="col-9 pr-1">
                    <p class="bg-light px-4 py-3 mb-2 font-small"><i class="bi bi-check-circle text-primary mr-2"></i> Accidentes en motos de cualquier cilindrada   </p>
                </div>
                <div class="col-3 pl-1">
                    <p class="bg-light text-center px-4 py-3 mb-2 font-small">Incluida</p>
                </div>
            </div>

            <div class="row justify-content-end my-5">
                <div class=" border border-primary bg-primary-transparent-1 mt-3 mb-5" style="border-radius: 20px 0 0 0;padding-right: 150px;">
                    <p class="font-weight-bold my-4 mx-5"><span class="text-danger">Pídenos cualquier modificación o variación</span> <span class="text-primary">de las propuestas. <br/>Podemos analizar para ti otros proyectos del mercado</span> 
                </div>

            </div>
            

            <div class="row footer pt-3 border-top border-primary border-width-custom-2 mt-5"> <!--PIE DE PÁGINA-->
                <div class="col-10">

                </div>
                <div class="col-2">
                    <p class="font-smaller mb-0 text-center">Página x de Y</p>
                </div>
            </div>
        </div>
        <div style="page-break-after:always;"></div>



        <!--PÁG 4 -->
        <div class="container  pt-3">
            <div class="row header pb-3 border-bottom  border-primary border-width-custom-2"> <!--ENCABEZADO-->
                <div class="col-9">

                    <p class="font-smaller mb-0"><span class="font-weight-bold">Fecha</span>: $fecha_hoy</p>
                    <p class="font-smaller mb-0"><span class="font-weight-bold">Validez del proyecto</span>: XX días</p>
                </div>
                <div class="col-3 text-right">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/logo-3mares-1.svg" alt="Nombre Empresa Seguros" class="img-fluid" style="width: 150px;">

                </div>
            </div>

            <div class="row justify-content-center mt-5 mb-1">
                <div class="col-8 text-center">
                    <h2 class="font-weight-bold h3 text-primary border border-primary rounded-lg border-width-custom-1 pt-2 pb-3 px-4 bg-primary-transparent-2">¿Por qué elegir Sánchez Ansede?</h2>
                    <p class="text-secondary font-small">Gestionamos tus seguros para que tu puedas dedicarte a lo que realmente te importa.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-4 text-center mb-5">
                    <img  style="width: 150px;" src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/streamline-icon-change-setting-4@400x400-1.svg">
                    <h3 class="h5 font-weight-bold mb-3">Seguros para aquello que necesites</h3>
                    <p class="text-secondary font-small">Desde un seguro de vida a uno para tu nueva nave espacial.</p>
                </div>
                <div class="col-4 text-center">
                    <img  style="width: 150px;" src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/streamline-icon-done-1@400x400.svg">
                    <h3 class="h5 font-weight-bold mb-3">Las mejores opciones entre las que elegir</h3>
                    <p class="text-secondary font-small">Colaboramos con las compañías más importantes del mercado.</p>
                </div>
                <div class="col-4 text-center">
                    <img  style="width: 150px;" src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/streamline-icon-trips-1@400x400.svg">
                    <h3 class="h5 font-weight-bold mb-3">Gestionamos tus siniestros</h3>
                    <p class="text-secondary font-small">Peleamos para que tus intereses estén bien protegidos.</p>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-light py-4">
            <div class="container my-3">
                <div class="row justify-content-center mt-1 mb-1">
                    <div class="col-8 text-center">
                        <h2 class="font-weight-bold h3 text-primary border border-primary rounded-lg border-width-custom-1 pt-2 pb-3 px-4 bg-primary-transparent-2">Compromisos Sánchez Ansede</h2>
                        <p class="text-secondary font-small">Nuestra manera de hacer las cosas nos distingue de la competencia.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-center">
                        <p class="h2 font-weight-bold text-danger">1</p>
                        <h3 class="h5 font-weight-bold mb-3">Las mejores compañías de seguros</h3>
                        <p class="text-secondary font-small">Te facilitamos la decisión de elegir una compañía de seguros. Trabajamos solo con aseguradoras top.</p>
                    </div>
                    <div class="col-4 text-center">
                        <p class="h2 font-weight-bold text-danger">2</p>
                        <h3 class="h5 font-weight-bold mb-3">Cambia de correduría sin cambiar de compañía</h3>
                        <p class="text-secondary font-small">Te ayudamos con tus seguros independientemente de con quien tengas tus pólizas.</p>
                    </div>
                    <div class="col-4 text-center">
                        <p class="h2 font-weight-bold text-danger">3</p>
                        <h3 class="h5 font-weight-bold mb-3">Ahorro más allá de lo económico</h3>
                        <p class="text-secondary font-small">Queremos lo mejor para tí. Por eso luchamos porque tus intereses prevalezcan.</p>
                    </div>
                </div>
                <div class="row justify-content-between mt-3">
                    <div class="col-4 text-center">
                        <p class="h2 font-weight-bold text-danger">4</p>
                        <h3 class="h5 font-weight-bold mb-3">Compartimos intereses</h3>
                        <p class="text-secondary font-small">Desde un seguro de vida a uno para tu nueva nave espacial.</p>
                    </div>
                    <div class="col-4 text-center">
                        <p class="h2 font-weight-bold text-danger">5</p>
                        <h3 class="h5 font-weight-bold mb-3">Te ahorramos investigar</h3>
                        <p class="text-secondary font-small">No dejamos de analizar e indagar sobre garantías y coberturas para ofrecerte lo mejor de lo mejor en tu póliza.</p>
                    </div>
                    <div class="col-4 text-center">
                        <p class="h2 font-weight-bold text-danger">6</p>
                        <h3 class="h5 font-weight-bold mb-3">Te ayudamos a vivir mejor</h3>
                        <p class="text-secondary font-small">Luchamos para que disfrutes una vida tranquila, protegido frente a viento y marea.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div class="row justify-content-center mt-5">
                <div class="col-8 text-center">
                    <h2 class="font-weight-bold h3 text-primary border border-primary rounded-lg border-width-custom-1 pt-2 pb-3 px-4 bg-primary-transparent-2">Las mejores compañías</h2>
                    <p class="text-secondary font-small">Trabajamos con las mejores aseguradoras para ofrecerte los productos con los mayores estándares de calidad del mercado.</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/allianz-2-1-1.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/logogenerali.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/dkv-color-af.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/logoaxa.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/pelayo-Convertido.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/mapfre-logo-1.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/liberty-seguros-Convertido.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/catalana-occidente-Convertido.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/caser-seguros-Convertido-1.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/zurich-logo-asd.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/adeslas-colorsdg.svg" class="img-fluid">
                </div>
                <div class="col-1">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/sanitas-en-color.svg" class="img-fluid">
                </div>
            </div>


            <div class="row footer pt-3 border-top border-primary border-width-custom-2 mt-5"> <!--PIE DE PÁGINA-->
                <div class="col-10">
            
                </div>
                <div class="col-2">
                    <p class="font-smaller mb-0 text-center">Página x de Y</p>
                </div>
            </div>
        </div>
        <div style="page-break-after:always;"></div>



        <!--PÁG 5 -->
        <div class="container  pt-3">
            <div class="row header pb-3 border-bottom  border-primary border-width-custom-2"> <!--ENCABEZADO-->
                <div class="col-9">

                    <p class="font-smaller mb-0"><span class="font-weight-bold">Fecha</span>: $fecha_hoy</p>
                    <p class="font-smaller mb-0"><span class="font-weight-bold">Validez del proyecto</span>: XX días</p>
                </div>
                <div class="col-3 text-right">
                    <img src="https://universopelo.com/wp-content/plugins/seguro-accidentes-aig/img/logo-3mares-1.svg" alt="Nombre Empresa Seguros" class="img-fluid" style="width: 150px;">

                </div>
            </div>

            <div class="row mt-4 mb-2">
                <div class="col mx-3">
                    <p class="text-secondary">Mediante este documento normalizado (sin valor contractual), te ofrecemos la descripción básica de los principales riesgos que conforman el producto presentado, así como diferentes aspectos destacados.</p>
                    <p class="text-secondary">Las condiciones precontractuales, y/o contractuales completas, figuran en los proyectos de seguro presentados, o en las Condiciones Particulares y Generales que se entreguen al formalizar el contrato.</p>
                    <h2 class="font-weight-bold h3">¿En qué consiste este tipo de seguro?</h2>
                    <p class="text-secondary">Nuestro producto de accidentes individuales cubre incapacidades absolutas, parciales y fallecimiento en caso de accidente. Es un producto que cubre 24 horas, los 365 días del año (incluyendo hasta 90 días de viaje en el extranjero).</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6 p-1">
                    <div class="row m-1">
                        <div class="col border border-primary rounded border-width-custom-1 text-primary p-3">
                            <h3 class="font-weight-bold h5 mb-3">¿Qué se asegura?</h3>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="col-11">
                                    <h4 class="font-weight-bold h6">Cobertura 24 horas</h4>
                                    <p class="font-small">Cubre las 24 horas del día todos los días del año. También si se viaja al extranjero.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="col-11">
                                    <h4 class="font-weight-bold h6">Deportes</h4>
                                    <p class="font-small">Quedan incluidos la práctica de cualquier deporte como amateur. Sin incluir la práctica como profesional ni competición federativa</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="col-11">
                                    <h4 class="font-weight-bold h6">Cobertura motos</h4>
                                    <p class="font-small">Quedan incluidos los accidentes de motocicleta de cualquier cilindrada.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="col-11">
                                    <h4 class="font-weight-bold h6">Fallecimiento / Invalidez Permanente Absoluta por Accidente </h4>
                                    <p class="font-small">Si como consecuencia de un accidente cubierto por la póliza, se produjera el Fallecimiento inmediatamente o en el plazo de un año a contar desde la fecha del accidente</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="col-11">
                                    <h4 class="font-weight-bold h6">Fracturas </h4>
                                    <p class="font-small">Se indemnizará al asegurado con la suma estipulada para la lesión producida en la tabla de indemnizaciones de la póliza.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="col-11">
                                    <h4 class="font-weight-bold h6">Gastos de reforma de la vivienda o vehículo en caso de Invalidez Permanente Absoluta por Accidente</h4>
                                    <p class="font-small">Se pagará el 80% del coste de reformas realizadas en la vivienda habitual o en el vehículo,  tanto para realizar sus actividades diarias, como para permanecer dentro de su hogar y moverse por él.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-6 p-1">
                    <div class="row m-1">
                        <div class="col-12 border border-danger rounded border-width-custom-1 text-danger p-3 mb-2">
                            <h3 class="font-weight-bold h5 mb-3">¿Qué NO se asegura?</h3>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                                <div class="col-11">
                                    <p class="font-small">La participación del Asegurado en acciones delictivas, provocaciones, riñas y duelos, carreras, apuestas o cualquier actuación/empresa arriesgada o temeraria.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                                <div class="col-11">
                                    <p class="font-small">La práctica como profesional o federado de cualquier deporte, así como en todo caso aquellas actividades enumeradas en el Contrato de seguro.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                                <div class="col-11">
                                    <p class="font-small">Acontecimientos de guerra, aun cuando no haya sido declarada, rebeliones, revoluciones, tumultos populares, terremotos, inundaciones, huracanes y erupciones volcánicas.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                                <div class="col-11">
                                    <p class="font-small">Imprudencias o negligencias graves.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                                <div class="col-11">
                                    <p class="font-small">Los accidentes sufridos por el Asegurado en estado de embriaguez, o bajo la acción de drogas narcóticas, euforizantes, psicotrópicas de carácter prohibido.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 border rounded border-width-custom-1 p-3">
                            <h3 class="font-weight-bold h5 mb-3">¿Existen restricciones en lo que respecta a la cobertura?</h3>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="col-11">
                                    <p class="font-small">El Tomador de la póliza deberá tener entre 18 y 70 años.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="col-11">
                                    <p class="font-small">Los límites económicos y temporales que figuren en las Condiciones Generales y/o Particulares. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col border rounded-lg border-semitransparent bg-light px-5 py-4">
                    <h3 class="font-weight-bold h5 mb-3">¿Dónde estoy cubierto?</h3>
                    <p class="text-primary font-small mb-0"> En todo el mundo. </p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col border rounded-lg border-semitransparent bg-light px-5 py-4">
                    <h3 class="font-weight-bold h5 mb-3">¿Cuándo y cómo tengo que efectuar los pagos?</h3>
                    <p class="text-primary font-small mb-0">El pago de la prima es anual, si bien existe la posibilidad de seleccionar pago fraccionado mensual en caso de que la cantidad total ascienda a más de 100€ al año. El recibo del seguro se le cobrará en la misma tarjeta de crédito/débito que nos facilite durante la contración, pudiendo modificar dichos datos siempre que lo desee.</p>
                </div>
            </div>
            

            <div class="row footer pt-3 border-top border-primary border-width-custom-2"> <!--PIE DE PÁGINA-->
                <div class="col-10">
                    
                </div>
                <div class="col-2">
                    <p class="font-smaller mb-0 text-center">Página x de Y</p>
                </div>
            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>
    
    EOF;
}