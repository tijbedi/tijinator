<?php
/**
 * Main Comment Form	
 * @author Kshitij Bedi
 * @copyright Zuova.com
 * @version 1.0
 * @package Forms
 */
class JQueryForm extends ZendX_JQuery_Form
{

	public function init()
	{
		try 
		{
			$this->setMethod('post');
			$this->setName('commentForm');
			$this->setAction("/index/savecomment");
			$this->setAttrib("id","commentForm");
			
			/**
			 * $date1 = new ZendX_JQuery_Form_Element_DatePicker('date1',	array('label' => 'Date:'));
			 * $this->addElement($date1);
			 */
			$this->addElement("textarea","comment",array('cols' => '26', 'rows' => '5' ));
			$this->addElement("select","type",array('tag' => 'div', 'multiOptions' => array("1"=>"For","2"=>"Against")
			    			));
            
			// Using both captcha and captchaOptions:
			$element = new Zend_Form_Element_Captcha('foo', array(
			    'label' => "Please verify you're a human",
			    'captcha' => 'Figlet',
			    'captchaOptions' => array(
			        'captcha' => 'Figlet',
			        'wordLen' => 6,
			        'timeout' => 300,
			    ),
			));
			
			//$this->addElement($element);
			
			$this->addElement('submit', 'Post it', array(
								'src' => '/graphics/button-background.png'
								)
							);
			
			$this->addElement("hidden","debate",array('value' => 1));
 		}
 		catch (Exception $e)
 		{
 			echo $e->getMessage();
 			
 		}

	}

}