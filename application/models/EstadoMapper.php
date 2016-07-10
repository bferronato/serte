<?php

//class Application_Model_EstadoMapper extends Application_Model_AbstractMapper {
//
//    public function __construct()
//    {
//        $this->setModel("Estado");
//    }
//
//    public function fetchAll($where = '1=1')
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
//                ->order($order)
//        );
//
//        $entries = array();
//
//        foreach ($resultSet as $row) {
//            $estado = new Application_Model_Estado();
//            $estado->setId_estado($row->id_estado);
//            $estado->setNome($row->nome);
//            $estado->setSigla($row->sigla);
//            $estado->setId_pais($row->id_pais);
//            $entries[] = $estado;
//        }
//        return $entries;
//
//    }
//
//}