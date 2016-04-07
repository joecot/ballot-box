<?php

namespace MESBallotBox\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use MESBallotBox\Propel\Affiliate as ChildAffiliate;
use MESBallotBox\Propel\AffiliateQuery as ChildAffiliateQuery;
use MESBallotBox\Propel\Ballot as ChildBallot;
use MESBallotBox\Propel\BallotQuery as ChildBallotQuery;
use MESBallotBox\Propel\BallotVersionQuery as ChildBallotVersionQuery;
use MESBallotBox\Propel\User as ChildUser;
use MESBallotBox\Propel\UserQuery as ChildUserQuery;
use MESBallotBox\Propel\Voter as ChildVoter;
use MESBallotBox\Propel\VoterQuery as ChildVoterQuery;
use MESBallotBox\Propel\VoterVersion as ChildVoterVersion;
use MESBallotBox\Propel\VoterVersionQuery as ChildVoterVersionQuery;
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
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'Voter' table.
 *
 *
 *
* @package    propel.generator.MESBallotBox.Propel.Base
*/
abstract class Voter implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MESBallotBox\\Propel\\Map\\VoterTableMap';


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
     * The value for the user_id field.
     *
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the affiliate_id field.
     *
     * @var        int
     */
    protected $affiliate_id;

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
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildAffiliate
     */
    protected $aAffiliate;

    /**
     * @var        ChildBallot
     */
    protected $aBallot;

    /**
     * @var        ObjectCollection|ChildVoterVersion[] Collection to store aggregation of ChildVoterVersion objects.
     */
    protected $collVoterVersions;
    protected $collVoterVersionsPartial;

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
     * @var ObjectCollection|ChildVoterVersion[]
     */
    protected $voterVersionsScheduledForDeletion = null;

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
     * Initializes internal state of MESBallotBox\Propel\Base\Voter object.
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
     * Compares this with another <code>Voter</code> instance.  If
     * <code>obj</code> is an instance of <code>Voter</code>, delegates to
     * <code>equals(Voter)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Voter The current object, for fluid interface
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
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getuserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [affiliate_id] column value.
     *
     * @return int
     */
    public function getaffiliateId()
    {
        return $this->affiliate_id;
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
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[VoterTableMap::COL_ID] = true;
        }

        return $this;
    } // setid()

    /**
     * Set the value of [ballot_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setballotId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ballot_id !== $v) {
            $this->ballot_id = $v;
            $this->modifiedColumns[VoterTableMap::COL_BALLOT_ID] = true;
        }

        if ($this->aBallot !== null && $this->aBallot->getid() !== $v) {
            $this->aBallot = null;
        }

        return $this;
    } // setballotId()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setuserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[VoterTableMap::COL_USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getid() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setuserId()

    /**
     * Set the value of [affiliate_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setaffiliateId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->affiliate_id !== $v) {
            $this->affiliate_id = $v;
            $this->modifiedColumns[VoterTableMap::COL_AFFILIATE_ID] = true;
        }

        if ($this->aAffiliate !== null && $this->aAffiliate->getid() !== $v) {
            $this->aAffiliate = null;
        }

        return $this;
    } // setaffiliateId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoterTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoterTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[VoterTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->version_created_at->format("Y-m-d H:i:s")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoterTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[VoterTableMap::COL_VERSION_CREATED_BY] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : VoterTableMap::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : VoterTableMap::translateFieldName('ballotId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ballot_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : VoterTableMap::translateFieldName('userId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : VoterTableMap::translateFieldName('affiliateId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->affiliate_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : VoterTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : VoterTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : VoterTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : VoterTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : VoterTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = VoterTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MESBallotBox\\Propel\\Voter'), 0, $e);
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
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getid()) {
            $this->aUser = null;
        }
        if ($this->aAffiliate !== null && $this->affiliate_id !== $this->aAffiliate->getid()) {
            $this->aAffiliate = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(VoterTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildVoterQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aAffiliate = null;
            $this->aBallot = null;
            $this->collVoterVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Voter::setDeleted()
     * @see Voter::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoterTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildVoterQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(VoterTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(VoterTableMap::COL_VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(VoterTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(VoterTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(VoterTableMap::COL_UPDATED_AT)) {
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
                VoterTableMap::addInstanceToPool($this);
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

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aAffiliate !== null) {
                if ($this->aAffiliate->isModified() || $this->aAffiliate->isNew()) {
                    $affectedRows += $this->aAffiliate->save($con);
                }
                $this->setAffiliate($this->aAffiliate);
            }

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

            if ($this->voterVersionsScheduledForDeletion !== null) {
                if (!$this->voterVersionsScheduledForDeletion->isEmpty()) {
                    \MESBallotBox\Propel\VoterVersionQuery::create()
                        ->filterByPrimaryKeys($this->voterVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->voterVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collVoterVersions !== null) {
                foreach ($this->collVoterVersions as $referrerFK) {
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

        $this->modifiedColumns[VoterTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . VoterTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(VoterTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(VoterTableMap::COL_BALLOT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ballot_id';
        }
        if ($this->isColumnModified(VoterTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(VoterTableMap::COL_AFFILIATE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'affiliate_id';
        }
        if ($this->isColumnModified(VoterTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(VoterTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(VoterTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(VoterTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(VoterTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }

        $sql = sprintf(
            'INSERT INTO Voter (%s) VALUES (%s)',
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
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'affiliate_id':
                        $stmt->bindValue($identifier, $this->affiliate_id, PDO::PARAM_INT);
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
        $pos = VoterTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getuserId();
                break;
            case 3:
                return $this->getaffiliateId();
                break;
            case 4:
                return $this->getCreatedAt();
                break;
            case 5:
                return $this->getUpdatedAt();
                break;
            case 6:
                return $this->getVersion();
                break;
            case 7:
                return $this->getVersionCreatedAt();
                break;
            case 8:
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

        if (isset($alreadyDumpedObjects['Voter'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Voter'][$this->hashCode()] = true;
        $keys = VoterTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getid(),
            $keys[1] => $this->getballotId(),
            $keys[2] => $this->getuserId(),
            $keys[3] => $this->getaffiliateId(),
            $keys[4] => $this->getCreatedAt(),
            $keys[5] => $this->getUpdatedAt(),
            $keys[6] => $this->getVersion(),
            $keys[7] => $this->getVersionCreatedAt(),
            $keys[8] => $this->getVersionCreatedBy(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[7]] instanceof \DateTime) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'User';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAffiliate) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'affiliate';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Affiliate';
                        break;
                    default:
                        $key = 'Affiliate';
                }

                $result[$key] = $this->aAffiliate->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->collVoterVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'voterVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Voter_versions';
                        break;
                    default:
                        $key = 'VoterVersions';
                }

                $result[$key] = $this->collVoterVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\MESBallotBox\Propel\Voter
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = VoterTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MESBallotBox\Propel\Voter
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
                $this->setuserId($value);
                break;
            case 3:
                $this->setaffiliateId($value);
                break;
            case 4:
                $this->setCreatedAt($value);
                break;
            case 5:
                $this->setUpdatedAt($value);
                break;
            case 6:
                $this->setVersion($value);
                break;
            case 7:
                $this->setVersionCreatedAt($value);
                break;
            case 8:
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
        $keys = VoterTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setballotId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setuserId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setaffiliateId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCreatedAt($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUpdatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setVersion($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setVersionCreatedAt($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setVersionCreatedBy($arr[$keys[8]]);
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
     * @return $this|\MESBallotBox\Propel\Voter The current object, for fluid interface
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
        $criteria = new Criteria(VoterTableMap::DATABASE_NAME);

        if ($this->isColumnModified(VoterTableMap::COL_ID)) {
            $criteria->add(VoterTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(VoterTableMap::COL_BALLOT_ID)) {
            $criteria->add(VoterTableMap::COL_BALLOT_ID, $this->ballot_id);
        }
        if ($this->isColumnModified(VoterTableMap::COL_USER_ID)) {
            $criteria->add(VoterTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(VoterTableMap::COL_AFFILIATE_ID)) {
            $criteria->add(VoterTableMap::COL_AFFILIATE_ID, $this->affiliate_id);
        }
        if ($this->isColumnModified(VoterTableMap::COL_CREATED_AT)) {
            $criteria->add(VoterTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(VoterTableMap::COL_UPDATED_AT)) {
            $criteria->add(VoterTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(VoterTableMap::COL_VERSION)) {
            $criteria->add(VoterTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(VoterTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(VoterTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(VoterTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(VoterTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
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
        $criteria = ChildVoterQuery::create();
        $criteria->add(VoterTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \MESBallotBox\Propel\Voter (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setballotId($this->getballotId());
        $copyObj->setuserId($this->getuserId());
        $copyObj->setaffiliateId($this->getaffiliateId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getVoterVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVoterVersion($relObj->copy($deepCopy));
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
     * @return \MESBallotBox\Propel\Voter Clone of current object.
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
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setuserId(NULL);
        } else {
            $this->setuserId($v->getid());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addVoter($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->user_id !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addVoters($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildAffiliate object.
     *
     * @param  ChildAffiliate $v
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAffiliate(ChildAffiliate $v = null)
    {
        if ($v === null) {
            $this->setaffiliateId(NULL);
        } else {
            $this->setaffiliateId($v->getid());
        }

        $this->aAffiliate = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAffiliate object, it will not be re-added.
        if ($v !== null) {
            $v->addVoter($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAffiliate object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAffiliate The associated ChildAffiliate object.
     * @throws PropelException
     */
    public function getAffiliate(ConnectionInterface $con = null)
    {
        if ($this->aAffiliate === null && ($this->affiliate_id !== null)) {
            $this->aAffiliate = ChildAffiliateQuery::create()->findPk($this->affiliate_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAffiliate->addVoters($this);
             */
        }

        return $this->aAffiliate;
    }

    /**
     * Declares an association between this object and a ChildBallot object.
     *
     * @param  ChildBallot $v
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
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
            $v->addVoter($this);
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
                $this->aBallot->addVoters($this);
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
        if ('VoterVersion' == $relationName) {
            return $this->initVoterVersions();
        }
    }

    /**
     * Clears out the collVoterVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVoterVersions()
     */
    public function clearVoterVersions()
    {
        $this->collVoterVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVoterVersions collection loaded partially.
     */
    public function resetPartialVoterVersions($v = true)
    {
        $this->collVoterVersionsPartial = $v;
    }

    /**
     * Initializes the collVoterVersions collection.
     *
     * By default this just sets the collVoterVersions collection to an empty array (like clearcollVoterVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVoterVersions($overrideExisting = true)
    {
        if (null !== $this->collVoterVersions && !$overrideExisting) {
            return;
        }

        $collectionClassName = VoterVersionTableMap::getTableMap()->getCollectionClassName();

        $this->collVoterVersions = new $collectionClassName;
        $this->collVoterVersions->setModel('\MESBallotBox\Propel\VoterVersion');
    }

    /**
     * Gets an array of ChildVoterVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildVoter is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVoterVersion[] List of ChildVoterVersion objects
     * @throws PropelException
     */
    public function getVoterVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVoterVersionsPartial && !$this->isNew();
        if (null === $this->collVoterVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVoterVersions) {
                // return empty collection
                $this->initVoterVersions();
            } else {
                $collVoterVersions = ChildVoterVersionQuery::create(null, $criteria)
                    ->filterByVoter($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVoterVersionsPartial && count($collVoterVersions)) {
                        $this->initVoterVersions(false);

                        foreach ($collVoterVersions as $obj) {
                            if (false == $this->collVoterVersions->contains($obj)) {
                                $this->collVoterVersions->append($obj);
                            }
                        }

                        $this->collVoterVersionsPartial = true;
                    }

                    return $collVoterVersions;
                }

                if ($partial && $this->collVoterVersions) {
                    foreach ($this->collVoterVersions as $obj) {
                        if ($obj->isNew()) {
                            $collVoterVersions[] = $obj;
                        }
                    }
                }

                $this->collVoterVersions = $collVoterVersions;
                $this->collVoterVersionsPartial = false;
            }
        }

        return $this->collVoterVersions;
    }

    /**
     * Sets a collection of ChildVoterVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $voterVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildVoter The current object (for fluent API support)
     */
    public function setVoterVersions(Collection $voterVersions, ConnectionInterface $con = null)
    {
        /** @var ChildVoterVersion[] $voterVersionsToDelete */
        $voterVersionsToDelete = $this->getVoterVersions(new Criteria(), $con)->diff($voterVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->voterVersionsScheduledForDeletion = clone $voterVersionsToDelete;

        foreach ($voterVersionsToDelete as $voterVersionRemoved) {
            $voterVersionRemoved->setVoter(null);
        }

        $this->collVoterVersions = null;
        foreach ($voterVersions as $voterVersion) {
            $this->addVoterVersion($voterVersion);
        }

        $this->collVoterVersions = $voterVersions;
        $this->collVoterVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related VoterVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related VoterVersion objects.
     * @throws PropelException
     */
    public function countVoterVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVoterVersionsPartial && !$this->isNew();
        if (null === $this->collVoterVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVoterVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVoterVersions());
            }

            $query = ChildVoterVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByVoter($this)
                ->count($con);
        }

        return count($this->collVoterVersions);
    }

    /**
     * Method called to associate a ChildVoterVersion object to this object
     * through the ChildVoterVersion foreign key attribute.
     *
     * @param  ChildVoterVersion $l ChildVoterVersion
     * @return $this|\MESBallotBox\Propel\Voter The current object (for fluent API support)
     */
    public function addVoterVersion(ChildVoterVersion $l)
    {
        if ($this->collVoterVersions === null) {
            $this->initVoterVersions();
            $this->collVoterVersionsPartial = true;
        }

        if (!$this->collVoterVersions->contains($l)) {
            $this->doAddVoterVersion($l);

            if ($this->voterVersionsScheduledForDeletion and $this->voterVersionsScheduledForDeletion->contains($l)) {
                $this->voterVersionsScheduledForDeletion->remove($this->voterVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVoterVersion $voterVersion The ChildVoterVersion object to add.
     */
    protected function doAddVoterVersion(ChildVoterVersion $voterVersion)
    {
        $this->collVoterVersions[]= $voterVersion;
        $voterVersion->setVoter($this);
    }

    /**
     * @param  ChildVoterVersion $voterVersion The ChildVoterVersion object to remove.
     * @return $this|ChildVoter The current object (for fluent API support)
     */
    public function removeVoterVersion(ChildVoterVersion $voterVersion)
    {
        if ($this->getVoterVersions()->contains($voterVersion)) {
            $pos = $this->collVoterVersions->search($voterVersion);
            $this->collVoterVersions->remove($pos);
            if (null === $this->voterVersionsScheduledForDeletion) {
                $this->voterVersionsScheduledForDeletion = clone $this->collVoterVersions;
                $this->voterVersionsScheduledForDeletion->clear();
            }
            $this->voterVersionsScheduledForDeletion[]= clone $voterVersion;
            $voterVersion->setVoter(null);
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
        if (null !== $this->aUser) {
            $this->aUser->removeVoter($this);
        }
        if (null !== $this->aAffiliate) {
            $this->aAffiliate->removeVoter($this);
        }
        if (null !== $this->aBallot) {
            $this->aBallot->removeVoter($this);
        }
        $this->id = null;
        $this->ballot_id = null;
        $this->user_id = null;
        $this->affiliate_id = null;
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
            if ($this->collVoterVersions) {
                foreach ($this->collVoterVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collVoterVersions = null;
        $this->aUser = null;
        $this->aAffiliate = null;
        $this->aBallot = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(VoterTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildVoter The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[VoterTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\MESBallotBox\Propel\Voter
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

        if (ChildVoterQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getBallot($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildVoterVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildVoterVersion();
        $version->setid($this->getid());
        $version->setballotId($this->getballotId());
        $version->setuserId($this->getuserId());
        $version->setaffiliateId($this->getaffiliateId());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setVoter($this);
        if (($related = $this->getBallot(null, $con)) && $related->getVersion()) {
            $version->setBallotIdVersion($related->getVersion());
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
     * @return  $this|ChildVoter The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildVoter object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildVoterVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildVoter The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildVoter'][$version->getid()][$version->getVersion()] = $this;
        $this->setid($version->getid());
        $this->setballotId($version->getballotId());
        $this->setuserId($version->getuserId());
        $this->setaffiliateId($version->getaffiliateId());
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
        $v = ChildVoterVersionQuery::create()
            ->filterByVoter($this)
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
     * @return  ChildVoterVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildVoterVersionQuery::create()
            ->filterByVoter($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection|ChildVoterVersion[] A list of ChildVoterVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(VoterVersionTableMap::COL_VERSION);

        return $this->getVoterVersions($criteria, $con);
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
     * @return PropelCollection|\MESBallotBox\Propel\VoterVersion[] List of \MESBallotBox\Propel\VoterVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildVoterVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(VoterVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getVoterVersions($criteria, $con);
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
        $metadata->addPropertyConstraint('ballot_id', new NotNull(array ('message' => 'Ballot cannot be blank',)));
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
            if (method_exists($this->aUser, 'validate')) {
                if (!$this->aUser->validate($validator)) {
                    $failureMap->addAll($this->aUser->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aAffiliate, 'validate')) {
                if (!$this->aAffiliate->validate($validator)) {
                    $failureMap->addAll($this->aAffiliate->getValidationFailures());
                }
            }
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

            if (null !== $this->collVoterVersions) {
                foreach ($this->collVoterVersions as $referrerFK) {
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
