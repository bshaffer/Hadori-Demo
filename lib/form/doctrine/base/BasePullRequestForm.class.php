<?php

/**
 * PullRequest form base class.
 *
 * @method PullRequest getObject() Returns the current form's model object
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePullRequestForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'author_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Author'), 'add_empty' => false)),
      'body'       => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormChoice(array('choices' => array('open' => 'open', 'closed' => 'closed', 'pending' => 'pending'))),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'author_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Author'))),
      'body'       => new sfValidatorString(array('max_length' => 255)),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'open', 1 => 'closed', 2 => 'pending'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pull_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PullRequest';
  }

}
