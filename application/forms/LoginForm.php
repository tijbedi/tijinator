<?php
/**
 * Login Form	
 * @author Kshitij Bedi
 * @copyright Zuova.com
 * @version 1.0
 * @package Forms
 */
class LoginForm extends ZendX_JQuery_Form
{
    //Init form
    public function init ()
    {
        try {
            //Form setup
            $this->setMethod('post');
            $this->setName('loginForm');
            $this->setAction("/user/authenticate");
            $this->setAttrib("id", "loginForm");
            
            //Elements
            $username = $this->CreateElement('text', 'username' , array( 'class'=>'VeryBigInputBox floatLeft margin','onFocus'=>'if(this.value=="Username ..."){this.value="";}','onBlur'=>'if(this.value==""){this.value = "Username ...";}'));
            $username->setDecorators(
                        array(	'ViewHelper' , 
                        		'Description' , 
                        		'Errors' , 
                                array(
                                        array('data' => 'HtmlTag' ) , 
                                        array('tag' => 'div' ,'class'=>'floatLeftBox')
                                      ) ,
                                 
                                array(
                                		'Label' , 
                                        array('tag' => 'span' , 'class'=>'subhead')
                                ) ,
                                
                                array(
                                        array('row' => 'HtmlTag') , 
                                        array('tag' => 'div' , 'class'=>'login')
                                )
                            )
                        );
            $password = $this->CreateElement('password', 'password', array('class'=>'VeryBigInputBox floatLeft margin'));
            $password->setDecorators(
                        array(	'ViewHelper' , 
                        		'Description' , 
                        		'Errors' , 
                                array(
                                        array('data' => 'HtmlTag') , 
                                        array('tag' => 'div' ,'class'=>'floatRight')
                                      ) , 
                                /* 
                                array(
                                		'Label' , 
                                        array('tag' => 'div' , 'class'=>'login')
                                ) ,
                                */
                                array(
                                        array('row' => 'HtmlTag') , 
                                        array('tag' => 'div' , 'class'=>'login')
                                )
                            )
                        );
            
            //Submit Button
            $submitButton = $this->CreateElement('image', 'Login', array('src' => '/graphics/front-login-button.jpg'));            
            $submitButton->setDecorators(array('ViewHelper' , 
            							array(array('data' => 'HtmlTag') , 
            							array('tag' => 'div' , 'class' => 'loginButton')) , 
            							/*array( array('label' => 'HtmlTag') , array('tag' => 'div' , 'placement' => 'prepend')) , */ 
            							array(array('row' => 'HtmlTag') , 
            							array('tag' => 'div' ,'class'=>'clear floatLeft'),
            							)));
            
            $cancelButton = $this->CreateElement('button', 'Cancel', array('id' => 'cancel-button','onclick'=>'$("#homePage").hide();$("#homePagePicker").fadeIn(1000);','class'=>'button image cancel'));
            $cancelButton->setDecorators(array('ViewHelper' , array(array('data' => 'HtmlTag') , array('tag' => 'div' , 'class' => 'loginButton')) , /*array( array('label' => 'HtmlTag') , array('tag' => 'div' , 'placement' => 'prepend')) , */ array(array('row' => 'HtmlTag') , array('tag' => 'div' ,'class'=>'floatRight'))));
            
            //Add Elements to form
            $this->addElements(array($username , $password , $submitButton , $cancelButton));
            
            //Form formatting
            $this->setDecorators(array(
                'FormElements',
                array('HtmlTag', array('tag' => 'div')),
                'Form',
            ));
            //Hidden stuff
            $this->addElement("hidden", "decision", array('value' => 1));   

                
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}