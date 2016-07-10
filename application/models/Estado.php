<?php

class Application_Model_Estado extends Application_Model_Abstract {

    protected $id_estado;
    protected $nome;
    protected $sigla;
    protected $id_pais;

    const SANTA_CATARINA = 24;

    public function __construct(array $options = null)
    {
        $this->setModel("Estado");
        parent::__construct($options);
    }

    public function getId_estado(){
        return $this->id_estado;
    }

    public function setId_estado($id_estado){
        $this->id_estado = $id_estado;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getSigla(){
        return $this->sigla;
    }

    public function setSigla($sigla){
        $this->sigla = $sigla;
    }

    public function getId_pais(){
        return $this->id_pais;
    }

    public function setId_pais($id_pais){
        $this->id_pais = $id_pais;
    }

}