<?php

/**
 * errors actions.
 *
 * @package    vaco
 * @subpackage errors
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class defaultActions extends sfActions
{
  
  /**
   * Error page for page not found (404) error
   *
   */
  public function executeError404()
  {
    $this->getResponse()->setStatusCode(404, 'This page does not exist');
  }

  /**
   * Warning page for restricted area - requires login
   *
   */
  public function executeSecure()
  {
    $this->getResponse()->setStatusCode(403);
  }
}
