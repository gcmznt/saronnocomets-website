            <div id="col1">
                <?php include(dirname(__FILE__).'/../box/menu.php'); ?>
                <?php include(dirname(__FILE__).'/../box/squadre.php'); ?>
            </div>
            <div id="colMain">
                <h2>Squadre</h2>
<?php
    require_once(dirname(__FILE__).'/../utilities.php');

    $stagioni = read_data('http://www.saronnocomets.it/_export/squadre.php');
    foreach($stagioni AS $s => $squadre) {
        ?>
                <div title="<?php echo ($s-1).' - '.$s; ?>" class="squadre">
                    <h3>Stagione <?php echo ($s-1).' - '.$s; ?></h3>
                    <?php
                        foreach($squadre AS $t => $giocatori) {
                            $foto = '_static/img/squadre/'.$t.$s;
                            $foto = (is_file(dirname(__FILE__).'/../../'.$foto.'.jpg')) ? '<a href="'.$foto.'.jpg" class="prettyPhoto" title="'.$t.' '.$s.'" rel="prettyPhoto['.$t.']"><img src="'.$foto.'_sm.jpg" class="team_photo" /></a>' : '';
                            ?>
                            <div class="squadra">
                                <h4><?php echo $t; ?></h4>
                                <?php echo $foto; ?>
                                <div class="left">
                                <?php
                                    $first = true;
                                    foreach($giocatori AS $t => $g) {
                                        ?>
                                                <!-- <td><?php echo $g['numero']; ?></td> -->
                                                <?php echo ($first) ? '&copy; ' : ''; echo $g['nome']; ?><br />
                                                <!-- <td><?php echo $g['nascita']; ?></td> -->
                                        <?php
                                        $first = false;
                                    }
                                ?>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
        <?php
    }
?>
            </div>
            <div id="col2">
                <?php include(dirname(__FILE__).'/../box/partite.php'); ?>
                <?php include(dirname(__FILE__).'/../box/facebook.php'); ?>
            </div>
