<?php

/**
 * IssueComment form base class.
 *
 * @method IssueComment getObject() Returns the current form's model object
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIssueCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'issue_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Issue'), 'add_empty' => false)),
      'author_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Author'), 'add_empty' => false)),
      'body'       => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'issue_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Issue'))),
      'author_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Author'))),
      'body'       => new sfValidatorString(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('issue_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IssueComment';
  }

}
