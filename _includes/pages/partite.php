                <h2>Partite</h2>

                    <table class="partite">
                    <tr>
                        <td rowspan="2">
                            <img src="_static/img/ico-cam.png" alt="" />
                            <img src="_static/img/ico-home.png" alt="" />
                        </td>
                        <td>Saronno Castor</td>
                        <td>50</td>
                        <td>40</td>
                        <td>Saronno Pollux</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="font-style: italic; color: #999; font-size: 90%;">
                            2012-01-12 15:30
                            Saronno, PalaDozio
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            <img src="_static/img/ico-cam.png" alt="" />
                            <img src="_static/img/ico-home.png" alt="" />
                        </td>
                        <td>Saronno Castor</td>
                        <td>50</td>
                        <td>40</td>
                        <td>Saronno Pollux</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="font-style: italic; color: #999; font-size: 90%;">
                            2012-01-12 15:30
                            Saronno, PalaDozio
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            <img src="_static/img/ico-cam.png" alt="" />
                            <img src="_static/img/ico-home.png" alt="" />
                        </td>
                        <td>Saronno Castor</td>
                        <td>50</td>
                        <td>40</td>
                        <td>Saronno Pollux</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="font-style: italic; color: #999; font-size: 90%;">
                            2012-01-12 15:30
                            Saronno, PalaDozio
                        </td>
                    </tr>
                    </table>


<?php
    $icone = array(
        'Campionato' => 'ico_cam.png',
        'Amichevole' => 'ico_ami.png',
        'EWC' => 'ico_ewc.png',
        'Torneo' => 'ico_tor.png',

        'casa' => 'ico_home.png',
        'trasferta' => 'ico_arrow.png',
        'neutro' => 'ico_neutral.png',
    );

    $stagioni = read_data('http://www.saronnocomets.it/_export/partite.php');
    foreach($stagioni AS $s => $partite) {
        ?>
                <div title="<?php echo ($s-1).' - '.$s; ?>">
                    <h3>Stagione <?php echo ($s-1).' - '.$s; ?></h3>
                    <table class="partite">
        <?php
            foreach($partite AS $p) {
                if ($p['neutro']) {
                    $campo = 'neutro';
                } else {
                    $campo = (substr($p['s1'], 0, 7) == 'Saronno') ? 'casa' : 'trasferta';
                }
                $class1 = (substr($p['s1'], 0, 7) == 'Saronno') ? ' class="saronno"' : '';
                $class2 = (substr($p['s2'], 0, 7) == 'Saronno') ? ' class="saronno"' : '';
                ?>
                    <tr>
                        <td class="data"><?php echo $p['data']; ?></td>
                        <td><img src="_static/img/<?php echo $icone[$p['evento']]; ?>" alt="<?php echo $p['evento']; ?>" /></td>
                        <td><img src="_static/img/<?php echo $icone[$campo]; ?>" alt="<?php echo $campo; ?>" /></td>
                        <td><?php echo $p['citta']; ?></td>
                        <td<?php echo $class1; ?>><?php echo $p['s1']; ?></td>
                        <td><?php echo $p['p1']; ?></td>
                        <td><?php echo $p['p2']; ?></td>
                        <td<?php echo $class2; ?>><?php echo $p['s2']; ?></td>
                    </tr>
                <?php
            }
        ?>
                    </table>
                </div>
        <?php
    }
?>
