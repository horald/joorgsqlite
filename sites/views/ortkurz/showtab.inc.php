<?php
$listarray = array ( array ( 'label' => 'Kurz',
                             'name' => 'ortkurz',      
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldkurz' ),
                     array ( 'label' => 'Bezeichnung',
                             'name' => 'bez',      
                             'width' => 50, 
                             'type' => 'text',
                             'dbfield' => 'fldbez' ),
/*
                     array ( 'label' => 'Zimmer',
                             'name' => 'zimmer',      
                             'width' => 50, 
                             'type' => 'selectid',
                             'dbtable' => 'tblorte',
                             'seldbfield' => 'fldBez',
                             'seldbindex' => 'fldindex',
                             'seldbwhere' => "fldo01typ='ZIMMER'",
                             'dbfield' => 'fldid_zimmer' ),
*/
                     array ( 'label' => 'Timestamp',
                             'name' => 'timestamp', 
                             'width' => 100, 
                             'type' => 'text',
                             'fieldhide' => 'true1',
                             'fieldsave' => 'NO',
                             'dbfield' => 'fldtimestamp' ),
                     array ( 'label' => 'dbsync',
                             'name' => 'dbsync', 
                             'width' => 100, 
                             'type' => 'text',
                             'fieldsave' => 'NO',
                             'dbfield' => 'flddbsyncstatus' ));

$pararray = array ( 'headline' => 'Ort (kurz)',
                    'dbtable' => 'tblortkurz',
                    'orderby' => 'fldkurz',
                    'strwhere' => '',
                    'dbsyncnr' => 'J',
                    'fldindex' => 'fldindex');

?>