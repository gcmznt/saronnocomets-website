<?php

    require_once __DIR__ . '/_libs/silex/vendor/autoload.php';
    $silex = new Silex\Application();
    require_once __DIR__ . '/_libs/twig/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/_templates'));

    if (preg_match('/MSIE [45678]/i', $_SERVER['HTTP_USER_AGENT'])) {
        return $silex->redirect('/no-ie');
    }

    $silex['debug'] = true;

    $context = array(
        'favicon' => array(
            'href' => '/_static/img/icon.png',
            'type' => 'image/png',
        ),
        // 'ga_account' => 'UA-28063203-1',
        'og_image' => 'http://www.saronnocomets.it/_static/img/logo.png',
        'title' => 'ASD Saronno TchoukBall Club',
        'extra_css' => array(),
        'extra_js' => array(),
        'meta_tags' => array(
            'description' => false,
            'keywords' => false,
        ),
    );

    $silex->get('/', function () use ($silex, $twig, $context) { 
        $context['title'] = 'Home - ' . $context['title'];
        $twig->display('base.html', $context);
    });

    $silex->get('/{page}/', function ($page) use ($silex, $twig, $context) { 
        $context['title'] = $page . ' - ' . $context['title'];
        $twig->display('base.html', $context);
    });

    $silex->get('/no-ie', function () use ($silex, $twig, $context) { 
        $context['title'] = 'AHAHAHAH - ' . $context['title'];
        $twig->display('base.html', $context);
    });

    $app->error(function (\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

    $silex->run();


echo $_SERVER['HTTP_USER_AGENT'];


die();