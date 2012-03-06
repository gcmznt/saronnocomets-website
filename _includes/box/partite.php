                <div id="partite">
                    <h4>Partite</h4>
<?php
    $icone = array(
        'Campionato' => 'champ',
        'Campionato Serie A' => 'champa',
        'Campionato Serie B' => 'champb',
        'Amichevole' => 'friendly',
        'EWC' => 'ewc',
        'Torneo' => 'torneo',
    );

    $partite = read_data('http://www.saronnocomets.it/_export/partite_home.php');
    if ($partite) {
        foreach($partite AS $p) {
            $evento = $p['evento'];
            if ($p['dettaglio'] == 'Serie A') $evento .= ' Serie A';
            if ($p['dettaglio'] == 'Serie B') $evento .= ' Serie B';
            $data = str_replace(' 0.00', '', substr($p['data'],0,strrpos($p['data'], '.')));
            ?>
                        <div class="partita <?php echo $icone[$p['evento']]; ?>">
                            <h5>
                                <?php echo $data; ?><br />
                                <?php echo $p['citta']; ?><?php echo ($p['indirizzo'] != '') ? ', '.$p['indirizzo'] : ''; ?><br />
                                <?php echo $p['info']; ?>
                            </h5>
                            <div><?php echo $p['s1']; ?> <span><?php echo $p['p1']; ?></span></div>
                            <div><?php echo $p['s2']; ?> <span><?php echo $p['p2']; ?></span></div>
                        </div>
            <?php
        }
    } else { echo "<p><i>Non ci sono partite in programma</i></p>"; }
?>
                    <a href="/partite" class="button white">Tutte le partite</a>
                </div>
