<?php

class Application_Model_Cidade extends Application_Model_Abstract {

    protected $id_cidade;
    protected $nome;
    protected $id_estado;

    const FLORIANOPOLIS = 7920;

    public function __construct(array $options = null)
    {
        $this->setModel("Cidade");
        parent::__construct($options);
    }

    public function getId_cidade(){
        return $this->id_cidade;
    }

    public function setId_cidade($id_cidade){
        $this->id_cidade = $id_cidade;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getId_estado(){
        return $this->id_estado;
    }

    public function setId_estado($id_estado){
        $this->id_estado = $id_estado;
    }

}