<?php

namespace MESBallotBox\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use MESBallotBox\Propel\Ballot as ChildBallot;
use MESBallotBox\Propel\BallotQuery as ChildBallotQuery;
use MESBallotBox\Propel\BallotVersion as ChildBallotVersion;
use MESBallotBox\Propel\BallotVersionQuery as ChildBallotVersionQuery;
use MESBallotBox\Propel\Question as ChildQuestion;
use MESBallotBox\Propel\QuestionQuery as ChildQuestionQuery;
use MESBallotBox\Propel\QuestionVersionQuery as ChildQuestionVersionQuery;
use MESBallotBox\Propel\Vote as ChildVote;
use MESBallotBox\Propel\VoteQuery as ChildVoteQuery;
use MESBallotBox\Propel\VoteVersionQuery as ChildVoteVersionQuery;
use MESBallotBox\Propel\Voter as ChildVoter;
use MESBallotBox\Propel\VoterQuery as ChildVoterQuery;
use MESBallotBox\Propel\VoterVersionQuery as ChildVoterVersionQuery;
use MESBallotBox\Propel\Map\BallotTableMap;
use MESBallotBox\Propel\Map\BallotVersionTableMap;
use MESBallotBox\Propel\Map\QuestionTableMap;
use MESBallotBox\Propel\Map\QuestionVersionTableMap;
use MESBallotBox\Propel\Map\VoteTableMap;
use MESBallotBox\Propel\Map\VoteVersionTableMap;
use MESBallotBox\Propel\Map\VoterTableMap;
use MESBallotBox\Propel\Map\VoterVersionTableMap;
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
 * Base class that represents a row from the 'Ballot' table.
 *
 *
 *
* @package    propel.generator.MESBallotBox.Propel.Base
*/
abstract class Ballot implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MESBallotBox\\Propel\\Map\\BallotTableMap';


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
     * The value for the user_id field.
     *
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the start_time field.
     *
     * @var        int
     */
    protected $start_time;

    /**
     * The value for the end_time field.
     *
     * @var        int
     */
    protected $end_time;

    /**
     * The value for the timezone field.
     *
     * @var        int
     */
    protected $timezone;

    /**
     * The value for the version_created_by field.
     *
     * @var        int
     */
    protected $version_created_by;

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
     * @var        ObjectCollection|ChildVoter[] Collection to store aggregation of ChildVoter objects.
     */
    protected $collVoters;
    protected $collVotersPartial;

    /**
     * @var        ObjectCollection|ChildQuestion[] Collection to store aggregation of ChildQuestion objects.
     */
    protected $collQuestions;
    protected $collQuestionsPartial;

    /**
     * @var        ObjectCollection|ChildVote[] Collection to store aggregation of ChildVote objects.
     */
    protected $collVotes;
    protected $collVotesPartial;

    /**
     * @var        ObjectCollection|ChildBallotVersion[] Collection to store aggregation of ChildBallotVersion objects.
     */
    protected $collBallotVersions;
    protected $collBallotVersionsPartial;

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
     * @var ObjectCollection|ChildVoter[]
     */
    protected $votersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildQuestion[]
     */
    protected $questionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVote[]
     */
    protected $votesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBallotVersion[]
     */
    protected $ballotVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
    }

    /**
     * Initializes internal state of MESBallotBox\Propel\Base\Ballot object.
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
     * Compares this with another <code>Ballot</code> instance.  If
     * <code>obj</code> is an instance of <code>Ballot</code>, delegates to
     * <code>equals(Ballot)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Ballot The current object, for fluid interface
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
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getuserId()
    {
        return $this->user_id;
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
     * Get the [start_time] column value.
     *
     * @return int
     */
    public function getstartTime()
    {
        return $this->start_time;
    }

    /**
     * Get the [end_time] column value.
     *
     * @return int
     */
    public function getendTime()
    {
        return $this->end_time;
    }

    /**
     * Get the [timezone] column value.
     *
     * @return int
     */
    public function gettimezone()
    {
        return $this->timezone;
    }

    /**
     * Get the [version_created_by] column value.
     *
     * @return int
     */
    public function getversionCreatedBy()
    {
        return $this->version_created_by;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BallotTableMap::COL_ID] = true;
        }

        return $this;
    } // setid()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setuserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[BallotTableMap::COL_USER_ID] = true;
        }

        return $this;
    } // setuserId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[BallotTableMap::COL_NAME] = true;
        }

        return $this;
    } // setname()

    /**
     * Set the value of [start_time] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setstartTime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->start_time !== $v) {
            $this->start_time = $v;
            $this->modifiedColumns[BallotTableMap::COL_START_TIME] = true;
        }

        return $this;
    } // setstartTime()

    /**
     * Set the value of [end_time] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setendTime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->end_time !== $v) {
            $this->end_time = $v;
            $this->modifiedColumns[BallotTableMap::COL_END_TIME] = true;
        }

        return $this;
    } // setendTime()

    /**
     * Set the value of [timezone] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function settimezone($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->timezone !== $v) {
            $this->timezone = $v;
            $this->modifiedColumns[BallotTableMap::COL_TIMEZONE] = true;
        }

        return $this;
    } // settimezone()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setversionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[BallotTableMap::COL_VERSION_CREATED_BY] = true;
        }

        return $this;
    } // setversionCreatedBy()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BallotTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BallotTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[BallotTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->version_created_at->format("Y-m-d H:i:s")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BallotTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BallotTableMap::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BallotTableMap::translateFieldName('userId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BallotTableMap::translateFieldName('name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BallotTableMap::translateFieldName('startTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_time = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BallotTableMap::translateFieldName('endTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->end_time = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BallotTableMap::translateFieldName('timezone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->timezone = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BallotTableMap::translateFieldName('versionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BallotTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : BallotTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : BallotTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : BallotTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = BallotTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MESBallotBox\\Propel\\Ballot'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(BallotTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBallotQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collVoters = null;

            $this->collQuestions = null;

            $this->collVotes = null;

            $this->collBallotVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Ballot::setDeleted()
     * @see Ballot::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BallotTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBallotQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BallotTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(BallotTableMap::COL_VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(BallotTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(BallotTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(BallotTableMap::COL_UPDATED_AT)) {
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
                BallotTableMap::addInstanceToPool($this);
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

            if ($this->votersScheduledForDeletion !== null) {
                if (!$this->votersScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\VoterQuery::create()
                        ->filterByPrimaryKeys($this->votersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->votersScheduledForDeletion = null;
                }
            }

            if ($this->collVoters !== null) {
                foreach ($this->collVoters as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->questionsScheduledForDeletion !== null) {
                if (!$this->questionsScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\QuestionQuery::create()
                        ->filterByPrimaryKeys($this->questionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->questionsScheduledForDeletion = null;
                }
            }

            if ($this->collQuestions !== null) {
                foreach ($this->collQuestions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->votesScheduledForDeletion !== null) {
                if (!$this->votesScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\VoteQuery::create()
                        ->filterByPrimaryKeys($this->votesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->votesScheduledForDeletion = null;
                }
            }

            if ($this->collVotes !== null) {
                foreach ($this->collVotes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ballotVersionsScheduledForDeletion !== null) {
                if (!$this->ballotVersionsScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\BallotVersionQuery::create()
                        ->filterByPrimaryKeys($this->ballotVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ballotVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collBallotVersions !== null) {
                foreach ($this->collBallotVersions as $referrerFK) {
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

        $this->modifiedColumns[BallotTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BallotTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BallotTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(BallotTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(BallotTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(BallotTableMap::COL_START_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'start_time';
        }
        if ($this->isColumnModified(BallotTableMap::COL_END_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'end_time';
        }
        if ($this->isColumnModified(BallotTableMap::COL_TIMEZONE)) {
            $modifiedColumns[':p' . $index++]  = 'timezone';
        }
        if ($this->isColumnModified(BallotTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }
        if ($this->isColumnModified(BallotTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(BallotTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(BallotTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(BallotTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }

        $sql = sprintf(
            'INSERT INTO Ballot (%s) VALUES (%s)',
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
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'start_time':
                        $stmt->bindValue($identifier, $this->start_time, PDO::PARAM_INT);
                        break;
                    case 'end_time':
                        $stmt->bindValue($identifier, $this->end_time, PDO::PARAM_INT);
                        break;
                    case 'timezone':
                        $stmt->bindValue($identifier, $this->timezone, PDO::PARAM_INT);
                        break;
                    case 'version_created_by':
                        $stmt->bindValue($identifier, $this->version_created_by, PDO::PARAM_INT);
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
        $pos = BallotTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getuserId();
                break;
            case 2:
                return $this->getname();
                break;
            case 3:
                return $this->getstartTime();
                break;
            case 4:
                return $this->getendTime();
                break;
            case 5:
                return $this->gettimezone();
                break;
            case 6:
                return $this->getversionCreatedBy();
                break;
            case 7:
                return $this->getCreatedAt();
                break;
            case 8:
                return $this->getUpdatedAt();
                break;
            case 9:
                return $this->getVersion();
                break;
            case 10:
                return $this->getVersionCreatedAt();
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

        if (isset($alreadyDumpedObjects['Ballot'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Ballot'][$this->hashCode()] = true;
        $keys = BallotTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getid(),
            $keys[1] => $this->getuserId(),
            $keys[2] => $this->getname(),
            $keys[3] => $this->getstartTime(),
            $keys[4] => $this->getendTime(),
            $keys[5] => $this->gettimezone(),
            $keys[6] => $this->getversionCreatedBy(),
            $keys[7] => $this->getCreatedAt(),
            $keys[8] => $this->getUpdatedAt(),
            $keys[9] => $this->getVersion(),
            $keys[10] => $this->getVersionCreatedAt(),
        );
        if ($result[$keys[7]] instanceof \DateTime) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        if ($result[$keys[8]] instanceof \DateTime) {
            $result[$keys[8]] = $result[$keys[8]]->format('c');
        }

        if ($result[$keys[10]] instanceof \DateTime) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collVoters) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'voters';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Voters';
                        break;
                    default:
                        $key = 'Voters';
                }

                $result[$key] = $this->collVoters->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuestions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'questions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Questions';
                        break;
                    default:
                        $key = 'Questions';
                }

                $result[$key] = $this->collQuestions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVotes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'votes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Votes';
                        break;
                    default:
                        $key = 'Votes';
                }

                $result[$key] = $this->collVotes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBallotVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ballotVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Ballot_versions';
                        break;
                    default:
                        $key = 'BallotVersions';
                }

                $result[$key] = $this->collBallotVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\MESBallotBox\Propel\Ballot
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BallotTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MESBallotBox\Propel\Ballot
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setid($value);
                break;
            case 1:
                $this->setuserId($value);
                break;
            case 2:
                $this->setname($value);
                break;
            case 3:
                $this->setstartTime($value);
                break;
            case 4:
                $this->setendTime($value);
                break;
            case 5:
                $this->settimezone($value);
                break;
            case 6:
                $this->setversionCreatedBy($value);
                break;
            case 7:
                $this->setCreatedAt($value);
                break;
            case 8:
                $this->setUpdatedAt($value);
                break;
            case 9:
                $this->setVersion($value);
                break;
            case 10:
                $this->setVersionCreatedAt($value);
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
        $keys = BallotTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setuserId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setstartTime($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setendTime($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->settimezone($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setversionCreatedBy($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCreatedAt($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUpdatedAt($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setVersion($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setVersionCreatedAt($arr[$keys[10]]);
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
     * @return $this|\MESBallotBox\Propel\Ballot The current object, for fluid interface
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
        $criteria = new Criteria(BallotTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BallotTableMap::COL_ID)) {
            $criteria->add(BallotTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BallotTableMap::COL_USER_ID)) {
            $criteria->add(BallotTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(BallotTableMap::COL_NAME)) {
            $criteria->add(BallotTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(BallotTableMap::COL_START_TIME)) {
            $criteria->add(BallotTableMap::COL_START_TIME, $this->start_time);
        }
        if ($this->isColumnModified(BallotTableMap::COL_END_TIME)) {
            $criteria->add(BallotTableMap::COL_END_TIME, $this->end_time);
        }
        if ($this->isColumnModified(BallotTableMap::COL_TIMEZONE)) {
            $criteria->add(BallotTableMap::COL_TIMEZONE, $this->timezone);
        }
        if ($this->isColumnModified(BallotTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(BallotTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
        }
        if ($this->isColumnModified(BallotTableMap::COL_CREATED_AT)) {
            $criteria->add(BallotTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(BallotTableMap::COL_UPDATED_AT)) {
            $criteria->add(BallotTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(BallotTableMap::COL_VERSION)) {
            $criteria->add(BallotTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(BallotTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(BallotTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
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
        $criteria = ChildBallotQuery::create();
        $criteria->add(BallotTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \MESBallotBox\Propel\Ballot (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setuserId($this->getuserId());
        $copyObj->setname($this->getname());
        $copyObj->setstartTime($this->getstartTime());
        $copyObj->setendTime($this->getendTime());
        $copyObj->settimezone($this->gettimezone());
        $copyObj->setversionCreatedBy($this->getversionCreatedBy());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getVoters() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVoter($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuestions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuestion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVotes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVote($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBallotVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBallotVersion($relObj->copy($deepCopy));
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
     * @return \MESBallotBox\Propel\Ballot Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Voter' == $relationName) {
            return $this->initVoters();
        }
        if ('Question' == $relationName) {
            return $this->initQuestions();
        }
        if ('Vote' == $relationName) {
            return $this->initVotes();
        }
        if ('BallotVersion' == $relationName) {
            return $this->initBallotVersions();
        }
    }

    /**
     * Clears out the collVoters collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVoters()
     */
    public function clearVoters()
    {
        $this->collVoters = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVoters collection loaded partially.
     */
    public function resetPartialVoters($v = true)
    {
        $this->collVotersPartial = $v;
    }

    /**
     * Initializes the collVoters collection.
     *
     * By default this just sets the collVoters collection to an empty array (like clearcollVoters());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVoters($overrideExisting = true)
    {
        if (null !== $this->collVoters && !$overrideExisting) {
            return;
        }

        $collectionClassName = VoterTableMap::getTableMap()->getCollectionClassName();

        $this->collVoters = new $collectionClassName;
        $this->collVoters->setModel('\MESBallotBox\Propel\Voter');
    }

    /**
     * Gets an array of ChildVoter objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBallot is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVoter[] List of ChildVoter objects
     * @throws PropelException
     */
    public function getVoters(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVotersPartial && !$this->isNew();
        if (null === $this->collVoters || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVoters) {
                // return empty collection
                $this->initVoters();
            } else {
                $collVoters = ChildVoterQuery::create(null, $criteria)
                    ->filterByBallot($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVotersPartial && count($collVoters)) {
                        $this->initVoters(false);

                        foreach ($collVoters as $obj) {
                            if (false == $this->collVoters->contains($obj)) {
                                $this->collVoters->append($obj);
                            }
                        }

                        $this->collVotersPartial = true;
                    }

                    return $collVoters;
                }

                if ($partial && $this->collVoters) {
                    foreach ($this->collVoters as $obj) {
                        if ($obj->isNew()) {
                            $collVoters[] = $obj;
                        }
                    }
                }

                $this->collVoters = $collVoters;
                $this->collVotersPartial = false;
            }
        }

        return $this->collVoters;
    }

    /**
     * Sets a collection of ChildVoter objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $voters A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function setVoters(Collection $voters, ConnectionInterface $con = null)
    {
        /** @var ChildVoter[] $votersToDelete */
        $votersToDelete = $this->getVoters(new Criteria(), $con)->diff($voters);


        $this->votersScheduledForDeletion = $votersToDelete;

        foreach ($votersToDelete as $voterRemoved) {
            $voterRemoved->setBallot(null);
        }

        $this->collVoters = null;
        foreach ($voters as $voter) {
            $this->addVoter($voter);
        }

        $this->collVoters = $voters;
        $this->collVotersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Voter objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Voter objects.
     * @throws PropelException
     */
    public function countVoters(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVotersPartial && !$this->isNew();
        if (null === $this->collVoters || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVoters) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVoters());
            }

            $query = ChildVoterQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBallot($this)
                ->count($con);
        }

        return count($this->collVoters);
    }

    /**
     * Method called to associate a ChildVoter object to this object
     * through the ChildVoter foreign key attribute.
     *
     * @param  ChildVoter $l ChildVoter
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function addVoter(ChildVoter $l)
    {
        if ($this->collVoters === null) {
            $this->initVoters();
            $this->collVotersPartial = true;
        }

        if (!$this->collVoters->contains($l)) {
            $this->doAddVoter($l);

            if ($this->votersScheduledForDeletion and $this->votersScheduledForDeletion->contains($l)) {
                $this->votersScheduledForDeletion->remove($this->votersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVoter $voter The ChildVoter object to add.
     */
    protected function doAddVoter(ChildVoter $voter)
    {
        $this->collVoters[]= $voter;
        $voter->setBallot($this);
    }

    /**
     * @param  ChildVoter $voter The ChildVoter object to remove.
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function removeVoter(ChildVoter $voter)
    {
        if ($this->getVoters()->contains($voter)) {
            $pos = $this->collVoters->search($voter);
            $this->collVoters->remove($pos);
            if (null === $this->votersScheduledForDeletion) {
                $this->votersScheduledForDeletion = clone $this->collVoters;
                $this->votersScheduledForDeletion->clear();
            }
            $this->votersScheduledForDeletion[]= clone $voter;
            $voter->setBallot(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Ballot is new, it will return
     * an empty collection; or if this Ballot has previously
     * been saved, it will retrieve related Voters from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ballot.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVoter[] List of ChildVoter objects
     */
    public function getVotersJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoterQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getVoters($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Ballot is new, it will return
     * an empty collection; or if this Ballot has previously
     * been saved, it will retrieve related Voters from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ballot.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVoter[] List of ChildVoter objects
     */
    public function getVotersJoinAffiliate(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoterQuery::create(null, $criteria);
        $query->joinWith('Affiliate', $joinBehavior);

        return $this->getVoters($query, $con);
    }

    /**
     * Clears out the collQuestions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestions()
     */
    public function clearQuestions()
    {
        $this->collQuestions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collQuestions collection loaded partially.
     */
    public function resetPartialQuestions($v = true)
    {
        $this->collQuestionsPartial = $v;
    }

    /**
     * Initializes the collQuestions collection.
     *
     * By default this just sets the collQuestions collection to an empty array (like clearcollQuestions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuestions($overrideExisting = true)
    {
        if (null !== $this->collQuestions && !$overrideExisting) {
            return;
        }

        $collectionClassName = QuestionTableMap::getTableMap()->getCollectionClassName();

        $this->collQuestions = new $collectionClassName;
        $this->collQuestions->setModel('\MESBallotBox\Propel\Question');
    }

    /**
     * Gets an array of ChildQuestion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBallot is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuestion[] List of ChildQuestion objects
     * @throws PropelException
     */
    public function getQuestions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuestions) {
                // return empty collection
                $this->initQuestions();
            } else {
                $collQuestions = ChildQuestionQuery::create(null, $criteria)
                    ->filterByBallot($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collQuestionsPartial && count($collQuestions)) {
                        $this->initQuestions(false);

                        foreach ($collQuestions as $obj) {
                            if (false == $this->collQuestions->contains($obj)) {
                                $this->collQuestions->append($obj);
                            }
                        }

                        $this->collQuestionsPartial = true;
                    }

                    return $collQuestions;
                }

                if ($partial && $this->collQuestions) {
                    foreach ($this->collQuestions as $obj) {
                        if ($obj->isNew()) {
                            $collQuestions[] = $obj;
                        }
                    }
                }

                $this->collQuestions = $collQuestions;
                $this->collQuestionsPartial = false;
            }
        }

        return $this->collQuestions;
    }

    /**
     * Sets a collection of ChildQuestion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $questions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function setQuestions(Collection $questions, ConnectionInterface $con = null)
    {
        /** @var ChildQuestion[] $questionsToDelete */
        $questionsToDelete = $this->getQuestions(new Criteria(), $con)->diff($questions);


        $this->questionsScheduledForDeletion = $questionsToDelete;

        foreach ($questionsToDelete as $questionRemoved) {
            $questionRemoved->setBallot(null);
        }

        $this->collQuestions = null;
        foreach ($questions as $question) {
            $this->addQuestion($question);
        }

        $this->collQuestions = $questions;
        $this->collQuestionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Question objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Question objects.
     * @throws PropelException
     */
    public function countQuestions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuestions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getQuestions());
            }

            $query = ChildQuestionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBallot($this)
                ->count($con);
        }

        return count($this->collQuestions);
    }

    /**
     * Method called to associate a ChildQuestion object to this object
     * through the ChildQuestion foreign key attribute.
     *
     * @param  ChildQuestion $l ChildQuestion
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function addQuestion(ChildQuestion $l)
    {
        if ($this->collQuestions === null) {
            $this->initQuestions();
            $this->collQuestionsPartial = true;
        }

        if (!$this->collQuestions->contains($l)) {
            $this->doAddQuestion($l);

            if ($this->questionsScheduledForDeletion and $this->questionsScheduledForDeletion->contains($l)) {
                $this->questionsScheduledForDeletion->remove($this->questionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildQuestion $question The ChildQuestion object to add.
     */
    protected function doAddQuestion(ChildQuestion $question)
    {
        $this->collQuestions[]= $question;
        $question->setBallot($this);
    }

    /**
     * @param  ChildQuestion $question The ChildQuestion object to remove.
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function removeQuestion(ChildQuestion $question)
    {
        if ($this->getQuestions()->contains($question)) {
            $pos = $this->collQuestions->search($question);
            $this->collQuestions->remove($pos);
            if (null === $this->questionsScheduledForDeletion) {
                $this->questionsScheduledForDeletion = clone $this->collQuestions;
                $this->questionsScheduledForDeletion->clear();
            }
            $this->questionsScheduledForDeletion[]= clone $question;
            $question->setBallot(null);
        }

        return $this;
    }

    /**
     * Clears out the collVotes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVotes()
     */
    public function clearVotes()
    {
        $this->collVotes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVotes collection loaded partially.
     */
    public function resetPartialVotes($v = true)
    {
        $this->collVotesPartial = $v;
    }

    /**
     * Initializes the collVotes collection.
     *
     * By default this just sets the collVotes collection to an empty array (like clearcollVotes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVotes($overrideExisting = true)
    {
        if (null !== $this->collVotes && !$overrideExisting) {
            return;
        }

        $collectionClassName = VoteTableMap::getTableMap()->getCollectionClassName();

        $this->collVotes = new $collectionClassName;
        $this->collVotes->setModel('\MESBallotBox\Propel\Vote');
    }

    /**
     * Gets an array of ChildVote objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBallot is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVote[] List of ChildVote objects
     * @throws PropelException
     */
    public function getVotes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVotesPartial && !$this->isNew();
        if (null === $this->collVotes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVotes) {
                // return empty collection
                $this->initVotes();
            } else {
                $collVotes = ChildVoteQuery::create(null, $criteria)
                    ->filterByBallot($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVotesPartial && count($collVotes)) {
                        $this->initVotes(false);

                        foreach ($collVotes as $obj) {
                            if (false == $this->collVotes->contains($obj)) {
                                $this->collVotes->append($obj);
                            }
                        }

                        $this->collVotesPartial = true;
                    }

                    return $collVotes;
                }

                if ($partial && $this->collVotes) {
                    foreach ($this->collVotes as $obj) {
                        if ($obj->isNew()) {
                            $collVotes[] = $obj;
                        }
                    }
                }

                $this->collVotes = $collVotes;
                $this->collVotesPartial = false;
            }
        }

        return $this->collVotes;
    }

    /**
     * Sets a collection of ChildVote objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $votes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function setVotes(Collection $votes, ConnectionInterface $con = null)
    {
        /** @var ChildVote[] $votesToDelete */
        $votesToDelete = $this->getVotes(new Criteria(), $con)->diff($votes);


        $this->votesScheduledForDeletion = $votesToDelete;

        foreach ($votesToDelete as $voteRemoved) {
            $voteRemoved->setBallot(null);
        }

        $this->collVotes = null;
        foreach ($votes as $vote) {
            $this->addVote($vote);
        }

        $this->collVotes = $votes;
        $this->collVotesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Vote objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Vote objects.
     * @throws PropelException
     */
    public function countVotes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVotesPartial && !$this->isNew();
        if (null === $this->collVotes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVotes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVotes());
            }

            $query = ChildVoteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBallot($this)
                ->count($con);
        }

        return count($this->collVotes);
    }

    /**
     * Method called to associate a ChildVote object to this object
     * through the ChildVote foreign key attribute.
     *
     * @param  ChildVote $l ChildVote
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function addVote(ChildVote $l)
    {
        if ($this->collVotes === null) {
            $this->initVotes();
            $this->collVotesPartial = true;
        }

        if (!$this->collVotes->contains($l)) {
            $this->doAddVote($l);

            if ($this->votesScheduledForDeletion and $this->votesScheduledForDeletion->contains($l)) {
                $this->votesScheduledForDeletion->remove($this->votesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVote $vote The ChildVote object to add.
     */
    protected function doAddVote(ChildVote $vote)
    {
        $this->collVotes[]= $vote;
        $vote->setBallot($this);
    }

    /**
     * @param  ChildVote $vote The ChildVote object to remove.
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function removeVote(ChildVote $vote)
    {
        if ($this->getVotes()->contains($vote)) {
            $pos = $this->collVotes->search($vote);
            $this->collVotes->remove($pos);
            if (null === $this->votesScheduledForDeletion) {
                $this->votesScheduledForDeletion = clone $this->collVotes;
                $this->votesScheduledForDeletion->clear();
            }
            $this->votesScheduledForDeletion[]= clone $vote;
            $vote->setBallot(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Ballot is new, it will return
     * an empty collection; or if this Ballot has previously
     * been saved, it will retrieve related Votes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ballot.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVote[] List of ChildVote objects
     */
    public function getVotesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoteQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getVotes($query, $con);
    }

    /**
     * Clears out the collBallotVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBallotVersions()
     */
    public function clearBallotVersions()
    {
        $this->collBallotVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBallotVersions collection loaded partially.
     */
    public function resetPartialBallotVersions($v = true)
    {
        $this->collBallotVersionsPartial = $v;
    }

    /**
     * Initializes the collBallotVersions collection.
     *
     * By default this just sets the collBallotVersions collection to an empty array (like clearcollBallotVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBallotVersions($overrideExisting = true)
    {
        if (null !== $this->collBallotVersions && !$overrideExisting) {
            return;
        }

        $collectionClassName = BallotVersionTableMap::getTableMap()->getCollectionClassName();

        $this->collBallotVersions = new $collectionClassName;
        $this->collBallotVersions->setModel('\MESBallotBox\Propel\BallotVersion');
    }

    /**
     * Gets an array of ChildBallotVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBallot is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBallotVersion[] List of ChildBallotVersion objects
     * @throws PropelException
     */
    public function getBallotVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBallotVersionsPartial && !$this->isNew();
        if (null === $this->collBallotVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBallotVersions) {
                // return empty collection
                $this->initBallotVersions();
            } else {
                $collBallotVersions = ChildBallotVersionQuery::create(null, $criteria)
                    ->filterByBallot($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBallotVersionsPartial && count($collBallotVersions)) {
                        $this->initBallotVersions(false);

                        foreach ($collBallotVersions as $obj) {
                            if (false == $this->collBallotVersions->contains($obj)) {
                                $this->collBallotVersions->append($obj);
                            }
                        }

                        $this->collBallotVersionsPartial = true;
                    }

                    return $collBallotVersions;
                }

                if ($partial && $this->collBallotVersions) {
                    foreach ($this->collBallotVersions as $obj) {
                        if ($obj->isNew()) {
                            $collBallotVersions[] = $obj;
                        }
                    }
                }

                $this->collBallotVersions = $collBallotVersions;
                $this->collBallotVersionsPartial = false;
            }
        }

        return $this->collBallotVersions;
    }

    /**
     * Sets a collection of ChildBallotVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ballotVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function setBallotVersions(Collection $ballotVersions, ConnectionInterface $con = null)
    {
        /** @var ChildBallotVersion[] $ballotVersionsToDelete */
        $ballotVersionsToDelete = $this->getBallotVersions(new Criteria(), $con)->diff($ballotVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->ballotVersionsScheduledForDeletion = clone $ballotVersionsToDelete;

        foreach ($ballotVersionsToDelete as $ballotVersionRemoved) {
            $ballotVersionRemoved->setBallot(null);
        }

        $this->collBallotVersions = null;
        foreach ($ballotVersions as $ballotVersion) {
            $this->addBallotVersion($ballotVersion);
        }

        $this->collBallotVersions = $ballotVersions;
        $this->collBallotVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BallotVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BallotVersion objects.
     * @throws PropelException
     */
    public function countBallotVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBallotVersionsPartial && !$this->isNew();
        if (null === $this->collBallotVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBallotVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBallotVersions());
            }

            $query = ChildBallotVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBallot($this)
                ->count($con);
        }

        return count($this->collBallotVersions);
    }

    /**
     * Method called to associate a ChildBallotVersion object to this object
     * through the ChildBallotVersion foreign key attribute.
     *
     * @param  ChildBallotVersion $l ChildBallotVersion
     * @return $this|\MESBallotBox\Propel\Ballot The current object (for fluent API support)
     */
    public function addBallotVersion(ChildBallotVersion $l)
    {
        if ($this->collBallotVersions === null) {
            $this->initBallotVersions();
            $this->collBallotVersionsPartial = true;
        }

        if (!$this->collBallotVersions->contains($l)) {
            $this->doAddBallotVersion($l);

            if ($this->ballotVersionsScheduledForDeletion and $this->ballotVersionsScheduledForDeletion->contains($l)) {
                $this->ballotVersionsScheduledForDeletion->remove($this->ballotVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBallotVersion $ballotVersion The ChildBallotVersion object to add.
     */
    protected function doAddBallotVersion(ChildBallotVersion $ballotVersion)
    {
        $this->collBallotVersions[]= $ballotVersion;
        $ballotVersion->setBallot($this);
    }

    /**
     * @param  ChildBallotVersion $ballotVersion The ChildBallotVersion object to remove.
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function removeBallotVersion(ChildBallotVersion $ballotVersion)
    {
        if ($this->getBallotVersions()->contains($ballotVersion)) {
            $pos = $this->collBallotVersions->search($ballotVersion);
            $this->collBallotVersions->remove($pos);
            if (null === $this->ballotVersionsScheduledForDeletion) {
                $this->ballotVersionsScheduledForDeletion = clone $this->collBallotVersions;
                $this->ballotVersionsScheduledForDeletion->clear();
            }
            $this->ballotVersionsScheduledForDeletion[]= clone $ballotVersion;
            $ballotVersion->setBallot(null);
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
        $this->id = null;
        $this->user_id = null;
        $this->name = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->timezone = null;
        $this->version_created_by = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
        $this->version_created_at = null;
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
            if ($this->collVoters) {
                foreach ($this->collVoters as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuestions) {
                foreach ($this->collQuestions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVotes) {
                foreach ($this->collVotes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBallotVersions) {
                foreach ($this->collBallotVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collVoters = null;
        $this->collQuestions = null;
        $this->collVotes = null;
        $this->collBallotVersions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BallotTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildBallot The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[BallotTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\MESBallotBox\Propel\Ballot
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

        if (ChildBallotQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getVoters(null, $con) as $relatedObject) {
            if ($relatedObject->isVersioningNecessary($con)) {
                $this->alreadyInSave = false;

                return true;
            }
        }
        $this->alreadyInSave = false;

        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getQuestions(null, $con) as $relatedObject) {
            if ($relatedObject->isVersioningNecessary($con)) {
                $this->alreadyInSave = false;

                return true;
            }
        }
        $this->alreadyInSave = false;

        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getVotes(null, $con) as $relatedObject) {
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
     * @return  ChildBallotVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildBallotVersion();
        $version->setid($this->getid());
        $version->setuserId($this->getuserId());
        $version->setname($this->getname());
        $version->setstartTime($this->getstartTime());
        $version->setendTime($this->getendTime());
        $version->settimezone($this->gettimezone());
        $version->setversionCreatedBy($this->getversionCreatedBy());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setBallot($this);
        if ($relateds = $this->getVoters(null, $con)->toKeyValue('id', 'Version')) {
            $version->setVoterIds(array_keys($relateds));
            $version->setVoterVersions(array_values($relateds));
        }
        if ($relateds = $this->getQuestions(null, $con)->toKeyValue('id', 'Version')) {
            $version->setQuestionIds(array_keys($relateds));
            $version->setQuestionVersions(array_values($relateds));
        }
        if ($relateds = $this->getVotes(null, $con)->toKeyValue('id', 'Version')) {
            $version->setVoteIds(array_keys($relateds));
            $version->setVoteVersions(array_values($relateds));
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
     * @return  $this|ChildBallot The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildBallot object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildBallotVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildBallot The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildBallot'][$version->getid()][$version->getVersion()] = $this;
        $this->setid($version->getid());
        $this->setuserId($version->getuserId());
        $this->setname($version->getname());
        $this->setstartTime($version->getstartTime());
        $this->setendTime($version->getendTime());
        $this->settimezone($version->gettimezone());
        $this->setversionCreatedBy($version->getversionCreatedBy());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        if ($fkValues = $version->getVoterIds()) {
            $this->clearVoters();
            $fkVersions = $version->getVoterVersions();
            $query = ChildVoterVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(VoterVersionTableMap::COL_ID, $value);
                $c2 = $query->getNewCriterion(VoterVersionTableMap::COL_VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildVoter']) && isset($loadedObjects['ChildVoter'][$relatedVersion->getid()]) && isset($loadedObjects['ChildVoter'][$relatedVersion->getid()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildVoter'][$relatedVersion->getid()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildVoter();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addVoter($related);
                $this->collVotersPartial = false;
            }
        }
        if ($fkValues = $version->getQuestionIds()) {
            $this->clearQuestion();
            $fkVersions = $version->getQuestionVersions();
            $query = ChildQuestionVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(QuestionVersionTableMap::COL_ID, $value);
                $c2 = $query->getNewCriterion(QuestionVersionTableMap::COL_VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildQuestion']) && isset($loadedObjects['ChildQuestion'][$relatedVersion->getid()]) && isset($loadedObjects['ChildQuestion'][$relatedVersion->getid()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildQuestion'][$relatedVersion->getid()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildQuestion();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addQuestion($related);
                $this->collQuestionPartial = false;
            }
        }
        if ($fkValues = $version->getVoteIds()) {
            $this->clearVote();
            $fkVersions = $version->getVoteVersions();
            $query = ChildVoteVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(VoteVersionTableMap::COL_ID, $value);
                $c2 = $query->getNewCriterion(VoteVersionTableMap::COL_VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildVote']) && isset($loadedObjects['ChildVote'][$relatedVersion->getid()]) && isset($loadedObjects['ChildVote'][$relatedVersion->getid()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildVote'][$relatedVersion->getid()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildVote();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addVote($related);
                $this->collVotePartial = false;
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
        $v = ChildBallotVersionQuery::create()
            ->filterByBallot($this)
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
     * @return  ChildBallotVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildBallotVersionQuery::create()
            ->filterByBallot($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection|ChildBallotVersion[] A list of ChildBallotVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(BallotVersionTableMap::COL_VERSION);

        return $this->getBallotVersions($criteria, $con);
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
     * @return PropelCollection|\MESBallotBox\Propel\BallotVersion[] List of \MESBallotBox\Propel\BallotVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildBallotVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(BallotVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getBallotVersions($criteria, $con);
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
        $metadata->addPropertyConstraint('name', new NotNull(array ('message' => 'Ballot name cannot be blank',)));
        $metadata->addPropertyConstraint('name', new Length(array ('min' => 3,'max' => 40,'minMessage' => 'Ballot name too short','maxMessage' => 'Ballot name too long',)));
        $metadata->addPropertyConstraint('start_time', new NotNull());
        $metadata->addPropertyConstraint('end_time', new NotNull());
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


            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collVoters) {
                foreach ($this->collVoters as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collQuestions) {
                foreach ($this->collQuestions as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collVotes) {
                foreach ($this->collVotes as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collBallotVersions) {
                foreach ($this->collBallotVersions as $referrerFK) {
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
