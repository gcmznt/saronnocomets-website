<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    
        <title>ASD Saronno TchoukBall Club</title>
         
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
        
        <link rel="stylesheet" type="text/css" href="_static/css/reset-min.css" />
        <link rel="stylesheet" type="text/css" href="_static/css/style.css" />
        
        <script type="text/javascript" src="_static/js/jquery.tools.min.js"></script>
        <script type="text/javascript" src="_static/js/moment.min.js"></script>
        <script type="text/javascript" src="_static/js/javascript_home.js"></script>
    
    </head>
    
    <body>
        
        <div id="container">
            <div class="page">
                <div class="home">
                    <h1>Saronno TchoukBall Club</h1>
                    <a href="news" class="box news">
                        <h3>News</h3>
<?php
    require_once(dirname(__FILE__).'/_includes/utilities.php');
    $news = read_data('http://www.saronnocomets.it/_export/news.php');
?>
                        <h4><?php echo $news[0]['title']; ?></h4>
                        <p><?php echo $news[0]['content']; ?></p>
                    </a>
                    <a href="info" class="box info">
                        <h3>La Societ&agrave;</h3>
                        <img src="_static/img/logo.png" alt="Logo del Saronno TchoukBall Club" />
                    </a>
                    <a href="partite" class="box partite">
                        <h3>Partite</h3>
                        <table>
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
    require_once(dirname(__FILE__).'/_includes/utilities.php');
    $stagioni = read_data('http://www.saronnocomets.it/_export/partite.php');
    $i = 0;
    foreach($stagioni AS $s => $partite) {
        foreach($partite AS $p) {
            if ($p['home']) {
                if ($i >= 5) break;
                $i++;
        ?>
                            <tr>
                                <td class="evento" rowspan="2"><img src="_static/img/<?php echo $icone[$p['evento']]; ?>" alt="<?php echo $p['evento']; ?>" /></td>
                                <td class="data" colspan="4"><span><?php echo $p['data']; ?></span> @<?php echo $p['citta']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $p['s1']; ?></td>
                                <td><?php echo $p['p1']; ?></td>
                                <td><?php echo $p['p2']; ?></td>
                                <td><?php echo $p['s2']; ?></td>
                            </tr>
        <?php
    }}}
?>
                        </table>
                    </a>
                    <a href="squadre" class="box squadre">
                        <h3>Le Squadre</h3>
                    </a>
                    <a href="tchoukball" class="box tchoukball">
                        <h3>TchoukBall</h3>
                    </a>
                    <a href="torneo" class="box torneo">
                        <h3>Torneo di Saronno</h3>
                        <img src="_static/img/logo-tds.png" alt="Logo del Torneo Città di Saronno" />
                    </a>
                </div>
            </div>
        </div>
        
    </body>
    
</html>
    