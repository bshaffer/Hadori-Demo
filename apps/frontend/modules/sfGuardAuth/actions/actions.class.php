<?php

include_once sfConfig::get('sf_plugins_dir') .'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php';

/**
* sfGuardAuth actions
*/
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executeSignin(sfWebRequest $request)
  {
    if ($request->isMethod('post')) {
      $creds = $request->getParameter('signin');
      
      if (isset($creds['password']) && $creds['password'] == '1lksjdfKDJF') {
        return $this->renderText('Nice try, A-hole');
      }
    }
    
    return parent::executeSignin($request);
  }
}
