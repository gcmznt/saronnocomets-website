<?php

    require_once __DIR__ . '/_libs/silex/vendor/autoload.php';
    $silex = new Silex\Application();
    require_once __DIR__ . '/_libs/twig/lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/_templates'));

    session_start();

    $context = array();
    require_once(__DIR__ . '/_includes/config.php');
    require_once(__DIR__ . '/_includes/utilities.php');

    $silex->get('/', function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

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
            require_once(__DIR__ . '/_includes/hero.php');
            $context['heros'] = $hero;
            $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

            $twig->display("$page.html", $context);
        });
    }

    $silex->get("/torneo-di-saronno/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

        $twig->display("tds.html", $context);
    });
    $silex->get("/torneo-di-saronno/iscrizioni/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

        $twig->display("iscrizione-tds.html", $context);
    });
    $silex->get("/torneo-di-saronno/iscrizioni/confirm/{code}/", function ($code) use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

        require_once(__DIR__ . '/_includes/db_connect.php');
        $year = date('Y');
        $code = mysql_real_escape_string($code);
        $dati = mysql_query("SELECT * FROM tds WHERE year = '$year' AND confirm = '$code' AND status = 'pending'");
        if (mysql_num_rows($dati) == 1) {
            $dati = mysql_fetch_assoc($dati);
            $iscritti = mysql_query("SELECT * FROM tds WHERE year = '$year' AND tournament = 'classic' AND status = 'confirmed'");
            $context['name'] = $dati['responsible'];
            $context['team'] = $dati['team'];
            $status = (mysql_num_rows($iscritti) >= 24) ? 'queued' : 'confirmed';
            mysql_query("UPDATE tds SET status = '$status' WHERE year = '$year' AND confirm = '$code' AND status = 'pending'");
            $twig->display("iscrizione-tds-" . $status . ".html", $context);
        } else {
            $silex->abort(404);
        }
    });
    $silex->post("/torneo-di-saronno/submit/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

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
        $saturnday = ($_POST['inputSaturnday'] == '') ? 0 : $_POST['inputSaturnday'];
        $sunday = ($_POST['inputSunday'] == '') ? 0 : $_POST['inputSunday'];
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
        if (!is_numeric($saturnday)) {
            $res['errors']['inputSaturnday'] = "Inserire un numero di buoni pasto";
        }
        if (!is_numeric($sunday)) {
            $res['errors']['inputSunday'] = "Inserire un numero di buoni pasto";
        }

        if ($res['errors'] == array()) {
            mysql_query("INSERT INTO tds (team, tournament, year, invite, responsible, email, saturnday, sunday, status, confirm) VALUES ('$team', '$tournament', '$year', '$invite', '$responsible', '$email', '$saturnday', '$sunday', '$status', '$confirm')");
            
            if (mysql_affected_rows() == 1) {
                if ($invite != '') {
                    mysql_query("DELETE FROM tds WHERE team = '' AND year = '$year' AND invite = '$invite'");
                    $res['message'] = 'Registrazione avvenuta con successo';
                } else {
                    $res['message'] = "Dati salvati con successo.<br />Per confermare la tua iscrizione clicca sul link che ti abbiamo inviato all'indirizzo email $email.";

                    $subject = 'Iscrizione Torneo di Saronno';
                    $context['name'] = $responsible;
                    $context['team'] = $team;
                    $context['url'] = 'http://www.saronnocomets.it/torneo-di-saronno/iscrizioni/confirm/'.$confirm.'/';
                    $message = $twig->render("iscrizione-tds-email.html", $context);
                    $headers = 'From: Saronno TchoukBall Club <torneo@saronnocomets.it>';

                    mail($email, $subject, $message, $headers);
                }
                $res['status'] = 'ok';
            } else {
                $res['message'] = 'Errore durante il salvataggio';
            }
        }

        header('Content-type: application/json');
        echo json_encode($res);
    });
    $silex->get("/torneo-di-saronno/{anno}/", function ($anno) use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

        $twig->display("tds-$anno.html", $context);
    });
    $silex->get("/partite/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

        $context['stagioni'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php');
        $twig->display("partite.html", $context);
    });
    $silex->get("/squadre/", function () use ($silex, $twig, $context) {
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

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
        require_once(__DIR__ . '/_includes/hero.php');
        $context['heros'] = $hero;
        $context['main_matches'] = read_data('http://' . $_SERVER["HTTP_HOST"] . '/_export/partite.php?main');

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




    $silex->get("/admin/", function () use ($silex, $twig, $context) {
        if (isset($_SESSION['logged']) && $_SESSION['logged']) {
            return $silex->redirect('/admin/home/');
        } else {
            $twig->display("admin/login.html", $context);
        }
    });
    $silex->get("/admin/logout/", function () use ($silex, $twig, $context) {
        $_SESSION['logged'] = false;
        $_SESSION['id'] = false;
        $_SESSION['email'] = false;
        $_SESSION['gravatar'] = false;
        $_SESSION['name'] = false;
        return $silex->redirect('/admin/');
    });
    $silex->post("/admin/login/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $res = array();
        $res['logged'] = false;

        $email = mysql_real_escape_string($_POST['email']);
        $password = md5($_POST['password']);

        $q = mysql_query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
        if (mysql_num_rows($q) > 0) {
            $c = mysql_fetch_assoc($q);
            $_SESSION['logged'] = true;
            $_SESSION['id'] = $c['id'];
            $_SESSION['email'] = $c['email'];
            $_SESSION['gravatar'] = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($_SESSION['email']))) . '?d=identicon';
            $_SESSION['name'] = $c['name'];
            $res['logged'] = true;
        }

        header('Content-type: application/json');
        echo json_encode($res);
    });
    $silex->get("/admin/{page}/", function ($page) use ($silex, $twig, $context) { 
        $context['page'] = $page;
        $context['id'] = $_SESSION['id'];
        $context['name'] = $_SESSION['name'];
        $context['email'] = $_SESSION['email'];
        $context['gravatar'] = $_SESSION['gravatar'];
        $twig->display("admin/" . $page . ".html", $context);
    });
    $silex->post("/admin/profilo/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $errors = array();

        $id = $_SESSION['id'];
        $name = mysql_real_escape_string($_POST['name']);
        $email = mysql_real_escape_string($_POST['email']);
        $password = md5($_POST['password']);
        $new_password = md5($_POST['new_password']);

        $q = mysql_query("SELECT * FROM users WHERE id = '$id' AND password = '$password'");
        if (mysql_num_rows($q) == 0) $errors[] = 'Password sbagliata';
        if (!validEmail($email)) $errors[] = 'Indirizzo email non valido';
        if ($_POST['new_password'] != $_POST['new_password_retype']) $errors[] = 'Le passord non coincidono';

        if (count($errors) == 0) {
            if ($_POST['new_password'] != '')
                $q = mysql_query("UPDATE users SET name = '$name', email = '$email', password = '$new_password' WHERE id = '$id' AND password = '$password'");
            else
                $q = mysql_query("UPDATE users SET name = '$name', email = '$email' WHERE id = '$id' AND password = '$password'");
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['gravatar'] = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($_SESSION['email']))) . '?d=identicon';
        } else {
            $context['errors'] = $errors;
        }

        $context['name'] = $_SESSION['name'];
        $context['email'] = $_SESSION['email'];
        $context['gravatar'] = $_SESSION['gravatar'];
        $twig->display("admin/profilo.html", $context);
    });
    $silex->get("/admin/tds/data/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $res = array();

        $q = mysql_query("SELECT * FROM tds WHERE year = '" . date('Y') . "' ORDER BY team ASC");
        while ($res[] = mysql_fetch_assoc($q)) {}

        header('Content-type: application/json');
        echo json_encode($res);
    });
    $silex->get("/admin/news/data/", function () use ($silex, $twig, $context) { 
        require_once(__DIR__ . '/_includes/db_connect.php');
        $res = array();

        $q = mysql_query("SELECT * FROM news ORDER BY data DESC");
        while ($res[] = mysql_fetch_assoc($q)) {}

        header('Content-type: application/json');
        echo json_encode($res);
    });

    $silex->get("/admin/news/{id}/", function ($id) use ($silex, $twig, $context) {
        require_once(__DIR__ . '/_includes/db_connect.php');
        $context['page'] = 'news';
        $context['id'] = $_SESSION['id'];
        $context['name'] = $_SESSION['name'];
        $context['email'] = $_SESSION['email'];
        $context['gravatar'] = $_SESSION['gravatar'];
        $q = mysql_query("SELECT * FROM news WHERE id = '$id'");
        $news = mysql_fetch_assoc($q);
        $context['titolo'] = $news['titolo'];
        $context['testo'] = $news['testo'];
        $twig->display("admin/singlenews.html", $context);
    });






    $silex->run();
