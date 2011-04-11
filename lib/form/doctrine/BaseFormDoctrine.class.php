<?php

/**
 * Project form base class.
 *
 * @package    form
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
  // ===================
  // = Form Formatters =
  // ===================
  /**
   * Adds a required asterisk on the end of all required fields, wrapped in a <span class='required'> tag
   * Call this method AFTER your validatorSchema is set for it to work properly, as the validatorSchema 
   * must be passed to the formatter itself
   *
   * @return void
   * @author Brent Shaffer
   */
  public function setRequiredFormatter()
  {
    $formatter = new sfWidgetFormSchemaFormatterRequired($this->widgetSchema);
    $formatter->setValidatorSchema($this->validatorSchema);
    $this->widgetSchema->addFormFormatter('required', $formatter);
    $this->widgetSchema->setFormFormatterName('required');
  }
  
  /**
   * Replaces the default table-formatted form rows / table with divs
   * If implementing the FormTransformPlugin, this must be called in 
   * order for it to work
   *
   * @return void
   * @author Brent Shaffer
   */
  public function setTablelessFormatter()
  {
    $formatter = new csWidgetFormSchemaFormatterTable($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('cs-formatter', $formatter);
    $this->widgetSchema->setFormFormatterName('cs-formatter');
  }

  // =============================
  // = Form Field Helper Methods =
  // =============================
  /**
   * Default double-list array.  Ensures the image paths for the 
   * associate/unassociate arrows are not broken
   *
   * @param string $choices 
   * @return void
   * @author Brent Shaffer
   */
  public function getDoubleListArray($choices)
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('Asset'));
    $options = array(
      'choices'     => $choices,
      'unassociate' => 
      '<img src="'.image_path('/sfFormExtraPlugin/images/next.png').'" alt="unassociate" />',
      'associate'   =>
      '<img src="'.image_path('/sfFormExtraPlugin/images/previous.png').'" alt="associate" />');
    
    return $options;
  }

  /**
   * returns an array of all the form errors for a given form.  
   * great for debugging
   *
   * @return array of errors
   * @author Brent Shaffer
   */
  public function getErrorList()
  {
    $errors = array();
    if($global = $this->getGlobalErrors())
    {
      if (count($global)) 
      {
        $errors['global_errors'] = implode(',', $global);
      }
      else
      {
        $errors['global_errors'] = (string) $global;
      }
    }
    $embedded = $this->getEmbeddedForms();

    foreach ($this->validatorSchema->getFields() as $key => $value) 
    {
      if(in_array($key, array_keys($embedded)))
      {
        if($embed_errors = $embedded[$key]->getErrorList())
        {
          $errors[$key] = $embed_errors;
        }
      }
      elseif($this[$key]->hasError())
      {
        $val = $this[$key]->getError();
        $errors[$key] = (string) $val;
      }
    }
    return $errors;
  }

  /**
   * The below is some code to fix problems with embedded forms. jwage gave
   * me this as a fix until it's included in symfony -- cwage
   *
   * @return void
   * @author Jonathan Wage
   */
  public function processValues($values)
  {
    $values = (array) $values;
    $values = parent::processValues($values);
    $values = $this->processValuesEmbeddedForms($values);

    return $values;
  }

  public function processValuesEmbeddedForms($values = null, $forms = null)
  {
    if (is_null($forms))
    {
      $forms = $this->embeddedForms;
    }

    foreach ($forms as $name => $form)
    {
      if (!isset($values[$name]) || !is_array($values[$name]))
      {
        continue;
      }

      if ($form instanceof sfFormDoctrine)
      {
        $values[$name] = $form->processValues($values[$name]);
      }
      else
      {
        $values[$name] = $this->processValuesEmbeddedForms($values[$name], $form->getEmbeddedForms());
      }
    }

    return $values;
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $ret = parent::bind($taintedValues, $taintedFiles);
    foreach ($this->embeddedForms as $name => $form)
    {
      $this->embeddedForms[$name]->isBound = true;
      if (isset($this->values[$name]))
      {
        $this->embeddedForms[$name]->values = $this->values[$name];
      }
    }

    return $ret;
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  {
    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    if (is_null($forms))
    {
      $forms = $this->embeddedForms;
    }

    foreach ($forms as $key => $form)
    {
      if ($form instanceof sfFormDoctrine)
      {
        $form->doSave($con);
        $form->saveEmbeddedForms($con, $form->getEmbeddedForms());
      } else {
        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
      }
    }
  }

  protected function processUploadedFile($field, $filename = null, $values = null)
  {
    if (!$this->validatorSchema[$field] instanceof sfValidatorFile)
    {
      throw new LogicException(sprintf('You cannot save the current file for field "%s" as the field is not a file.', $field));
    }

    if (is_null($values))
    {
      $values = $this->values;
    }

    if (isset($values[$field.'_delete']) && $values[$field.'_delete'])
    {
      $this->removeFile($field);

      return '';
    }

    if (!$values[$field] || !$values[$field] instanceof sfValidatedFile)
    {
      return $this->object->$field;
    }

    // we need the base directory
    if (!$this->validatorSchema[$field]->getOption('path'))
    {
      return $values[$field];
    }

    $this->removeFile($field);

    return $this->saveFile($field, $filename, $values[$field]);
  }
}
