<?php

/**
 * sfGuardUser form.
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $this->useFields(array(
      'first_name', 
      'last_name', 
      'email_address', 
      'is_active',
      'username',
      'password',
    ));
    
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));

  }
}
