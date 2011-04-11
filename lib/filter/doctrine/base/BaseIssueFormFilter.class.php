<?php

/**
 * Issue filter form base class.
 *
 * @package    skeleton
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIssueFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'author_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Author'), 'add_empty' => true)),
      'body'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'      => new sfWidgetFormChoice(array('choices' => array('' => '', 'open' => 'open', 'closed' => 'closed', 'unread' => 'unread'))),
      'date_closed' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'position'    => new sfWidgetFormFilterInput(),
      'tags_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Tag')),
    ));

    $this->setValidators(array(
      'author_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Author'), 'column' => 'id')),
      'body'        => new sfValidatorPass(array('required' => false)),
      'status'      => new sfValidatorChoice(array('required' => false, 'choices' => array('open' => 'open', 'closed' => 'closed', 'unread' => 'unread'))),
      'date_closed' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'position'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tags_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Tag', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('issue_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addTagsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.IssueTag IssueTag')
      ->andWhereIn('IssueTag.tag_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Issue';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'author_id'   => 'ForeignKey',
      'body'        => 'Text',
      'status'      => 'Enum',
      'date_closed' => 'Date',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'position'    => 'Number',
      'tags_list'   => 'ManyKey',
    );
  }
}
