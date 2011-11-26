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
                                                    's1'             => 1,
                                                    'p1'             => 2,
                                                    'p2'             => 3,
                                                    's2'             => 4,
                                                    'derby'          => 5,
                                                    'neutro'         => 6,
                                                    'citta'          => 7,
                                                    'indirizzo'      => 8,
                                                    'evento'         => 9,
                                                    'stagione'       => 10,
                                                    'data'           => 11,
                                                    'youtchouk'      => 12,
                                                    ),
                            'callback'      => 'Store', // Funzione di callback
                        ),
                    );

        
        
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    // Funzioni CALLBACK di Storing
    
                
        function Store($Fields) {
            
            $Fields['derby'] = ($Fields['derby'] == 'x') ? true : false;
            $Fields['neutro'] = ($Fields['neutro'] == 'x') ? true : false;

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
            $dataOutput[$CurrentFields['stagione']][] = $MininingRules['callback']($CurrentFields);
        }

        fclose($handle);
        
    }
    
    echo json_encode($dataOutput);
