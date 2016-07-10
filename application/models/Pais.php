<?php

class Application_Model_Pais extends Application_Model_Abstract {

    protected $id_pais;
    protected $nome;

    const BRASIL = 1;

    public function __construct(array $options = null)
    {
        $this->setModel("Pais");
        parent::__construct($options);
    }

    public function getId_pais(){
        return $this->id_pais;
    }

    public function setId_pais($id_pais){
        $this->id_pais = $id_pais;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

}