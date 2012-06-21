<?php

    require_once __DIR__ . '/_libs/silex/vendor/autoload.php';
    $silex = new Silex\Application();
    require_once __DIR__ . '/_libs/twig/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/_templates'));


    $silex['debug'] = true;

    $context = array(
        'favicon' => array(
            'href' => '/_static/img/favicon.png',
            'type' => 'image/png',
        ),
        'ga_account' => false,
        'og_image' => false,
        'title' => 'Template',
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

    $silex->run();
