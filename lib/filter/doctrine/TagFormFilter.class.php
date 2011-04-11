<?php

/**
 * Tag filter form.
 *
 * @package    skeleton
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TagFormFilter extends BaseTagFormFilter
{
  public function configure()
  {
    $this->useFields(array(
      'name',
      'text_color',
      'background_color',
      'created_at'
    ));
  }
}
