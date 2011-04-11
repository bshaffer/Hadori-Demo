<?php
/*
 * Extended Doctrine Query class providing a few additional functions
 * for wrapping your where clauses more efficiently
 */
class Doctrine_Query_Extra extends Doctrine_Query
{
  protected
    $_startClause  = false;

  public function serialize()
  {
    return serialize(array('dqlParts' => $this->_dqlParts, 'params' => $this->getParams()));
  }

  public function unserialize($serialized)
  {
    $params = unserialize($serialized);

    $this->_dqlParts = $params['dqlParts'];

    $this->_params = $params['params'];

    return $this;
  }

  public function clause()
  {
    $this->_params['where'] = array();

    $this->_addDqlQueryPart('where', '(');

    $this->_startClause = true;

    return $this;
  }

  /**
   * This function begins an AND clause wrapped in parenthesis
   * Requires a call to endClause()
   *
   * @return $this
   */
  public function andClause()
  {
    if ($this->_hasDqlQueryPart('where')) {
        $this->_addDqlQueryPart('where', 'AND', true);
    }

    $this->_addDqlQueryPart('where', '(', true);

    $this->_startClause = true;

    return $this;
  }

  /**
   * This function begins an OR clause wrapped in parenthesis.
   * Requires a call to endClause()
   *
   * @return $this
   */
  public function orClause()
  {
    if ($this->_hasDqlQueryPart('where')) {
        $this->_addDqlQueryPart('where', 'OR', true);
    }

    $this->_addDqlQueryPart('where', '(', true);

    $this->_startClause = true;

    return $this;
  }

  /**
   * This function ends a clause
   *
   * @return $this
   */
  public function end()
  {
    if ($this->_startClause)
    {
      $this->_startClause = false;

      // Remove last two elements (open parenthesis and the "AND or OR" before it)
      array_pop($this->_dqlParts['where']);
      array_pop($this->_dqlParts['where']);
    }
    else
    {
      $this->_addDqlQueryPart('where', ')', true);
    }

    return $this;
  }

  /**
   * This function will wrap the current dql where statement in a clause
   *
   * @return $this
   */
  public function whereWrap()
  {
    $where = $this->_dqlParts['where'];

    if (count($where) > 0)
    {
      array_unshift($where, '(');
      array_push($where, ')');

      $this->_dqlParts['where'] = $where;
    }

    return $this;
  }

  public function orderBy($orderby, $values = null)
  {
    if ($values !== null)
    {
      return $this->orderByWhereIn($orderby, $values);
    }

    return $this->_addDqlQueryPart('orderby', $orderby);
  }

  public function addOrderBy($orderby, $values = null)
  {
    if ($values !== null)
    {
      return $this->addOrderByWhereIn($orderby, $values);
    }

    return $this->_addDqlQueryPart('orderby', $orderby, true);
  }

  public function addOrderByWhereIn($field, $values)
  {
    return $this->orderByWhereIn($field, $values, true);
  }

  public function orderByWhereIn($field, $values, $append = false)
  {
    $params     = explode(' ', $field);

    $direction  = isset($params[1]) ? $params[1] : 'ASC';

    return $this
      ->_addDqlQueryPart('orderby', sprintf('FIELD(%s, "%s") = 0 %s', $field, implode('","', $values), $direction), $append)
      ->_addDqlQueryPart('orderby', sprintf('FIELD(%s, "%s") %s', $field, implode('","', $values), $direction), true);
  }

  public function getColumnValues($column)
  {
    $this->_dqlParts['from'][0] =
      sprintf('%s %s INDEXBY %s',
        $this->getRootTableComponentName(),
        $this->getRootAlias(),
        $column);

    $this
      ->select(sprintf('%s.%s', $this->getRootAlias(), $column))
      ->groupBy(sprintf('%s.%s', $this->getRootAlias(), $column));

    return array_keys($this->fetchArray());
  }


  public function debug()
  {
    $sql = $this->getSqlQuery();

    $params = $this->getParams();

    foreach ($params as $key => $type)
    {
      foreach ($type as $param)
      {
        $sql = preg_replace('/\?/', is_int($param) ? $param : "'$param'", $sql, 1);
      }
    }

    return $sql;
  }

  /**
   * Fixes issue where doctrine returns all records if params are an empty array
   */
  public function andWhereIn($expr, $params = array(), $not = false)
  {
    return parent::andWhereIn($expr, $params === array() ? array(0) : $params, $not);
  }

  public function getPrimaryKeys()
  {
    if (!$this->_hasDqlQueryPart('from'))
    {
      throw new sfException("Must have 'from' set in query to use this function");
    }

    $from = $this->getDqlPart('from');

    return $this->getColumnValues(Doctrine::getTable($this->getRootTableComponentName())->getIdentifier());
  }

  public function getRootTableComponentName()
  {
    if (!$this->_hasDqlQueryPart('from'))
    {
      throw new sfException("Must have 'from' set in query to use this function");
    }

    $from = $this->getDqlPart('from');

    $firstFrom = explode(' ', $from[0]);

    return array_shift($firstFrom);
  }

  public function hasInnerJoin($join)
  {
    $join =  'INNER JOIN ' . $join;

    foreach ($this->_dqlParts['from'] as $from)
    {
      if ($from == $join)
      {
        return true;
      }
    }

    return false;
  }

  public function setBaseTable($tableName)
  {
    if(count($this->_dqlParts['from']))
    {
      $this->_dqlParts['from'][0] = $tableName . ' ' . $this->getRootAlias();
    }
    else
    {
      $this->from($tableName. ' ' . $this->getRootAlias());
    }

    return $this;
  }

  protected function _addDqlQueryPart($queryPartName, $queryPart, $append = false)
  {
    if ($queryPartName == 'where' && $this->_startClause && ($queryPart == 'AND' || $queryPart == 'OR'))
    {
      $this->_startClause = false;
      return $this;
    }

    return parent::_addDqlQueryPart($queryPartName, $queryPart, $append);
  }
}
