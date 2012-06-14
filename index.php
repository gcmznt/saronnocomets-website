<?php
    require_once(dirname(__FILE__).'/_includes/utilities.php');

    $page = (isset($_GET['page'])) ? $_GET['page'] : 'news';
    $page = str_replace(array('/', '.', ' '), '', $page);
    if (is_file(dirname(__FILE__).'/_includes/pages/'.$page.'.php')) {
        $page_file = dirname(__FILE__).'/_includes/pages/'.$page.'.php';
    } else {
        header('HTTP/1.0 404 Not Found');
        $page_file = dirname(__FILE__).'/_includes/pages/errore.php';
    }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ASD Saronno TchoukBall Club</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <meta property="og:image" content="http://www.saronnocomets.it/_static/img/logo.png" />
    <link rel="shortcut icon" href="_static/img/icon.png" type="image/png" />
    <link rel="icon" href="_static/img/icon.png" type="image/png" />
    
    <link rel="stylesheet" type="text/css" href="_static/css/reset-min.css" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Philosopher:400,700,400italic,700italic" />
    <link rel="stylesheet" type="text/css" href="_static/css/style.css" />
    <link rel="stylesheet" type="text/css" href="_static/css/prettyPhoto.css" />
    
    <script type="text/javascript" src="_static/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="_static/js/jquery.tools.min.js"></script>
    <script type="text/javascript" src="_static/js/jquery.prettyPhoto.js"></script>
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
        <div id="titleText">Saronno TchoukBall Club</div>
        <div id="bookmark">
            <a href="./"><img src="_static/img/logo.png" id="logo" alt="Il logo del Saronno TchoukBall Club" /></a>
        </div>
    </div>
    <div id="main">
        <div id="herospace">
            <?php
                $hero_demo = array(
                    'bg' => "hero-ewcs.png",
                    'h2' => "Campioni d&rsquo;Europa!",
                    'h3' => "I <b>Saronno Castor</b> hanno vinto<br />per il terzo anno consecutivo",
                    'bt' => array(
                        array('bottone1', '#'),
                        array('bottone2', '#'),
                    ),
                );


                $hero[] = array(
                    'bg' => "hero-carta.png",
                    'h2' => "<i>&quot;Il bel gioco richiama il bel gioco&quot;</i>",
                    'bt' => array(
                        array("La carta del TchoukBall", '/carta'),
                    ),
                );
                // $hero[] = array(
                //     'bg' => "hero-playoff.png",
                //     'h2' => "22 Aprile - Le finali del campionato",
                //     'h3' => "Per la stagione 2011 2012 tornano<br />a Saronno le partite che<br />decideranno chi vincerà<br />lo scudetto",
                //     'bt' => array(
                //         array("Visita la pagina dell'evento", 'http://www.tchoukball.it/eventi-ita12a'),
                //     ),
                // );
                // $hero[] = array(
                //     'bg' => "hero-5champ.png",
                //     'h2' => "Castor pentacampioni!",
                //     'h3' => "I Castor hanno conquistato<br />il loro quinto scudetto",
                //     'bt' => array(
                //         array("Leggi la news", '/news-77'),
                //         array("Risultati", '/playoff'),
                //     ),
                // );
                // $hero[] = array(
                //     'bg' => "hero-playoff12.png",
                //     'h2' => "Playoff 2012 - Le finali del campionato",
                //     'h3' => "PalaDozio, 22 Aprile 2012<br />4 squadre per uno scudetto",
                //     'bt' => array(
                //         array("Programma", '/playoff'),
                //     ),
                // );
                // $hero[] = array(
                //     'bg' => "hero-ewcs.png",
                //     'h2' => "Campioni d&rsquo;Europa!",
                //     'h3' => "I <b>Saronno Castor</b> hanno vinto<br />per il terzo anno consecutivo<br />l'<b>European Winners' Cup</b><br />confermandosi squadra di club<br />ai vertici del vecchio continente",
                //     'bt' => array(
                //         array("Leggi la news", '/news-62'),
                //         array("I risultati", 'http://www.tchoukball.it/eventi-ewc12'),
                //     ),
                // );
                // $hero[] = array(
                //     'bg' => "hero-2002.png",
                //     'h2' => "Saronno. Since 2002",
                //     'h3' => "Il primo Club di TchoukBall<br />in Italia!",
                //     'bt' => array(
                //         array('La societ&agrave;', '/info'),
                //     ),
                // );
                // $hero[] = array(
                //     'bg' => "hero-castorpollux.png",
                //     'h2' => "Castor e Pollux",
                //     'h3' => "Si diceva che si assomigliassero<br />molto fisicamente e che persino si<br />vestissero allo stesso modo, come<br />spesso fanno i gemelli.",
                //     'bt' => array(
                //         array('I nomi delle squadre', '/curiosita'),
                //     ),
                // );

                foreach ($hero AS $k => $h) {
            ?>
            <div class="hero" style="<?php if (isset($h['bg'])) echo "background-image:url('_static/img/".$h['bg']."');"; ?><?php if ($k != 0) echo 'display:none;' ?>">
                <h2><?php echo $h['h2']; ?></h2>
                <h3><?php echo $h['h3']; ?></h3>
                <?php
                    if (isset($h['bt'])) {
                        foreach ($h['bt'] as $b) {
                            echo '<a href="'.$b[1].'" class="button white">'.$b[0].'</a>';
                        }
                    }
                ?>
            </div>
            <?php } ?>
        </div>
        <div id="content">
            <?php include($page_file); ?>
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
                <a href="http://www.tchoukball.it" id="ftbi">Federazione TchoukBall Italia</a>
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
    