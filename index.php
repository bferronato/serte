<?php

// Define path to root directory
defined('ROOT_PATH')
    || define('ROOT_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
define('APPLICATION_PATH', ROOT_PATH . '/application');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH . '/library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

date_default_timezone_set('America/Sao_Paulo');

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

die("ok22");

// Incluindo Action Helpers
Zend_Controller_Action_HelperBroker::addPath('./application/controllers/helpers');

// Registrando o Zend Translate
include_once APPLICATION_PATH . '/i18n/pt-br.php';
$translate = new Zend_Translate('array', $portugues, 'pt_BR');
Zend_Registry::set('translate', $translate );

$application->bootstrap()
            ->run();
