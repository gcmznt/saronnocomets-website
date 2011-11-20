<?php
    define('DEFAULT_PAGE', 'news');
    //session_start();
    
    $pagina = (isset($_GET['section'])) ? $_GET['section'] : DEFAULT_PAGE;
    $pagina = str_replace('/', '', $pagina);
    $pagina = str_replace('.', '', $pagina);
    $pagina_file = '_includes/pages/' . $pagina . '.php';
    
    if (!is_file($pagina_file)) {
        header("HTTP/1.0 404 Not Found");
        $pagina_file = '_includes/pages/errore.php';
    }
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    
        <title></title>
         
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
        <meta name="viewport" content="width=980px, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        
        <link rel="stylesheet" type="text/css" href="_static/css/reset-min.css" />
        <link rel="stylesheet" type="text/css" href="_static/css/style.css" />
        
        <script type="text/javascript" src="_static/js/jquery.tools.min.js"></script>
        <script type="text/javascript" src="_static/js/javascript.js"></script>
    
    </head>
    
    <body>
        
        <div id="container">
            <div class="page">
        <div class="home">
            <h1>Saronno TchoukBall Club</h1>
            <div class="box">
                <h3>News</h3>
                    La terza giornata di campionato, che sar&agrave; giocata domani, domenica 20 novembre, ad Asti e Gerenzano, segna turno di riposo per i Comets. Siccome la quarta giornata prevede l'incontro con i Varese Pirates e il derby Castor - Pollux, le societ&agrave; di Varese e Saronno hanno deciso di anticipare le partite e di giocarle durante le serate di allenamento.<br />
                    Tutte le partite avverranno alla palestra del Liceo G.B Grassi di Saronno, in via B. Croce, alle ore 21.<br />
                    <br />
                    Questo l'ordine delle partite:<br />
                    <br />
                    luned&igrave; 21 novembre ore 21: Saronno Castor-Saronno Pollux<br />
                    luned&igrave; 28 novembre ore 21: Saronno Castor-Varese Pirates<br />
                    gioved&igrave; 1 dicembre ore 21: Saronno Pollux-Varese Pirates<br />
            </div>
            <div class="box">
                <h3>Societ&agrave;</h3>
                <img id="logo" src="_static/img/logo.png" alt="Logo del Saronno TchoukBall Club" />
            </div>
            <div class="box">
                <h3>Partite</h3>
            </div>
            <div class="box">
                <h3>Squadre</h3>
            </div>
            <div class="box">
                <h3>TchoukBall</h3>
            </div>
            <div class="box">
                <h3>Torneo di Saronno</h3>
                <img id="logo-tds" src="_static/img/logo-tds.png" alt="Logo del Torneo Città di Saronno" />
            </div>
        </div>
        </div>
        </div>
        
    </body>
    
</html>
    