<?php

class Zend_Controller_Action_Helper_String extends Zend_Controller_Action_Helper_Abstract
{

	function numeric($string)
	{
	    return preg_replace('#\W#', '', $string);
	}

}