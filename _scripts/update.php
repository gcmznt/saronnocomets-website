<?php
        define('DB_HOST',           '62.149.150.66');
        define('DB_USER',           'Sql125733');
        define('DB_PASSWORD',       '612cae5b');
        define('DB_NAME1',           'Sql125733_1');
        define('DB_NAME2',           'Sql125733_3');

	mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('Errore di connessione al db');
    mysql_select_db(DB_NAME1) or die ('Errore di selezione del db');

    $q = mysql_query("SELECT * FROM comets_news order by date asc");

	mysql_select_db(DB_NAME2) or die ('Errore di selezione del db');

    while ($n = mysql_fetch_assoc($q)) {
        $d = $n['date'];
        $t = mysql_real_escape_string(htmlentities($n['title']));
        $c = '<p>'.mysql_real_escape_string(nl2br(htmlentities($n['content']))).'</p>';
        
        mysql_query("insert into news (data, titolo, testo) values ('$d', '$t', '$c')");
        echo "'$d', '$t': ".mysql_affected_rows().'<br>';
    }