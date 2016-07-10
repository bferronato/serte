<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	* Função faz a conexão com o banco de dados e registra a variável $db para
	* que ela esteja disponível em toda a aplicação.
	*/
	protected function _initConnection()
	{
	    /**
	     * Obtém os resources(recursos).
	     */
	    $db_adapter = getenv('DB_ADAPTER');
	    $params     = array(
                        'host'     => getenv('DB_HOST'),
                        'username' => getenv('DB_USERNAME'),
                        'password' => getenv('DB_PASSWORD'),
                        'dbname'   => getenv('DB_DBNAME'),
                        'charset'  => getenv('DB_CHARSET')
                    );
        

print_r($params);

	    try{

	        /**
	         * Este método carrega dinamicamente a classe adptadora
	         * usando Zend_Loader::loadClass().
	         */
	        $db = Zend_Db::factory($db_adapter, $params);

	        /**
	         * Este método retorna um objeto para a conexão representada por uma
	         * respectiva extensão de banco de dados.
	         */
	        $db->getConnection();

	        // Registra a $db para que se torne acessível em toda app
	        $registry = Zend_Registry::getInstance();
	        $registry->set('db', $db);

	     } catch( Zend_Exception $e) {
	         echo "Estamos sem conexão ao banco de dados neste momento. Tente mais tarde por favor.";
	         exit;
	     }

	}

    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Application',
            'basePath'  => APPLICATION_PATH,
            'resourceTypes' => array (
                'form' => array(
                    'path' => 'forms',
                    'namespace' => 'Form',
                ),
                'model' => array(
                    'path' => 'models',
                    'namespace' => 'Model',
                ),
            )
        ));
        
        return $autoloader;
    }

    protected function _initDb() {
    	$params = array(
                    'host'     => getenv('DB_HOST'),
                    'username' => getenv('DB_USERNAME'),
                    'password' => getenv('DB_PASSWORD'),
                    'dbname'   => getenv('DB_DBNAME'),
                    'charset'  => getenv('DB_CHARSET')
                  );
				        
        $resources = $this->getOption('resources');
        $db = Zend_Db::factory(getenv('DB_ADAPTER'), $params);
        $db->getConnection();
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        $frontend = array('lifetime' => 86400, 'automatic_serialization' => true);
        $cache = Zend_Cache::factory('Core', 'File', $frontend, array('cache_dir' => APPLICATION_PATH . '/../tmp', 'cache_file_umask' => 0755, 'cache_file_perm' => 0755));
        Zend_Db_Table::setDefaultMetadataCache($cache);
    }

    protected function _initHelpers() {
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/controllers/helpers');
    }

	/**
     * Init Paginator
     */
    protected function _initPaginator()
    {
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    }

}
