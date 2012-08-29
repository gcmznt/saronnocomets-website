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

    $silex->get("/torneo-di-saronno/iscrizioni/", function () use ($silex, $twig, $context) { 
        $twig->display("iscrizione-tds.html", $context);
    });
    $silex->get("/torneo-di-saronno/iscrizioni/confirm/{code}/", function ($code) use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $year = date('Y');
        $code = mysql_real_escape_string($code);
        $q = mysql_query("SELECT * FROM tds WHERE year = '$year' AND confirm = '$code' AND status = 'pending'");
        if (mysql_num_rows($q) == 1) {
            $dati = mysql_fetch_assoc($q);
            $context['name'] = $dati['responsible'];
            $context['team'] = $dati['team'];
            $q = mysql_query("UPDATE tds SET status = 'confirmed' WHERE year = '$year' AND confirm = '$code' AND status = 'pending'");
            $twig->display("iscrizione-tds-confirm.html", $context);
        } else {
            $silex->abort(404);
        }
    });
    $silex->post("/torneo-di-saronno/submit/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $res = array();
        $res['status'] = 'ko';
        $res['errors'] = array();

        $team = mysql_real_escape_string($_POST['inputName']);
        $tournament = mysql_real_escape_string($_POST['inputTorneo']);
        $year = date('Y');
        $invite = mysql_real_escape_string($_POST['inputCode']);
        $responsible = mysql_real_escape_string($_POST['inputResponsible']);
        $email = mysql_real_escape_string($_POST['inputEmail']);
        $saturnday = mysql_real_escape_string($_POST['inputSaturnday']);
        $sunday = mysql_real_escape_string($_POST['inputSunday']);
        $status = ($tournament == 'elite') ? 'confirmed' : 'pending';
        $confirm = uniqid();

        if ($team == '') {
            $res['errors']['inputName'] = "Inserire il nome della squadra";
        } else {
            $n = mysql_num_rows(mysql_query("SELECT * FROM tds WHERE team = '$team' AND year = '$year' AND tournament = '$tournament'"));
            if ($n > 0) {
                $res['errors']['inputName'] = "Squadra già iscritta";
            }
        }
        if ($tournament == 'elite') {
            $n = mysql_num_rows(mysql_query("SELECT * FROM tds WHERE team = '' AND year = '$year' AND invite = '$invite'"));
            if ($n == 0) {
                $res['errors']['inputCode'] = "Codice non valido";
            }
        }
        if ($responsible == '') {
            $res['errors']['inputResponsible'] = "Inserire il nome del responsabile";
        }
        if ($email == '') {
            $res['errors']['inputEmail'] = "Inserire l'indirizzo email";
        } elseif (!validEmail($email)) {
            $res['errors']['inputEmail'] = "Indirizzo email non valido";
        }

        if ($res['errors'] == array()) {
            mysql_query("INSERT INTO tds (team, tournament, year, invite, responsible, email, saturnday, sunday, status, confirm) VALUES ('$team', '$tournament', '$year', '$invite', '$responsible', '$email', '$saturnday', '$sunday', '$status', '$confirm')");
            
            if (mysql_affected_rows() == 1) {
                if ($invite != '') {
                    mysql_query("DELETE FROM tds WHERE team = '' AND year = '$year' AND invite = '$invite'");
                }
                $res['status'] = 'ok';
                $res['message'] = 'Iscrizione avvenuta con successo';

                $subject = 'Iscrizione Torneo di Saronno';
                $context['name'] = $responsible;
                $context['team'] = $team;
                $context['url'] = 'http://www.saronnocomets.it/torneo-di-saronno/iscrizioni/confirm/'.$confirm.'/';
                $message = $twig->render("iscrizione-tds-email.html", $context);
                $headers = 'From: torneo@saronnocomets.it';

                mail($email, $subject, $message, $headers);
            } else {
                $res['message'] = 'Errore durante il salvataggio';
            }
        }

        header('Content-type: application/json');
        echo json_encode($res);
    });
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
