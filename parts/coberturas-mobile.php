<?php require_once SACAIG_PLUGIN_PATH . 'parts/datos-polizas-coberturas.php'; ?>

<div class="text-start franja franja-forms-viajes pt-1 pb-3">
    <div class="d-flex justify-content-end align-items-start flex-wrap">

        <ul class="nav nav-tabs" id="polizasTab">
            <?php foreach ($nombre as $index => $nombre_poliza): ?>
            <li class="nav-item <?= $class_width; ?>">
                <a class="nav-link polizaTab<?= $index === 0 ? ' active' : ''; ?>" data-policy="<?= $index + 1; ?>" id="tabItem<?= $index + 1; ?>-tab" data-bs-toggle="tab" href="#tabItem<?= $index + 1; ?>" role="tab">
                    <?= $nombre_poliza; ?></br>
                    <span class="prMvop" id="prc-tab-<?= strtolower($nombre_poliza); ?>">
                        <?= $precios[$index]; ?> <span class="mini-moneda" id="small_precio_<?= $index + 1; ?>"><?= $anotaciones_precio[$index]; ?></span>
                    </span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content">
            <?php foreach ($nombre as $index => $nombre_poliza): ?>
            <div class="tab-pane fade<?= $index === 0 ? ' show active' : ''; ?>" id="tabItem<?= $index + 1; ?>" role="tabpanel">
                <div class="card-viaje-option">
                    <div class="d-flex justify-content-start align-items-start justify-content-center name-price-inter">
                        <div class="text-center">
                            <div class="icono-viaje">
                                <img src="<?= $imagenes_polizas[$index]; ?>" alt="">
                            </div>
                            <div class="name-prod-viaje"><?= $nombre_poliza; ?></div>
                            <div class="price-inter" id="precio_<?= $index + 1; ?>"><?= $precios[$index]; ?> <span class="mini-moneda"><?= $anotaciones_precio[$index]; ?></span></div>
                            <a href="#" id="btn_precio_<?= $index + 1; ?>" class="btn btn-primary acc-selector">Contratar ahora</a>
                            <a data-disparo_id="btn_precio_<?= $index + 1; ?>" class="btn_presupuesto_sol btn_seleccion_opt_ciber_secundario">Presupuesto PDF</a>
                            <small class="poliza-small-advice color-azul"><?= $anotacion_poliza[$index]; ?></small>
                        </div>  
                    </div>                              
                </div>

                <h3 class="accordion-header" id="heading<?= $index + 1; ?>">
                    <button class="accordion-button no-icon" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index + 1; ?>" aria-expanded="true" aria-controls="collapse<?= $index + 1; ?>">Comparativa de coberturas</button>
                </h3>

                <div class="accordion-collapse collapse show" aria-labelledby="heading<?= $index + 1; ?>" data-bs-parent="#miAcordeon">
                    <div class="accordion-body">
                        <?php 
                            foreach ($coberturas as $cobertura) {
                                if ($cobertura['titulo']) {
                                    echo '<table class="table_cob_viajes">';
                                    echo '<tbody>';
                                    echo '<tr>';
                                    echo '<td class="text-left tam3_tab">' . $cobertura['titulo'] . '</td>';
                                    if($cobertura['titulo'] != 'Extorsión Cibernética'){
                                        echo '<td class="text-center valor_cobertura_viajes">' . $cobertura['valores'][$index] . '</td>';
                                    }else{
                                        echo '<td class="text-center"> - </td>';
                                    }
                                    echo '</tr>';
                                    echo '</tbody>';
                                    echo '</table>';
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-start flex-wrap" id="form_datos_select_productos">
                    <div class="card-viaje-option  border-0 shadow-none">
                        <div class="d-flex justify-content-start align-items-start justify-content-center name-price-inter bg-white">
                            <div class="text-center">
                                <a  data-disparo_id="btn_precio_<?= $index + 1; ?>" class="btn btn-primary btn_seleccion_opt_ciber_secundario">Contratar ahora</a>
                                <a data-disparo_id="btn_precio_<?= $index + 1; ?>" class="btn_presupuesto_sol btn_seleccion_opt_ciber_secundario">Presupuesto PDF</a>

                            </div>  
                        </div>                              
                    </div>

                </div>
                
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>