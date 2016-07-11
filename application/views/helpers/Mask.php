<?php

class Zend_View_Helper_Mask extends Zend_View_Helper_Abstract
{
    const FONE = '(##)####-####';
    const CPF = '###.###.###-##';
    const CEP = '#####-###';
    const CNPJ = '##.###.###/####-##';

    public function mask($mask, $str)
	{
		$mask = $this->getMask($mask);
	
		if(!$str) $mask = $str;
	
		$str = str_replace(" ", "", $str);
		for($i = 0; $i < strlen($str); $i++) {
			$mask[strpos($mask, "#")] = $str[$i];
		}
		return $mask;
	}
	
	private function getMask($mask)
	{
		switch($mask) {
			case 'FONE':
				$mask = Zend_View_Helper_Mask::FONE;
			break;
			case 'CPF':
				$mask = Zend_View_Helper_Mask::CPF;
			break;
			case 'CEP':
				$mask = Zend_View_Helper_Mask::CEP;
			break;
			case 'CNPJ':
				$mask = Zend_View_Helper_Mask::CNPJ;
			break;
		}
	
		return $mask;
	}

}
