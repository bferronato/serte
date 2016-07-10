<?php

class Application_Model_Table_Doador extends Zend_Db_Table_Abstract {

    /**
     * The default table name
     */
    protected $_name = 'doador';
    protected $_primary = 'id_doador';
    
    protected $_referenceMap = array(
        'Cidade' => array(
            'columns' => 'id_cidade',
            'refTableClass' => 'Application_Model_Table_Cidade',
            'refColumns' => 'id_cidade'
        )
    );

    public function getAll($paginate = false, $where = '1=1', $order = array('telefone asc')) {
        $select = $this->select()
                ->from($this->_name)
                ->where($where)
                ->order($order);

        return ($paginate) ? $select : $this->fetchAll($select);
    }

}