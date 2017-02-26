<?php

namespace MESBallotBox\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use MESBallotBox\Propel\Candidate as ChildCandidate;
use MESBallotBox\Propel\CandidateQuery as ChildCandidateQuery;
use MESBallotBox\Propel\CandidateVersionQuery as ChildCandidateVersionQuery;
use MESBallotBox\Propel\Question as ChildQuestion;
use MESBallotBox\Propel\QuestionQuery as ChildQuestionQuery;
use MESBallotBox\Propel\QuestionVersionQuery as ChildQuestionVersionQuery;
use MESBallotBox\Propel\Vote as ChildVote;
use MESBallotBox\Propel\VoteItem as ChildVoteItem;
use MESBallotBox\Propel\VoteItemQuery as ChildVoteItemQuery;
use MESBallotBox\Propel\VoteItemVersion as ChildVoteItemVersion;
use MESBallotBox\Propel\VoteItemVersionQuery as ChildVoteItemVersionQuery;
use MESBallotBox\Propel\VoteQuery as ChildVoteQuery;
use MESBallotBox\Propel\VoteVersionQuery as ChildVoteVersionQuery;
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
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'Vote_item' table.
 *
 *
 *
 * @package    propel.generator.MESBallotBox.Propel.Base
 */
abstract class VoteItem implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MESBallotBox\\Propel\\Map\\VoteItemTableMap';


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
     * The value for the vote_id field.
     *
     * @var        int
     */
    protected $vote_id;

    /**
     * The value for the question_id field.
     *
     * @var        int
     */
    protected $question_id;

    /**
     * The value for the candidate_id field.
     *
     * @var        int
     */
    protected $candidate_id;

    /**
     * The value for the answer field.
     *
     * @var        int
     */
    protected $answer;

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
     * @var        ChildVote
     */
    protected $aVote;

    /**
     * @var        ChildQuestion
     */
    protected $aQuestion;

    /**
     * @var        ChildCandidate
     */
    protected $aCandidate;

    /**
     * @var        ObjectCollection|ChildVoteItemVersion[] Collection to store aggregation of ChildVoteItemVersion objects.
     */
    protected $collVoteItemVersions;
    protected $collVoteItemVersionsPartial;

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
     * @var ObjectCollection|ChildVoteItemVersion[]
     */
    protected $voteItemVersionsScheduledForDeletion = null;

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
     * Initializes internal state of MESBallotBox\Propel\Base\VoteItem object.
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
     * Compares this with another <code>VoteItem</code> instance.  If
     * <code>obj</code> is an instance of <code>VoteItem</code>, delegates to
     * <code>equals(VoteItem)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|VoteItem The current object, for fluid interface
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
     * Get the [vote_id] column value.
     *
     * @return int
     */
    public function getvoteId()
    {
        return $this->vote_id;
    }

    /**
     * Get the [question_id] column value.
     *
     * @return int
     */
    public function getquestionId()
    {
        return $this->question_id;
    }

    /**
     * Get the [candidate_id] column value.
     *
     * @return int
     */
    public function getcandidateId()
    {
        return $this->candidate_id;
    }

    /**
     * Get the [answer] column value.
     *
     * @return int
     */
    public function getanswer()
    {
        return $this->answer;
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
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[VoteItemTableMap::COL_ID] = true;
        }

        return $this;
    } // setid()

    /**
     * Set the value of [vote_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setvoteId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->vote_id !== $v) {
            $this->vote_id = $v;
            $this->modifiedColumns[VoteItemTableMap::COL_VOTE_ID] = true;
        }

        if ($this->aVote !== null && $this->aVote->getid() !== $v) {
            $this->aVote = null;
        }

        return $this;
    } // setvoteId()

    /**
     * Set the value of [question_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setquestionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->question_id !== $v) {
            $this->question_id = $v;
            $this->modifiedColumns[VoteItemTableMap::COL_QUESTION_ID] = true;
        }

        if ($this->aQuestion !== null && $this->aQuestion->getid() !== $v) {
            $this->aQuestion = null;
        }

        return $this;
    } // setquestionId()

    /**
     * Set the value of [candidate_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setcandidateId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->candidate_id !== $v) {
            $this->candidate_id = $v;
            $this->modifiedColumns[VoteItemTableMap::COL_CANDIDATE_ID] = true;
        }

        if ($this->aCandidate !== null && $this->aCandidate->getid() !== $v) {
            $this->aCandidate = null;
        }

        return $this;
    } // setcandidateId()

    /**
     * Set the value of [answer] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setanswer($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->answer !== $v) {
            $this->answer = $v;
            $this->modifiedColumns[VoteItemTableMap::COL_ANSWER] = true;
        }

        return $this;
    } // setanswer()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoteItemTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoteItemTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[VoteItemTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->version_created_at->format("Y-m-d H:i:s.u")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoteItemTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[VoteItemTableMap::COL_VERSION_CREATED_BY] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : VoteItemTableMap::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : VoteItemTableMap::translateFieldName('voteId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vote_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : VoteItemTableMap::translateFieldName('questionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->question_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : VoteItemTableMap::translateFieldName('candidateId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->candidate_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : VoteItemTableMap::translateFieldName('answer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->answer = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : VoteItemTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : VoteItemTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : VoteItemTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : VoteItemTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : VoteItemTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = VoteItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MESBallotBox\\Propel\\VoteItem'), 0, $e);
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
        if ($this->aVote !== null && $this->vote_id !== $this->aVote->getid()) {
            $this->aVote = null;
        }
        if ($this->aQuestion !== null && $this->question_id !== $this->aQuestion->getid()) {
            $this->aQuestion = null;
        }
        if ($this->aCandidate !== null && $this->candidate_id !== $this->aCandidate->getid()) {
            $this->aCandidate = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(VoteItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildVoteItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aVote = null;
            $this->aQuestion = null;
            $this->aCandidate = null;
            $this->collVoteItemVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see VoteItem::setDeleted()
     * @see VoteItem::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildVoteItemQuery::create()
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

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(VoteItemTableMap::COL_VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(VoteItemTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(VoteItemTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(VoteItemTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
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
                VoteItemTableMap::addInstanceToPool($this);
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

            if ($this->aVote !== null) {
                if ($this->aVote->isModified() || $this->aVote->isNew()) {
                    $affectedRows += $this->aVote->save($con);
                }
                $this->setVote($this->aVote);
            }

            if ($this->aQuestion !== null) {
                if ($this->aQuestion->isModified() || $this->aQuestion->isNew()) {
                    $affectedRows += $this->aQuestion->save($con);
                }
                $this->setQuestion($this->aQuestion);
            }

            if ($this->aCandidate !== null) {
                if ($this->aCandidate->isModified() || $this->aCandidate->isNew()) {
                    $affectedRows += $this->aCandidate->save($con);
                }
                $this->setCandidate($this->aCandidate);
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

            if ($this->voteItemVersionsScheduledForDeletion !== null) {
                if (!$this->voteItemVersionsScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\VoteItemVersionQuery::create()
                        ->filterByPrimaryKeys($this->voteItemVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->voteItemVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collVoteItemVersions !== null) {
                foreach ($this->collVoteItemVersions as $referrerFK) {
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

        $this->modifiedColumns[VoteItemTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . VoteItemTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(VoteItemTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VOTE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'vote_id';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_QUESTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'question_id';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_CANDIDATE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'candidate_id';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_ANSWER)) {
            $modifiedColumns[':p' . $index++]  = 'answer';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }

        $sql = sprintf(
            'INSERT INTO Vote_item (%s) VALUES (%s)',
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
                    case 'vote_id':
                        $stmt->bindValue($identifier, $this->vote_id, PDO::PARAM_INT);
                        break;
                    case 'question_id':
                        $stmt->bindValue($identifier, $this->question_id, PDO::PARAM_INT);
                        break;
                    case 'candidate_id':
                        $stmt->bindValue($identifier, $this->candidate_id, PDO::PARAM_INT);
                        break;
                    case 'answer':
                        $stmt->bindValue($identifier, $this->answer, PDO::PARAM_INT);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'version':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case 'version_created_at':
                        $stmt->bindValue($identifier, $this->version_created_at ? $this->version_created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = VoteItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getvoteId();
                break;
            case 2:
                return $this->getquestionId();
                break;
            case 3:
                return $this->getcandidateId();
                break;
            case 4:
                return $this->getanswer();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
                break;
            case 7:
                return $this->getVersion();
                break;
            case 8:
                return $this->getVersionCreatedAt();
                break;
            case 9:
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

        if (isset($alreadyDumpedObjects['VoteItem'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['VoteItem'][$this->hashCode()] = true;
        $keys = VoteItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getid(),
            $keys[1] => $this->getvoteId(),
            $keys[2] => $this->getquestionId(),
            $keys[3] => $this->getcandidateId(),
            $keys[4] => $this->getanswer(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
            $keys[7] => $this->getVersion(),
            $keys[8] => $this->getVersionCreatedAt(),
            $keys[9] => $this->getVersionCreatedBy(),
        );
        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        if ($result[$keys[8]] instanceof \DateTime) {
            $result[$keys[8]] = $result[$keys[8]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aVote) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'vote';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Vote';
                        break;
                    default:
                        $key = 'Vote';
                }

                $result[$key] = $this->aVote->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->aCandidate) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'candidate';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Candidate';
                        break;
                    default:
                        $key = 'Candidate';
                }

                $result[$key] = $this->aCandidate->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collVoteItemVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'voteItemVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Vote_item_versions';
                        break;
                    default:
                        $key = 'VoteItemVersions';
                }

                $result[$key] = $this->collVoteItemVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\MESBallotBox\Propel\VoteItem
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = VoteItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MESBallotBox\Propel\VoteItem
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setid($value);
                break;
            case 1:
                $this->setvoteId($value);
                break;
            case 2:
                $this->setquestionId($value);
                break;
            case 3:
                $this->setcandidateId($value);
                break;
            case 4:
                $this->setanswer($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
            case 7:
                $this->setVersion($value);
                break;
            case 8:
                $this->setVersionCreatedAt($value);
                break;
            case 9:
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
        $keys = VoteItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setvoteId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setquestionId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setcandidateId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setanswer($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUpdatedAt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setVersion($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setVersionCreatedAt($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setVersionCreatedBy($arr[$keys[9]]);
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
     * @return $this|\MESBallotBox\Propel\VoteItem The current object, for fluid interface
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
        $criteria = new Criteria(VoteItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(VoteItemTableMap::COL_ID)) {
            $criteria->add(VoteItemTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VOTE_ID)) {
            $criteria->add(VoteItemTableMap::COL_VOTE_ID, $this->vote_id);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_QUESTION_ID)) {
            $criteria->add(VoteItemTableMap::COL_QUESTION_ID, $this->question_id);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_CANDIDATE_ID)) {
            $criteria->add(VoteItemTableMap::COL_CANDIDATE_ID, $this->candidate_id);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_ANSWER)) {
            $criteria->add(VoteItemTableMap::COL_ANSWER, $this->answer);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_CREATED_AT)) {
            $criteria->add(VoteItemTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_UPDATED_AT)) {
            $criteria->add(VoteItemTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VERSION)) {
            $criteria->add(VoteItemTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(VoteItemTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(VoteItemTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(VoteItemTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
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
        $criteria = ChildVoteItemQuery::create();
        $criteria->add(VoteItemTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \MESBallotBox\Propel\VoteItem (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setvoteId($this->getvoteId());
        $copyObj->setquestionId($this->getquestionId());
        $copyObj->setcandidateId($this->getcandidateId());
        $copyObj->setanswer($this->getanswer());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getVoteItemVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVoteItemVersion($relObj->copy($deepCopy));
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
     * @return \MESBallotBox\Propel\VoteItem Clone of current object.
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
     * Declares an association between this object and a ChildVote object.
     *
     * @param  ChildVote $v
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     * @throws PropelException
     */
    public function setVote(ChildVote $v = null)
    {
        if ($v === null) {
            $this->setvoteId(NULL);
        } else {
            $this->setvoteId($v->getid());
        }

        $this->aVote = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildVote object, it will not be re-added.
        if ($v !== null) {
            $v->addVoteItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildVote object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildVote The associated ChildVote object.
     * @throws PropelException
     */
    public function getVote(ConnectionInterface $con = null)
    {
        if ($this->aVote === null && ($this->vote_id !== null)) {
            $this->aVote = ChildVoteQuery::create()->findPk($this->vote_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVote->addVoteItems($this);
             */
        }

        return $this->aVote;
    }

    /**
     * Declares an association between this object and a ChildQuestion object.
     *
     * @param  ChildQuestion $v
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     * @throws PropelException
     */
    public function setQuestion(ChildQuestion $v = null)
    {
        if ($v === null) {
            $this->setquestionId(NULL);
        } else {
            $this->setquestionId($v->getid());
        }

        $this->aQuestion = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildQuestion object, it will not be re-added.
        if ($v !== null) {
            $v->addVoteItem($this);
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
        if ($this->aQuestion === null && ($this->question_id !== null)) {
            $this->aQuestion = ChildQuestionQuery::create()->findPk($this->question_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aQuestion->addVoteItems($this);
             */
        }

        return $this->aQuestion;
    }

    /**
     * Declares an association between this object and a ChildCandidate object.
     *
     * @param  ChildCandidate $v
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCandidate(ChildCandidate $v = null)
    {
        if ($v === null) {
            $this->setcandidateId(NULL);
        } else {
            $this->setcandidateId($v->getid());
        }

        $this->aCandidate = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCandidate object, it will not be re-added.
        if ($v !== null) {
            $v->addVoteItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCandidate object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCandidate The associated ChildCandidate object.
     * @throws PropelException
     */
    public function getCandidate(ConnectionInterface $con = null)
    {
        if ($this->aCandidate === null && ($this->candidate_id !== null)) {
            $this->aCandidate = ChildCandidateQuery::create()->findPk($this->candidate_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCandidate->addVoteItems($this);
             */
        }

        return $this->aCandidate;
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
        if ('VoteItemVersion' == $relationName) {
            return $this->initVoteItemVersions();
        }
    }

    /**
     * Clears out the collVoteItemVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVoteItemVersions()
     */
    public function clearVoteItemVersions()
    {
        $this->collVoteItemVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVoteItemVersions collection loaded partially.
     */
    public function resetPartialVoteItemVersions($v = true)
    {
        $this->collVoteItemVersionsPartial = $v;
    }

    /**
     * Initializes the collVoteItemVersions collection.
     *
     * By default this just sets the collVoteItemVersions collection to an empty array (like clearcollVoteItemVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVoteItemVersions($overrideExisting = true)
    {
        if (null !== $this->collVoteItemVersions && !$overrideExisting) {
            return;
        }

        $collectionClassName = VoteItemVersionTableMap::getTableMap()->getCollectionClassName();

        $this->collVoteItemVersions = new $collectionClassName;
        $this->collVoteItemVersions->setModel('\MESBallotBox\Propel\VoteItemVersion');
    }

    /**
     * Gets an array of ChildVoteItemVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildVoteItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVoteItemVersion[] List of ChildVoteItemVersion objects
     * @throws PropelException
     */
    public function getVoteItemVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVoteItemVersionsPartial && !$this->isNew();
        if (null === $this->collVoteItemVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVoteItemVersions) {
                // return empty collection
                $this->initVoteItemVersions();
            } else {
                $collVoteItemVersions = ChildVoteItemVersionQuery::create(null, $criteria)
                    ->filterByVoteItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVoteItemVersionsPartial && count($collVoteItemVersions)) {
                        $this->initVoteItemVersions(false);

                        foreach ($collVoteItemVersions as $obj) {
                            if (false == $this->collVoteItemVersions->contains($obj)) {
                                $this->collVoteItemVersions->append($obj);
                            }
                        }

                        $this->collVoteItemVersionsPartial = true;
                    }

                    return $collVoteItemVersions;
                }

                if ($partial && $this->collVoteItemVersions) {
                    foreach ($this->collVoteItemVersions as $obj) {
                        if ($obj->isNew()) {
                            $collVoteItemVersions[] = $obj;
                        }
                    }
                }

                $this->collVoteItemVersions = $collVoteItemVersions;
                $this->collVoteItemVersionsPartial = false;
            }
        }

        return $this->collVoteItemVersions;
    }

    /**
     * Sets a collection of ChildVoteItemVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $voteItemVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildVoteItem The current object (for fluent API support)
     */
    public function setVoteItemVersions(Collection $voteItemVersions, ConnectionInterface $con = null)
    {
        /** @var ChildVoteItemVersion[] $voteItemVersionsToDelete */
        $voteItemVersionsToDelete = $this->getVoteItemVersions(new Criteria(), $con)->diff($voteItemVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->voteItemVersionsScheduledForDeletion = clone $voteItemVersionsToDelete;

        foreach ($voteItemVersionsToDelete as $voteItemVersionRemoved) {
            $voteItemVersionRemoved->setVoteItem(null);
        }

        $this->collVoteItemVersions = null;
        foreach ($voteItemVersions as $voteItemVersion) {
            $this->addVoteItemVersion($voteItemVersion);
        }

        $this->collVoteItemVersions = $voteItemVersions;
        $this->collVoteItemVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related VoteItemVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related VoteItemVersion objects.
     * @throws PropelException
     */
    public function countVoteItemVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVoteItemVersionsPartial && !$this->isNew();
        if (null === $this->collVoteItemVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVoteItemVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVoteItemVersions());
            }

            $query = ChildVoteItemVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByVoteItem($this)
                ->count($con);
        }

        return count($this->collVoteItemVersions);
    }

    /**
     * Method called to associate a ChildVoteItemVersion object to this object
     * through the ChildVoteItemVersion foreign key attribute.
     *
     * @param  ChildVoteItemVersion $l ChildVoteItemVersion
     * @return $this|\MESBallotBox\Propel\VoteItem The current object (for fluent API support)
     */
    public function addVoteItemVersion(ChildVoteItemVersion $l)
    {
        if ($this->collVoteItemVersions === null) {
            $this->initVoteItemVersions();
            $this->collVoteItemVersionsPartial = true;
        }

        if (!$this->collVoteItemVersions->contains($l)) {
            $this->doAddVoteItemVersion($l);

            if ($this->voteItemVersionsScheduledForDeletion and $this->voteItemVersionsScheduledForDeletion->contains($l)) {
                $this->voteItemVersionsScheduledForDeletion->remove($this->voteItemVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVoteItemVersion $voteItemVersion The ChildVoteItemVersion object to add.
     */
    protected function doAddVoteItemVersion(ChildVoteItemVersion $voteItemVersion)
    {
        $this->collVoteItemVersions[]= $voteItemVersion;
        $voteItemVersion->setVoteItem($this);
    }

    /**
     * @param  ChildVoteItemVersion $voteItemVersion The ChildVoteItemVersion object to remove.
     * @return $this|ChildVoteItem The current object (for fluent API support)
     */
    public function removeVoteItemVersion(ChildVoteItemVersion $voteItemVersion)
    {
        if ($this->getVoteItemVersions()->contains($voteItemVersion)) {
            $pos = $this->collVoteItemVersions->search($voteItemVersion);
            $this->collVoteItemVersions->remove($pos);
            if (null === $this->voteItemVersionsScheduledForDeletion) {
                $this->voteItemVersionsScheduledForDeletion = clone $this->collVoteItemVersions;
                $this->voteItemVersionsScheduledForDeletion->clear();
            }
            $this->voteItemVersionsScheduledForDeletion[]= clone $voteItemVersion;
            $voteItemVersion->setVoteItem(null);
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
        if (null !== $this->aVote) {
            $this->aVote->removeVoteItem($this);
        }
        if (null !== $this->aQuestion) {
            $this->aQuestion->removeVoteItem($this);
        }
        if (null !== $this->aCandidate) {
            $this->aCandidate->removeVoteItem($this);
        }
        $this->id = null;
        $this->vote_id = null;
        $this->question_id = null;
        $this->candidate_id = null;
        $this->answer = null;
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
            if ($this->collVoteItemVersions) {
                foreach ($this->collVoteItemVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collVoteItemVersions = null;
        $this->aVote = null;
        $this->aQuestion = null;
        $this->aCandidate = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(VoteItemTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildVoteItem The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[VoteItemTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\MESBallotBox\Propel\VoteItem
     */
    public function enforceVersioning()
    {
        $this->enforceVersion = true;

        return $this;
    }

    /**
     * Checks whether the current state must be recorded as a version
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     * @return  boolean
     */
    public function isVersioningNecessary(ConnectionInterface $con = null)
    {
        if ($this->alreadyInSave) {
            return false;
        }

        if ($this->enforceVersion) {
            return true;
        }

        if (ChildVoteItemQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getVote($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }

        if (null !== ($object = $this->getQuestion($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }

        if (null !== ($object = $this->getCandidate($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  ChildVoteItemVersion A version object
     */
    public function addVersion(ConnectionInterface $con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildVoteItemVersion();
        $version->setid($this->getid());
        $version->setvoteId($this->getvoteId());
        $version->setquestionId($this->getquestionId());
        $version->setcandidateId($this->getcandidateId());
        $version->setanswer($this->getanswer());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setVoteItem($this);
        if (($related = $this->getVote(null, $con)) && $related->getVersion()) {
            $version->setVoteIdVersion($related->getVersion());
        }
        if (($related = $this->getQuestion(null, $con)) && $related->getVersion()) {
            $version->setQuestionIdVersion($related->getVersion());
        }
        if (($related = $this->getCandidate(null, $con)) && $related->getVersion()) {
            $version->setCandidateIdVersion($related->getVersion());
        }
        $version->save($con);

        return $version;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  $this|ChildVoteItem The current object (for fluent API support)
     */
    public function toVersion($versionNumber, ConnectionInterface $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildVoteItem object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildVoteItemVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildVoteItem The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildVoteItem'][$version->getid()][$version->getVersion()] = $this;
        $this->setid($version->getid());
        $this->setvoteId($version->getvoteId());
        $this->setquestionId($version->getquestionId());
        $this->setcandidateId($version->getcandidateId());
        $this->setanswer($version->getanswer());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        if ($fkValue = $version->getvoteId()) {
            if (isset($loadedObjects['ChildVote']) && isset($loadedObjects['ChildVote'][$fkValue]) && isset($loadedObjects['ChildVote'][$fkValue][$version->getVoteIdVersion()])) {
                $related = $loadedObjects['ChildVote'][$fkValue][$version->getVoteIdVersion()];
            } else {
                $related = new ChildVote();
                $relatedVersion = ChildVoteVersionQuery::create()
                    ->filterByid($fkValue)
                    ->filterByVersionCreatedBy($version->getVoteIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setVote($related);
        }
        if ($fkValue = $version->getquestionId()) {
            if (isset($loadedObjects['ChildQuestion']) && isset($loadedObjects['ChildQuestion'][$fkValue]) && isset($loadedObjects['ChildQuestion'][$fkValue][$version->getQuestionIdVersion()])) {
                $related = $loadedObjects['ChildQuestion'][$fkValue][$version->getQuestionIdVersion()];
            } else {
                $related = new ChildQuestion();
                $relatedVersion = ChildQuestionVersionQuery::create()
                    ->filterByid($fkValue)
                    ->filterByVersionCreatedBy($version->getQuestionIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setQuestion($related);
        }
        if ($fkValue = $version->getcandidateId()) {
            if (isset($loadedObjects['ChildCandidate']) && isset($loadedObjects['ChildCandidate'][$fkValue]) && isset($loadedObjects['ChildCandidate'][$fkValue][$version->getCandidateIdVersion()])) {
                $related = $loadedObjects['ChildCandidate'][$fkValue][$version->getCandidateIdVersion()];
            } else {
                $related = new ChildCandidate();
                $relatedVersion = ChildCandidateVersionQuery::create()
                    ->filterByid($fkValue)
                    ->filterByVersionCreatedBy($version->getCandidateIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setCandidate($related);
        }

        return $this;
    }

    /**
     * Gets the latest persisted version number for the current object
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  integer
     */
    public function getLastVersionNumber(ConnectionInterface $con = null)
    {
        $v = ChildVoteItemVersionQuery::create()
            ->filterByVoteItem($this)
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
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  Boolean
     */
    public function isLastVersion(ConnectionInterface $con = null)
    {
        return $this->getLastVersionNumber($con) == $this->getVersion();
    }

    /**
     * Retrieves a version object for this entity and a version number
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  ChildVoteItemVersion A version object
     */
    public function getOneVersion($versionNumber, ConnectionInterface $con = null)
    {
        return ChildVoteItemVersionQuery::create()
            ->filterByVoteItem($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  ObjectCollection|ChildVoteItemVersion[] A list of ChildVoteItemVersion objects
     */
    public function getAllVersions(ConnectionInterface $con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(VoteItemVersionTableMap::COL_VERSION);

        return $this->getVoteItemVersions($criteria, $con);
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
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersion($versionNumber, $keys = 'columns', ConnectionInterface $con = null, $ignoredColumns = array())
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
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersions($fromVersionNumber, $toVersionNumber, $keys = 'columns', ConnectionInterface $con = null, $ignoredColumns = array())
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
     * @param  Integer             $number The number of record to return.
     * @param  Criteria            $criteria The Criteria object containing modified values.
     * @param  ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return PropelCollection|\MESBallotBox\Propel\VoteItemVersion[] List of \MESBallotBox\Propel\VoteItemVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, ConnectionInterface $con = null)
    {
        $criteria = ChildVoteItemVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(VoteItemVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getVoteItemVersions($criteria, $con);
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
        $metadata->addPropertyConstraint('question_id', new NotNull(array ('message' => 'Question required',)));
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
            if (method_exists($this->aVote, 'validate')) {
                if (!$this->aVote->validate($validator)) {
                    $failureMap->addAll($this->aVote->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aQuestion, 'validate')) {
                if (!$this->aQuestion->validate($validator)) {
                    $failureMap->addAll($this->aQuestion->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aCandidate, 'validate')) {
                if (!$this->aCandidate->validate($validator)) {
                    $failureMap->addAll($this->aCandidate->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collVoteItemVersions) {
                foreach ($this->collVoteItemVersions as $referrerFK) {
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
