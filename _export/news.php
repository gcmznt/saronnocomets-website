<?php
    header("Content-type: text/plain");
    include_once dirname(__FILE__).'/../core/db_connect.php';
    
    $select = "n.id AS id, oggetto, data, testo, categoria, link, CONCAT_WS(' ', a.nome, a.cognome) AS nome, u.livello, a.public, a.codice";
    $news = mysql_query("SELECT $select FROM (news AS n, utenti AS u) LEFT JOIN anagrafica AS a ON a.utente = u.id WHERE n.utente = u.id AND ftbi >= 1 ORDER BY n.data DESC");
    
    $data = array();
    
    for ($i = 0; $current = mysql_fetch_assoc($news); $i++) {
        $current['dataEstesa'] = $current['data'];
        $current['data'] = substr($current['data'], 8, 2).'/'.substr($current['data'], 5, 2).'/'.substr($current['data'], 0, 4);
        
        $current = array_map('htmlentities', $current);
        
        $current['titoloHTML'] = (($current['link'] != '') && ($current['link'] != 'http://')) ? '<a href="'.$current['link'].'">'.$current['oggetto'].'</a>' : $current['oggetto'];
        $current['testo'] = str_replace("\r\n", "<br />", $current['testo']);
        //$current['firmaHTML'] = (($current['codice'][0] == 'A') && ($current['public'] == 1)) ? '<a href="?section=teams&zone='.$current['codice'].'" class="firma">'.$current['nome'].'</a>' : '<span class="firma">'.$current['nome'].'</span>';
        //$current['firmaHTML'] = '<span class="firma">'.$current['nome'].'</span>';
        $data[] = $current;
    }
    
    // print_r($data);
    echo json_encode($data);
    // return json_encode($data);
