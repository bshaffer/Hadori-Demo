<?php

/**
* 
*/
class Doctrine_Collection_Extra extends Doctrine_Collection
{
  public function filter($wheres)
  {
    $collection = Doctrine_Collection::create($this->_table->getOption('name'));
    
    foreach ($this->data as $record) {
      foreach ($wheres as $property => $value) {
        if ($record[$property] == $value) $collection[] = $record;
      }
    }
    
    return $collection;
  }

  public function filterOne($wheres)
  {
    $collection = Doctrine_Collection::create($this->_table->getOption('name'));
    
    foreach ($this->data as $record) {
      foreach ($wheres as $property => $value) {
        if ($record[$property] == $value) return $record;
      }
    }
    
    return null;
  }
  
  public function refresh()
  {
    foreach ($this->data as $record) 
    {
      $record->refresh();
    }
  }
  
  public function refreshRelated()
  {
    foreach ($this->data as $record) 
    {
      $record->refreshRelated();
    }
  }
  
  public function next($wrap = false)
  {
    $next = next($this->data);
    if (!$next && $wrap) 
    {
      $next = reset($this->data);
    }
    return $next;
  }

  public function current()
  {
    return current($this->data);
  }
}
