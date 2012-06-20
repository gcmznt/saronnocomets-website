<?php
    function read_data($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, TRUE);
    }

    mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('Errore di connessione al db');
    mysql_select_db(DB_NAME) or die ('Errore di selezione del db');
