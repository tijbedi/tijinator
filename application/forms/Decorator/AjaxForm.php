<?php
/**
 * Ajax Form Decorator	
 * @author Kshitij Bedi
 * @copyright Zuova.com
 * @version 1.0
 * @package Forms
 */
class Zuova_Form_Decorator_AjaxForm extends Zend_Form_Decorator_Form 
{
  protected $_helper = "ajaxForm";

  protected $_jQueryParams = array();

  public function getOptions()
  {
    $options = parent::getOptions();
    if(isset($options['jQueryParams'])) {
      $this->_jQueryParams = $options['jQueryParams'];
      unset($options['jQueryParams']);
      unset($this->_options['jQueryParams']);
    }

    return $options;
  }

  /**
   * Render a form
   *
   * Replaces $content entirely from currently set element.
   *
   * @param string $content
   * @return string
   */
  public function render($content)
  {
    $form  = $this->getElement();
    $view  = $form->getView();
    if (null === $view) {
      return $content;
    }

    $helper    = $this->getHelper();
    $attribs    = $this->getOptions();
    $name     = $form->getFullyQualifiedName();
    $attribs['id'] = $form->getId();
    return $view->$helper($name, $attribs, $content, $this->_jQueryParams);
  }
}