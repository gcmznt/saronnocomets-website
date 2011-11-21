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
        
        <a href="."><img id="logo" src="_static/img/logo.png" alt="Logo del Saronno TchoukBall Club" /></a>

        <div id="menuContainer">
            <ul id="menu">
                <?php
                    $menu = array(
                        'news' => array('News'),
                        'partite' => array('Le Partite'),
                        'squadre' => array('Le Squadre'),
                        'info' => array('La Societ&agrave;'),
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
    