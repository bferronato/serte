<?php

class Application_Model_Table_Estado extends Zend_Db_Table_Abstract {

    protected $_name = 'estado';
    protected $_primary = 'id_estado';

    protected $_dependentTables = array('Application_Model_Table_Cidade');

    protected $_referenceMap    = array(
        'Pais' => array(
            'columns'           => 'id_pais',
            'refTableClass'     => 'Application_Model_Table_Pais',
            'refColumns'        => 'id_pais'
        )
    );

    public function getAll($paginate = false, $where = '1=1', $order = array('nome asc')) {
        $select = $this->select()
                       ->from($this->_name)
                       ->where($where)
                       ->order($order);

        return ($paginate) ? $select : $this->fetchAll($select);
    }
}