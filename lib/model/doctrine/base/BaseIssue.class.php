<?php

/**
 * BaseIssue
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $author_id
 * @property clob $body
 * @property enum $status
 * @property timestamp $date_closed
 * @property sfGuardUser $Author
 * @property Doctrine_Collection $Tags
 * @property Doctrine_Collection $Comments
 * @property Doctrine_Collection $IssueTags
 * 
 * @method integer             getAuthorId()    Returns the current record's "author_id" value
 * @method clob                getBody()        Returns the current record's "body" value
 * @method enum                getStatus()      Returns the current record's "status" value
 * @method timestamp           getDateClosed()  Returns the current record's "date_closed" value
 * @method sfGuardUser         getAuthor()      Returns the current record's "Author" value
 * @method Doctrine_Collection getTags()        Returns the current record's "Tags" collection
 * @method Doctrine_Collection getComments()    Returns the current record's "Comments" collection
 * @method Doctrine_Collection getIssueTags()   Returns the current record's "IssueTags" collection
 * @method Issue               setAuthorId()    Sets the current record's "author_id" value
 * @method Issue               setBody()        Sets the current record's "body" value
 * @method Issue               setStatus()      Sets the current record's "status" value
 * @method Issue               setDateClosed()  Sets the current record's "date_closed" value
 * @method Issue               setAuthor()      Sets the current record's "Author" value
 * @method Issue               setTags()        Sets the current record's "Tags" collection
 * @method Issue               setComments()    Sets the current record's "Comments" collection
 * @method Issue               setIssueTags()   Sets the current record's "IssueTags" collection
 * 
 * @package    skeleton
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIssue extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('issue');
        $this->hasColumn('author_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('body', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'open',
              1 => 'closed',
              2 => 'unread',
             ),
             'notnull' => true,
             'default' => 'unread',
             ));
        $this->hasColumn('date_closed', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as Author', array(
             'local' => 'author_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Tag as Tags', array(
             'refClass' => 'IssueTag',
             'local' => 'issue_id',
             'foreign' => 'tag_id'));

        $this->hasMany('IssueComment as Comments', array(
             'local' => 'id',
             'foreign' => 'issue_id'));

        $this->hasMany('IssueTag as IssueTags', array(
             'local' => 'id',
             'foreign' => 'issue_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $sortable0 = new Doctrine_Template_Sortable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($sortable0);
    }
}