            <div id="col1">
                <?php include(dirname(__FILE__).'/../box/menu.php'); ?>
                <?php include(dirname(__FILE__).'/../box/squadre.php'); ?>
            </div>
            <div id="colBig">
                <h1>Tutte le partite</h1>
<?php
    $icone = array(
        'Campionato' => 'ico-cam.png',
        'Campionato Serie A' => 'ico-seriea.png',
        'Campionato Serie B' => 'ico-serieb.png',
        'Amichevole' => 'ico-ami.png',
        'EWC' => 'ico-ewc.png',
        'Torneo' => 'ico-tor.png',

        'casa' => 'ico-home.png',
        'trasferta' => 'ico-away.png',
        'neutro' => 'ico-neutral.png',
    );

    $stagioni = read_data('http://www.saronnocomets.it/_export/partite.php');
    foreach($stagioni AS $s => $partite) {
        ?>
                    <h3>Stagione <?php echo ($s-1).' - '.$s; ?></h3>
                    <table class="partite">
        <?php
            foreach($partite AS $p) {
                if ($p['neutro']) {
                    $campo = 'neutro';
                } else {
                    $campo = (substr($p['s1'], 0, 7) == 'Saronno') ? 'casa' : 'trasferta';
                }
                $luogo = $p['citta'];
                $luogo .= ($p['indirizzo'] != '') ? ', '.$p['indirizzo'] : '';
                $data = str_replace(' 0.00', '', substr($p['data'],0,strrpos($p['data'], '.')));
                $evento = $p['evento'];
                if ($p['dettaglio'] == 'Serie A') $evento .= ' Serie A';
                if ($p['dettaglio'] == 'Serie B') $evento .= ' Serie B';
                ?>
                    <tr>
                        <td>
                            <img src="_static/img/<?php echo $icone[$evento]; ?>" alt="<?php echo $evento; ?>" title="<?php echo $evento; ?>" />
                            <img src="_static/img/<?php echo $icone[$campo]; ?>" alt="<?php echo $luogo; ?>" title="<?php echo $luogo; ?>" />
                        </td>
                        <td><?php echo $data; ?></td>
                        <td><?php echo $luogo; ?></td>
                        <td<?php if ($p['p1'] > $p['p2']) echo ' class="winner"'; ?>><?php echo $p['s1']; ?></td>
                        <td><?php echo $p['p1']; ?></td>
                        <td><?php echo $p['p2']; ?></td>
                        <td<?php if ($p['p2'] > $p['p1']) echo ' class="winner"'; ?>><?php echo $p['s2']; ?></td>
                    </tr>
                <?php
            }
        ?>
                    </table>
        <?php
    }
?>
            </div>