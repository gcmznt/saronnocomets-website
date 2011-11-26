<?php
    header("Content-type: text/plain");
    include_once dirname(__FILE__).'/_db_connect.php';
    

    $select = "n.id, n.title, n.date, n.content, u.username";
    $news = mysql_query("SELECT $select FROM comets_news AS n LEFT JOIN comets_users AS u ON n.user = u.id ORDER BY date DESC");
    
    $data = array();
    
    for ($i = 0; $current = mysql_fetch_assoc($news); $i++) {
        $current['datetime'] = $current['date'];
        $current['date'] = substr($current['date'], 8, 2).'/'.substr($current['date'], 5, 2).'/'.substr($current['date'], 0, 4);
        
        $current = array_map('htmlentities', $current);
        
        $current['content'] = str_replace("\r\n", "<br />", $current['content']);
        $data[] = $current;
    }
    
    echo json_encode($data);
