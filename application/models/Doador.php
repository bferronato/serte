<?php

class Application_Model_Doador extends Application_Model_Abstract {

    protected $id_doador;
    protected $nome;
    protected $celular;
    protected $telefone;
    protected $valor;
    protected $valor_celesc;
    protected $codigo_unidade_consumidora;
    protected $comando_do_movimento;
    protected $doador;
    protected $cidade;
    protected $cep;
    protected $logradouro;
    protected $numero;
    protected $email;
    protected $cpf;
    protected $cnpj;
    protected $rg;
    protected $banco;
    protected $conta;
    protected $agencia;
    protected $observacao;

    public function __construct(array $options = null)
    {
        $this->setModel("Doador");
        parent::__construct($options);
    }

    public function getId_doador(){
        return $this->id_doador;
    }

    public function setId_doador($id_doador){
        $this->id_doador = $id_doador;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getCelular(){
        return $this->celular;
    }

    public function setCelular($celular){
        $this->celular = $celular;
    }

    public function getTelefone(){
        return $this->telefone;
    }

    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setValor($valor){
        $this->valor = $valor;
    }

    public function getValorCelesc(){
        return $this->valor_celesc;
    }

    public function setValorCelesc($valor_celesc){
        $this->valor_celesc = $valor_celesc;
    }
    
    public function getCodigoUnidadeConsumidora(){
        return $this->codigo_unidade_consumidora;
    }

    public function setCodigoUnidadeConsumidora($codigo_unidade_consumidora){
        $this->codigo_unidade_consumidora = $codigo_unidade_consumidora;
    }
    
    public function getComandoDoMovimento(){
        return $this->comando_do_movimento;
    }

    public function setComandoDoMovimento($comando_do_movimento){
        $this->comando_do_movimento = $comando_do_movimento;
    }

    public function getCidade(){
        return $this->cidade;
    }

    public function setCidade($cidade){
        $this->cidade = $cidade;
    }

    public function getCep(){
        return $this->cep;
    }

    public function setCep($cep){
        $this->cep = $cep;
    }

    public function getLogradouro(){
        return $this->logradouro;
    }

    public function setLogradouro($logradouro){
        $this->logradouro = $logradouro;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function setNumero($numero){
        $this->numero = $numero;
    }
    
    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setCpf($cpf){
        $this->cpf = $cpf;
    }

    public function getCnpj(){
        return $this->cnpj;
    }

    public function setCnpj($cnpj){
        $this->cnpj = $cnpj;
    }

    public function getRg(){
        return $this->rg;
    }

    public function setRg($rg){
        $this->rg = $rg;
    }

    public function getBanco(){
        return $this->banco;
    }

    public function setBanco($banco){
        $this->banco = $banco;
    }

    public function getConta(){
        return $this->conta;
    }

    public function setConta($conta){
        $this->conta = $conta;
    }

    public function getAgencia(){
        return $this->agencia;
    }

    public function setAgencia($agencia){
        $this->agencia = $agencia;
    }

    public function getObservacao(){
        return $this->observacao;
    }

    public function setObservacao($observacao){
        $this->observacao = $observacao;
    }

}