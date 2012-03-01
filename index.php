<?php
    require_once(dirname(__FILE__).'/_includes/utilities.php');

    $page = (isset($_GET['page'])) ? $_GET['page'] : 'news';
    $page = str_replace(array('/', '.', ' '), '', $page);
    $page_file = (is_file(dirname(__FILE__).'/_includes/pages/'.$page.'.php')) ? dirname(__FILE__).'/_includes/pages/'.$page.'.php' : dirname(__FILE__).'/_includes/pages/news.php';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ASD Saronno TchoukBall Club</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <meta property="og:image" content="http://www.saronnocomets.it/_static/img/logo-shadow.png" />
    <link rel="shortcut icon" href="_static/img/icon.png" type="image/png" />
    <link rel="icon" href="_static/img/icon.png" type="image/png" />
    
    <link rel="stylesheet" type="text/css" href="_static/css/reset-min.css" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Philosopher:400,700,400italic,700italic" />
    <link rel="stylesheet" type="text/css" href="_static/css/style.css" />
    <link rel="stylesheet" type="text/css" href="_static/css/prettyPhoto.css" />
    
    <script type="text/javascript" src="_static/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="_static/js/jquery.tools.min.js"></script>
    <script type="text/javascript" src="_static/js/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" src="_static/js/moment.min.js"></script>
    <script type="text/javascript" src="_static/js/javascript.js"></script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-28063203-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
</head>
<body>
    <div id="title">
        <h1>Saronno Tchoukball Club</h1>
        <div id="bookmark">
            <a href="./"><img src="_static/img/logo-shadow.png" id="logo" alt="Il logo del Saronno TchoukBall Club" /></a>
        </div>
    </div>
    <div id="main">
        <div id="herospace">
            <?php
                $hero = array(
                    // array('hero-championships.png', '', ''),
                    array('hero-ewcs.png', 'Campioni d&rsquo;Europa!', "I <b>Saronno Castor</b> hanno vinto<br />per il terzo anno consecutivo<br />l'<b>European Winners' Cup</b><br />confermandosi squadra di club<br />ai vertici del vecchio continente"),
                    array('hero-2002.png', 'Saronno. Since 2002', 'Il primo Club di TchoukBall<br />in Italia!'),
                );
                foreach ($hero AS $k => $h) {
            ?>
            <div class="hero" style="background-image:url('_static/img/<?php echo $h[0]; ?>');<?php if ($k != 0) echo 'display:none;' ?>">
                <h2><?php echo $h[1]; ?></h2>
                <h3><?php echo $h[2]; ?></h3>
            </div>
            <?php } ?>
        </div>
        <div id="content">
            <?php include($page_file); ?>
            <div id="col2">
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
    ?>
                <div id="partite">
                    <h4>Partite</h4>
    <?php
        foreach($partite AS $p) {
            $evento = $p['evento'];
            if ($p['dettaglio'] == 'Serie A') $evento .= ' Serie A';
            if ($p['dettaglio'] == 'Serie B') $evento .= ' Serie B';
            ?>
                        <div class="partita <?php echo $icone[$p['evento']]; ?>">
                            <h5>
                                <?php echo substr($p['data'],0,strrpos($p['data'], '.')); ?><br />
                                <?php echo $p['citta']; ?><?php echo ($p['indirizzo'] != '') ? ', '.$p['indirizzo'] : ''; ?><br />
                                <?php echo $p['info']; ?>
                            </h5>
                            <div><?php echo $p['s1']; ?> <span><?php echo $p['p1']; ?></span></div>
                            <div><?php echo $p['s2']; ?> <span><?php echo $p['p2']; ?></span></div>
                        </div>
            <?php
        }
        ?>
                </div>
        <?php
    }
?>
                <div id="squadre">
                    <h4>Le squadre</h4>
                    <div class="squadra">
                        <a href="_static/img/squadre/Castor2012.jpg" class="prettyPhoto" title="Castor 2012" rel="prettyPhoto[2012]">
                            <img src="_static/img/squadre/Castor2012_sm.jpg" />
                            Castor
                        </a>
                    </div>
                    <div class="squadra">
                        <a href="_static/img/squadre/Pollux2012.jpg" class="prettyPhoto" title="Pollux 2012" rel="prettyPhoto[2012]">
                            <img src="_static/img/squadre/Pollux2012_sm.jpg" />
                            Pollux
                        </a>
                    </div>
                    <div class="squadra">
                        <a href="_static/img/squadre/PolarisMizar2012.jpg" class="prettyPhoto" title="Mizar e Polaris 2012" rel="prettyPhoto[2012]">
                            <img src="_static/img/squadre/PolarisMizar2012_sm.jpg" />
                            Mizar e Polaris
                        </a>
                    </div>
                </div>
                <div id="facebook">
                    <h4>Facebook</h4>
                    <div class="facebookContainer">
                        <div class="facebookInnerContainer">
                            <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fsaronnocomets&amp;width=184&amp;height=410&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;appId=110921952278697" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:184px; height:410px;" allowTransparency="true"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div id="footerContent">
            <div class="footerCol">
                <h4>La Societ&agrave;</h4>
                <h5>A.S.D. Saronnno TchoukBall Club</h5>
                <p>via Parini 54, 21047 Saronno (VA)</p>
                <p>info@saronnocomets.it</p>
                <p><a href="post/?iframe=true" rel="prettyPhotoIframes" title="Aggiungi post" class="prettyPhotoIframe">Admin</a></p>
            </div>
            <div class="footerCol" id="link">
                <h4>Link</h4>
                <a href="http://www.tchouball.it" id="ftbi">Federazione TchoukBall Italia</a>
                <a href="http://www.youtchouk.com/" id="youtchouk">YouTchouk</a>
            </div>
            <div class="footerCol">
                <h4>Il TchoukBall</h4>
                <p><a href="http://www.tchoukball.it/tchouk">Cos'&egrave; il TchoukBall?</a></p>
                <p><a href="http://www.tchoukball.it/eventi-ita12a">Serie A</a> e <a href="http://www.tchoukball.it/eventi-ita12b">Serie B</a> 2011.2012</p>
            </div>
            <div class="footerCol" id="sponsor">
                <h4>Sponsor</h4>
                <a href="http://www.prodigys.it" id="prodigys">Prodigys Technology</a>
                <a href="http://www.imp-spa.com/" id="imp">IMP Saronno</a>
            </div>
        </div>
        <a href="http://www.giko.it" id="giko">sito realizzato da Giko</a>
    </div>

</body>
</html>
    