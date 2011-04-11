<?php

/**
 * Issue form base class.
 *
 * @method Issue getObject() Returns the current form's model object
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIssueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'author_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Author'), 'add_empty' => false)),
      'body'        => new sfWidgetFormTextarea(),
      'status'      => new sfWidgetFormChoice(array('choices' => array('open' => 'open', 'closed' => 'closed', 'unread' => 'unread'))),
      'date_closed' => new sfWidgetFormDateTime(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'position'    => new sfWidgetFormInputText(),
      'tags_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Tag')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'author_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Author'))),
      'body'        => new sfValidatorString(),
      'status'      => new sfValidatorChoice(array('choices' => array(0 => 'open', 1 => 'closed', 2 => 'unread'), 'required' => false)),
      'date_closed' => new sfValidatorDateTime(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'position'    => new sfValidatorInteger(array('required' => false)),
      'tags_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Tag', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Issue', 'column' => array('position')))
    );

    $this->widgetSchema->setNameFormat('issue[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Issue';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['tags_list']))
    {
      $this->setDefault('tags_list', $this->object->Tags->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveTagsList($con);

    parent::doSave($con);
  }

  public function saveTagsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tags_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Tags->getPrimaryKeys();
    $values = $this->getValue('tags_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Tags', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Tags', array_values($link));
    }
  }

}
