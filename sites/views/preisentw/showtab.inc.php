<?php

$listarray = array ( array ( 'label' => 'Bezeichnung',
                             'name' => 'bez',
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldBez' ),
                     array ( 'label' => 'Ort',
                             'name' => 'ort',
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldOrt' ),
                     array ( 'label' => 'Preis',
                             'name' => 'preis',
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldPreis' ),
                     array ( 'label' => 'Datum',
                             'name' => 'datum',
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldDatum' ));


$pararray = array ( 'headline' => 'Preisentwicklung',
                    'dbtable' => 'tblpreisentw',
                    'orderby' => '',
                    'strwhere' => '',
                    'fldindex' => 'fldindex');

?>