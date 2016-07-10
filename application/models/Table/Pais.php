<?php

class Application_Model_Table_Pais extends Zend_Db_Table_Abstract {

    protected $_name = 'pais';
    protected $_primary = 'id_pais';

    protected $_dependentTables = array('Application_Model_Table_Estado');

}