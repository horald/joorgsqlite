<?php
$listarray = array ( array ( 'label' => 'Dateiname',
                             'name' => 'bez',      
                             'width' => 50, 
                             'type' => 'gettext',
                             'dbfield' => 'fldfilename' ),
                     array ( 'label' => 'Bezeichnung',
                             'name' => 'bez',      
                             'width' => 50, 
                             'type' => 'text',
                             'dbfield' => 'fldbez' ));

$pararray = array ( 'headline' => 'Bildernotiz',
                    'dbtable' => 'tblbilder',
                    'orderby' => '',
                    'strwhere' => '',
                    'dbsyncnr' => 'N',
                    'fldindex' => 'fldindex');

?>