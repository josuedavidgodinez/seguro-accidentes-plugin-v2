<?php require_once SACAIG_PLUGIN_PATH . 'parts/datos-polizas-coberturas.php'; ?>

<div class="text-start franja franja-forms-viajes pt-1 pb-3">
    <div class="d-flex justify-content-end align-items-start flex-wrap" id="form_datos_select_productos">

        <?php 
            foreach ($nombre as $index => $nombre_poliza) {
                $url_icono_poliza = $imagenes_polizas[$index];
                $precio_poliza = $precios[$index];
                $anotacion_precio = $anotaciones_precio[$index];
                $small_precio = $anotacion_poliza[$index];
                $btn_id = 'btn_precio_' . ($index + 1);
                $precio_id = 'precio_' . ($index + 1);
                ?>
                <div class="card-viaje-option">
                    <div class="d-flex justify-content-start align-items-start justify-content-center name-price-inter">
                        <div class="text-center">
                            <div class="icono-viaje">
                                <img src="<?= $url_icono_poliza; ?>" alt="">
                            </div>
                            <div class="name-prod-viaje"><?= $nombre_poliza; ?></div>
                            <div class="price-inter" id="<?= $precio_id; ?>"><?= $precio_poliza; ?> <span class="mini-moneda"><?= $anotacion_precio; ?></span></div>
                            <a href="#" id="<?= $btn_id; ?>" class="btn btn-primary acc-selector">Contratar ahora</a>
                            <a  data-disparo_id="<?=$btn_id;?>" class="btn_presupuesto_sol btn_seleccion_opt_ciber_secundario">Presupuesto PDF</a>
                            <small class="poliza-small-advice color-azul"><?= $small_precio; ?></small>
                        </div>  
                    </div>                              
                </div>
                <?php
            }
        ?>
    </div>

    <h3 class="accordion-header" id="heading1">
        <button class="accordion-button no-icon" type="button" data-bs-toggle="collapse" data-bs-target="#" aria-expanded="true" aria-controls="collapse1">Comparativa de coberturas</button>
    </h3>

    <div class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#miAcordeon">

        <div class="accordion-body">
            <?php 
                foreach ($coberturas as $cobertura) {
                    if ($cobertura['titulo']) {
                        echo '<table class="table_cob_viajes">';
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td class="text-left tam3_tab">' . $cobertura['titulo'] . '</td>';
                        foreach ($cobertura['valores'] as $i=>$valor) {
                            if($i==0){
                                if($cobertura['titulo']!='Extorsión Cibernética'){
                                    echo '<td class="text-center valor_cobertura_viajes">' . $valor . '</td>';
                                }else{
                                    echo '<td class="text-center"> - </td>';
                                }
                            }else {
                                echo '<td class="text-center valor_cobertura_viajes">' . $valor . '</td>';
                            }
                        }
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }
                }
             ?>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-start flex-wrap" >

        <?php 
            foreach ($nombre as $index => $nombre_poliza) {
                $btn_id = 'btn_precio_' . ($index + 1);
                
                ?>
                <div class="card-viaje-option border-0 shadow-none">
                    <div class="d-flex justify-content-start align-items-start justify-content-center name-price-inter bg-white">
                        <div class="text-center">
                            <a  data-disparo_id="<?=$btn_id;?>" class="btn btn-primary btn_seleccion_opt_ciber_secundario">Contratar ahora</a>
                            <a  data-disparo_id="<?=$btn_id;?>" class="btn_presupuesto_sol btn_seleccion_opt_ciber_secundario">Presupuesto PDF</a>

                        </div>  
                    </div>                              
                </div>
                <?php
            }
        ?>
    </div>

</div>