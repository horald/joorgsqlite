<?php
$listarray = array ( array ( 'label' => 'Deutsch',
                             'name' => 'deu',      
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldsprache_eins' ),
                     array ( 'label' => 'Englisch',
                             'name' => 'hrv',      
                             'width' => 100, 
                             'type' => 'text',
                             'dbfield' => 'fldsprache_zwei' ),
							 array ( 'label' => 'Lektion',
                             'name' => 'lektion', 
                             'getdefault' => 'true',
                             'width' => 5, 
                             'type' => 'select',
                             'dbtable' => 'tbllektion',
                             'seldbfield' => 'fldbez',
                             'dbfield' => 'fldlektion' ),
							 array ( 'label' => 'Sprache',
                             'name' => 'sprache', 
                             'getdefault' => 'true',
                             'width' => 5, 
                             'type' => 'select',
                             'dbtable' => 'tblsprache',
                             'seldbfield' => 'fldbez',
                             'dbfield' => 'fldfremdsprache' ),
                     array ( 'label' => 'Timestamp',
                             'name' => 'timestamp', 
                             'width' => 10, 
                             'type' => 'text',
                             'fieldhide' => 'true1',
                             'fieldsave' => 'NO',
                             'dbfield' => 'fldtimestamp' ));
							 

$filterarray = array ( 
                       array ( 'label' => 'Lektion:',
                             'name' => 'typ', 
                             'value' => '(ohne)',
                             'width' => 10, 
                             'type' => 'select',
                             'sign' => '=',
                             'dbtable' => 'tbllektion',
                             'seldbfield' => 'fldbez',
                             'dbfield' => 'fldlektion' ));
/*                             
                       array ( 'label' => 'Sprache:',
                             'name' => 'fltsprache', 
                             'value' => '(ohne)',
                             'width' => 10, 
                             'type' => 'select',
                             'sign' => '=',
                             'dbtable' => 'tblsprache',
                             'seldbfield' => 'fldbez',
                             'dbfield' => 'fldfremdsprache' ));
*/                             
							 
$pararray = array ( 'headline' => 'Vokabeln',
                    'muttersprache' => 'Deutsch',
                    'fremdsprache' => 'English',
                    'dbtable' => 'tblvokabeln',
                    'orderby' => 'fldlektion',
                    'strwhere' => 'fldfremdsprache="English"',
                    'fldindex' => 'fldindex');

?>