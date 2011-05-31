<?php
/**
 * Ajax Form Helper
 *
 */
class Zend_View_Helper_AjaxForm extends Zend_View_Helper_Form
{
  /**
   * Contains reference to the jQuery view helper
   *
   * @var ZendX_JQuery_View_Helper_JQuery_Container
   */
  protected $jquery;

  /**
   * Set view and enable jQuery Core and UI libraries
   *
   * @param Zend_View_Interface $view
   * @return ZendX_JQuery_View_Helper_Widget
   */
  public function setView(Zend_View_Interface $view)
  {
    parent::setView($view);
    $this->jquery = $this->view->jQuery();
    $this->jquery->enable()
           ->uiEnable();
    return $this;
  }

  /**
   * Get Ajax form
   *
   * @param string $name
   * @param string $attribs
   * @param boolean $content
   * @param array $options
   * @return Zend_Form
   */
  public function ajaxForm($name, $attribs = null, $content = false, array $options=array())
  {
    $id = $name;
    if(isset($attribs['id'])) {
      $id = $attribs['id'];
    }

    if(!isset($options['clearForm'])) {
      $options['clearForm'] = true;
    }

    if(count($options) > 0) {
      require_once "Zend/Json.php";
      $jsonOptions = Zend_Json::encode($options);

      // Fix Callbacks if present
      if(isset($options['beforeSubmit'])) {
        $jsonOptions = str_replace('"beforeSubmit":"'.$options['beforeSubmit'].'"', '"beforeSubmit":'.$options['beforeSubmit'], $jsonOptions);
      }
      if(isset($options['success'])) {
        $jsonOptions = str_replace('"success":"'.$options['success'].'"', '"success":'.$options['success'], $jsonOptions);
      }
    } else {
      $jsonOptions = "{}";
    }

    $this->jquery->addOnLoad(sprintf(
      '$("#%s").ajaxForm(%s)', $id, $jsonOptions
    ));

    return parent::form($name, $attribs, $content);
  }
}
?>