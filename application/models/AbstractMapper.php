<?php

abstract class Application_Model_AbstractMapper
{

    // liga o mapper à classe de tabela
    protected $_dbTable;
    // indica o nome da entidade (ex.: User), que é usado tanto no
    // modelo quanto na classe de tabela
    protected $_model;

    public function getDbTable()
    {
        if (null === $this->_dbTable)
        {
            $this->setDbTable("Application_Model_Table_".$this->getModel());
        }
        return $this->_dbTable;
    }

    public function getModel()
    {
        if (null === $this->_model)
        {
            // ok, eu sei que isso daria erro... mas é justamente para forçar o erro
            // para saber que faltou setar o modelo no mapper
            $this->setModel('Abstract');
        }
        return $this->_model;
    }

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable))
        {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract)
        {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }

}