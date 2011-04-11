<?php

/**
 * IssueTag form base class.
 *
 * @method IssueTag getObject() Returns the current form's model object
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIssueTagForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'issue_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Issues'), 'add_empty' => false)),
      'tag_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tags'), 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'issue_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Issues'))),
      'tag_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tags'))),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('issue_tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IssueTag';
  }

}
