<?php
    define('DEFAULT_PAGE', 'news');

    //session_start();
    
    $pagina = (isset($_GET['section'])) ? $_GET['section'] : DEFAULT_PAGE;
    $pagina = str_replace('/', '', $pagina);
    $pagina = str_replace('.', '', $pagina);
    $pagina_file = 'pages/' . $pagina . '.php';
    
    if (!is_file($pagina_file)) {
        header("HTTP/1.0 404 Not Found");
        $pagina_file = 'pages/errore.php';
    }

    $base_url = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], '/')+1);
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    
        <title>ASD Saronno TchoukBall Club</title>
         
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
        
        <link rel="stylesheet" type="text/css" href="_static/css/reset-min.css" />
        <link rel="stylesheet" type="text/css" href="_static/css/prettyPhoto.css" />
        <link rel="stylesheet" type="text/css" href="_static/css/style.css" />
        
        <script type="text/javascript" src="_static/js/jquery.tools.min.js"></script>
        <script type="text/javascript" src="_static/js/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" src="_static/js/jquery.address-1.4.min.js?state=<?php echo $base_url; ?>"></script>
        <script type="text/javascript" src="_static/js/moment.min.js"></script>
        <script type="text/javascript" src="_static/js/javascript.js"></script>
    
    </head>
    
    <body>
        
        <div><a href="."><img id="logo" src="_static/img/logo.png" alt="Logo del Saronno TchoukBall Club" /></a></div>

        <div id="menuContainer">
            <ul id="menu">
                <?php
                    $menu = array(
                        'news' => array('News'),
                        'partite' => array('Partite'),
                        'squadre' => array('Squadre'),
                        'info' => array('Societ&agrave;'),
                        'torneo' => array('Torneo di Saronno'),
                        'tchoukball' => array('Il TchoukBall'),
                    );
                    foreach ($menu AS $key => $value) {
                        ?>
                            <li><a href="<?php echo $key; ?>"<?php if ($pagina == $key) echo ' class="active"'; ?>><?php echo $value[0]; ?></a></li>
                        <?php
                    }
                ?>
            </ul>
        </div>
        
        <div id="container">
            <div class="page">
                <div class="innerContainer">
                    <?php include $pagina_file; ?>
                </div>
            </div>
        </div>
        
    </body>
    
</html>
    