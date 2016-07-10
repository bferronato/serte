<?php

class Application_Model_CidadeMapper extends Application_Model_AbstractMapper {

    public function __construct()
    {
        $this->setModel("Cidade");
    }

    public function fetchAll($where = '1=1')
    {

        $table = $this->getDbTable();

        $order = array("nome ASC");

        $resultSet = $this->getDbTable()->fetchAll(
            $this->getDbTable()
                ->select()
                ->where($where)
                ->order($order)
        );

        $entries = array();

        foreach ($resultSet as $row) {
            $cidade = new Application_Model_Cidade();
            $cidade->setId_cidade($row->id_cidade);
            $cidade->setNome($row->nome);
            $cidade->setId_estado($row->id_estado);
            $entries[] = $cidade;
        }
        return $entries;

    }

}