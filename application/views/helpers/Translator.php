<?php
/**
 *
 * @author Kshitij
 * @version 
 */

/**
 * Translator helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Translator extends Zend_View_Helper_Abstract {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	public function __tt($text)
	{
		//Does nothing for now but will be reserved for Translation
		return $text;
	}
	
	/**
	 *  
	 */
	public function translator() {
		// TODO Auto-generated Zend_View_Helper_Translator::translator() helper 
		return null;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
