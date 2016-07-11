<?php
class Application_Form_Doador extends Zend_Form
{

    public function init()
    {
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
    }

    public function __construct($options = null, Zend_Db_Table_Row $doador = null)
    {
        parent::__construct($options);

        $this->setName('doador')
             ->setMethod('post')
             ->setAttribs(array('id'=>'formularioDoador', 'action'=> '/doador/cadastrar', 'class'=>'form-horizontal'))
             ->removeDecorator('HtmlTag')
        ;

        $id_doador = new Zend_Form_Element_Hidden('id_doador');
        $id_doador->setValue($doador->id_doador)
                   ->removeDecorator('label')
                   ->removeDecorator('HtmlTag')
        ;

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome completo')
             ->setValue($doador->nome);
        $nome->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) ),
        ))
        ;

        $telefone = new Zend_Form_Element_Text('telefone');
        $telefone->setLabel('Telefone')
                 ->setValue($doador->telefone)
                 ->setRequired(false);
        $telefone->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $valor = new Zend_Form_Element_Text('valor');
        $valor->setLabel('Valor OI')
              ->setValue($doador->valor)
              ->addValidators(array(new Zend_Validate_CampoAuxiliarNotEmpty(array('telefone'))));
        $valor->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $cpf = new Zend_Form_Element_Text('cpf');
        $cpf->setLabel('CPF')
            ->setValue($doador->cpf);
        $cpf->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $cnpj = new Zend_Form_Element_Text('cnpj');
        $cnpj->setLabel('CNPJ')
             ->setValue($doador->cnpj);
        $cnpj->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;
        
        $valorCelesc = new Zend_Form_Element_Text('valor_celesc');
        $valorCelesc->setLabel('Valor Celesc')
              ->setValue($doador->valor_celesc)
              ->addValidators(array(new Zend_Validate_CampoAuxiliarNotEmpty(array('cpf'))));
        $valorCelesc->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $celular = new Zend_Form_Element_Text('celular');
        $celular->setLabel('Celular')
                ->setValue($doador->celular);
        $celular->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail 22222')
              ->setValue($doador->email);
        $email->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;
        
        $tableEstado = new Application_Model_Table_Estado();
        $id_estado = ($doador->id_cidade) ? $doador->findParentRow('Application_Model_Table_Cidade')->id_estado : Application_Model_Estado::SANTA_CATARINA;

        $estado = new Zend_Form_Element_Select('estado');
		$estado->setLabel ('Estado');
		foreach ( $tableEstado->getAll() as $row ) {
			$estado->addMultiOption($row->id_estado, $row->nome );
		}
		$estado->setValue($id_estado)
		       ->setDecorators( array(
                    'ViewHelper',
                    'Errors',
                    array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
                    array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
                    array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $tableCidade = new Application_Model_Table_Cidade();
        $id_cidade = ($doador->id_cidade) ? $doador->findParentRow('Application_Model_Table_Cidade')->id_cidade : Application_Model_Cidade::FLORIANOPOLIS;

        $where = "id_estado = {$id_estado}";
        $cidades = $tableCidade->fetchAll($where);

        $cidade = new Zend_Form_Element_Select('cidade');
		$cidade->setLabel ('Cidade')
		          ->setRegisterInArrayValidator(false);
		foreach ( $cidades as $row ) {
			$cidade->addMultiOption($row->id_cidade, $row->nome );
		}
        $cidade->setValue($id_cidade)
                  ->setDecorators( array(
                    'ViewHelper',
                    'Errors',
                    array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
                    array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
                    array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $cep = new Zend_Form_Element_Text('cep');
        $cep->setLabel('CEP')
            ->setValue($doador->cep);
        $cep->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $endereco = new Zend_Form_Element_Text('endereco');
        $endereco->setLabel('Endereço completo')
                 ->setValue($doador->endereco);
        $endereco->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $rg = new Zend_Form_Element_Text('rg');
        $rg->setLabel('RG')
           ->setValue($doador->rg);
        $rg->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $banco = new Zend_Form_Element_Text('banco');
        $banco->setLabel('Banco')
              ->setValue($doador->banco);
        $banco->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $agencia = new Zend_Form_Element_Text('agencia');
        $agencia->setLabel('Agencia')
                ->setValue($doador->agencia);
        $agencia->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $conta = new Zend_Form_Element_Text('conta');
        $conta->setLabel('Conta')
              ->setValue($doador->conta);
        $conta->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;

        $observacao = new Zend_Form_Element_Textarea('observacao');
        $observacao->setLabel('Observação')
                   ->setValue($doador->observacao)
                   ->setAttrib('rows', 3);
        $observacao->setDecorators( array(
            'ViewHelper',
            'Errors',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class' => 'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) )
        ))
        ;
        
        $submit = ($doador->id_doador > 0) ? 'Atualizar' : 'Cadastrar';
        $cadastrar = new Zend_Form_Element_Submit($submit);
        $cadastrar->setDecorators(array(
            'ViewHelper',
            'Errors',
            array(array('wrapperField' => 'HtmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('placement' => 'prepend', 'class' => 'control-label')),
            array(array('wrapperAll' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group')),
        ));

        $cadastrar->removeDecorator('label')
                ->setAttrib('class', 'btn')
        ;

        $this->addElements(array(
            $id_doador,
            $nome,
            $telefone,
            $valor,
            $cpf,
            $cnpj,
            $valorCelesc,
            $celular,
            $email,
            $estado,
            $cidade,
            $cep,
            $endereco,
            $rg,
            $banco,
            $agencia,
            $conta,
            $observacao,
            $cadastrar
        ));

    }
}
