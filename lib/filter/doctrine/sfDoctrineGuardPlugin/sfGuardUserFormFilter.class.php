<?php

/**
 * sfGuardUser filter form.
 *
 * @package    skeleton
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserFormFilter extends PluginsfGuardUserFormFilter
{
  public function configure()
  {
    $this->useFields(array(
      'first_name',
      'last_name',
      'email_address',
      'username',
      'is_active',
      'is_super_admin',
      'created_at',
      'last_login',
    ));
  }
}
