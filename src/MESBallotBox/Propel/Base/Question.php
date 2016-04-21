<?php

namespace MESBallotBox\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use MESBallotBox\Propel\Ballot as ChildBallot;
use MESBallotBox\Propel\BallotQuery as ChildBallotQuery;
use MESBallotBox\Propel\BallotVersionQuery as ChildBallotVersionQuery;
use MESBallotBox\Propel\Candidate as ChildCandidate;
use MESBallotBox\Propel\CandidateQuery as ChildCandidateQuery;
use MESBallotBox\Propel\CandidateVersionQuery as ChildCandidateVersionQuery;
use MESBallotBox\Propel\Question as ChildQuestion;
use MESBallotBox\Propel\QuestionQuery as ChildQuestionQuery;
use MESBallotBox\Propel\QuestionVersion as ChildQuestionVersion;
use MESBallotBox\Propel\QuestionVersionQuery as ChildQuestionVersionQuery;
use MESBallotBox\Propel\VoteItem as ChildVoteItem;
use MESBallotBox\Propel\VoteItemQuery as ChildVoteItemQuery;
use MESBallotBox\Propel\VoteItemVersionQuery as ChildVoteItemVersionQuery;
use MESBallotBox\Propel\Map\CandidateTableMap;
use MESBallotBox\Propel\Map\CandidateVersionTableMap;
use MESBallotBox\Propel\Map\QuestionTableMap;
use MESBallotBox\Propel\Map\QuestionVersionTableMap;
use MESBallotBox\Propel\Map\VoteItemTableMap;
use MESBallotBox\Propel\Map\VoteItemVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'Question' table.
 *
 *
 *
* @package    propel.generator.MESBallotBox.Propel.Base
*/
abstract class Question implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MESBallotBox\\Propel\\Map\\QuestionTableMap';


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
     * Note: this column has a database default value of: 0
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
     * @var        ChildBallot
     */
    protected $aBallot;

    /**
     * @var        ObjectCollection|ChildCandidate[] Collection to store aggregation of ChildCandidate objects.
     */
    protected $collCandidates;
    protected $collCandidatesPartial;

    /**
     * @var        ObjectCollection|ChildVoteItem[] Collection to store aggregation of ChildVoteItem objects.
     */
    protected $collVoteItems;
    protected $collVoteItemsPartial;

    /**
     * @var        ObjectCollection|ChildQuestionVersion[] Collection to store aggregation of ChildQuestionVersion objects.
     */
    protected $collQuestionVersions;
    protected $collQuestionVersionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // versionable behavior


    /**
     * @var bool
     */
    protected $enforceVersion = false;

    // validate behavior

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * ConstraintViolationList object
     *
     * @see     http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html
     * @var     ConstraintViolationList
     */
    protected $validationFailures;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCandidate[]
     */
    protected $candidatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVoteItem[]
     */
    protected $voteItemsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildQuestionVersion[]
     */
    protected $questionVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_deleted = 0;
        $this->version = 0;
    }

    /**
     * Initializes internal state of MESBallotBox\Propel\Base\Question object.
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
     * Compares this with another <code>Question</code> instance.  If
     * <code>obj</code> is an instance of <code>Question</code>, delegates to
     * <code>equals(Question)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Question The current object, for fluid interface
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
        $valueSet = QuestionTableMap::getValueSet(QuestionTableMap::COL_TYPE);
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[QuestionTableMap::COL_ID] = true;
        }

        return $this;
    } // setid()

    /**
     * Set the value of [ballot_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setballotId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ballot_id !== $v) {
            $this->ballot_id = $v;
            $this->modifiedColumns[QuestionTableMap::COL_BALLOT_ID] = true;
        }

        if ($this->aBallot !== null && $this->aBallot->getid() !== $v) {
            $this->aBallot = null;
        }

        return $this;
    } // setballotId()

    /**
     * Set the value of [order_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setorderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[QuestionTableMap::COL_ORDER_ID] = true;
        }

        return $this;
    } // setorderId()

    /**
     * Set the value of [is_deleted] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setisDeleted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_deleted !== $v) {
            $this->is_deleted = $v;
            $this->modifiedColumns[QuestionTableMap::COL_IS_DELETED] = true;
        }

        return $this;
    } // setisDeleted()

    /**
     * Set the value of [type] column.
     *
     * @param  string $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function settype($v)
    {
        if ($v !== null) {
            $valueSet = QuestionTableMap::getValueSet(QuestionTableMap::COL_TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[QuestionTableMap::COL_TYPE] = true;
        }

        return $this;
    } // settype()

    /**
     * Set the value of [count] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setcount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->count !== $v) {
            $this->count = $v;
            $this->modifiedColumns[QuestionTableMap::COL_COUNT] = true;
        }

        return $this;
    } // setcount()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[QuestionTableMap::COL_NAME] = true;
        }

        return $this;
    } // setname()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setdescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[QuestionTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setdescription()

    /**
     * Set the value of [readmore] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setreadmore($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->readmore !== $v) {
            $this->readmore = $v;
            $this->modifiedColumns[QuestionTableMap::COL_READMORE] = true;
        }

        return $this;
    } // setreadmore()

    /**
     * Set the value of [discussion] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setdiscussion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discussion !== $v) {
            $this->discussion = $v;
            $this->modifiedColumns[QuestionTableMap::COL_DISCUSSION] = true;
        }

        return $this;
    } // setdiscussion()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[QuestionTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[QuestionTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[QuestionTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->version_created_at->format("Y-m-d H:i:s")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[QuestionTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[QuestionTableMap::COL_VERSION_CREATED_BY] = true;
        }

        return $this;
    } // setVersionCreatedBy()

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
            if ($this->is_deleted !== 0) {
                return false;
            }

            if ($this->version !== 0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : QuestionTableMap::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : QuestionTableMap::translateFieldName('ballotId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ballot_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : QuestionTableMap::translateFieldName('orderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : QuestionTableMap::translateFieldName('isDeleted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_deleted = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : QuestionTableMap::translateFieldName('type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : QuestionTableMap::translateFieldName('count', TableMap::TYPE_PHPNAME, $indexType)];
            $this->count = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : QuestionTableMap::translateFieldName('name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : QuestionTableMap::translateFieldName('description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : QuestionTableMap::translateFieldName('readmore', TableMap::TYPE_PHPNAME, $indexType)];
            $this->readmore = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : QuestionTableMap::translateFieldName('discussion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discussion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : QuestionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : QuestionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : QuestionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : QuestionTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : QuestionTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = QuestionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MESBallotBox\\Propel\\Question'), 0, $e);
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
        if ($this->aBallot !== null && $this->ballot_id !== $this->aBallot->getid()) {
            $this->aBallot = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(QuestionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildQuestionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBallot = null;
            $this->collCandidates = null;

            $this->collVoteItems = null;

            $this->collQuestionVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Question::setDeleted()
     * @see Question::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildQuestionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(QuestionTableMap::COL_VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(QuestionTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(QuestionTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(QuestionTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                // versionable behavior
                if (isset($createVersion)) {
                    $this->addVersion($con);
                }
                QuestionTableMap::addInstanceToPool($this);
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

            if ($this->aBallot !== null) {
                if ($this->aBallot->isModified() || $this->aBallot->isNew()) {
                    $affectedRows += $this->aBallot->save($con);
                }
                $this->setBallot($this->aBallot);
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

            if ($this->candidatesScheduledForDeletion !== null) {
                if (!$this->candidatesScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\CandidateQuery::create()
                        ->filterByPrimaryKeys($this->candidatesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->candidatesScheduledForDeletion = null;
                }
            }

            if ($this->collCandidates !== null) {
                foreach ($this->collCandidates as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->voteItemsScheduledForDeletion !== null) {
                if (!$this->voteItemsScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\VoteItemQuery::create()
                        ->filterByPrimaryKeys($this->voteItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->voteItemsScheduledForDeletion = null;
                }
            }

            if ($this->collVoteItems !== null) {
                foreach ($this->collVoteItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->questionVersionsScheduledForDeletion !== null) {
                if (!$this->questionVersionsScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\QuestionVersionQuery::create()
                        ->filterByPrimaryKeys($this->questionVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->questionVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collQuestionVersions !== null) {
                foreach ($this->collQuestionVersions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[QuestionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . QuestionTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(QuestionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_BALLOT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ballot_id';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'order_id';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_IS_DELETED)) {
            $modifiedColumns[':p' . $index++]  = 'is_deleted';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'count';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_READMORE)) {
            $modifiedColumns[':p' . $index++]  = 'readmore';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_DISCUSSION)) {
            $modifiedColumns[':p' . $index++]  = 'discussion';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }

        $sql = sprintf(
            'INSERT INTO Question (%s) VALUES (%s)',
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
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setid($pk);

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
        $pos = QuestionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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

        if (isset($alreadyDumpedObjects['Question'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Question'][$this->hashCode()] = true;
        $keys = QuestionTableMap::getFieldNames($keyType);
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
            if (null !== $this->aBallot) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ballot';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Ballot';
                        break;
                    default:
                        $key = 'Ballot';
                }

                $result[$key] = $this->aBallot->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCandidates) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'candidates';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Candidates';
                        break;
                    default:
                        $key = 'Candidates';
                }

                $result[$key] = $this->collCandidates->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVoteItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'voteItems';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Vote_items';
                        break;
                    default:
                        $key = 'VoteItems';
                }

                $result[$key] = $this->collVoteItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuestionVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'questionVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Question_versions';
                        break;
                    default:
                        $key = 'QuestionVersions';
                }

                $result[$key] = $this->collQuestionVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\MESBallotBox\Propel\Question
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = QuestionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MESBallotBox\Propel\Question
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
                $valueSet = QuestionTableMap::getValueSet(QuestionTableMap::COL_TYPE);
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
        $keys = QuestionTableMap::getFieldNames($keyType);

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
     * @return $this|\MESBallotBox\Propel\Question The current object, for fluid interface
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
        $criteria = new Criteria(QuestionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(QuestionTableMap::COL_ID)) {
            $criteria->add(QuestionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_BALLOT_ID)) {
            $criteria->add(QuestionTableMap::COL_BALLOT_ID, $this->ballot_id);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_ORDER_ID)) {
            $criteria->add(QuestionTableMap::COL_ORDER_ID, $this->order_id);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_IS_DELETED)) {
            $criteria->add(QuestionTableMap::COL_IS_DELETED, $this->is_deleted);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_TYPE)) {
            $criteria->add(QuestionTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_COUNT)) {
            $criteria->add(QuestionTableMap::COL_COUNT, $this->count);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_NAME)) {
            $criteria->add(QuestionTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_DESCRIPTION)) {
            $criteria->add(QuestionTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_READMORE)) {
            $criteria->add(QuestionTableMap::COL_READMORE, $this->readmore);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_DISCUSSION)) {
            $criteria->add(QuestionTableMap::COL_DISCUSSION, $this->discussion);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_CREATED_AT)) {
            $criteria->add(QuestionTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_UPDATED_AT)) {
            $criteria->add(QuestionTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_VERSION)) {
            $criteria->add(QuestionTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(QuestionTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(QuestionTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
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
        $criteria = ChildQuestionQuery::create();
        $criteria->add(QuestionTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getid();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getid();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MESBallotBox\Propel\Question (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
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

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCandidates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCandidate($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVoteItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVoteItem($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuestionVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuestionVersion($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \MESBallotBox\Propel\Question Clone of current object.
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
     * Declares an association between this object and a ChildBallot object.
     *
     * @param  ChildBallot $v
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBallot(ChildBallot $v = null)
    {
        if ($v === null) {
            $this->setballotId(NULL);
        } else {
            $this->setballotId($v->getid());
        }

        $this->aBallot = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBallot object, it will not be re-added.
        if ($v !== null) {
            $v->addQuestion($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBallot object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBallot The associated ChildBallot object.
     * @throws PropelException
     */
    public function getBallot(ConnectionInterface $con = null)
    {
        if ($this->aBallot === null && ($this->ballot_id !== null)) {
            $this->aBallot = ChildBallotQuery::create()->findPk($this->ballot_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBallot->addQuestions($this);
             */
        }

        return $this->aBallot;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Candidate' == $relationName) {
            return $this->initCandidates();
        }
        if ('VoteItem' == $relationName) {
            return $this->initVoteItems();
        }
        if ('QuestionVersion' == $relationName) {
            return $this->initQuestionVersions();
        }
    }

    /**
     * Clears out the collCandidates collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCandidates()
     */
    public function clearCandidates()
    {
        $this->collCandidates = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCandidates collection loaded partially.
     */
    public function resetPartialCandidates($v = true)
    {
        $this->collCandidatesPartial = $v;
    }

    /**
     * Initializes the collCandidates collection.
     *
     * By default this just sets the collCandidates collection to an empty array (like clearcollCandidates());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCandidates($overrideExisting = true)
    {
        if (null !== $this->collCandidates && !$overrideExisting) {
            return;
        }

        $collectionClassName = CandidateTableMap::getTableMap()->getCollectionClassName();

        $this->collCandidates = new $collectionClassName;
        $this->collCandidates->setModel('\MESBallotBox\Propel\Candidate');
    }

    /**
     * Gets an array of ChildCandidate objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildQuestion is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCandidate[] List of ChildCandidate objects
     * @throws PropelException
     */
    public function getCandidates(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCandidatesPartial && !$this->isNew();
        if (null === $this->collCandidates || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCandidates) {
                // return empty collection
                $this->initCandidates();
            } else {
                $collCandidates = ChildCandidateQuery::create(null, $criteria)
                    ->filterByQuestion($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCandidatesPartial && count($collCandidates)) {
                        $this->initCandidates(false);

                        foreach ($collCandidates as $obj) {
                            if (false == $this->collCandidates->contains($obj)) {
                                $this->collCandidates->append($obj);
                            }
                        }

                        $this->collCandidatesPartial = true;
                    }

                    return $collCandidates;
                }

                if ($partial && $this->collCandidates) {
                    foreach ($this->collCandidates as $obj) {
                        if ($obj->isNew()) {
                            $collCandidates[] = $obj;
                        }
                    }
                }

                $this->collCandidates = $collCandidates;
                $this->collCandidatesPartial = false;
            }
        }

        return $this->collCandidates;
    }

    /**
     * Sets a collection of ChildCandidate objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $candidates A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function setCandidates(Collection $candidates, ConnectionInterface $con = null)
    {
        /** @var ChildCandidate[] $candidatesToDelete */
        $candidatesToDelete = $this->getCandidates(new Criteria(), $con)->diff($candidates);


        $this->candidatesScheduledForDeletion = $candidatesToDelete;

        foreach ($candidatesToDelete as $candidateRemoved) {
            $candidateRemoved->setQuestion(null);
        }

        $this->collCandidates = null;
        foreach ($candidates as $candidate) {
            $this->addCandidate($candidate);
        }

        $this->collCandidates = $candidates;
        $this->collCandidatesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Candidate objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Candidate objects.
     * @throws PropelException
     */
    public function countCandidates(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCandidatesPartial && !$this->isNew();
        if (null === $this->collCandidates || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCandidates) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCandidates());
            }

            $query = ChildCandidateQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByQuestion($this)
                ->count($con);
        }

        return count($this->collCandidates);
    }

    /**
     * Method called to associate a ChildCandidate object to this object
     * through the ChildCandidate foreign key attribute.
     *
     * @param  ChildCandidate $l ChildCandidate
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function addCandidate(ChildCandidate $l)
    {
        if ($this->collCandidates === null) {
            $this->initCandidates();
            $this->collCandidatesPartial = true;
        }

        if (!$this->collCandidates->contains($l)) {
            $this->doAddCandidate($l);

            if ($this->candidatesScheduledForDeletion and $this->candidatesScheduledForDeletion->contains($l)) {
                $this->candidatesScheduledForDeletion->remove($this->candidatesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCandidate $candidate The ChildCandidate object to add.
     */
    protected function doAddCandidate(ChildCandidate $candidate)
    {
        $this->collCandidates[]= $candidate;
        $candidate->setQuestion($this);
    }

    /**
     * @param  ChildCandidate $candidate The ChildCandidate object to remove.
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function removeCandidate(ChildCandidate $candidate)
    {
        if ($this->getCandidates()->contains($candidate)) {
            $pos = $this->collCandidates->search($candidate);
            $this->collCandidates->remove($pos);
            if (null === $this->candidatesScheduledForDeletion) {
                $this->candidatesScheduledForDeletion = clone $this->collCandidates;
                $this->candidatesScheduledForDeletion->clear();
            }
            $this->candidatesScheduledForDeletion[]= clone $candidate;
            $candidate->setQuestion(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Question is new, it will return
     * an empty collection; or if this Question has previously
     * been saved, it will retrieve related Candidates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Question.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCandidate[] List of ChildCandidate objects
     */
    public function getCandidatesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCandidateQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getCandidates($query, $con);
    }

    /**
     * Clears out the collVoteItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVoteItems()
     */
    public function clearVoteItems()
    {
        $this->collVoteItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVoteItems collection loaded partially.
     */
    public function resetPartialVoteItems($v = true)
    {
        $this->collVoteItemsPartial = $v;
    }

    /**
     * Initializes the collVoteItems collection.
     *
     * By default this just sets the collVoteItems collection to an empty array (like clearcollVoteItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVoteItems($overrideExisting = true)
    {
        if (null !== $this->collVoteItems && !$overrideExisting) {
            return;
        }

        $collectionClassName = VoteItemTableMap::getTableMap()->getCollectionClassName();

        $this->collVoteItems = new $collectionClassName;
        $this->collVoteItems->setModel('\MESBallotBox\Propel\VoteItem');
    }

    /**
     * Gets an array of ChildVoteItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildQuestion is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVoteItem[] List of ChildVoteItem objects
     * @throws PropelException
     */
    public function getVoteItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVoteItemsPartial && !$this->isNew();
        if (null === $this->collVoteItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVoteItems) {
                // return empty collection
                $this->initVoteItems();
            } else {
                $collVoteItems = ChildVoteItemQuery::create(null, $criteria)
                    ->filterByQuestion($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVoteItemsPartial && count($collVoteItems)) {
                        $this->initVoteItems(false);

                        foreach ($collVoteItems as $obj) {
                            if (false == $this->collVoteItems->contains($obj)) {
                                $this->collVoteItems->append($obj);
                            }
                        }

                        $this->collVoteItemsPartial = true;
                    }

                    return $collVoteItems;
                }

                if ($partial && $this->collVoteItems) {
                    foreach ($this->collVoteItems as $obj) {
                        if ($obj->isNew()) {
                            $collVoteItems[] = $obj;
                        }
                    }
                }

                $this->collVoteItems = $collVoteItems;
                $this->collVoteItemsPartial = false;
            }
        }

        return $this->collVoteItems;
    }

    /**
     * Sets a collection of ChildVoteItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $voteItems A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function setVoteItems(Collection $voteItems, ConnectionInterface $con = null)
    {
        /** @var ChildVoteItem[] $voteItemsToDelete */
        $voteItemsToDelete = $this->getVoteItems(new Criteria(), $con)->diff($voteItems);


        $this->voteItemsScheduledForDeletion = $voteItemsToDelete;

        foreach ($voteItemsToDelete as $voteItemRemoved) {
            $voteItemRemoved->setQuestion(null);
        }

        $this->collVoteItems = null;
        foreach ($voteItems as $voteItem) {
            $this->addVoteItem($voteItem);
        }

        $this->collVoteItems = $voteItems;
        $this->collVoteItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related VoteItem objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related VoteItem objects.
     * @throws PropelException
     */
    public function countVoteItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVoteItemsPartial && !$this->isNew();
        if (null === $this->collVoteItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVoteItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVoteItems());
            }

            $query = ChildVoteItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByQuestion($this)
                ->count($con);
        }

        return count($this->collVoteItems);
    }

    /**
     * Method called to associate a ChildVoteItem object to this object
     * through the ChildVoteItem foreign key attribute.
     *
     * @param  ChildVoteItem $l ChildVoteItem
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function addVoteItem(ChildVoteItem $l)
    {
        if ($this->collVoteItems === null) {
            $this->initVoteItems();
            $this->collVoteItemsPartial = true;
        }

        if (!$this->collVoteItems->contains($l)) {
            $this->doAddVoteItem($l);

            if ($this->voteItemsScheduledForDeletion and $this->voteItemsScheduledForDeletion->contains($l)) {
                $this->voteItemsScheduledForDeletion->remove($this->voteItemsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVoteItem $voteItem The ChildVoteItem object to add.
     */
    protected function doAddVoteItem(ChildVoteItem $voteItem)
    {
        $this->collVoteItems[]= $voteItem;
        $voteItem->setQuestion($this);
    }

    /**
     * @param  ChildVoteItem $voteItem The ChildVoteItem object to remove.
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function removeVoteItem(ChildVoteItem $voteItem)
    {
        if ($this->getVoteItems()->contains($voteItem)) {
            $pos = $this->collVoteItems->search($voteItem);
            $this->collVoteItems->remove($pos);
            if (null === $this->voteItemsScheduledForDeletion) {
                $this->voteItemsScheduledForDeletion = clone $this->collVoteItems;
                $this->voteItemsScheduledForDeletion->clear();
            }
            $this->voteItemsScheduledForDeletion[]= clone $voteItem;
            $voteItem->setQuestion(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Question is new, it will return
     * an empty collection; or if this Question has previously
     * been saved, it will retrieve related VoteItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Question.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVoteItem[] List of ChildVoteItem objects
     */
    public function getVoteItemsJoinVote(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoteItemQuery::create(null, $criteria);
        $query->joinWith('Vote', $joinBehavior);

        return $this->getVoteItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Question is new, it will return
     * an empty collection; or if this Question has previously
     * been saved, it will retrieve related VoteItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Question.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVoteItem[] List of ChildVoteItem objects
     */
    public function getVoteItemsJoinCandidate(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoteItemQuery::create(null, $criteria);
        $query->joinWith('Candidate', $joinBehavior);

        return $this->getVoteItems($query, $con);
    }

    /**
     * Clears out the collQuestionVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestionVersions()
     */
    public function clearQuestionVersions()
    {
        $this->collQuestionVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collQuestionVersions collection loaded partially.
     */
    public function resetPartialQuestionVersions($v = true)
    {
        $this->collQuestionVersionsPartial = $v;
    }

    /**
     * Initializes the collQuestionVersions collection.
     *
     * By default this just sets the collQuestionVersions collection to an empty array (like clearcollQuestionVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuestionVersions($overrideExisting = true)
    {
        if (null !== $this->collQuestionVersions && !$overrideExisting) {
            return;
        }

        $collectionClassName = QuestionVersionTableMap::getTableMap()->getCollectionClassName();

        $this->collQuestionVersions = new $collectionClassName;
        $this->collQuestionVersions->setModel('\MESBallotBox\Propel\QuestionVersion');
    }

    /**
     * Gets an array of ChildQuestionVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildQuestion is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuestionVersion[] List of ChildQuestionVersion objects
     * @throws PropelException
     */
    public function getQuestionVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionVersionsPartial && !$this->isNew();
        if (null === $this->collQuestionVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuestionVersions) {
                // return empty collection
                $this->initQuestionVersions();
            } else {
                $collQuestionVersions = ChildQuestionVersionQuery::create(null, $criteria)
                    ->filterByQuestion($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collQuestionVersionsPartial && count($collQuestionVersions)) {
                        $this->initQuestionVersions(false);

                        foreach ($collQuestionVersions as $obj) {
                            if (false == $this->collQuestionVersions->contains($obj)) {
                                $this->collQuestionVersions->append($obj);
                            }
                        }

                        $this->collQuestionVersionsPartial = true;
                    }

                    return $collQuestionVersions;
                }

                if ($partial && $this->collQuestionVersions) {
                    foreach ($this->collQuestionVersions as $obj) {
                        if ($obj->isNew()) {
                            $collQuestionVersions[] = $obj;
                        }
                    }
                }

                $this->collQuestionVersions = $collQuestionVersions;
                $this->collQuestionVersionsPartial = false;
            }
        }

        return $this->collQuestionVersions;
    }

    /**
     * Sets a collection of ChildQuestionVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $questionVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function setQuestionVersions(Collection $questionVersions, ConnectionInterface $con = null)
    {
        /** @var ChildQuestionVersion[] $questionVersionsToDelete */
        $questionVersionsToDelete = $this->getQuestionVersions(new Criteria(), $con)->diff($questionVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->questionVersionsScheduledForDeletion = clone $questionVersionsToDelete;

        foreach ($questionVersionsToDelete as $questionVersionRemoved) {
            $questionVersionRemoved->setQuestion(null);
        }

        $this->collQuestionVersions = null;
        foreach ($questionVersions as $questionVersion) {
            $this->addQuestionVersion($questionVersion);
        }

        $this->collQuestionVersions = $questionVersions;
        $this->collQuestionVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related QuestionVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related QuestionVersion objects.
     * @throws PropelException
     */
    public function countQuestionVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionVersionsPartial && !$this->isNew();
        if (null === $this->collQuestionVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuestionVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getQuestionVersions());
            }

            $query = ChildQuestionVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByQuestion($this)
                ->count($con);
        }

        return count($this->collQuestionVersions);
    }

    /**
     * Method called to associate a ChildQuestionVersion object to this object
     * through the ChildQuestionVersion foreign key attribute.
     *
     * @param  ChildQuestionVersion $l ChildQuestionVersion
     * @return $this|\MESBallotBox\Propel\Question The current object (for fluent API support)
     */
    public function addQuestionVersion(ChildQuestionVersion $l)
    {
        if ($this->collQuestionVersions === null) {
            $this->initQuestionVersions();
            $this->collQuestionVersionsPartial = true;
        }

        if (!$this->collQuestionVersions->contains($l)) {
            $this->doAddQuestionVersion($l);

            if ($this->questionVersionsScheduledForDeletion and $this->questionVersionsScheduledForDeletion->contains($l)) {
                $this->questionVersionsScheduledForDeletion->remove($this->questionVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildQuestionVersion $questionVersion The ChildQuestionVersion object to add.
     */
    protected function doAddQuestionVersion(ChildQuestionVersion $questionVersion)
    {
        $this->collQuestionVersions[]= $questionVersion;
        $questionVersion->setQuestion($this);
    }

    /**
     * @param  ChildQuestionVersion $questionVersion The ChildQuestionVersion object to remove.
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function removeQuestionVersion(ChildQuestionVersion $questionVersion)
    {
        if ($this->getQuestionVersions()->contains($questionVersion)) {
            $pos = $this->collQuestionVersions->search($questionVersion);
            $this->collQuestionVersions->remove($pos);
            if (null === $this->questionVersionsScheduledForDeletion) {
                $this->questionVersionsScheduledForDeletion = clone $this->collQuestionVersions;
                $this->questionVersionsScheduledForDeletion->clear();
            }
            $this->questionVersionsScheduledForDeletion[]= clone $questionVersion;
            $questionVersion->setQuestion(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aBallot) {
            $this->aBallot->removeQuestion($this);
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
            if ($this->collCandidates) {
                foreach ($this->collCandidates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVoteItems) {
                foreach ($this->collVoteItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuestionVersions) {
                foreach ($this->collQuestionVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCandidates = null;
        $this->collVoteItems = null;
        $this->collQuestionVersions = null;
        $this->aBallot = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(QuestionTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildQuestion The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[QuestionTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\MESBallotBox\Propel\Question
     */
    public function enforceVersioning()
    {
        $this->enforceVersion = true;

        return $this;
    }

    /**
     * Checks whether the current state must be recorded as a version
     *
     * @return  boolean
     */
    public function isVersioningNecessary($con = null)
    {
        if ($this->alreadyInSave) {
            return false;
        }

        if ($this->enforceVersion) {
            return true;
        }

        if (ChildQuestionQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getBallot($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }

        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getCandidates(null, $con) as $relatedObject) {
            if ($relatedObject->isVersioningNecessary($con)) {
                $this->alreadyInSave = false;

                return true;
            }
        }
        $this->alreadyInSave = false;

        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getVoteItems(null, $con) as $relatedObject) {
            if ($relatedObject->isVersioningNecessary($con)) {
                $this->alreadyInSave = false;

                return true;
            }
        }
        $this->alreadyInSave = false;


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildQuestionVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildQuestionVersion();
        $version->setid($this->getid());
        $version->setballotId($this->getballotId());
        $version->setorderId($this->getorderId());
        $version->setisDeleted($this->getisDeleted());
        $version->settype($this->gettype());
        $version->setcount($this->getcount());
        $version->setname($this->getname());
        $version->setdescription($this->getdescription());
        $version->setreadmore($this->getreadmore());
        $version->setdiscussion($this->getdiscussion());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setQuestion($this);
        if (($related = $this->getBallot(null, $con)) && $related->getVersion()) {
            $version->setBallotIdVersion($related->getVersion());
        }
        if ($relateds = $this->getCandidates(null, $con)->toKeyValue('id', 'Version')) {
            $version->setCandidateIds(array_keys($relateds));
            $version->setCandidateVersions(array_values($relateds));
        }
        if ($relateds = $this->getVoteItems(null, $con)->toKeyValue('id', 'Version')) {
            $version->setVoteItemIds(array_keys($relateds));
            $version->setVoteItemVersions(array_values($relateds));
        }
        $version->save($con);

        return $version;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  $this|ChildQuestion The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildQuestion object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildQuestionVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildQuestion'][$version->getid()][$version->getVersion()] = $this;
        $this->setid($version->getid());
        $this->setballotId($version->getballotId());
        $this->setorderId($version->getorderId());
        $this->setisDeleted($version->getisDeleted());
        $this->settype($version->gettype());
        $this->setcount($version->getcount());
        $this->setname($version->getname());
        $this->setdescription($version->getdescription());
        $this->setreadmore($version->getreadmore());
        $this->setdiscussion($version->getdiscussion());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        if ($fkValue = $version->getballotId()) {
            if (isset($loadedObjects['ChildBallot']) && isset($loadedObjects['ChildBallot'][$fkValue]) && isset($loadedObjects['ChildBallot'][$fkValue][$version->getBallotIdVersion()])) {
                $related = $loadedObjects['ChildBallot'][$fkValue][$version->getBallotIdVersion()];
            } else {
                $related = new ChildBallot();
                $relatedVersion = ChildBallotVersionQuery::create()
                    ->filterByid($fkValue)
                    ->filterByVersion($version->getBallotIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setBallot($related);
        }
        if ($fkValues = $version->getCandidateIds()) {
            $this->clearCandidates();
            $fkVersions = $version->getCandidateVersions();
            $query = ChildCandidateVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(CandidateVersionTableMap::COL_ID, $value);
                $c2 = $query->getNewCriterion(CandidateVersionTableMap::COL_VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildCandidate']) && isset($loadedObjects['ChildCandidate'][$relatedVersion->getid()]) && isset($loadedObjects['ChildCandidate'][$relatedVersion->getid()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildCandidate'][$relatedVersion->getid()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildCandidate();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addCandidate($related);
                $this->collCandidatesPartial = false;
            }
        }
        if ($fkValues = $version->getVoteItemIds()) {
            $this->clearVoteItem();
            $fkVersions = $version->getVoteItemVersions();
            $query = ChildVoteItemVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(VoteItemVersionTableMap::COL_ID, $value);
                $c2 = $query->getNewCriterion(VoteItemVersionTableMap::COL_VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildVoteItem']) && isset($loadedObjects['ChildVoteItem'][$relatedVersion->getid()]) && isset($loadedObjects['ChildVoteItem'][$relatedVersion->getid()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildVoteItem'][$relatedVersion->getid()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildVoteItem();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addVoteItem($related);
                $this->collVoteItemPartial = false;
            }
        }

        return $this;
    }

    /**
     * Gets the latest persisted version number for the current object
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  integer
     */
    public function getLastVersionNumber($con = null)
    {
        $v = ChildQuestionVersionQuery::create()
            ->filterByQuestion($this)
            ->orderByVersion('desc')
            ->findOne($con);
        if (!$v) {
            return 0;
        }

        return $v->getVersion();
    }

    /**
     * Checks whether the current object is the latest one
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  Boolean
     */
    public function isLastVersion($con = null)
    {
        return $this->getLastVersionNumber($con) == $this->getVersion();
    }

    /**
     * Retrieves a version object for this entity and a version number
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildQuestionVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildQuestionVersionQuery::create()
            ->filterByQuestion($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection|ChildQuestionVersion[] A list of ChildQuestionVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(QuestionVersionTableMap::COL_VERSION);

        return $this->getQuestionVersions($criteria, $con);
    }

    /**
     * Compares the current object with another of its version.
     * <code>
     * print_r($book->compareVersion(1));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $versionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersion($versionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->toArray();
        $toVersion = $this->getOneVersion($versionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Compares two versions of the current object.
     * <code>
     * print_r($book->compareVersions(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $fromVersionNumber
     * @param   integer             $toVersionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersions($fromVersionNumber, $toVersionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->getOneVersion($fromVersionNumber, $con)->toArray();
        $toVersion = $this->getOneVersion($toVersionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Computes the diff between two versions.
     * <code>
     * print_r($book->computeDiff(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   array     $fromVersion     An array representing the original version.
     * @param   array     $toVersion       An array representing the destination version.
     * @param   string    $keys            Main key used for the result diff (versions|columns).
     * @param   array     $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    protected function computeDiff($fromVersion, $toVersion, $keys = 'columns', $ignoredColumns = array())
    {
        $fromVersionNumber = $fromVersion['Version'];
        $toVersionNumber = $toVersion['Version'];
        $ignoredColumns = array_merge(array(
            'Version',
            'VersionCreatedAt',
            'VersionCreatedBy',
        ), $ignoredColumns);
        $diff = array();
        foreach ($fromVersion as $key => $value) {
            if (in_array($key, $ignoredColumns)) {
                continue;
            }
            if ($toVersion[$key] != $value) {
                switch ($keys) {
                    case 'versions':
                        $diff[$fromVersionNumber][$key] = $value;
                        $diff[$toVersionNumber][$key] = $toVersion[$key];
                        break;
                    default:
                        $diff[$key] = array(
                            $fromVersionNumber => $value,
                            $toVersionNumber => $toVersion[$key],
                        );
                        break;
                }
            }
        }

        return $diff;
    }
    /**
     * retrieve the last $number versions.
     *
     * @param Integer $number the number of record to return.
     * @return PropelCollection|\MESBallotBox\Propel\QuestionVersion[] List of \MESBallotBox\Propel\QuestionVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildQuestionVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(QuestionVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getQuestionVersions($criteria, $con);
    }
    // validate behavior

    /**
     * Configure validators constraints. The Validator object uses this method
     * to perform object validation.
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotNull(array ('message' => 'Question name cannot be blank',)));
        $metadata->addPropertyConstraint('name', new Length(array ('min' => 3,'max' => 64,'minMessage' => 'Question name too short','maxMessage' => 'Ballot name too long',)));
    }

    /**
     * Validates the object and all objects related to this table.
     *
     * @see        getValidationFailures()
     * @param      ValidatorInterface|null $validator A Validator class instance
     * @return     boolean Whether all objects pass validation.
     */
    public function validate(ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            $validator = new RecursiveValidator(
                new ExecutionContextFactory(new IdentityTranslator()),
                new LazyLoadingMetadataFactory(new StaticMethodLoader()),
                new ConstraintValidatorFactory()
            );
        }

        $failureMap = new ConstraintViolationList();

        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aBallot, 'validate')) {
                if (!$this->aBallot->validate($validator)) {
                    $failureMap->addAll($this->aBallot->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collCandidates) {
                foreach ($this->collCandidates as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collVoteItems) {
                foreach ($this->collVoteItems as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collQuestionVersions) {
                foreach ($this->collQuestionVersions as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }

            $this->alreadyInValidation = false;
        }

        $this->validationFailures = $failureMap;

        return (Boolean) (!(count($this->validationFailures) > 0));

    }

    /**
     * Gets any ConstraintViolation objects that resulted from last call to validate().
     *
     *
     * @return     object ConstraintViolationList
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
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
