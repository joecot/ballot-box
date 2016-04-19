<?php

namespace MESBallotBox\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use MESBallotBox\Propel\Question as ChildQuestion;
use MESBallotBox\Propel\QuestionQuery as ChildQuestionQuery;
use MESBallotBox\Propel\QuestionVersionQuery as ChildQuestionVersionQuery;
use MESBallotBox\Propel\Map\QuestionVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'Question_version' table.
 *
 *
 *
* @package    propel.generator.MESBallotBox.Propel.Base
*/
abstract class QuestionVersion implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MESBallotBox\\Propel\\Map\\QuestionVersionTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the ballot_id field.
     *
     * @var        int
     */
    protected $ballot_id;

    /**
     * The value for the order_id field.
     *
     * @var        int
     */
    protected $order_id;

    /**
     * The value for the is_deleted field.
     *
     * @var        int
     */
    protected $is_deleted;

    /**
     * The value for the type field.
     *
     * @var        int
     */
    protected $type;

    /**
     * The value for the count field.
     *
     * @var        int
     */
    protected $count;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the readmore field.
     *
     * @var        string
     */
    protected $readmore;

    /**
     * The value for the discussion field.
     *
     * @var        string
     */
    protected $discussion;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime
     */
    protected $updated_at;

    /**
     * The value for the version field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * The value for the version_created_at field.
     *
     * @var        DateTime
     */
    protected $version_created_at;

    /**
     * The value for the version_created_by field.
     *
     * @var        string
     */
    protected $version_created_by;

    /**
     * The value for the ballot_id_version field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $ballot_id_version;

    /**
     * The value for the candidate_ids field.
     *
     * @var        array
     */
    protected $candidate_ids;

    /**
     * The unserialized $candidate_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $candidate_ids_unserialized;

    /**
     * The value for the candidate_versions field.
     *
     * @var        array
     */
    protected $candidate_versions;

    /**
     * The unserialized $candidate_versions value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $candidate_versions_unserialized;

    /**
     * The value for the vote_item_ids field.
     *
     * @var        array
     */
    protected $vote_item_ids;

    /**
     * The unserialized $vote_item_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $vote_item_ids_unserialized;

    /**
     * The value for the vote_item_versions field.
     *
     * @var        array
     */
    protected $vote_item_versions;

    /**
     * The unserialized $vote_item_versions value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $vote_item_versions_unserialized;

    /**
     * @var        ChildQuestion
     */
    protected $aQuestion;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
        $this->ballot_id_version = 0;
    }

    /**
     * Initializes internal state of MESBallotBox\Propel\Base\QuestionVersion object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>QuestionVersion</code> instance.  If
     * <code>obj</code> is an instance of <code>QuestionVersion</code>, delegates to
     * <code>equals(QuestionVersion)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|QuestionVersion The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getid()
    {
        return $this->id;
    }

    /**
     * Get the [ballot_id] column value.
     *
     * @return int
     */
    public function getballotId()
    {
        return $this->ballot_id;
    }

    /**
     * Get the [order_id] column value.
     *
     * @return int
     */
    public function getorderId()
    {
        return $this->order_id;
    }

    /**
     * Get the [is_deleted] column value.
     *
     * @return int
     */
    public function getisDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function gettype()
    {
        if (null === $this->type) {
            return null;
        }
        $valueSet = QuestionVersionTableMap::getValueSet(QuestionVersionTableMap::COL_TYPE);
        if (!isset($valueSet[$this->type])) {
            throw new PropelException('Unknown stored enum key: ' . $this->type);
        }

        return $valueSet[$this->type];
    }

    /**
     * Get the [count] column value.
     *
     * @return int
     */
    public function getcount()
    {
        return $this->count;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getname()
    {
        return $this->name;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getdescription()
    {
        return $this->description;
    }

    /**
     * Get the [readmore] column value.
     *
     * @return string
     */
    public function getreadmore()
    {
        return $this->readmore;
    }

    /**
     * Get the [discussion] column value.
     *
     * @return string
     */
    public function getdiscussion()
    {
        return $this->discussion;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Get the [version] column value.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the [optionally formatted] temporal [version_created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getVersionCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->version_created_at;
        } else {
            return $this->version_created_at instanceof \DateTimeInterface ? $this->version_created_at->format($format) : null;
        }
    }

    /**
     * Get the [version_created_by] column value.
     *
     * @return string
     */
    public function getVersionCreatedBy()
    {
        return $this->version_created_by;
    }

    /**
     * Get the [ballot_id_version] column value.
     *
     * @return int
     */
    public function getBallotIdVersion()
    {
        return $this->ballot_id_version;
    }

    /**
     * Get the [candidate_ids] column value.
     *
     * @return array
     */
    public function getCandidateIds()
    {
        if (null === $this->candidate_ids_unserialized) {
            $this->candidate_ids_unserialized = array();
        }
        if (!$this->candidate_ids_unserialized && null !== $this->candidate_ids) {
            $candidate_ids_unserialized = substr($this->candidate_ids, 2, -2);
            $this->candidate_ids_unserialized = $candidate_ids_unserialized ? explode(' | ', $candidate_ids_unserialized) : array();
        }

        return $this->candidate_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [candidate_ids] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasCandidateId($value)
    {
        return in_array($value, $this->getCandidateIds());
    } // hasCandidateId()

    /**
     * Get the [candidate_versions] column value.
     *
     * @return array
     */
    public function getCandidateVersions()
    {
        if (null === $this->candidate_versions_unserialized) {
            $this->candidate_versions_unserialized = array();
        }
        if (!$this->candidate_versions_unserialized && null !== $this->candidate_versions) {
            $candidate_versions_unserialized = substr($this->candidate_versions, 2, -2);
            $this->candidate_versions_unserialized = $candidate_versions_unserialized ? explode(' | ', $candidate_versions_unserialized) : array();
        }

        return $this->candidate_versions_unserialized;
    }

    /**
     * Test the presence of a value in the [candidate_versions] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasCandidateVersion($value)
    {
        return in_array($value, $this->getCandidateVersions());
    } // hasCandidateVersion()

    /**
     * Get the [vote_item_ids] column value.
     *
     * @return array
     */
    public function getVoteItemIds()
    {
        if (null === $this->vote_item_ids_unserialized) {
            $this->vote_item_ids_unserialized = array();
        }
        if (!$this->vote_item_ids_unserialized && null !== $this->vote_item_ids) {
            $vote_item_ids_unserialized = substr($this->vote_item_ids, 2, -2);
            $this->vote_item_ids_unserialized = $vote_item_ids_unserialized ? explode(' | ', $vote_item_ids_unserialized) : array();
        }

        return $this->vote_item_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [vote_item_ids] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasVoteItemId($value)
    {
        return in_array($value, $this->getVoteItemIds());
    } // hasVoteItemId()

    /**
     * Get the [vote_item_versions] column value.
     *
     * @return array
     */
    public function getVoteItemVersions()
    {
        if (null === $this->vote_item_versions_unserialized) {
            $this->vote_item_versions_unserialized = array();
        }
        if (!$this->vote_item_versions_unserialized && null !== $this->vote_item_versions) {
            $vote_item_versions_unserialized = substr($this->vote_item_versions, 2, -2);
            $this->vote_item_versions_unserialized = $vote_item_versions_unserialized ? explode(' | ', $vote_item_versions_unserialized) : array();
        }

        return $this->vote_item_versions_unserialized;
    }

    /**
     * Test the presence of a value in the [vote_item_versions] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasVoteItemVersion($value)
    {
        return in_array($value, $this->getVoteItemVersions());
    } // hasVoteItemVersion()

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_ID] = true;
        }

        if ($this->aQuestion !== null && $this->aQuestion->getid() !== $v) {
            $this->aQuestion = null;
        }

        return $this;
    } // setid()

    /**
     * Set the value of [ballot_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setballotId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ballot_id !== $v) {
            $this->ballot_id = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_BALLOT_ID] = true;
        }

        return $this;
    } // setballotId()

    /**
     * Set the value of [order_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setorderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_ORDER_ID] = true;
        }

        return $this;
    } // setorderId()

    /**
     * Set the value of [is_deleted] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setisDeleted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_deleted !== $v) {
            $this->is_deleted = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_IS_DELETED] = true;
        }

        return $this;
    } // setisDeleted()

    /**
     * Set the value of [type] column.
     *
     * @param  string $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function settype($v)
    {
        if ($v !== null) {
            $valueSet = QuestionVersionTableMap::getValueSet(QuestionVersionTableMap::COL_TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_TYPE] = true;
        }

        return $this;
    } // settype()

    /**
     * Set the value of [count] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setcount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->count !== $v) {
            $this->count = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_COUNT] = true;
        }

        return $this;
    } // setcount()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_NAME] = true;
        }

        return $this;
    } // setname()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setdescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setdescription()

    /**
     * Set the value of [readmore] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setreadmore($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->readmore !== $v) {
            $this->readmore = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_READMORE] = true;
        }

        return $this;
    } // setreadmore()

    /**
     * Set the value of [discussion] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setdiscussion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discussion !== $v) {
            $this->discussion = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_DISCUSSION] = true;
        }

        return $this;
    } // setdiscussion()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[QuestionVersionTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[QuestionVersionTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->version_created_at->format("Y-m-d H:i:s")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[QuestionVersionTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_VERSION_CREATED_BY] = true;
        }

        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [ballot_id_version] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setBallotIdVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ballot_id_version !== $v) {
            $this->ballot_id_version = $v;
            $this->modifiedColumns[QuestionVersionTableMap::COL_BALLOT_ID_VERSION] = true;
        }

        return $this;
    } // setBallotIdVersion()

    /**
     * Set the value of [candidate_ids] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setCandidateIds($v)
    {
        if ($this->candidate_ids_unserialized !== $v) {
            $this->candidate_ids_unserialized = $v;
            $this->candidate_ids = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[QuestionVersionTableMap::COL_CANDIDATE_IDS] = true;
        }

        return $this;
    } // setCandidateIds()

    /**
     * Adds a value to the [candidate_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function addCandidateId($value)
    {
        $currentArray = $this->getCandidateIds();
        $currentArray []= $value;
        $this->setCandidateIds($currentArray);

        return $this;
    } // addCandidateId()

    /**
     * Removes a value from the [candidate_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function removeCandidateId($value)
    {
        $targetArray = array();
        foreach ($this->getCandidateIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setCandidateIds($targetArray);

        return $this;
    } // removeCandidateId()

    /**
     * Set the value of [candidate_versions] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setCandidateVersions($v)
    {
        if ($this->candidate_versions_unserialized !== $v) {
            $this->candidate_versions_unserialized = $v;
            $this->candidate_versions = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[QuestionVersionTableMap::COL_CANDIDATE_VERSIONS] = true;
        }

        return $this;
    } // setCandidateVersions()

    /**
     * Adds a value to the [candidate_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function addCandidateVersion($value)
    {
        $currentArray = $this->getCandidateVersions();
        $currentArray []= $value;
        $this->setCandidateVersions($currentArray);

        return $this;
    } // addCandidateVersion()

    /**
     * Removes a value from the [candidate_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function removeCandidateVersion($value)
    {
        $targetArray = array();
        foreach ($this->getCandidateVersions() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setCandidateVersions($targetArray);

        return $this;
    } // removeCandidateVersion()

    /**
     * Set the value of [vote_item_ids] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setVoteItemIds($v)
    {
        if ($this->vote_item_ids_unserialized !== $v) {
            $this->vote_item_ids_unserialized = $v;
            $this->vote_item_ids = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[QuestionVersionTableMap::COL_VOTE_ITEM_IDS] = true;
        }

        return $this;
    } // setVoteItemIds()

    /**
     * Adds a value to the [vote_item_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function addVoteItemId($value)
    {
        $currentArray = $this->getVoteItemIds();
        $currentArray []= $value;
        $this->setVoteItemIds($currentArray);

        return $this;
    } // addVoteItemId()

    /**
     * Removes a value from the [vote_item_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function removeVoteItemId($value)
    {
        $targetArray = array();
        foreach ($this->getVoteItemIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setVoteItemIds($targetArray);

        return $this;
    } // removeVoteItemId()

    /**
     * Set the value of [vote_item_versions] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function setVoteItemVersions($v)
    {
        if ($this->vote_item_versions_unserialized !== $v) {
            $this->vote_item_versions_unserialized = $v;
            $this->vote_item_versions = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS] = true;
        }

        return $this;
    } // setVoteItemVersions()

    /**
     * Adds a value to the [vote_item_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function addVoteItemVersion($value)
    {
        $currentArray = $this->getVoteItemVersions();
        $currentArray []= $value;
        $this->setVoteItemVersions($currentArray);

        return $this;
    } // addVoteItemVersion()

    /**
     * Removes a value from the [vote_item_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     */
    public function removeVoteItemVersion($value)
    {
        $targetArray = array();
        foreach ($this->getVoteItemVersions() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setVoteItemVersions($targetArray);

        return $this;
    } // removeVoteItemVersion()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->version !== 0) {
                return false;
            }

            if ($this->ballot_id_version !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : QuestionVersionTableMap::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : QuestionVersionTableMap::translateFieldName('ballotId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ballot_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : QuestionVersionTableMap::translateFieldName('orderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : QuestionVersionTableMap::translateFieldName('isDeleted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_deleted = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : QuestionVersionTableMap::translateFieldName('type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : QuestionVersionTableMap::translateFieldName('count', TableMap::TYPE_PHPNAME, $indexType)];
            $this->count = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : QuestionVersionTableMap::translateFieldName('name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : QuestionVersionTableMap::translateFieldName('description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : QuestionVersionTableMap::translateFieldName('readmore', TableMap::TYPE_PHPNAME, $indexType)];
            $this->readmore = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : QuestionVersionTableMap::translateFieldName('discussion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discussion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : QuestionVersionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : QuestionVersionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : QuestionVersionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : QuestionVersionTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : QuestionVersionTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : QuestionVersionTableMap::translateFieldName('BallotIdVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ballot_id_version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : QuestionVersionTableMap::translateFieldName('CandidateIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->candidate_ids = $col;
            $this->candidate_ids_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : QuestionVersionTableMap::translateFieldName('CandidateVersions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->candidate_versions = $col;
            $this->candidate_versions_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : QuestionVersionTableMap::translateFieldName('VoteItemIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vote_item_ids = $col;
            $this->vote_item_ids_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : QuestionVersionTableMap::translateFieldName('VoteItemVersions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vote_item_versions = $col;
            $this->vote_item_versions_unserialized = null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 20; // 20 = QuestionVersionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MESBallotBox\\Propel\\QuestionVersion'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aQuestion !== null && $this->id !== $this->aQuestion->getid()) {
            $this->aQuestion = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildQuestionVersionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aQuestion = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see QuestionVersion::setDeleted()
     * @see QuestionVersion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildQuestionVersionQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                QuestionVersionTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aQuestion !== null) {
                if ($this->aQuestion->isModified() || $this->aQuestion->isNew()) {
                    $affectedRows += $this->aQuestion->save($con);
                }
                $this->setQuestion($this->aQuestion);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(QuestionVersionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_BALLOT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ballot_id';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'order_id';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_IS_DELETED)) {
            $modifiedColumns[':p' . $index++]  = 'is_deleted';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'count';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_READMORE)) {
            $modifiedColumns[':p' . $index++]  = 'readmore';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_DISCUSSION)) {
            $modifiedColumns[':p' . $index++]  = 'discussion';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_BALLOT_ID_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'ballot_id_version';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_CANDIDATE_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'Candidate_ids';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS)) {
            $modifiedColumns[':p' . $index++]  = 'Candidate_versions';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VOTE_ITEM_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'Vote_item_ids';
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS)) {
            $modifiedColumns[':p' . $index++]  = 'Vote_item_versions';
        }

        $sql = sprintf(
            'INSERT INTO Question_version (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'ballot_id':
                        $stmt->bindValue($identifier, $this->ballot_id, PDO::PARAM_INT);
                        break;
                    case 'order_id':
                        $stmt->bindValue($identifier, $this->order_id, PDO::PARAM_INT);
                        break;
                    case 'is_deleted':
                        $stmt->bindValue($identifier, $this->is_deleted, PDO::PARAM_INT);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case 'count':
                        $stmt->bindValue($identifier, $this->count, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'readmore':
                        $stmt->bindValue($identifier, $this->readmore, PDO::PARAM_STR);
                        break;
                    case 'discussion':
                        $stmt->bindValue($identifier, $this->discussion, PDO::PARAM_STR);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'version':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case 'version_created_at':
                        $stmt->bindValue($identifier, $this->version_created_at ? $this->version_created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'version_created_by':
                        $stmt->bindValue($identifier, $this->version_created_by, PDO::PARAM_STR);
                        break;
                    case 'ballot_id_version':
                        $stmt->bindValue($identifier, $this->ballot_id_version, PDO::PARAM_INT);
                        break;
                    case 'Candidate_ids':
                        $stmt->bindValue($identifier, $this->candidate_ids, PDO::PARAM_STR);
                        break;
                    case 'Candidate_versions':
                        $stmt->bindValue($identifier, $this->candidate_versions, PDO::PARAM_STR);
                        break;
                    case 'Vote_item_ids':
                        $stmt->bindValue($identifier, $this->vote_item_ids, PDO::PARAM_STR);
                        break;
                    case 'Vote_item_versions':
                        $stmt->bindValue($identifier, $this->vote_item_versions, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = QuestionVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getid();
                break;
            case 1:
                return $this->getballotId();
                break;
            case 2:
                return $this->getorderId();
                break;
            case 3:
                return $this->getisDeleted();
                break;
            case 4:
                return $this->gettype();
                break;
            case 5:
                return $this->getcount();
                break;
            case 6:
                return $this->getname();
                break;
            case 7:
                return $this->getdescription();
                break;
            case 8:
                return $this->getreadmore();
                break;
            case 9:
                return $this->getdiscussion();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
                return $this->getUpdatedAt();
                break;
            case 12:
                return $this->getVersion();
                break;
            case 13:
                return $this->getVersionCreatedAt();
                break;
            case 14:
                return $this->getVersionCreatedBy();
                break;
            case 15:
                return $this->getBallotIdVersion();
                break;
            case 16:
                return $this->getCandidateIds();
                break;
            case 17:
                return $this->getCandidateVersions();
                break;
            case 18:
                return $this->getVoteItemIds();
                break;
            case 19:
                return $this->getVoteItemVersions();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['QuestionVersion'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['QuestionVersion'][$this->hashCode()] = true;
        $keys = QuestionVersionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getid(),
            $keys[1] => $this->getballotId(),
            $keys[2] => $this->getorderId(),
            $keys[3] => $this->getisDeleted(),
            $keys[4] => $this->gettype(),
            $keys[5] => $this->getcount(),
            $keys[6] => $this->getname(),
            $keys[7] => $this->getdescription(),
            $keys[8] => $this->getreadmore(),
            $keys[9] => $this->getdiscussion(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getUpdatedAt(),
            $keys[12] => $this->getVersion(),
            $keys[13] => $this->getVersionCreatedAt(),
            $keys[14] => $this->getVersionCreatedBy(),
            $keys[15] => $this->getBallotIdVersion(),
            $keys[16] => $this->getCandidateIds(),
            $keys[17] => $this->getCandidateVersions(),
            $keys[18] => $this->getVoteItemIds(),
            $keys[19] => $this->getVoteItemVersions(),
        );
        if ($result[$keys[10]] instanceof \DateTime) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        if ($result[$keys[11]] instanceof \DateTime) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }

        if ($result[$keys[13]] instanceof \DateTime) {
            $result[$keys[13]] = $result[$keys[13]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aQuestion) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'question';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Question';
                        break;
                    default:
                        $key = 'Question';
                }

                $result[$key] = $this->aQuestion->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\MESBallotBox\Propel\QuestionVersion
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = QuestionVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MESBallotBox\Propel\QuestionVersion
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setid($value);
                break;
            case 1:
                $this->setballotId($value);
                break;
            case 2:
                $this->setorderId($value);
                break;
            case 3:
                $this->setisDeleted($value);
                break;
            case 4:
                $valueSet = QuestionVersionTableMap::getValueSet(QuestionVersionTableMap::COL_TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->settype($value);
                break;
            case 5:
                $this->setcount($value);
                break;
            case 6:
                $this->setname($value);
                break;
            case 7:
                $this->setdescription($value);
                break;
            case 8:
                $this->setreadmore($value);
                break;
            case 9:
                $this->setdiscussion($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
                $this->setUpdatedAt($value);
                break;
            case 12:
                $this->setVersion($value);
                break;
            case 13:
                $this->setVersionCreatedAt($value);
                break;
            case 14:
                $this->setVersionCreatedBy($value);
                break;
            case 15:
                $this->setBallotIdVersion($value);
                break;
            case 16:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setCandidateIds($value);
                break;
            case 17:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setCandidateVersions($value);
                break;
            case 18:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setVoteItemIds($value);
                break;
            case 19:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setVoteItemVersions($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = QuestionVersionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setballotId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setorderId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setisDeleted($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->settype($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setcount($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setname($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setdescription($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setreadmore($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setdiscussion($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setVersion($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setVersionCreatedAt($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setVersionCreatedBy($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setBallotIdVersion($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setCandidateIds($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setCandidateVersions($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setVoteItemIds($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setVoteItemVersions($arr[$keys[19]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(QuestionVersionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(QuestionVersionTableMap::COL_ID)) {
            $criteria->add(QuestionVersionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_BALLOT_ID)) {
            $criteria->add(QuestionVersionTableMap::COL_BALLOT_ID, $this->ballot_id);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_ORDER_ID)) {
            $criteria->add(QuestionVersionTableMap::COL_ORDER_ID, $this->order_id);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_IS_DELETED)) {
            $criteria->add(QuestionVersionTableMap::COL_IS_DELETED, $this->is_deleted);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_TYPE)) {
            $criteria->add(QuestionVersionTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_COUNT)) {
            $criteria->add(QuestionVersionTableMap::COL_COUNT, $this->count);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_NAME)) {
            $criteria->add(QuestionVersionTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_DESCRIPTION)) {
            $criteria->add(QuestionVersionTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_READMORE)) {
            $criteria->add(QuestionVersionTableMap::COL_READMORE, $this->readmore);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_DISCUSSION)) {
            $criteria->add(QuestionVersionTableMap::COL_DISCUSSION, $this->discussion);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_CREATED_AT)) {
            $criteria->add(QuestionVersionTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_UPDATED_AT)) {
            $criteria->add(QuestionVersionTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VERSION)) {
            $criteria->add(QuestionVersionTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(QuestionVersionTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(QuestionVersionTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_BALLOT_ID_VERSION)) {
            $criteria->add(QuestionVersionTableMap::COL_BALLOT_ID_VERSION, $this->ballot_id_version);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_CANDIDATE_IDS)) {
            $criteria->add(QuestionVersionTableMap::COL_CANDIDATE_IDS, $this->candidate_ids);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS)) {
            $criteria->add(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS, $this->candidate_versions);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VOTE_ITEM_IDS)) {
            $criteria->add(QuestionVersionTableMap::COL_VOTE_ITEM_IDS, $this->vote_item_ids);
        }
        if ($this->isColumnModified(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS)) {
            $criteria->add(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS, $this->vote_item_versions);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildQuestionVersionQuery::create();
        $criteria->add(QuestionVersionTableMap::COL_ID, $this->id);
        $criteria->add(QuestionVersionTableMap::COL_VERSION, $this->version);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getid() &&
            null !== $this->getVersion();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation Question_version_fk_e2315c to table Question
        if ($this->aQuestion && $hash = spl_object_hash($this->aQuestion)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getid();
        $pks[1] = $this->getVersion();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setid($keys[0]);
        $this->setVersion($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getid()) && (null === $this->getVersion());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MESBallotBox\Propel\QuestionVersion (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setid($this->getid());
        $copyObj->setballotId($this->getballotId());
        $copyObj->setorderId($this->getorderId());
        $copyObj->setisDeleted($this->getisDeleted());
        $copyObj->settype($this->gettype());
        $copyObj->setcount($this->getcount());
        $copyObj->setname($this->getname());
        $copyObj->setdescription($this->getdescription());
        $copyObj->setreadmore($this->getreadmore());
        $copyObj->setdiscussion($this->getdiscussion());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());
        $copyObj->setBallotIdVersion($this->getBallotIdVersion());
        $copyObj->setCandidateIds($this->getCandidateIds());
        $copyObj->setCandidateVersions($this->getCandidateVersions());
        $copyObj->setVoteItemIds($this->getVoteItemIds());
        $copyObj->setVoteItemVersions($this->getVoteItemVersions());
        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \MESBallotBox\Propel\QuestionVersion Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildQuestion object.
     *
     * @param  ChildQuestion $v
     * @return $this|\MESBallotBox\Propel\QuestionVersion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setQuestion(ChildQuestion $v = null)
    {
        if ($v === null) {
            $this->setid(NULL);
        } else {
            $this->setid($v->getid());
        }

        $this->aQuestion = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildQuestion object, it will not be re-added.
        if ($v !== null) {
            $v->addQuestionVersion($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildQuestion object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildQuestion The associated ChildQuestion object.
     * @throws PropelException
     */
    public function getQuestion(ConnectionInterface $con = null)
    {
        if ($this->aQuestion === null && ($this->id !== null)) {
            $this->aQuestion = ChildQuestionQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aQuestion->addQuestionVersions($this);
             */
        }

        return $this->aQuestion;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aQuestion) {
            $this->aQuestion->removeQuestionVersion($this);
        }
        $this->id = null;
        $this->ballot_id = null;
        $this->order_id = null;
        $this->is_deleted = null;
        $this->type = null;
        $this->count = null;
        $this->name = null;
        $this->description = null;
        $this->readmore = null;
        $this->discussion = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->ballot_id_version = null;
        $this->candidate_ids = null;
        $this->candidate_ids_unserialized = null;
        $this->candidate_versions = null;
        $this->candidate_versions_unserialized = null;
        $this->vote_item_ids = null;
        $this->vote_item_ids_unserialized = null;
        $this->vote_item_versions = null;
        $this->vote_item_versions_unserialized = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aQuestion = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(QuestionVersionTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
