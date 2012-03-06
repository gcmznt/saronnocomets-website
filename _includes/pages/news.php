            <div id="col1">
                <?php include(dirname(__FILE__).'/../box/menu.php'); ?>
                <?php include(dirname(__FILE__).'/../box/squadre.php'); ?>
            </div>
            <div id="colMain">
                <h1>News</h1>
                <?php
                    $w = '';
                    $single = false;
                    if (isset($_GET['param']) && $_GET['param'] != '') {
                        $w = " WHERE id = " . mysql_real_escape_string($_GET['param']);
                        $single = true;
                    }
                    $news = mysql_query("SELECT * FROM news" . $w . " ORDER BY data DESC LIMIT 0,10;");
                    while ($n = mysql_fetch_assoc($news)) {
                ?>
                <div class="news">
                    <div class="newsContent">
                        <h3><a href="/news-<?php echo $n['id']; ?>"><?php echo stripslashes($n['titolo']); ?></a></h3>
                        <h5><?php echo substr($n['data'],8,2).' '.substr($n['data'],5,2); ?> <?php echo substr($n['data'],0,4); ?></h5>
                        <?php
                            if ($single) {
                                echo stripslashes($n['testo']);
                        ?>
                        <div class="newsBottom">
                            <div class="twitter">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.saronnocomets.it/news-<?php echo $n['id']; ?>" data-text="<?php echo stripslashes($n['titolo']); ?>" data-lang="it">Tweet</a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </div>
                            <div class="facebook">
                                <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.saronnocomets.it%2Fnews-<?php echo $n['id']; ?>&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=110921952278697" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
                            </div>
                        </div>
                        <div>
                            <a href="/news">Torna alle news</a>
                        </div>
                        <?php
                            } else {
                                $t = strip_tags(str_replace('<br />', ' ', stripslashes($n['testo'])));
                                preg_match('/^([^.!?\s]*[\.!?\s]+){0,60}/', $t, $abstract);
                                echo $abstract[0];
                                if (strlen($abstract[0]) != strlen($t)) echo '... ';
                                echo '<a href="/news-'.$n['id'].'">continua a leggere</a>';
                            }
                        ?>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
            <div id="col2">
                <?php include(dirname(__FILE__).'/../box/partite.php'); ?>
                <?php include(dirname(__FILE__).'/../box/facebook.php'); ?>
            </div>
