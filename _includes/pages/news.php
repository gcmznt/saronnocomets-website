                <h2>News</h2>
<?php
    require_once(dirname(__FILE__).'/../utilities.php');
    $news = read_data('http://www.saronnocomets.it/_export/news.php');
    for($i=0; $i<10; $i++) {
        ?>
                <div title="<?php echo $news[$i]['title']; ?>" class="news">
                    <h3><?php echo $news[$i]['title']; ?></h3>
                    <div class="data"><?php echo $news[$i]['date']; ?></div>
                    <p><?php echo $news[$i]['content']; ?></p>
                    <p class="firma"><?php echo $news[$i]['username']; ?></p>
                </div>
        <?php
    }
?>
