<?php

/**
 * sf_guard_user actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage sf_guard_user
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class autoSf_guard_userActions extends sfActions
{
  public function preExecute()
  {
    $this->helper = new sfHadoriThemeHelper();
  }

  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_direction')));
    }

    $this->pager  = $this->getPager();
  }

  public function executeFilter(sfWebRequest $request)
  {
    if ($request->hasParameter('_reset'))
    {
      $this->setFilters(array());
      $this->redirect('@sf_guard_user');
    }

    $this->filters = new sfGuardUserFormFilter();
    $filters = array_intersect_key($request->getParameter($this->filters->getName()), $request->getParameter('include', array()));

    $this->filters->bind($filters);

    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      $this->redirect('@sf_guard_user');
    }

    $this->pager = $this->getPager();
    $this->helper->setFilters($filters);
    $this->setTemplate('index');
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new sfGuardUserForm();
    $this->sf_guard_user = $this->form->getObject();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new sfGuardUserForm();
    $this->sf_guard_user = $this->form->getObject();

    if($this->processForm($this->form))
    {
      $this->getUser()->setFlash('notice', 'The item was created successfully');

      $this->redirect($request->hasParameter('_save_and_add') ? '@sf_guard_user_new' : '@sf_guard_user');
    }

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->sf_guard_user = $this->getRoute()->getObject();
    $this->form = new sfGuardUserForm($this->sf_guard_user);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->sf_guard_user = $this->getRoute()->getObject();
    $this->form = new sfGuardUserForm($this->sf_guard_user);

    if($this->processForm($this->form))
    {
      $this->getUser()->setFlash('notice', 'The item was updated successfully');

      $this->redirect($request->hasParameter('_save_and_add') ? '@sf_guard_user_new' : '@sf_guard_user');
    }

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    if ($this->getRoute()->getObject()->delete())
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    }

    $this->redirect('@sf_guard_user');
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->sf_guard_user = $this->getRoute()->getObject();
  }

  public function executeExport(sfWebRequest $request)
  { 
    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_direction')));
    }

    $this->pager = $this->getPager();
     
    if ($request->isMethod('post')) 
    { 
      $manager = new sfExportManager($this->getResponse());
      
      $fields = array_intersect_key($request->getParameter('export'), $request->getParameter('include'));
      
      if(false === $manager->export($this->pager->getQuery()->limit(9999999)->execute(), $fields, 'sfGuardUserExport'))
      {
        // There was an error when generating the download.  Redirect to the referer and set the error in a flash message
        $this->redirectReferer($manager->getErrorMessage());
      }

      if($route = $manager->getDownloadRoute())
      {
        $this->redirect($route);
      }
      
      return sfView::NONE;
    }
  }


  public function executeBatch(sfWebRequest $request)
  {
    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');
    }
    elseif (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');
    }

    $method = sprintf('execute%s', ucfirst($action));
    $this->$method($request);  
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids     = $request->getParameter('ids');
    $records = Doctrine_Core::getTable('sfGuardUser')->createQuery()->whereIn('id', $ids)->execute();
    $records->delete();

    $this->getUser()->setFlash('notice', 'The selected items have been deleted.');
    $this->redirect('@sf_guard_user');
  }

  protected function processForm(sfForm $form)
  {
    $form->bind($this->getRequest()->getParameter($form->getName()), $this->getRequest()->getFiles($form->getName()));

    if ($form->isValid())
    {
      $sf_guard_user = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_user)));
      
      return $sf_guard_user;
    }
    
    return false;
  }

  protected function getFilters()
  {
    $filters = $this->getUser()->getAttribute('sf_guard_user.filters', array());
    $this->helper->setFilters($filters);
    return $filters;
  }

  protected function setFilters(array $filters)
  {
    $filters = $this->getUser()->setAttribute('sf_guard_user.filters', $filters);
    $this->helper->setFilters($filters);
    return $filters;
  }

  protected function getPager()
  {
    $pager = new sfDoctrinePager('sfGuardUser', 10);
    $pager->setQuery($this->buildQuery());
    $pager->setPage($this->getRequest()->getParameter('page'));
    $pager->init();

    return $pager;
  }

  protected function buildQuery()
  {
    if(!$this->filters) {
      $this->filters = new sfGuardUserFormFilter($this->getFilters());
    }

    $this->filters->setQuery($this->getBaseQuery());

    $query = $this->filters->buildQuery($this->getFilters());

    if ($sort = $this->getSort())
    {
      $query->addOrderBy($sort[0] . ' ' . $sort[1]);
    }

    return $query;
  }

  protected function getBaseQuery()
  {
    return Doctrine_Core::getTable('sfGuardUser')->createQuery();
  }

  protected function getSort()
  {
    $sort = $this->getUser()->getAttribute('sf_guard_user.sort', array());
    $this->helper->setSort($sort);
    return $sort;
  }

  protected function setSort(array $sort)
  {
    if (null !== $sort[0] && null === $sort[1])
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute('sf_guard_user.sort', $sort);
    
    $this->helper->setSort($sort);
    return $sort;
  }
}
