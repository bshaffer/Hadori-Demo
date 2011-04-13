<?php

/**
 * sf_guard_user actions.
 *
 * @package    skeleton
 * @subpackage sf_guard_user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sf_guard_userActions extends autoSf_guard_userActions
{
  public function executeToggleAssistantStatus(sfWebRequest $request)
  {
    $user = $this->getRoute()->getObject();
    $assistantPermission = Doctrine_Core::getTable('sfGuardPermission')->findOneByName('assistant');

    if ($user->hasPermission('assistant')) {
      Doctrine_Core::getTable('sfGuardUserPermission')
        ->createQuery()
        ->delete()
        ->where('permission_id = ?', $assistantPermission['id'])
        ->andWhere('user_id = ?', $user['id'])
        ->execute();

      $this->getUser()->setFlash('notice', sprintf('user %s has been demoted from assistant', $user));
    }
    else{
      $user['Permissions'][] = $assistantPermission;
      $user->save();
      $this->getUser()->setFlash('notice', sprintf('user %s is now an assistant', $user));
    }

    $this->redirect($this->getReferer('@sf_guard_user'));
  }

  protected function getBaseQuery()
  {
    return Doctrine_Core::getTable('sfGuardUser')
      ->createQuery()
      ->whereNotIn('username', array('bshaffer', 'admin', 'assistant'));
  }
}
