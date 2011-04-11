<?php

/**
 * Issue form.
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IssueForm extends BaseIssueForm
{
  public function configure()
  {
    $this->useFields(array(
      'author_id',
      'body',
      'status',
      'tags_list'
    ));
  }
}
