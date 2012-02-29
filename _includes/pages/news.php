                <h2>News</h2>
                <?php
                    $w = '';
                    if (isset($_GET['p']) && $_GET['p'] != '') {
                        $w = " WHERE id = " . mysql_real_escape_string($_GET['p']);
                    }
                    $news = mysql_query("SELECT * FROM news" . $w . " ORDER BY data DESC LIMIT 0,3;");
                    while ($n = mysql_fetch_assoc($news)) {
                ?>
                <div class="news">
                    <div class="date">
                        <?php echo substr($n['data'],8,2).'.'.substr($n['data'],5,2); ?><br /><?php echo substr($n['data'],0,4); ?>
                    </div>
                    <div class="newsContent">
                        <h3><a href="?p=<?php echo $n['id']; ?>"><?php echo stripslashes($n['titolo']); ?></a></h3>
                        <?php echo stripslashes($n['testo']); ?>
                    </div>
                </div>
                <?php
                    }
                ?>