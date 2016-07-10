<?php

class Application_Model_Table_Cidade extends Zend_Db_Table_Abstract {

    protected $_name = 'cidade';
    protected $_primary = 'id_cidade';

    protected $_dependentTables = array('Application_Model_Table_Doador');

    protected $_referenceMap    = array(
        'Estado' => array(
            'columns'           => 'id_estado',
            'refTableClass'     => 'Application_Model_Table_Estado',
            'refColumns'        => 'id_estado'
        )
    );
}