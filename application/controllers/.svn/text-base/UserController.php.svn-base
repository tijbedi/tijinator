<?php
/**
 * User / Authentication / ACL controller
 * @package Controllers
 * @todo	ACL functionality to be added.
 * @author 	KBedi
 * @version	1.0
 */
class UserController extends Zend_Controller_Action
{
	var $_db;
	protected $zuova_session;
	
	/**
	 * Pre Dispatch method
	 *
	 */
	public function preDispatch()
	{
	
		$registry = Zend_Registry::getInstance();
		$this->_db = $registry->get("dbAdapter");
    	$this->zuova_session = new Zend_Session_Namespace('zuova_session');
	}
	
	/**
	 * Login Form 
	 *
	 */
	function loginAction()
	{
		//Message Form
		$this->form = new LoginForm();		
		$this->form->addPrefixPath('Zuova_Form_Decorator', Zuova_Bootstrap::$config->site->realpath.'/forms/Decorator' , 'decorator');
		$this->form->removeDecorator('Form');
		$this->form->addDecorator('AjaxForm', array(
								  'jQueryParams' => array(
								    'beforeSubmit' => 'showRequest',  // pre-submit callback 
									'success' => 'showResponse', //post-submit 
									'clearForm' => false,
								   ),
								));
		//$this->form->getElement("decision")->setValue($this->_debate->id);
		$this->form->getElement('username')->setValue("Username ...");
		$this->form->getElement('password')->setValue("test");
		$this->form->getElement('decision')->setValue($this->getRequest()->getParam("decision"));
		
		$this->view->form = $this->form;
		$this->view->jQuery()->addJavascript(' 
							//pre-submit callback 
							function showRequest(formData, jqForm, options){ 
								/*
								(var queryString = $.param(formData); 
								alert("About to submit: \n\n" + queryString);
								*/ 
								return true;
							}
							
                            
                            
                            //post-submit callback 
                            function showResponse(responseText, statusText)
                            {
                            	var responseObj = eval ("(" + responseText + ")");
                            	if(responseObj.result == false)
                            	{                          	
                               		$("#post_message_result").fadeIn(1000);
                                	$("#post_message_result").text(responseObj.message);
                                	$("#post_message_result").fadeOut(7000);
                                }
                                else
                                {
                                	window.location.href="/";
                                }
                            }');
		
		$this->view->addHelperPath("/View/Helper", "Zend_View_Helper");
		
		$this->_helper->layout()->setLayout("plain-js");
	}
	
    /**
     * Login Action to authenticate Request or Show Login Form
     * Sets up Zend Session
     * 
     * @return void
     */
	public function authenticateAction()
	{	
	    $this->_helper->layout()->setLayout("plain");
		$this->_helper->viewRenderer->setNoRender();
		
		if (Zend_Auth::getInstance()->hasIdentity())
		{
            $this->_redirect('/');
        }
        
		$request = $this->getRequest();
		$logger = Zend_Registry::getInstance()->logger;
		
        // check to see if this action has been POST'ed to
        if ($this->getRequest()->getParam('username') != "")
        {		
        	try{	
                 // do the authentication                 
				$request = $this->getRequest();
				$username = $request->getParam('username');
				$password = $request->getParam('password');
				$decision = $request->getParam("decision");
				
				$this->zuova_session->decision = $decision;
				
                // Configure the instance
				$auth = new Zend_Auth_Adapter_DbTable(
									    $this->_db,
									    'user',
									    'email',
									    'password'
									);                             
				$auth->setIdentity($username)
					 ->setCredential($password);				
						    
                $result = $auth->authenticate();
				
                if($result->isValid())
                {
                	Zend_Auth::getInstance()->getStorage()->write($auth->getResultRowObject());
                	echo json_encode(array("result" => $auth->getResultRowObject(array("firstname","lastname","email","id"),array("password"))));
                }
                else 
                {
					echo json_encode(
						array(
						"result" => $auth->getResultRowObject(array("firstname","lastname","email","id"),array("password")),
						"message" =>  $this->view->translate("Invalid Username or Password"),
						)
					);
                }
        	}
        	catch (Zend_Auth_Exception $e)
        	{
        		//echo $e->getMessage();
        	}
        }

	}

	/**
     * Log user out, and end session  redirect to homepage
     * @return void
     */
	function logoutAction()
    {
    	//Get user info before logout for logging
    	$user = Zend_Auth::getInstance()->getStorage()->read();
    	
    	//Log user out
        Zend_Auth::getInstance()->clearIdentity();
        
        //Logging
        //$logger = Zend_Registry::getInstance()->logger;
        //$logger->log($user['uid'][0]." Logout success.", Zend_Log::WARN);
        
        //Redirect to home
        $this->_redirect('/');
    }
    
    /**
     * Signup form
     *
     */
    function signupAction()
    {
    	$this->_helper->layout()->setLayout("plain");
    	$this->view->userForm = $this->_getUserCreateForm();
    }

    /**
     * Get Login Form
     * @return Zend_Form
     */
    protected function _getLoginForm()
    {
        //require_once APPLICATION_PATH . '/forms/Login.php';
        $form = new Form_Login();
        $form->setAction($this->_helper->url('login'));
        return $form;
    }
    
    /**
     * Create User Form
     *
     */
    protected function _getUserCreateForm()
    {
        $form = new SignupForm();
        $form->setAction($this->_helper->url('createuser'));
        return $form;    	
    }
}
