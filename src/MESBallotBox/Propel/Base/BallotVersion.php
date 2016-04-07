<?php

namespace MESBallotBox\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use MESBallotBox\Propel\Ballot as ChildBallot;
use MESBallotBox\Propel\BallotQuery as ChildBallotQuery;
use MESBallotBox\Propel\BallotVersionQuery as ChildBallotVersionQuery;
use MESBallotBox\Propel\Map\BallotVersionTableMap;
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
 * Base class that represents a row from the 'Ballot_version' table.
 *
 *
 *
* @package    propel.generator.MESBallotBox.Propel.Base
*/
abstract class BallotVersion implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MESBallotBox\\Propel\\Map\\BallotVersionTableMap';


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
     * The value for the voter_ids field.
     *
     * @var        array
     */
    protected $voter_ids;

    /**
     * The unserialized $voter_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $voter_ids_unserialized;

    /**
     * The value for the voter_versions field.
     *
     * @var        array
     */
    protected $voter_versions;

    /**
     * The unserialized $voter_versions value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $voter_versions_unserialized;

    /**
     * The value for the question_ids field.
     *
     * @var        array
     */
    protected $question_ids;

    /**
     * The unserialized $question_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $question_ids_unserialized;

    /**
     * The value for the question_versions field.
     *
     * @var        array
     */
    protected $question_versions;

    /**
     * The unserialized $question_versions value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $question_versions_unserialized;

    /**
     * The value for the vote_ids field.
     *
     * @var        array
     */
    protected $vote_ids;

    /**
     * The unserialized $vote_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $vote_ids_unserialized;

    /**
     * The value for the vote_versions field.
     *
     * @var        array
     */
    protected $vote_versions;

    /**
     * The unserialized $vote_versions value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $vote_versions_unserialized;

    /**
     * @var        ChildBallot
     */
    protected $aBallot;

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
    }

    /**
     * Initializes internal state of MESBallotBox\Propel\Base\BallotVersion object.
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
     * Compares this with another <code>BallotVersion</code> instance.  If
     * <code>obj</code> is an instance of <code>BallotVersion</code>, delegates to
     * <code>equals(BallotVersion)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|BallotVersion The current object, for fluid interface
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
     * Get the [voter_ids] column value.
     *
     * @return array
     */
    public function getVoterIds()
    {
        if (null === $this->voter_ids_unserialized) {
            $this->voter_ids_unserialized = array();
        }
        if (!$this->voter_ids_unserialized && null !== $this->voter_ids) {
            $voter_ids_unserialized = substr($this->voter_ids, 2, -2);
            $this->voter_ids_unserialized = $voter_ids_unserialized ? explode(' | ', $voter_ids_unserialized) : array();
        }

        return $this->voter_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [voter_ids] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasVoterId($value)
    {
        return in_array($value, $this->getVoterIds());
    } // hasVoterId()

    /**
     * Get the [voter_versions] column value.
     *
     * @return array
     */
    public function getVoterVersions()
    {
        if (null === $this->voter_versions_unserialized) {
            $this->voter_versions_unserialized = array();
        }
        if (!$this->voter_versions_unserialized && null !== $this->voter_versions) {
            $voter_versions_unserialized = substr($this->voter_versions, 2, -2);
            $this->voter_versions_unserialized = $voter_versions_unserialized ? explode(' | ', $voter_versions_unserialized) : array();
        }

        return $this->voter_versions_unserialized;
    }

    /**
     * Test the presence of a value in the [voter_versions] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasVoterVersion($value)
    {
        return in_array($value, $this->getVoterVersions());
    } // hasVoterVersion()

    /**
     * Get the [question_ids] column value.
     *
     * @return array
     */
    public function getQuestionIds()
    {
        if (null === $this->question_ids_unserialized) {
            $this->question_ids_unserialized = array();
        }
        if (!$this->question_ids_unserialized && null !== $this->question_ids) {
            $question_ids_unserialized = substr($this->question_ids, 2, -2);
            $this->question_ids_unserialized = $question_ids_unserialized ? explode(' | ', $question_ids_unserialized) : array();
        }

        return $this->question_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [question_ids] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasQuestionId($value)
    {
        return in_array($value, $this->getQuestionIds());
    } // hasQuestionId()

    /**
     * Get the [question_versions] column value.
     *
     * @return array
     */
    public function getQuestionVersions()
    {
        if (null === $this->question_versions_unserialized) {
            $this->question_versions_unserialized = array();
        }
        if (!$this->question_versions_unserialized && null !== $this->question_versions) {
            $question_versions_unserialized = substr($this->question_versions, 2, -2);
            $this->question_versions_unserialized = $question_versions_unserialized ? explode(' | ', $question_versions_unserialized) : array();
        }

        return $this->question_versions_unserialized;
    }

    /**
     * Test the presence of a value in the [question_versions] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasQuestionVersion($value)
    {
        return in_array($value, $this->getQuestionVersions());
    } // hasQuestionVersion()

    /**
     * Get the [vote_ids] column value.
     *
     * @return array
     */
    public function getVoteIds()
    {
        if (null === $this->vote_ids_unserialized) {
            $this->vote_ids_unserialized = array();
        }
        if (!$this->vote_ids_unserialized && null !== $this->vote_ids) {
            $vote_ids_unserialized = substr($this->vote_ids, 2, -2);
            $this->vote_ids_unserialized = $vote_ids_unserialized ? explode(' | ', $vote_ids_unserialized) : array();
        }

        return $this->vote_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [vote_ids] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasVoteId($value)
    {
        return in_array($value, $this->getVoteIds());
    } // hasVoteId()

    /**
     * Get the [vote_versions] column value.
     *
     * @return array
     */
    public function getVoteVersions()
    {
        if (null === $this->vote_versions_unserialized) {
            $this->vote_versions_unserialized = array();
        }
        if (!$this->vote_versions_unserialized && null !== $this->vote_versions) {
            $vote_versions_unserialized = substr($this->vote_versions, 2, -2);
            $this->vote_versions_unserialized = $vote_versions_unserialized ? explode(' | ', $vote_versions_unserialized) : array();
        }

        return $this->vote_versions_unserialized;
    }

    /**
     * Test the presence of a value in the [vote_versions] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasVoteVersion($value)
    {
        return in_array($value, $this->getVoteVersions());
    } // hasVoteVersion()

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_ID] = true;
        }

        if ($this->aBallot !== null && $this->aBallot->getid() !== $v) {
            $this->aBallot = null;
        }

        return $this;
    } // setid()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setuserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_USER_ID] = true;
        }

        return $this;
    } // setuserId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_NAME] = true;
        }

        return $this;
    } // setname()

    /**
     * Set the value of [start_time] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setstartTime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->start_time !== $v) {
            $this->start_time = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_START_TIME] = true;
        }

        return $this;
    } // setstartTime()

    /**
     * Set the value of [end_time] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setendTime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->end_time !== $v) {
            $this->end_time = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_END_TIME] = true;
        }

        return $this;
    } // setendTime()

    /**
     * Set the value of [timezone] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function settimezone($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->timezone !== $v) {
            $this->timezone = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_TIMEZONE] = true;
        }

        return $this;
    } // settimezone()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setversionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_VERSION_CREATED_BY] = true;
        }

        return $this;
    } // setversionCreatedBy()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BallotVersionTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BallotVersionTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[BallotVersionTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->version_created_at->format("Y-m-d H:i:s")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BallotVersionTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [voter_ids] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setVoterIds($v)
    {
        if ($this->voter_ids_unserialized !== $v) {
            $this->voter_ids_unserialized = $v;
            $this->voter_ids = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[BallotVersionTableMap::COL_VOTER_IDS] = true;
        }

        return $this;
    } // setVoterIds()

    /**
     * Adds a value to the [voter_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function addVoterId($value)
    {
        $currentArray = $this->getVoterIds();
        $currentArray []= $value;
        $this->setVoterIds($currentArray);

        return $this;
    } // addVoterId()

    /**
     * Removes a value from the [voter_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function removeVoterId($value)
    {
        $targetArray = array();
        foreach ($this->getVoterIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setVoterIds($targetArray);

        return $this;
    } // removeVoterId()

    /**
     * Set the value of [voter_versions] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setVoterVersions($v)
    {
        if ($this->voter_versions_unserialized !== $v) {
            $this->voter_versions_unserialized = $v;
            $this->voter_versions = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[BallotVersionTableMap::COL_VOTER_VERSIONS] = true;
        }

        return $this;
    } // setVoterVersions()

    /**
     * Adds a value to the [voter_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function addVoterVersion($value)
    {
        $currentArray = $this->getVoterVersions();
        $currentArray []= $value;
        $this->setVoterVersions($currentArray);

        return $this;
    } // addVoterVersion()

    /**
     * Removes a value from the [voter_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function removeVoterVersion($value)
    {
        $targetArray = array();
        foreach ($this->getVoterVersions() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setVoterVersions($targetArray);

        return $this;
    } // removeVoterVersion()

    /**
     * Set the value of [question_ids] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setQuestionIds($v)
    {
        if ($this->question_ids_unserialized !== $v) {
            $this->question_ids_unserialized = $v;
            $this->question_ids = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[BallotVersionTableMap::COL_QUESTION_IDS] = true;
        }

        return $this;
    } // setQuestionIds()

    /**
     * Adds a value to the [question_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function addQuestionId($value)
    {
        $currentArray = $this->getQuestionIds();
        $currentArray []= $value;
        $this->setQuestionIds($currentArray);

        return $this;
    } // addQuestionId()

    /**
     * Removes a value from the [question_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function removeQuestionId($value)
    {
        $targetArray = array();
        foreach ($this->getQuestionIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setQuestionIds($targetArray);

        return $this;
    } // removeQuestionId()

    /**
     * Set the value of [question_versions] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setQuestionVersions($v)
    {
        if ($this->question_versions_unserialized !== $v) {
            $this->question_versions_unserialized = $v;
            $this->question_versions = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[BallotVersionTableMap::COL_QUESTION_VERSIONS] = true;
        }

        return $this;
    } // setQuestionVersions()

    /**
     * Adds a value to the [question_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function addQuestionVersion($value)
    {
        $currentArray = $this->getQuestionVersions();
        $currentArray []= $value;
        $this->setQuestionVersions($currentArray);

        return $this;
    } // addQuestionVersion()

    /**
     * Removes a value from the [question_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function removeQuestionVersion($value)
    {
        $targetArray = array();
        foreach ($this->getQuestionVersions() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setQuestionVersions($targetArray);

        return $this;
    } // removeQuestionVersion()

    /**
     * Set the value of [vote_ids] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setVoteIds($v)
    {
        if ($this->vote_ids_unserialized !== $v) {
            $this->vote_ids_unserialized = $v;
            $this->vote_ids = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[BallotVersionTableMap::COL_VOTE_IDS] = true;
        }

        return $this;
    } // setVoteIds()

    /**
     * Adds a value to the [vote_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function addVoteId($value)
    {
        $currentArray = $this->getVoteIds();
        $currentArray []= $value;
        $this->setVoteIds($currentArray);

        return $this;
    } // addVoteId()

    /**
     * Removes a value from the [vote_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function removeVoteId($value)
    {
        $targetArray = array();
        foreach ($this->getVoteIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setVoteIds($targetArray);

        return $this;
    } // removeVoteId()

    /**
     * Set the value of [vote_versions] column.
     *
     * @param array $v new value
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function setVoteVersions($v)
    {
        if ($this->vote_versions_unserialized !== $v) {
            $this->vote_versions_unserialized = $v;
            $this->vote_versions = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[BallotVersionTableMap::COL_VOTE_VERSIONS] = true;
        }

        return $this;
    } // setVoteVersions()

    /**
     * Adds a value to the [vote_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function addVoteVersion($value)
    {
        $currentArray = $this->getVoteVersions();
        $currentArray []= $value;
        $this->setVoteVersions($currentArray);

        return $this;
    } // addVoteVersion()

    /**
     * Removes a value from the [vote_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     */
    public function removeVoteVersion($value)
    {
        $targetArray = array();
        foreach ($this->getVoteVersions() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setVoteVersions($targetArray);

        return $this;
    } // removeVoteVersion()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BallotVersionTableMap::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BallotVersionTableMap::translateFieldName('userId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BallotVersionTableMap::translateFieldName('name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BallotVersionTableMap::translateFieldName('startTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_time = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BallotVersionTableMap::translateFieldName('endTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->end_time = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BallotVersionTableMap::translateFieldName('timezone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->timezone = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BallotVersionTableMap::translateFieldName('versionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BallotVersionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : BallotVersionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : BallotVersionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : BallotVersionTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : BallotVersionTableMap::translateFieldName('VoterIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->voter_ids = $col;
            $this->voter_ids_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : BallotVersionTableMap::translateFieldName('VoterVersions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->voter_versions = $col;
            $this->voter_versions_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : BallotVersionTableMap::translateFieldName('QuestionIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->question_ids = $col;
            $this->question_ids_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : BallotVersionTableMap::translateFieldName('QuestionVersions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->question_versions = $col;
            $this->question_versions_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : BallotVersionTableMap::translateFieldName('VoteIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vote_ids = $col;
            $this->vote_ids_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : BallotVersionTableMap::translateFieldName('VoteVersions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vote_versions = $col;
            $this->vote_versions_unserialized = null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = BallotVersionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MESBallotBox\\Propel\\BallotVersion'), 0, $e);
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
        if ($this->aBallot !== null && $this->id !== $this->aBallot->getid()) {
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
            $con = Propel::getServiceContainer()->getReadConnection(BallotVersionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBallotVersionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBallot = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see BallotVersion::setDeleted()
     * @see BallotVersion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BallotVersionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBallotVersionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BallotVersionTableMap::DATABASE_NAME);
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
                BallotVersionTableMap::addInstanceToPool($this);
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
        if ($this->isColumnModified(BallotVersionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_START_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'start_time';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_END_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'end_time';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_TIMEZONE)) {
            $modifiedColumns[':p' . $index++]  = 'timezone';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTER_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'Voter_ids';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTER_VERSIONS)) {
            $modifiedColumns[':p' . $index++]  = 'Voter_versions';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_QUESTION_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'Question_ids';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_QUESTION_VERSIONS)) {
            $modifiedColumns[':p' . $index++]  = 'Question_versions';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTE_IDS)) {
            $modifiedColumns[':p' . $index++]  = 'Vote_ids';
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTE_VERSIONS)) {
            $modifiedColumns[':p' . $index++]  = 'Vote_versions';
        }

        $sql = sprintf(
            'INSERT INTO Ballot_version (%s) VALUES (%s)',
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
                    case 'Voter_ids':
                        $stmt->bindValue($identifier, $this->voter_ids, PDO::PARAM_STR);
                        break;
                    case 'Voter_versions':
                        $stmt->bindValue($identifier, $this->voter_versions, PDO::PARAM_STR);
                        break;
                    case 'Question_ids':
                        $stmt->bindValue($identifier, $this->question_ids, PDO::PARAM_STR);
                        break;
                    case 'Question_versions':
                        $stmt->bindValue($identifier, $this->question_versions, PDO::PARAM_STR);
                        break;
                    case 'Vote_ids':
                        $stmt->bindValue($identifier, $this->vote_ids, PDO::PARAM_STR);
                        break;
                    case 'Vote_versions':
                        $stmt->bindValue($identifier, $this->vote_versions, PDO::PARAM_STR);
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
        $pos = BallotVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
            case 11:
                return $this->getVoterIds();
                break;
            case 12:
                return $this->getVoterVersions();
                break;
            case 13:
                return $this->getQuestionIds();
                break;
            case 14:
                return $this->getQuestionVersions();
                break;
            case 15:
                return $this->getVoteIds();
                break;
            case 16:
                return $this->getVoteVersions();
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

        if (isset($alreadyDumpedObjects['BallotVersion'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['BallotVersion'][$this->hashCode()] = true;
        $keys = BallotVersionTableMap::getFieldNames($keyType);
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
            $keys[11] => $this->getVoterIds(),
            $keys[12] => $this->getVoterVersions(),
            $keys[13] => $this->getQuestionIds(),
            $keys[14] => $this->getQuestionVersions(),
            $keys[15] => $this->getVoteIds(),
            $keys[16] => $this->getVoteVersions(),
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
     * @return $this|\MESBallotBox\Propel\BallotVersion
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BallotVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MESBallotBox\Propel\BallotVersion
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
            case 11:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setVoterIds($value);
                break;
            case 12:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setVoterVersions($value);
                break;
            case 13:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setQuestionIds($value);
                break;
            case 14:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setQuestionVersions($value);
                break;
            case 15:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setVoteIds($value);
                break;
            case 16:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setVoteVersions($value);
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
        $keys = BallotVersionTableMap::getFieldNames($keyType);

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
        if (array_key_exists($keys[11], $arr)) {
            $this->setVoterIds($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setVoterVersions($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setQuestionIds($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setQuestionVersions($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setVoteIds($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setVoteVersions($arr[$keys[16]]);
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
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object, for fluid interface
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
        $criteria = new Criteria(BallotVersionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BallotVersionTableMap::COL_ID)) {
            $criteria->add(BallotVersionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_USER_ID)) {
            $criteria->add(BallotVersionTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_NAME)) {
            $criteria->add(BallotVersionTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_START_TIME)) {
            $criteria->add(BallotVersionTableMap::COL_START_TIME, $this->start_time);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_END_TIME)) {
            $criteria->add(BallotVersionTableMap::COL_END_TIME, $this->end_time);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_TIMEZONE)) {
            $criteria->add(BallotVersionTableMap::COL_TIMEZONE, $this->timezone);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(BallotVersionTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_CREATED_AT)) {
            $criteria->add(BallotVersionTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_UPDATED_AT)) {
            $criteria->add(BallotVersionTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VERSION)) {
            $criteria->add(BallotVersionTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(BallotVersionTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTER_IDS)) {
            $criteria->add(BallotVersionTableMap::COL_VOTER_IDS, $this->voter_ids);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTER_VERSIONS)) {
            $criteria->add(BallotVersionTableMap::COL_VOTER_VERSIONS, $this->voter_versions);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_QUESTION_IDS)) {
            $criteria->add(BallotVersionTableMap::COL_QUESTION_IDS, $this->question_ids);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_QUESTION_VERSIONS)) {
            $criteria->add(BallotVersionTableMap::COL_QUESTION_VERSIONS, $this->question_versions);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTE_IDS)) {
            $criteria->add(BallotVersionTableMap::COL_VOTE_IDS, $this->vote_ids);
        }
        if ($this->isColumnModified(BallotVersionTableMap::COL_VOTE_VERSIONS)) {
            $criteria->add(BallotVersionTableMap::COL_VOTE_VERSIONS, $this->vote_versions);
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
        $criteria = ChildBallotVersionQuery::create();
        $criteria->add(BallotVersionTableMap::COL_ID, $this->id);
        $criteria->add(BallotVersionTableMap::COL_VERSION, $this->version);

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

        //relation Ballot_version_fk_df6701 to table Ballot
        if ($this->aBallot && $hash = spl_object_hash($this->aBallot)) {
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
     * @param      object $copyObj An object of \MESBallotBox\Propel\BallotVersion (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setid($this->getid());
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
        $copyObj->setVoterIds($this->getVoterIds());
        $copyObj->setVoterVersions($this->getVoterVersions());
        $copyObj->setQuestionIds($this->getQuestionIds());
        $copyObj->setQuestionVersions($this->getQuestionVersions());
        $copyObj->setVoteIds($this->getVoteIds());
        $copyObj->setVoteVersions($this->getVoteVersions());
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
     * @return \MESBallotBox\Propel\BallotVersion Clone of current object.
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
     * @return $this|\MESBallotBox\Propel\BallotVersion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBallot(ChildBallot $v = null)
    {
        if ($v === null) {
            $this->setid(NULL);
        } else {
            $this->setid($v->getid());
        }

        $this->aBallot = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBallot object, it will not be re-added.
        if ($v !== null) {
            $v->addBallotVersion($this);
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
        if ($this->aBallot === null && ($this->id !== null)) {
            $this->aBallot = ChildBallotQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBallot->addBallotVersions($this);
             */
        }

        return $this->aBallot;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aBallot) {
            $this->aBallot->removeBallotVersion($this);
        }
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
        $this->voter_ids = null;
        $this->voter_ids_unserialized = null;
        $this->voter_versions = null;
        $this->voter_versions_unserialized = null;
        $this->question_ids = null;
        $this->question_ids_unserialized = null;
        $this->question_versions = null;
        $this->question_versions_unserialized = null;
        $this->vote_ids = null;
        $this->vote_ids_unserialized = null;
        $this->vote_versions = null;
        $this->vote_versions_unserialized = null;
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

        $this->aBallot = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BallotVersionTableMap::DEFAULT_STRING_FORMAT);
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
