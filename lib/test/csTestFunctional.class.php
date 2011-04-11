<?php

/**
* Functional test for testing forms
*/
class csTestFunctional extends sfTestFunctional
{
  public function isModuleAction($module, $action, $statusCode = 200)
  {
    $this->with('request')->begin()->
  	  isParameter('module', $module)->
  	  isParameter('action', $action)->
  	end()->  

    with('response')->begin()->
    	isStatusCode($statusCode)->
    end();

    return $this;
  }

  public function login($username = null, $password = null, $debug = false)
  {
    if ($username instanceof sfGuardUser) 
    {
      $username = $username['username'];
      $password = $password ? $password : cfitFactory::DEFAULT_PASSWORD;
    }
    elseif($username == null)
    {
      $username = 'admin';
      $password = 'Client2009';
    }
    
    $this
      ->info(sprintf('Logging in with %s/%s ', $username, $password))
      ->get('/login')
      ->setField('signin[username]', $username)
      ->setField('signin[password]', $password)
      ->click('sign in');
      
    if ($debug) 
    {
      $this->with('response')->begin()
        ->debug()
      ->end();
    }
    
    return $this->followRedirect();
  }
  
  public function logout()
  {
    return $this
      ->get('/logout')
      
      ->followRedirect()
      
      ->with('user')->begin()
        ->isAuthenticated(false)
      ->end()
    ;
  }

  /**
   * setFieldsWithValues - pass a nested array of form fields to values.  Useful
   * when importing from YAML or for organizational purposes when setting a lot 
   * of form fields
   *
   * ex: $browser
   *        ->setFieldsWithValues(array(
   *            'sf_guard_user' => array(
   *              'username' => 'JohnArbuckle', 
   *              'password' => 'garfield')));
   *
   * @param array $fields 
   * @param string $prefix 
   * @return void
   * @author Brent Shaffer
   */
  public function setFieldsWithValues(array $fields, $prefix = '')
  {
    foreach ($fields as $field => $value) 
    {
      $name = $prefix ? sprintf('%s[%s]', $prefix, $field) : $field;
      
      if (is_array($value)) 
      {
        $this->setFieldsWithValues($value, $name);
      }
      else
      {
        $this->setField($name, $value);
      }
    }
    
    return $this;
  }
}