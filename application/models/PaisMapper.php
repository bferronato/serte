<?php

//class Application_Model_PaisMapper extends Application_Model_AbstractMapper {
//
//    public function __construct()
//    {
//        $this->setModel("Pais");
//    }
//
//    public function fetchAll($where = '')
//    {
//
//        $table = $this->getDbTable();
//
//        $order = array("nome ASC");
//
//        $resultSet = $this->getDbTable()->fetchAll(
//            $this->getDbTable()
//                ->select()
//                ->where($where)
//                ->order('nome ASC')
//        );
//
//        $entries   = array();
//
//        foreach ($resultSet as $row) {
//            $pais = new Application_Model_Pais();
//            $pais->setId_estado($row->id_pais);
//            $pais->setNome($row->nome);
//            $entries[] = $pais;
//        }
//        return $entries;
//
//    }
//
//}