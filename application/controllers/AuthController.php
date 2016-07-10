<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout ( 'site' );
    }

    public function indexAction()
    {
        $this->render('index');
    }

    public function loginAction()
    {

        if (!$this->getRequest()->isPost()) {
            return $this->_forward('index');
        }

        $data = $this->_request->getParams();
        $errors = $this->validaForm($data);

        if(empty($errors)) {

            $email = $data['email'];
            $senha = $data['senha'];

            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            //Inicia o adaptador Zend_Auth para banco de dados
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
            $authAdapter->setTableName('admin')
                        ->setIdentityColumn('email')
                        ->setCredentialColumn('senha')
                        ->setCredentialTreatment('MD5(?)');
            //Define os dados para processar o login

            $authAdapter->setIdentity($email)
                        ->setCredential($senha);

            //Efetua o login
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($authAdapter);
            //Verifica se o login foi efetuado com sucesso

            if ( $result->isValid() ) {
                //Armazena os dados do usuário em sessão, apenas desconsiderando
                //a senha do usuário

                $this->_helper->getHelper('Total')->atualizar();

                $info = $authAdapter->getResultRowObject(null, 'senha');
                $storage = $auth->getStorage();
                $storage->write($info);
                //Redireciona para o Controller protegido
                return $this->_helper->redirector->goToRoute( array('controller' => 'doador'), null, true);
            } else {
                $this->view->message = 'E-mail e/ou senha incorretos.';
                return $this->render('index');
            }
        } else {
            $this->view->message = 'E-mail e/ou senha incorretos.';
            $this->render('index');
        }

    }

    private function validaForm($values)
    {
        $errors = array();

        $email = $values['email'];
        $senha = $values['senha'];

        if(empty($email)) {
            $errors[] = "Preencha o e-mail";
        }

        if(empty($senha)) {
            $errors[] = "Preencha a senha";
        }

        return $errors;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/auth/index');
    }

}

