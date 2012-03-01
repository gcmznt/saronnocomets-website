<?php
    header("Content-type: text/plain");

    error_reporting(E_ALL ^ E_NOTICE);

    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    // Impostazioni
    
    $key = '0ApmzWu3XjwB1dHlDMUxrTDVXRzZXUkotTjNIWnhReGc';
    $dataOutput = array();
    
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    // Impostazioni per il recupero dati
    
        $DataMining = array(
                        array(
                            'sheet'         => 0, // Foglio interno, partono da 0
                            'jumpheader'    => 1, // Numero di righe da saltare
                            'fields'        => array( // Colonne da pescare (partono da 1)
                                                    'home'           => 1,
                                                    's1'             => 2,
                                                    'p1'             => 3,
                                                    'p2'             => 4,
                                                    's2'             => 5,
                                                    'derby'          => 6,
                                                    'neutro'         => 7,
                                                    'citta'          => 8,
                                                    'indirizzo'      => 9,
                                                    'evento'         => 10,
                                                    'dettaglio'      => 11,
                                                    'stagione'       => 12,
                                                    'data'           => 13,
                                                    'youtchouk'      => 14,
                                                    'info'           => 15,
                                                    ),
                            'callback'      => 'Store', // Funzione di callback
                        ),
                    );

        
        
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    // Funzioni CALLBACK di Storing
    
                
        function Store($Fields) {
            
            $Fields['home'] = ($Fields['home'] == 'x') ? true : false;
            $Fields['derby'] = ($Fields['derby'] == 'x') ? true : false;
            $Fields['neutro'] = ($Fields['neutro'] == 'x') ? true : false;

            $lastWeek = time() - (4 * 24 * 60 * 60);
            $nextWeek = time() + (6 * 24 * 60 * 60);

            $matchTime = mktime(0, 0, 0, substr($Fields['data'], 3, 2), substr($Fields['data'], 0, 2), substr($Fields['data'], 6, 4));

            return ($Fields['home'] || ($lastWeek <= $matchTime && $matchTime <= $nextWeek)) ? $Fields : false;
            // return array_map('htmlentities', $Fields);
        }

    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    
    
    foreach ($DataMining as $MininingRules) {
        $handle = fopen("https://docs.google.com/spreadsheet/pub?key=".$key."&gid=".$MininingRules['sheet']."&output=csv", "r");
        for ($i=0; $i<$MininingRules['jumpheader']; $i++) { ($data = fgetcsv($handle, 1000, ",")); }
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $CurrentFields = array();
            foreach ($MininingRules['fields'] as $FieldName => $Column) {
                $CurrentFields[$FieldName] = $data[$Column-1];
            }
            $r = $MininingRules['callback']($CurrentFields);
            if ($r)
                $dataOutput[] = $r;
        }

        fclose($handle);
        
    }
    
    echo json_encode($dataOutput);
