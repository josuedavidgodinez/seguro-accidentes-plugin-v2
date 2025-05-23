<?php

// Generar dinámicamente las filas del encabezado
$html_eleccion_polizas = "";
for ($i = 1; $i <= 3; $i++) {
    if ($i == $tipo_poliza) {
        $html_eleccion_polizas .= "<td class='text-white text-center font-small plan-selected first'>Tu elección</td>";
    } else {
        $html_eleccion_polizas .= "<td></td>";
    }
}

// Definir los planes
$plans = [
    1 => ['name' => 'Classic', 'price' => '92 €/año'],
    2 => ['name' => 'Plus', 'price' => '173 €/año'],
    3 => ['name' => 'Premier', 'price' => '265 €/año'],
];

// Filas y valores de la tabla
$rows = [
    'Garantías por fallecimiento' => [
        [
            'text'   => 'Fallecimiento por accidente',
            'values' => [
                1 => '150.000 €',
                2 => '250.000 €',
                3 => '350.000 €',
            ],
        ],
        [
            'text'   => 'Fallecimiento de ambos cónyuges por accidente de circulación',
            'values' => [
                1 => '+50.000 €',
                2 => '+50.000 €',
                3 => '+50.000 €',
            ],
        ],
        [
            'text'   => 'Fallecimiento por infarto de miocardio por accidente laboral',
            'values' => [
                1 => '100.000 €',
                2 => '100.000 €',
                3 => '100.000 €',
            ],
        ],
    ],
    'Garantías por invalidez' => [
        [
            'text'   => 'Invalidez permanente absoluta por accidente',
            'values' => [
                1 => '150.000 €',
                2 => '250.000 €',
                3 => '350.000 €',
            ],
        ],
        [
            'text'   => 'Invalidez permanente parcial por accidente (según baremo)',
            'values' => [
                1 => '150.000 €',
                2 => '250.000 €',
                3 => '350.000 €',
            ],
        ],
        [
            'text'   => 'Invalidez permanente absoluta por accidente de circulación',
            'values' => [
                1 => '200.000 €',
                2 => '300.000 €',
                3 => '400.000 €',
            ],
        ],
        [
            'text'   => 'Invalidez parcial',
            'values' => [
                1 => 'Incluida',
                2 => 'Incluida',
                3 => 'Incluida',
            ],
        ],
    ],
    'Otras garantías' => [
        [
            'text'   => 'Indemnización por hijos dependientes',
            'values' => [
                1 => '2.000 €',
                2 => '2.000 €',
                3 => '2.000 €',
            ],
        ],
        [
            'text'   => 'Indemnización diaria por hospitalización',
            'values' => [
                1 => '50 €',
                2 => '50 €',
                3 => '50 €',
            ],
        ],
        [
            'text'   => 'Gastos de reforma de la vivienda en caso de invalidez permanente por accidente',
            'values' => [
                1 => '5.000 €',
                2 => '5.000 €',
                3 => '5.000 €',
            ],
        ],
        [
            'text'   => 'Accidentes en motos de cualquier cilindrada',
            'values' => [
                1 => 'Incluida',
                2 => 'Incluida',
                3 => 'Incluida',
            ],
        ],
    ],
];
?>
<style>

    .icon-poliza{
            width: 45px;
            height: 45px;
		}
</style>

<table class="comparison-table w-100">
    <thead>
        <tr>
            <td></td>
            <?= $html_eleccion_polizas ?>
        </tr>
        <tr class="text-center">
            <th width="55%"></th>
            <?php foreach ($plans as $index => $plan): ?>
                <th width="15%" class="plan-title <?= $index == $tipo_poliza ? 'plan-selected' : '' ?>">
                    <img src="<?= SACAIG_PLUGIN_URL . 'templates/proyectos_pdf/img/accidentes-icon-cobertura-1.svg'?>" class=" icon-poliza mb-2">
                    <br>
                    <span class="text-primary font-weight-normal"><?= $plan['name'] ?></span>
                    <br>
                    <span class="h5 font-weight-bold"><?= $plan['price'] ?></span>
                </th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $section => $entries): ?>
            <tr>
                <td class="pt-3 pb-2" colspan="4">
                    <span class="text-primary text-uppercase h5"><?= $section ?></span>
                </td>
            </tr>
            <?php foreach ($entries as $entry): ?>
                <tr>
                    <td class="pb-2"><?= $entry['text'] ?></td>
                    <?php foreach ($entry['values'] as $index => $value): ?>
                        <td class="text-center font-weight-light pb-2 <?= ($index + 1) == $tipo_poliza ? 'plan-selected' : '' ?>">
                            <?= $value ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>