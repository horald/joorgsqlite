<?php
$listarray = array ( 
                     array ( 'label' => 'Anzahl',
                             'name' => 'anz',
                             'default' => '1',
                             'getdefault' => 'true',
                             'width' => 50, 
                             'type' => 'calc',
                             'calcidx' => '1',
                             'dbfield' => 'fldAnz' ), 
                     array ( 'label' => 'Bezeichnung',
                             'name' => 'bez',
                             'width' => 50, 
                             'type' => 'text',
                             'dbfield' => 'fldbez' ),
                     array ( 'label' => 'Gepaeck',
                             'name' => 'gepaeck',
                             'getdefault' => 'true',
                             'width' => 20, 
                             'type' => 'selectid',
                             'dbtable' => 'tblgepaeck',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'dbfield' => 'fldid_gepaeck' ),
                     array ( 'label' => 'Gewicht KG',
                             'name' => 'gewicht', 
                             'width' => 10, 
                             'type' => 'text',
                             'dbfield' => 'fldgewicht' ),
                     array ( 'label' => 'Gesamt',
                             'name' => 'gesamt', 
                             'width' => 10, 
                             'type' => 'calc',
                             'calcfield' => 'fldAnz',
                             'calcidx' => '2',
                             'fieldsave' => 'NO',
                             'dbfield' => 'fldgewicht' ),
                     array ( 'label' => 'Status',
                             'name' => 'status',
                             'getdefault' => 'true', 
                             'width' => 10, 
                             'type' => 'select',
                             'dbtable' => 'tblstatus',
                             'seldbfield' => 'fldbez',
                             'dbfield' => 'fldstatus' ),
                     array ( 'label' => 'Benutzer',
                             'name' => 'benutzer',
                             'getdefault' => 'true',
                             'width' => 20, 
                             'type' => 'selectid',
                             'dbtable' => 'tblbenutzer',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'dbfield' => 'fldid_benutzer' ));


$filterarray = array ( array ( 'label' => 'Benutzer:',
                             'name' => 'benutzer', 
                             'width' => 10, 
                             'type' => 'selectid',
                             'sign' => '=',
                             'dbtable' => 'tblbenutzer',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'dbfield' => 'fldid_benutzer' ),
                      array ( 'label' => 'Gepaeck:',
                             'name' => 'gepaeck', 
                             'width' => 10, 
                             'type' => 'selectid',
                             'sign' => '=',
                             'dbtable' => 'tblgepaeck',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'dbfield' => 'fldid_gepaeck' ),
                      array ( 'label' => 'Status:',
                             'name' => 'status', 
                             'addfunc' => 'true',
                             'funcsetstatus' => 'true',
                             'width' => 10, 
                             'type' => 'select',
                             'sign' => '=',
                             'dbtable' => 'tblstatus',
                             'seldbfield' => 'fldbez',
                             'dbfield' => 'fldstatus' ));

$pararray = array ( 'headline' => 'Gepackliste',
                    'dbtable' => 'tbltc_reiseliste',
                    'orderby' => 'fldid_gepaeck,fldid_benutzer,upper(fldbez)',
                    'strwhere' => "",
                    'fldindex' => 'fldindex',
//                    'markbgcolor' => '88ff88',
//                    'ummarkbgcolor' => 'ffffff',
                    'markyes' => 'OK',
                    'markno' => 'offen',
                    'marksign' => '=',
                    'markfield' => 'fldstatus');
?>