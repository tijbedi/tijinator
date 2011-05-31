<?php
/**
 * User Signup Form	
 * @author Kshitij Bedi
 * @copyright Zuova.com
 * @version 1.0
 * @package Forms
 */
class SignupForm extends ZendX_JQuery_Form
{
	public function init()
	{
		try 
		{
			$this->setMethod('post');
			$this->setName('userForm');
			$this->setAction("/user/save");
			$this->setAttrib("id","createUserForm");
			
			/**
			 * $date1 = new ZendX_JQuery_Form_Element_DatePicker('date1',	array('label' => 'Date:'));
			 * $this->addElement($date1);
			 */
			
			$this->addElement("text","firstname",array("label"=>"Firstname:"));
			$this->addElement("text","lastname",array("label"=>"Lastname:"));
			$this->addElement("text","email",array("label"=>"Email Address:"));
            
			$captcha = new Zend_Form_Element_Captcha(
			        'captcha', // This is the name of the input field
			        array('label' => 'Write the chars to the field',
			        'captcha' => array( // Here comes the magic...
			        // First the type...
			        'captcha' => 'Image',
			        // Length of the word...
			        'wordLen' => 6,
			        // Captcha timeout, 5 mins
			        'timeout' => 300,
			        // What font to use...
			        'font' => 'arial.ttf',
			        // Where to put the image
			        'imgDir' => '/srv/www/htdocs/zuova/tmp',
			        // URL to the images
			        // This was bogus, here's how it should be... Sorry again :S
			        'imgUrl' => Zuova_Bootstrap::$config->site->captchaurl,
			)));
			
			// Add the captcha element to the form...
			$this->addElement($captcha)
			        ->addElement('submit','Create Account');
 		}
 		catch (Exception $e)
 		{
 			echo $e->getMessage();
 			
 		}
	}
}