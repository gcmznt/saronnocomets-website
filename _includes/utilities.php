<?php
    function read_data($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, TRUE);
    }

    if ($_SERVER["HTTP_HOST"] == 'www.saronnocomets.it') {
        define('DB_HOST',           '62.149.150.66');
        define('DB_USER',           'Sql125733');
        define('DB_PASSWORD',       '612cae5b');
        define('DB_NAME',           'Sql125733_1');
    } else {
    	define('DB_HOST', 			'localhost');
    	define('DB_USER', 			'root');
    	define('DB_PASSWORD', 		'root');
    	define('DB_NAME', 			'stbc');
    }

	mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('Errore di connessione al db');
	mysql_select_db(DB_NAME) or die ('Errore di selezione del db');
