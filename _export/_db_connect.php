<?php
	
	define('DB_HOST', 			'62.149.150.66');
	define('DB_USER', 			'Sql125733');
	define('DB_PASSWORD', 		'612cae5b');
	define('DB_NAME', 			'Sql125733_1');

	mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('Errore di connessione al db');
	mysql_select_db(DB_NAME) or die ('Errore di selezione del db');
