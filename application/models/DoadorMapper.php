<?php

class Application_Model_DoadorMapper extends Application_Model_AbstractMapper {

    public function __construct()
    {
        $this->setModel("Doador");
    }

    public function previsaoReceitaOi($where = '1=1', $order = array('nome asc'))
    {
        $table = $this->getDbTable();

        $resultSet = $this->getDbTable()->fetchAll(
            $this->getDbTable()
                  ->select()
                  ->from($table, array('sum(valor) as total'))
        );

        $previsaoReceita = 0;

        foreach ($resultSet as $row) {
            $previsaoReceita = $row->total;
        }

        return $previsaoReceita;

    }

    public function previsaoReceitaCelesc($where = '1=1', $order = array('nome asc'))
    {
        $table = $this->getDbTable();

        $resultSet = $this->getDbTable()->fetchAll(
            $this->getDbTable()
                  ->select()
                  ->from($table, array('sum(valor_celesc) as total'))
        );

        $previsaoReceita = 0;

        foreach ($resultSet as $row) {
            $previsaoReceita = $row->total;
        }

        return $previsaoReceita;

    }
}