<?php 
/**
 * @see Zend_Loader
 */
require_once 'Zend/Loader/Autoloader.php';


/**
 * Bootstrap
 * 
 * This class organize the Zend Framework bootstraping

 *
 * @see         
 * @version  1
 */
class Zuova_Bootstrap
{
	/**
	 * Stores the static instance of Front controller
	 *
	 * @var object  
	 */
    public static $frontController;
    
    /**
	 * Stores the static instance of Zend registry
	 *
	 * @var object
	 */
    public static $registry;
	
	/**
	 * Stores the Configaration file path
	 *
	 * @var object
	 */
    public static $configPath;
    
    /**
	 * Stores the Configaration
	 *
	 * @var object
	 */
    public static $config;
    
    /**
	 * Stores the Output Compression option
	 *
	 * @var boolean
	 */
    public static $output_compression;
    
    /**
	 * Log Queries in Firebud Console
	 *
	 * @var boolean
	 */
    public static $log_queries;
	    
    /**
	 * Start 
	 * 
	 * Starts the bootstrapping process by calling a number of interim
	 * functions and at the end, sends the response.
	 *
	 * @param  none
	 * @return void
	 */
    public static function start($configPath)
    {   
    	try 
    	{
    		ini_set("display_errors",1);
    		
	  		self::$configPath = $configPath;
	  			
			// Load Zend Loader
	    	$loader = Zend_Loader_Autoloader::getInstance();		
			$loader->registerNamespace("Zuova_");
			$loader->setFallbackAutoloader(true);
     	   	$loader->suppressNotFoundWarnings(false);
			
			$s = new Zend_Session_Namespace('Zuova');
	    	
	    	// Load the Configarations
	    	self::$config = new Zend_Config_Xml(self::$configPath, APPSTAGE);
	    	
			// Prepare your application
		    self::setupEnviroment();		    
	        self::prepare();
	        
	
	        // Send the response to the browser
	        $response = self::$frontController->dispatch();	    
	        self::sendResponse($response);
		}
    	catch (Exception $e)
    	{
		 	echo $e->getMessage();
    	}
    }
    

    /**
	 * Setup Environment 
	 *
	 * Setup application environment by specifying debug option, query logging, 
	 * output compression and  setting the time zone.
	 *
	 * @param  none
	 * @return void
	 */
    public static function setupEnviroment()
    {
    	// Get the environment settings
    	$environment = self::$config->environment;		
		
		// Setup error reporting
		if($environment->display_errors)
		{
			error_reporting(E_ALL ^ E_NOTICE);
			ini_set("display_errors",1);
			
		}
		else
		{
			error_reporting(E_NONE); 
		}
		
        // Setup other envoironmental configurations
        date_default_timezone_set($environment->default_timezone);
        self::$output_compression = (self::$config->enviroment->compress_output) ? true : false;
        self::$log_queries 		  = (self::$config->enviroment->log_queries)     ? true : false;
        
        // Setup loggin and debugging options
		// I am using Zend_Log_Writer_Firebug here, you can use your favorite method
        if(self::$config->enviroment->debug)
        {
        	$logger = new Zend_Log();
			$logger->addWriter(
				new Zend_Log_Writer_Firebug()
				);
			Zend_Registry::set('logger',$logger);
        }       
    }
    
    /**
	 * Prepare Application 
	 *
	 * Prepare the application by loading the required Zend libraries and 
	 * then calling other functions for their specific setup (Front controller,  View, Database etc.)
	 *
	 * @param  none
	 * @return void
	 */
    public static function prepare()
    {    	
    	try
    	{	
	    	// Start Zend_Session and set session to registry
	        Zend_Session::start();
	        Zend_Session::setOptions(self::$config->session->toArray());
			$session = new Zend_Session_Namespace(self::$config->session->name . '_' .APPSTAGE);
			Zend_Registry::set('Zend_Session', $session);
			
	        // Get Zend registry
	        self::$registry = Zend_Registry::getInstance();
			self::$registry->set('config',   self::$config); 
	        self::$registry->set('siteInfo', self::$config->site);
	        self::$registry->set('path', 	 self::$config->path);
	        // Add config values as you need
	        
	        // Setup front controller, view, database
	        self::setupFrontController();
	        self::setupDatabase();
	        self::setupRoutes();
	        self::setupView();
	        self::setupTranslation();
			
		}
    	catch (Exception $e)
    	{
		 	echo $e->getMessage();
    	}
	}
    

	/**
	 * Setup Front Controller
	 * 
	 * Get the instance of Zend front controller and then set a few basic
	 * options. Also specify the default controller path.
	 *
	 * @param  none
	 * @return void
	 */
    public static function setupFrontController()
    {
    	try 
    	{
			// Initialize and set the front controller options
	        self::$frontController = Zend_Controller_Front::getInstance();
	        self::$frontController->returnResponse(true);
	        self::$frontController->throwExceptions(true);
	        self::$frontController->addModuleDirectory(ROOT_DIR.'/modules');	        
	        self::$frontController->setControllerDirectory(ROOT_DIR.'/controllers');
	        self::$frontController->setBaseUrl(self::$config->site->baseurl);	    
		    self::$frontController->setDefaultControllerName('index'); 
    	}
    	catch (Exception $e)
    	{
		 	echo $e->getMessage();
    	}
    	
        // Register  required controller plugin
		//self::$frontController->registerPlugin(new My_Plugins_Abcde());	
				
    }
    

    /**
	 * Setup View
	 * 
	 * Get an instance of Zend view and set the unicode encoding. Then get the
	 * view renderer and set it as a view helper for further help.
	 *
	 * @param  none
	 * @return void
	 */
    public static function setupView()
    {
    	try 
    	{
    		
	    	$view = new Zend_View();
	    	$view->setEncoding('UTF-8');
			
			// Add additional view helpers and scripts path
			//$view->addHelperPath('path/of/My/View/Helper', 'My_View_Helper');
			//$view->addScriptPath('path/of/my/view/partials');
			
			$view->assign('appstage', APPSTAGE);
			//$view->assign('language', $session->language);
			
			// Set the layout options
			Zend_Layout::startMvc(array('layout' => 'main','layoutPath' => ROOT_DIR.'/layouts/'));
			
			
			$view = Zend_Layout::getMvcInstance()->getView();
			$view->doctype('XHTML1_TRANSITIONAL');
	    	$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
	    	
	    	$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
	    	$viewRenderer->setView($view);
	    	Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);	    	
    	}
    	catch (Exception $e)
    	{
		 	echo $e->getMessage();
    	}
    }
    

    public static function setupTranslation(){
		$options = array(
			'scan' => Zend_Translate::LOCALE_FILENAME,
			'disableNotices' => true,
		);
		$translate = new Zend_Translate('csv', self::$config->site->realpath . '/languages/en.csv', 'auto', $options);
		Zend_Registry::set('Zend_Translate', $translate);
	}
    
    /**
	 * Setup Database
	 * 
	 * Load the DB config and then store it
	 * in Zend registry. Afterwards, use it for connection to database and
	 * setting it as default adapter of Zend_Db_Table.
	 *
	 * @param  none
	 * @return void
	 */
    public static function setupDatabase()
    {
    	try
    	{
			// Collect database options from config and set up default database adapter
			$dbConfig = self::$config->database;    
			$db = Zend_Db::factory($dbConfig);
			Zend_Db_Table::setDefaultAdapter($db);
	    	self::$registry->set('dbAdapter', $db);
    	}
    	catch (Zend_Db_Exception $ze)
    	{
    		echo $ze->getMessage();
    	}
			
    	// Log all db queries if required
    	if(self::$log_queries)
    	{
			// I am using Zend_Db_Profiler_Firebug for loggin db queries, you can use anythig you want
    		$profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
			$profiler->setEnabled(true);
			$db->setProfiler($profiler);
    	}
    }
	

    /**
	 * Set Routes
	 * 
	 * Setup and manage all routings of appllication
	 *
	 * @param  none
	 * @return void
	 */
	public function setupRoutes()
	{
		$router = self::$frontController->getRouter();
		
		$route = new Zend_Controller_Router_Route(
		    "/:urlkey",		    
		    array(
		    	'urlkey' => '1969-12-31',
		        'controller' => 'index',
		        'action'     => 'index'
		    )
		);
		
		$router->addRoute("",$route);
		
		$route = new Zend_Controller_Router_Route_Static(
			'index/getmessages', array('controller' => 'index', 'action' => 'getmessages'),
			'index/saveresponse', array('controller' => 'index', 'action' => 'saveresponse')
		);
		
		$router->addRoute('index', $route);	
				
		$route = new Zend_Controller_Router_Route_Regex(
			'home/(\w+)',
			array(
					'controller' => 'index', 
					'action' => 'home'
				)
		);
		
		$router->addRoute('index', $route);	
	}
	
    
    /**
	 * Send Response
	 * 
	 * Receive the response object and set the unicode header before sending
	 * it to the output
	 *
	 * @param  object Zend_Controller_Response_Http
	 * @return void
	 */
	
    public static function sendResponse(Zend_Controller_Response_Http $response)
    {
    	if(self::$output_compression)
    	{
			/*
			* I am using php_speedy for output compression. You can use it or anything you like
			* @see My post about PHP_Speedy - http://www.ajaxray.com/blog/2008/12/26/php-speedy-yslow-optimization-frontend/
			*/
    		include 'path/of/php_speedy/php_speedy.php';
	    	$response->sendResponse();
	    	$compressor->finish();	
    	}
    	else 
    	{
    		$response->sendResponse();
    	}
    }
}
?>