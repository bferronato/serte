<?php

class DoadorController extends Zend_Controller_Action {

    protected $path = "/tmp/";

    public function init() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/auth/index');
        } else {
            $this->_helper->layout->setLayout('sistema');
        }
    }

    public function indexAction() {

        $busca = $this->getRequest()->getParam('busca');
        $doador = new Zend_Session_Namespace('Doador');

        $where = "1 = 1";
        $doador->busca = $busca;
        if (!empty($busca)) {
            $where = "nome like '%{$busca}%' or telefone like '%{$busca}%'";
        } else {
            $busca = $doador->busca;
        }
        
        $page = $this->_getParam('page', 1);

        $doadorModel = new Application_Model_Table_Doador();
        // Returns an instance of the class Zend_Db_Table_Select
        $doadores = $doadorModel->getAll(true, $where);

        // Returns a rowset
        // $users = $userModel->getAll();
        // First option to use Zend_Paginator_Adapter_DbTableSelect
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($doadores);
        // $adapter->setRowCount($customCount);
        $paginator = new Zend_Paginator($adapter);

        // Second option to use Zend_Paginator_Adapter_DbTableSelect
        // $paginator = new Zend_Paginator($users);
        // Note: You cannot customize the count in this option
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage(10);

        $this->view->busca = $busca;
        $this->view->assign('paginator', $paginator);
    }
    
    public function cadastrarAction()
    {
        $data = $this->_request->getPost();
        extract($data);
        
        if(!isset($tipo)) {
            $tipo = array();
        }
        
        $tableDoador = new Application_Model_Table_Doador();
        $tableEstado = new Application_Model_Table_Estado();
        $tableCidade = new Application_Model_Table_Cidade();
        
        if (isset($id_doador) && $id_doador > 0) {
            $this->view->titulo = 'Atualizar Doador';
            $this->view->message = 'atualizado';
            
            // Busca o doador do banco de dados
            $doador = $tableDoador->fetchRow("id_doador = {$id_doador}");
        } else {
            $this->view->titulo = 'Cadastrar Doador';
            $this->view->message = 'cadastrado';
            
            // Cria um novo doador
            $doador = $tableDoador->createRow();
        }
        
        $this->view->doador = $doador;
        
        // Busca os estados e define o selecionado
        $this->view->estados = $tableEstado->getAll();
        $this->view->id_estado = (isset($estado)) ? $estado : Application_Model_Estado::SANTA_CATARINA;

        // Busca as cidades do estado e define a cidade selecionada
        $where = "id_estado = {$this->view->id_estado}";
        $this->view->cidades = $tableCidade->fetchAll($where);
        $this->view->id_cidade = (isset($cidade)) ? $cidade : Application_Model_Cidade::FLORIANOPOLIS;
        
        /**
         * Valida o formulario de cadastro e edicao
         */
        if ($this->_request->isPost()) {

            $valor = str_replace('R$', '', str_replace(",", ".", str_replace(".", "", $valor)));
            $valor_celesc = str_replace('R$', '', str_replace(",", ".", str_replace(".", "", $valor_celesc)));
            
            // Limpa os dados referentes a doacao oi caso nao seja selecionado
            if(!in_array("doador-oi", $tipo)) {
                $valor = 0;
                $telefone = '';
            }
            
            // Limpa os dados referentes a doacao celesc caso nao seja selecionado
            if(!in_array("doador-celesc", $tipo)) {
                $codigo_unidade_consumidora = 0;
                $cpf = 0;
                $valor_celesc = 0;
            }
            
            $cidade = $tableCidade->find($cidade);

            $data = array(
                'id_doador' => $id_doador,
                'nome' => $nome,
                'celular' => $this->_helper->string->numeric($celular),
                'telefone' => $this->_helper->string->numeric($telefone),
                'valor' => floatval($valor),
                'valor_celesc' => floatval($valor_celesc),
                'codigo_unidade_consumidora' => $codigo_unidade_consumidora,
                'id_cidade' => $cidade->current()->id_cidade,
                'cep' => $this->_helper->string->numeric($cep),
                'logradouro' => $logradouro,
                'numero' => $numero,
                'email' => $email,
                'cpf' => $this->_helper->string->numeric($cpf),
                'cnpj' => $this->_helper->string->numeric($cnpj),
                'rg' => $rg,
                'banco' => $banco,
                'conta' => $conta,
                'agencia' => $agencia,
                'observacao' => $observacao,
                'tipo' => join(',', $tipo)
            );

            // Chama o metodo de validacao do forulario
            $error = $this->validaFormulario($data);
            
            // Seto os valores no objeto doador
            $doador->setFromArray($data);
            
            // Se nao houver erro salvo o registro
            if(count($error) === 0) {
                $this->save($doador);
            } else {
                // Preparo os valores para apresentacao em tela caso exista erro
                $data = array(
                    'valor' => new Zend_Currency(array('value' => $data['valor'])),
                    'valor_celesc' => new Zend_Currency(array('value' => $data['valor_celesc']))
                );
                
                // Seto os valores no objeto
                $doador->setFromArray($data);
                
                // Seta o doador para a view
                $this->view->doador = $doador;
                $this->view->error = $error;
            }
        }
        
        $this->view->action = '/doador/cadastrar';
        $this->view->form = $this->view->render('doador/form.phtml');
    }
    
    public function editarAction()
    {
        $data = $this->_request->getPost();
        
        extract($data);
        
        $id_doador = $this->_request->getParam('id_doador');
        $this->view->titulo = 'Atualizar Doador';

        if ($id_doador > 0) {

            $tableDoador = new Application_Model_Table_Doador();
            $tableEstado = new Application_Model_Table_Estado();
            $tableCidade = new Application_Model_Table_Cidade();

            $doador = $tableDoador->fetchRow("id_doador = {$id_doador}");
            // Seta o doador para a view
            $this->view->doador = $doador;
            
            // Busca os estados e define o selecionado
            $this->view->id_estado = (isset($estado)) ? $estado : $doador->findParentRow('Application_Model_Table_Cidade')->id_estado;
            $this->view->estados = $tableEstado->getAll();

            // Busca as cidades e define a selecionada com base no estado
            $this->view->id_cidade = (isset($cidade)) ? $cidade : $doador->findParentRow('Application_Model_Table_Cidade')->id_cidade;
            $this->view->cidades = $tableCidade->fetchAll();
            
        }
        
        $this->view->action = '/doador/cadastrar';
        $this->view->form = $this->view->render('doador/form.phtml');
    }
    
    private function validaFormulario($data)
    {
        $error = array();
        $tipos = array();
        
        if(empty($data['nome'])) {
            $error[] = 'Preencha o campo nome.';
        }
        
        if(isset($data['tipo'])) {
            $tipos = array_filter(explode(',', $data['tipo']));
        }
        
        if(count($tipos) == 0) {
            $error[] = 'Selecione o tipo de doador.';
        }
        
        // Valida os campos para o dodor OI
        if(in_array('doador-oi', $tipos)) {
            if(empty($data['telefone'])) {
                $error[] = 'Preencha o campo telefone.';
            }
            if(empty($data['valor'])) {
                $error[] = 'Preencha o valor de doação OI.';
            }
        }
        
        // Valida os campos para o doador Celesc
        if(in_array('doador-celesc', $tipos)) {
            if(empty($data['codigo_unidade_consumidora'])) {
                $error[] = 'Preencha o código da unidade consumidora.';
            }
            
            if(empty($data['cpf']) && empty($data['cnpj'])) {
                if(empty($data['cpf'])) {
                    $error[] = 'Preencha o CPF.';
                }
                if(empty($data['cnpj'])) {
                    $error[] = 'Preencha o CNPJ.';
                }
            }
            
            if(empty($data['valor_celesc'])) {
                $error[] = 'Preencha o valor de doação Celesc.';
            }
        }
        
        $cpfValido = $this->_helper->CPF->valido($data['cpf']);
        if(!$cpfValido) {
            $error[] = 'O CPF informado é inválido.';
        }

        return $error;
    }

    public function deleteAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $id_doador = $this->_getParam('id_doador', 0);
        if ($id_doador > 0) {
            try {
                $tableDoador = new Application_Model_Table_Doador();
                $doador = $tableDoador->fetchRow("id_doador = {$id_doador}");
                $doador->delete();

                $this->_helper->getHelper('Total')->atualizar();
                $this->_redirect('doador');
            } catch (Zend_Exception $e) {
                // MAIL ERROR LOG
                echo '<pre>';
                print_r($e);
            }
        } else {
            $this->_redirect('doador');
        }
    }

    function previsaoReceitaAction() {
        $doadorMapper = new Application_Model_DoadorMapper();
        
        $previsaoReceitaOi = $doadorMapper->previsaoReceitaOi();
        $previsaoReceitaCelesc = $doadorMapper->previsaoReceitaCelesc();
        $previsaoReceitaTotal = $previsaoReceitaOi + $previsaoReceitaCelesc;

        $this->view->previsaoReceitaOi = new Zend_Currency(array('value' => $previsaoReceitaOi));
        $this->view->previsaoReceitaCelesc = new Zend_Currency(array('value' => $previsaoReceitaCelesc));
        $this->view->previsaoReceitaTotal = new Zend_Currency(array('value' => $previsaoReceitaTotal));
    }
    
    private function save(Zend_Db_Table_Row $doador) {
        try {
            $doador->save();

            $this->_helper->getHelper('Total')->atualizar();
            $this->_helper->viewRenderer('save');
        } catch (Zend_Db_Exception $e) {
            echo "Erro ao salvar doador: " . get_class($e) . "\n";
            echo "Mensagem: " . $e->getMessage() . "\n";
        }
    }

}