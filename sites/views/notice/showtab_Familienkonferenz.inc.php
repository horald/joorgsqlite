<?php

$listarray = array ( array ( 'label' => 'Nr',
                             'name' => 'nr',
                             'width' => 30, 
                             'type' => 'text',
                             'fieldprthide' => 'true',
                             'dbfield' => 'fldnr' ),
                     array ( 'label' => 'Datum',
                             'name' => 'datum', 
                             'width' => 100, 
                             'type' => 'date',
                             'inctime' => 'true',
                             'fieldprthide' => 'true1',
                             'dbfield' => 'flddatum' ),
                     array ( 'label' => 'Thema',
                             'name' => 'thema',
                             'width' => 200, 
                             'type' => 'text',
                             'linkfield' => 'fldlink',
                             'targetfield' => 'fldTarget',
                             'dbfield' => 'fldbez' ),
                     array ( 'label' => 'Bemerkung',
                             'name' => 'bemerk',
                             'width' => 300, 
                             'type' => 'textarea',
                             'fieldhide' => 'true1',
                             'dbfield' => 'fldbemerk' ),
                     array ( 'label' => 'Link',
                             'name' => 'link',
                             'fieldhide' => 'true',
                             'width' => 500, 
                             'type' => 'text',
                             'dbfield' => 'fldlink' ),
                     array ( 'label' => 'Target',
                             'name' => 'target',
                             'fieldhide' => 'true',
                             'width' => 50, 
                             'type' => 'text',
                             'dbfield' => 'fldTarget' ),
                     array ( 'label' => 'File',
                             'name' => 'file',
                             'width' => 500, 
                             'type' => 'text',
                             'fieldhide' => 'true',
                             'dbfield' => 'fldfilename' ),
                     array ( 'label' => 'Gruppe',
                             'name' => 'gruppe',
                             'width' => 20, 
                             'type' => 'selectid',
                             'getdefault' => 'true',
                             'dbtable' => 'tblgrperl',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'fieldprthide' => 'true',
                             'dbfield' => 'fldid_gruppe' ),
                     array ( 'label' => 'Status',
                             'name' => 'status',
                             'width' => 20, 
                             'type' => 'selectid',
                             'getdefault' => 'true',
                             'fieldhide' => 'true1',
                             'dbtable' => 'tblstatus',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'fieldprthide' => 'true',
                             'dbfield' => 'fldid_status' ),
                     array ( 'label' => '',
                             'width' => 5, 
                             'type' => 'icon',
                             'fieldprthide' => 'true',
                             'func' => 'pdffunc.php',
                             'dbfield' => 'icon-file' ));

$filterarray = array ( array ( 'label' => 'Gruppe:',
                             'name' => 'gruppe', 
                             'width' => 1, 
                             'type' => 'selectid',
                             'sign' => '=',
                             'dbtable' => 'tblgrperl',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'dbfield' => 'fldid_gruppe' ),
                     array ( 'label' => 'Status:',
                             'name' => 'fltstatus', 
                             'width' => 1, 
                             'type' => 'selectid',
                             'sign' => '=',
                             'dbtable' => 'tblstatus',
                             'seldbfield' => 'fldbez',
                             'seldbindex' => 'fldindex',
                             'dbfield' => 'fldid_status' ));

$pararray = array ( 'headline' => 'Notizen',
                    'dbtable' => 'tblnotiz',
                    'orderby' => 'flddatum',
                    'editonlogin1' => 'true',
                    'prtanzsp' => 1,
                    'strwhere' => "fldarchivdat='0000-00-00'",
                    'fldindex' => 'fldindex');

?>