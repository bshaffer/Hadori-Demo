<?php

/**
 * Tag form.
 *
 * @package    skeleton
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TagForm extends BaseTagForm
{
  public function configure()
  {
    $this->useFields(array(
      'name',
      'text_color',
      'background_color'));
  }
}
