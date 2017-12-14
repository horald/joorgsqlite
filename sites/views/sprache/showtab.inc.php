<?php

$listarray = array ( array ( 'label' => 'Bezeichnung',
                             'name' => 'bez',
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldbez' ),
                     array ( 'label' => 'Sprache',
                             'name' => 'sprache',      
                             'width' => 100, 
                             'type' => 'text',
                            'dbfield' => 'fldlanguage' ),
                      array ( 'label' => 'Timestamp',
                             'name' => 'timestamp', 
                             'width' => 10, 
                             'type' => 'text',
                             'fieldhide' => 'true1',
                             'fieldsave' => 'NO',
                             'dbfield' => 'fldtimestamp' ));



$pararray = array ( 'headline' => 'Sprache',
                    'dbtable' => 'tblsprache',
                    'orderby' => 'fldbez',
                    'strwhere' => "",
                    'fldindex' => 'fldindex');

?>