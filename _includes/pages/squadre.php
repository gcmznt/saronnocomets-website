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
                            ?>
                                <h4><?php echo $t; ?></h4>
                                <table>
                                <?php
                                    foreach($giocatori AS $t => $g) {
                                        ?>
                                            <tr>
                                                <td><?php echo $g['numero']; ?></td>
                                                <td><?php echo ($g['capitano']) ? '(C)' : ''; ?></td>
                                                <td><?php echo $g['nome']; ?></td>
                                                <td><?php echo $g['nascita']; ?></td>
                                                <td><?php echo $g['data']; ?></td>
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
