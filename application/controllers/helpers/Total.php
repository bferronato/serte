<?php

class Zend_Controller_Action_Helper_Total extends Zend_Controller_Action_Helper_Abstract {

    function atualizar() {
        $total = new Zend_Session_Namespace('Total');

        $tableDoador = new Application_Model_Table_Doador();
        $doadores = $tableDoador->fetchAll();

        $total->doadores = count($doadores);

        return $total;
    }

}