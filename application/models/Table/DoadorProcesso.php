<?php

class Application_Model_Table_DoadorProcesso extends Zend_Db_Table_Abstract {

    protected $_name = 'doador_processo';
    protected $_primary = array('id_doador','id_processo');

    protected $_referenceMap    = array(
        'Doador' => array(
            'columns'           => 'id_doador',
            'refTableClass'     => 'Application_Model_Table_Doador',
            'refColumns'        => 'id_doador'
        ),
        'Processo' => array(
            'columns'           => 'id_processo',
            'refTableClass'     => 'Application_Model_Table_Processo',
            'refColumns'        => 'id_processo'
        )
    );

}