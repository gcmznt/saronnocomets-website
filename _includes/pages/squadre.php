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
                            $foto = (is_file(dirname(__FILE__).'/../../'.$foto.'.jpg')) ? '<a href="'.$foto.'.jpg" class="prettyPhoto" title="'.$t.' '.$s.'" rel="prettyPhoto['.$t.']"><img src="'.$foto.'_sm.jpg" /></a>' : '';
                            ?>
                                <h4><?php echo $t; ?></h4>
                                <?php echo $foto; ?>
                                <table>
                                <?php
                                    foreach($giocatori AS $t => $g) {
                                        ?>
                                            <tr>
                                                <td><?php echo $g['numero']; ?></td>
                                                <td><?php echo $g['nome']; ?></td>
                                                <td><?php echo $g['nascita']; ?></td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                                </table>
                            <?php
                        }
                    ?>
                </div>
        <?php
    }
?>
