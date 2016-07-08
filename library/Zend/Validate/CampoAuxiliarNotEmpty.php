<?php
/*
 * Valida o preenchimento de outro campo quando o campo de valor for preenchido.
 * Filtro utilizado para a validacao dos campos de valor.
 */
class Zend_Validate_CampoAuxiliarNotEmpty extends Zend_Validate_Abstract {

    const EMPTYFIELD = 'isempty';

    protected $compareTo;
    protected $_messageTemplates = array(
        self::EMPTYFIELD => "É necessário preencher o campo %value%"
    );

    public function __construct($compareTo = '') {
        $this->compareTo = $compareTo;
    }

    public function isValid($value, $context = null) {
        
        $value = floatval(str_replace('R$', '', str_replace(",", ".", str_replace(".", "", $value))));

        if (!empty($value)) {
            foreach ($this->compareTo as $key => $campo) {
                if (false == isset($context[$campo]) || empty($context[$campo])) {
                    
                    $this->_setValue(ucfirst($campo));
                    
                    $this->_error(self::EMPTYFIELD);
                    return false;
                }
            }
        }

        return true;
    }

}
