<?php
    header("Content-type: text/plain");

    error_reporting(E_ALL ^ E_NOTICE);

    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    // Impostazioni
    
    $key = '0ApmzWu3XjwB1dGMtVTAtNndrUzR6RUVZdDUyV3hiMkE';
    $dataOutput = array();
    
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    // Impostazioni per il recupero dati
    
        $DataMining = array(
                        array(
                            'sheet'         => 0, // Foglio interno, partono da 0
                            'jumpheader'    => 1, // Numero di righe da saltare
                            'fields'        => array( // Colonne da pescare (partono da 1)
                                                    'stagione'             => 1,
                                                    'squadra'             => 2,
                                                    'nome'             => 3,
                                                    'capitano'             => 4,
                                                    'nascita'          => 5,
                                                    'numero'         => 6,
                                                    ),
                            'callback'      => 'Store', // Funzione di callback
                        ),
                    );

        
        
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    // Funzioni CALLBACK di Storing
    
                
        function Store($Fields) {
            
            $Fields['capitano'] = ($Fields['capitano'] == 'x') ? true : false;

            return $Fields;
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
            $dataOutput[$CurrentFields['stagione']][$CurrentFields['squadra']][] = $MininingRules['callback']($CurrentFields);
        }

        fclose($handle);
        
    }
    
    echo json_encode($dataOutput);
