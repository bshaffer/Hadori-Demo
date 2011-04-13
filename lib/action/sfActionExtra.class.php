<?php

/**
* 
*/
class sfActionExtra
{
  public static function observeMethodNotFound(sfEvent $event)
  {
    if (method_exists('sfActionExtra', $event['method'])) 
    {
      $args = array_merge(array($event->getSubject()), $event['arguments']);

      $ret = call_user_func_array(array('sfActionExtra', $event['method']), $args);
      
      $event->setReturnValue($ret);
      
      return $ret;
    }
  }
  
  public static function forward403($action)
  {
    $action->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    throw new sfStopException();
  }
  
  public static function forward403Unless($action, $bool)
  {
    if (!$bool) 
    {
      $action->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

      throw new sfStopException();
    }
    
    return true;
  }
  
  protected static function getReferer($action, $default = '@homepage')
  {
    $referer = $action->getUser()->getReferer($action->getRequest()->getReferer());

    $referer =  $referer && $referer != $action->getRequest()->getUri() ? $referer : $default;
    
    return $referer;
  }
}
