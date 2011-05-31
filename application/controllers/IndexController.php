<?php
/**
 * Index Controller, this can also be refered to as the main controller as all default requests are passed 
 * @package Controllers
 * @author 	KBedi
 * @version	1.0
 * @todo 	Implement response types, currently static array
 */
class IndexController extends Zend_Controller_Action
{
	/** Private Debate **/
	public $debate;
	protected $form;
	protected $zuova_session;
	
	/**
	 * Predispatch Action, load JQuery & enable it for everything in this controller
	 *
	 */ 
	public function preDispatch()
	{
		$jquery = $this->view->jQuery();
		$jquery->enable(); // enable jQuery Core Library
		$this->zuova_session = new Zend_Session_Namespace('zuova_session');
	}
	
	/**
	 * Default action, almost everything is going to be routed from in here.
	 * 
	 * @return void
	 */
    public function indexAction()
    {
    	if(!Zend_Auth::getInstance()->hasIdentity())
		{		
			$this->_redirect("index/home");
			return;
        }
        
    	try 
    	{    		
			$this->view->baseUrl = $this->getFrontController()->getBaseUrl();

			//Get the url key		
	    	$urlKey = $this->getRequest()->getParam('urlkey');	
	    
	    	//Get Debates model
	    	$debate = $this->_getDebateModel();	
	    	
	    	//Convert to date object
			$urlDateKey = date('Y-m-d',strtotime($urlKey));	 
			
			//check if param is a date or not
			if($urlDateKey!="1969-12-31" && $urlKey !="")
			{	
				//Param was a date so find record by date
				$this->_debate = $debate->fetchEntryByDate($urlDateKey);
			}
			else 
			{
				$urlKey = "is-debating-good-or-bad";
				
				//param was text, check if a url key is defined
				$this->_debate = $debate->fetchEntryByUrlkey($urlKey);
			}			
	    	
			//Set view variables			
			$this->view->debate = $this->_debate;							
			$responses = new DbTable_Responses();			
			$select = $responses->select()->order("id Desc");			
			$this->view->responses = $this->_debate->findDependentRowset('DbTable_Responses',null,$select);		
			
			
			//Set page title			
			$this->view->headTitle()->setSeparator(' - ');
			
			//Set banner
			$this->view->headTitle()->prepend($this->_debate->question);
			
			//Response types
			$this->view->responseType = array(	"1" => "for",
											   	"2" => "against",
												"3" => "neutral"
											);	

			//Message Form
			$this->form = new JQueryForm();		
			$this->form->addPrefixPath('Zuova_Form_Decorator', Zuova_Bootstrap::$config->site->realpath.'/forms/Decorator' , 'decorator');
			$this->form->removeDecorator('Form');
			$this->form->addDecorator('AjaxForm', array(
									  'jQueryParams' => array(
									    'beforeSubmit' => 'showRequest',  // pre-submit callback 
										'success' => 'showResponse', //post-submit 
										'clearForm' => false,
									   ),
									));
			$this->form->getElement("debate")->setValue($this->_debate->id);	        
			
			$this->form->getElement("type")->setValue($this->zuova_session->decision);
			
			$this->view->form = $this->form;
			
			$this->view->jQuery()->addJavascript('// pre-submit callback 
													function showRequest(formData, jqForm, options){ 
													    // formData is an array; here we use $.param to convert it to a string to display it 
													    // but the form plugin does this for you automatically when it submits the data 
													    var queryString = $.param(formData); 
													 
													    // jqForm is a jQuery object encapsulating the form element.  To access the 
													    // DOM element for the form do this: 
													    // var formElement = jqForm[0]; 
													 
													    //alert("About to submit: \n\n" + queryString); 
													 
													    // here we could return false to prevent the form from being submitted; 
													    // returning anything other than false will allow the form submit to continue 
													    return true; 
													} 
													
													// post-submit callback 
													function showResponse(responseText, statusText){ 
													    // for normal html responses, the first argument to the success callback 
													    // is the XMLHttpRequest object"s responseText property 
													 
													    // if the ajaxSubmit method was passed an Options Object with the dataType 
													    // property set to "xml" then the first argument to the success callback 
													    // is the XMLHttpRequest object"s responseXML property 
													 
													    // if the ajaxSubmit method was passed an Options Object with the dataType 
													    // property set to "json" then the first argument to the success callback 
													    // is the json data object returned by the server 
													 
													    document.getElementById("comment").value ="";
													    
													   	$("#post_message_result").show();
													    $("#post_message_result").text("Your message was posted!");
													    $("#post_message_result").fadeOut(5000);

													    //alert("status: " + statusText + "\n\nresponseText: \n" + responseText + 
													    //    "\n\nThe output div should have already been updated with the responseText."); 
													}');
			
			$this->view->addHelperPath("/View/Helper", "Zend_View_Helper");
			
			$this->_helper->layout()->setLayout('debate');
    	}
    	
    	//Exception
    	catch (Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	
    	//Db Exception
    	catch (Zend_Db_Exception $e)
    	{
    		echo $e->getMessage();
    	}
    }
    
    
    /**
     * Get the actions that have not loaded on the users machine yet
     *
     * @return void
     */
    public function getmessagesAction()
    {
    	try 
    	{
	    	$this->_helper->layout()->setLayout('plain'); 
	    	
	 		$this->_debate = $this->_getDebateModel()->fetchEntry($this->getRequest()->getParam("debate"));
	 		
			//Response types
			$responseType = array(	"1" => "for",
								   	"2" => "against",
									"3" => "neutral"
								);
				    	
											
	    	$responses = new DbTable_Responses();			
			$select = $responses->select()->where("id > ?",$this->getRequest()->getParam("last_message"))
											->order("id Desc");
			$responses = $this->_debate->findDependentRowset('DbTable_Responses',null,$select);
			
			$i = 0;
			foreach ($responses as $response)
			{	
				$messages["messages"][$i]["messageid"] = $response->id;
				$messages["messages"][$i]["type"] = $responseType[$response->type]."Message";
				$messages["messages"][$i]["username"] = "The Tij";
				$messages["messages"][$i]["userid"] = $response->user;
				$messages["messages"][$i]["message"] = $response->message;
				$messages["messages"][$i]["date_created"] = date("M d, y h:i a",strtotime($response->date_created));
				$i++;
			}
			
			$this->view->json = json_encode($messages);
			
	    	$this->render();
    	}
    	
    	//General Exception
    	catch (Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	
    	//Db Exception
    	catch (Zend_Db_Exception $e)
    	{
    		echo $e->getMessage();
    	}
    }
    
    /**
     * Home page
     *
     */
    public function homeAction()
    {
		$this->view->baseUrl = $this->getFrontController()->getBaseUrl();
		
		//Get the url key		
		$urlKey = $this->getRequest()->getParam('urlkey');	
		
		//Get Debates model
		$debate = $this->_getDebateModel();	
		
		//Convert to date object
		$urlDateKey = date('Y-m-d',strtotime($urlKey));	 
		
		//check if param is a date or not
		if($urlDateKey!="1969-12-31" && $urlKey !="")
		{	
			//Param was a date so find record by date
			$this->_debate = $debate->fetchEntryByDate($urlDateKey);
		}
		else 
		{
			$urlKey = "is-debating-good-or-bad";
			//param was text, check if a url key is defined
			$this->_debate = $debate->fetchEntryByUrlkey($urlKey);
		}			
		
		//Set view variables			
		$this->view->debate = $this->_debate;							
		$responses = new DbTable_Responses();			
		$select = $responses->select()->order("id Desc");			
		$this->view->responses = $this->_debate->findDependentRowset('DbTable_Responses',null,$select);		
		
		
		//Set page title			
		$this->view->headTitle()->setSeparator(' - ');
		
		//Set banner
		$this->view->headTitle()->prepend($this->_debate->question);
		//Response types
		$this->view->responseType = array(	"1" => "for",
										   	"2" => "against",
											"3" => "neutral"
										);			
		$this->_helper->layout()->setLayout('debate-intro');   
		
		$this->view->addHelperPath("/View/Helper", "Zend_View_Helper");
		
    }
    
    /**
     * save response coming from request
     *
     */
    public function savecommentAction()
    {
    	$data = array();
    	
    	$data['message']= urldecode($this->getRequest()->getParam("comment"));
    	$data['debate'] = urldecode($this->getRequest()->getParam("debate"));
    	$data['type'] 	= urldecode($this->getRequest()->getParam("type"));    	
    	
    	echo $this->_getResponseModel()->save($data);
    	
    	$this->_helper->layout()->setLayout('plain'); 
    	$this->_helper->viewRenderer->setNoRender();
    }
    
    /**
     * Comment Form on the Nav Bar
     *
     */
    public function commentformAction()
    {
		
    }
    
    /**
     * get debates model
     *
     * @return model debate
     */
    protected function _getDebateModel()
    {
    	return new Debate();
    }
    
	/**
     * get Responses model
     *
     * @return model response
     */
    protected function _getResponseModel()
    {
    	return new Responses();
    }
    
}

?>