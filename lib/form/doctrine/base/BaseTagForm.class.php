<?php

/**
 * Tag form base class.
 *
 * @method Tag getObject() Returns the current form's model object
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTagForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'text_color'       => new sfWidgetFormInputText(),
      'background_color' => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'issues_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Issue')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 255)),
      'text_color'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'background_color' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'issues_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Issue', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tag';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['issues_list']))
    {
      $this->setDefault('issues_list', $this->object->Issues->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveIssuesList($con);

    parent::doSave($con);
  }

  public function saveIssuesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['issues_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Issues->getPrimaryKeys();
    $values = $this->getValue('issues_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Issues', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Issues', array_values($link));
    }
  }

}
