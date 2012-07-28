<?php

    require_once __DIR__ . '/_libs/silex/vendor/autoload.php';
    $silex = new Silex\Application();
    require_once __DIR__ . '/_libs/twig/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/_templates'));

    $context = array();
    require_once(__DIR__ . '/_includes/config.php');
    require_once(__DIR__ . '/_includes/utilities.php');

    require_once(__DIR__ . '/_includes/hero.php');
    $context['heros'] = $hero;

    $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

    $silex->get('/', function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $news = mysql_query("SELECT * FROM news ORDER BY data DESC LIMIT 0,10;");
        while ($n = mysql_fetch_assoc($news)) {
            $n['data_view'] = substr($n['data'],8,2).' '.substr($n['data'],5,2) . ' ' . substr($n['data'],0,4);
            $t = strip_tags(str_replace('<br />', ' ', stripslashes($n['testo'])));
            preg_match('/^([^.!?\s]*[\.!?\s]+){0,60}/', $t, $abstract);
            $n['abstract'] = $abstract[0];
            if (strlen($abstract[0]) != strlen($t)) $n['abstract'] .= '...';
            $n['titolo'] = stripslashes($n['titolo']);
            $context['news'][] = $n;
        }
        $twig->display("news.html", $context);
    });

    $static_pages = array(
        'info',
        'carta',
        'curiosita',
    );
    foreach ($static_pages as $page) {
        $silex->get("/$page/", function () use ($silex, $twig, $context, $page) { 
            $twig->display("$page.html", $context);
        });
    }

    $silex->get("/partite/", function () use ($silex, $twig, $context) { 
        $context['stagioni'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php');
        $twig->display("partite.html", $context);
    });
    $silex->get("/squadre/", function () use ($silex, $twig, $context) {
        $context['stagioni'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/squadre.php');
        $twig->display("squadre.html", $context);
    });
    $silex->get("/news/", function () use ($silex, $twig, $context) { 
        return $silex->redirect('/');
    });
    $silex->get("/news-{id}", function ($id) use ($silex, $twig, $context) { 
        return $silex->redirect("/news/$id/");
    });
    $silex->get("/news/{id}/", function ($id) use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $news = mysql_query("SELECT * FROM news WHERE id = " . mysql_real_escape_string($id) . " ORDER BY data DESC LIMIT 0,10;");
        $n = mysql_fetch_assoc($news);
        $n['data_view'] = substr($n['data'],8,2).' '.substr($n['data'],5,2) . ' ' . substr($n['data'],0,4);
        $next_news = mysql_query("SELECT id, titolo FROM news WHERE id > " . mysql_real_escape_string($id) . " ORDER BY id ASC LIMIT 1;");
        if (mysql_num_rows($next_news)) {
            $next = mysql_fetch_assoc($next_news);
            $context['next_news'] = $next['id'];
            $context['next_news_titolo'] = stripslashes($next['titolo']);
        }
        $prev_news = mysql_query("SELECT id, titolo FROM news WHERE id < " . mysql_real_escape_string($id) . " ORDER BY id DESC LIMIT 1;");
        if (mysql_num_rows($prev_news)) {
            $prev = mysql_fetch_assoc($prev_news);
            $context['prev_news'] = $prev['id'];
            $context['prev_news_titolo'] = stripslashes($prev['titolo']);
        }
        $n['testo'] = stripslashes($n['testo']);
        $n['titolo'] = stripslashes($n['titolo']);
        $context['notizia'] = $n;

        $twig->display("singlenews.html", $context);
    });

    $silex->run();
