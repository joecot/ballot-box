<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\Candidate as ChildCandidate;
use MESBallotBox\Propel\CandidateQuery as ChildCandidateQuery;
use MESBallotBox\Propel\User as ChildUser;
use MESBallotBox\Propel\UserQuery as ChildUserQuery;
use MESBallotBox\Propel\Vote as ChildVote;
use MESBallotBox\Propel\VoteQuery as ChildVoteQuery;
use MESBallotBox\Propel\Voter as ChildVoter;
use MESBallotBox\Propel\VoterQuery as ChildVoterQuery;
use MESBallotBox\Propel\Map\CandidateTableMap;
use MESBallotBox\Propel\Map\UserTableMap;
use MESBallotBox\Propel\Map\VoteTableMap;
use MESBallotBox\Propel\Map\VoterTableMap;
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

/**
 * Base class that represents a row from the 'User' table.
 *
 *
 *
* @package    propel.generator.MESBallotBox.Propel.Base
*/
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MESBallotBox\\Propel\\Map\\UserTableMap';


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
     * The value for the membership_number field.
     *
     * @var        string
     */
    protected $membership_number;

    /**
     * The value for the first_name field.
     *
     * @var        string
     */
    protected $first_name;

    /**
     * The value for the last_name field.
     *
     * @var        string
     */
    protected $last_name;

    /**
     * The value for the email_address field.
     *
     * @var        string
     */
    protected $email_address;

    /**
     * The value for the affiliate_id field.
     *
     * @var        int
     */
    protected $affiliate_id;

    /**
     * @var        ObjectCollection|ChildVoter[] Collection to store aggregation of ChildVoter objects.
     */
    protected $collVoters;
    protected $collVotersPartial;

    /**
     * @var        ObjectCollection|ChildCandidate[] Collection to store aggregation of ChildCandidate objects.
     */
    protected $collCandidates;
    protected $collCandidatesPartial;

    /**
     * @var        ObjectCollection|ChildVote[] Collection to store aggregation of ChildVote objects.
     */
    protected $collVotes;
    protected $collVotesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVoter[]
     */
    protected $votersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCandidate[]
     */
    protected $candidatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVote[]
     */
    protected $votesScheduledForDeletion = null;

    /**
     * Initializes internal state of MESBallotBox\Propel\Base\User object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|User The current object, for fluid interface
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
     * Get the [membership_number] column value.
     *
     * @return string
     */
    public function getmembershipNumber()
    {
        return $this->membership_number;
    }

    /**
     * Get the [first_name] column value.
     *
     * @return string
     */
    public function getfirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the [last_name] column value.
     *
     * @return string
     */
    public function getlastName()
    {
        return $this->last_name;
    }

    /**
     * Get the [email_address] column value.
     *
     * @return string
     */
    public function getemailAddress()
    {
        return $this->email_address;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
     */
    public function setid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setid()

    /**
     * Set the value of [membership_number] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
     */
    public function setmembershipNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->membership_number !== $v) {
            $this->membership_number = $v;
            $this->modifiedColumns[UserTableMap::COL_MEMBERSHIP_NUMBER] = true;
        }

        return $this;
    } // setmembershipNumber()

    /**
     * Set the value of [first_name] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
     */
    public function setfirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[UserTableMap::COL_FIRST_NAME] = true;
        }

        return $this;
    } // setfirstName()

    /**
     * Set the value of [last_name] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
     */
    public function setlastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[UserTableMap::COL_LAST_NAME] = true;
        }

        return $this;
    } // setlastName()

    /**
     * Set the value of [email_address] column.
     *
     * @param string $v new value
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
     */
    public function setemailAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email_address !== $v) {
            $this->email_address = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL_ADDRESS] = true;
        }

        return $this;
    } // setemailAddress()

    /**
     * Set the value of [affiliate_id] column.
     *
     * @param int $v new value
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
     */
    public function setaffiliateId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->affiliate_id !== $v) {
            $this->affiliate_id = $v;
            $this->modifiedColumns[UserTableMap::COL_AFFILIATE_ID] = true;
        }

        return $this;
    } // setaffiliateId()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('membershipNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->membership_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('firstName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('lastName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('emailAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('affiliateId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->affiliate_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MESBallotBox\\Propel\\User'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collVoters = null;

            $this->collCandidates = null;

            $this->collVotes = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
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
                UserTableMap::addInstanceToPool($this);
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
                    foreach ($this->votersScheduledForDeletion as $voter) {
                        // need to save related object because we set the relation to null
                        $voter->save($con);
                    }
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

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_MEMBERSHIP_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'membership_number';
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'first_name';
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'last_name';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'email_address';
        }
        if ($this->isColumnModified(UserTableMap::COL_AFFILIATE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'affiliate_id';
        }

        $sql = sprintf(
            'INSERT INTO User (%s) VALUES (%s)',
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
                    case 'membership_number':
                        $stmt->bindValue($identifier, $this->membership_number, PDO::PARAM_STR);
                        break;
                    case 'first_name':
                        $stmt->bindValue($identifier, $this->first_name, PDO::PARAM_STR);
                        break;
                    case 'last_name':
                        $stmt->bindValue($identifier, $this->last_name, PDO::PARAM_STR);
                        break;
                    case 'email_address':
                        $stmt->bindValue($identifier, $this->email_address, PDO::PARAM_STR);
                        break;
                    case 'affiliate_id':
                        $stmt->bindValue($identifier, $this->affiliate_id, PDO::PARAM_INT);
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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getmembershipNumber();
                break;
            case 2:
                return $this->getfirstName();
                break;
            case 3:
                return $this->getlastName();
                break;
            case 4:
                return $this->getemailAddress();
                break;
            case 5:
                return $this->getaffiliateId();
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

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getid(),
            $keys[1] => $this->getmembershipNumber(),
            $keys[2] => $this->getfirstName(),
            $keys[3] => $this->getlastName(),
            $keys[4] => $this->getemailAddress(),
            $keys[5] => $this->getaffiliateId(),
        );
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
     * @return $this|\MESBallotBox\Propel\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MESBallotBox\Propel\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setid($value);
                break;
            case 1:
                $this->setmembershipNumber($value);
                break;
            case 2:
                $this->setfirstName($value);
                break;
            case 3:
                $this->setlastName($value);
                break;
            case 4:
                $this->setemailAddress($value);
                break;
            case 5:
                $this->setaffiliateId($value);
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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setmembershipNumber($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setfirstName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setlastName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setemailAddress($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setaffiliateId($arr[$keys[5]]);
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
     * @return $this|\MESBallotBox\Propel\User The current object, for fluid interface
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
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_MEMBERSHIP_NUMBER)) {
            $criteria->add(UserTableMap::COL_MEMBERSHIP_NUMBER, $this->membership_number);
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRST_NAME)) {
            $criteria->add(UserTableMap::COL_FIRST_NAME, $this->first_name);
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_NAME)) {
            $criteria->add(UserTableMap::COL_LAST_NAME, $this->last_name);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL_ADDRESS)) {
            $criteria->add(UserTableMap::COL_EMAIL_ADDRESS, $this->email_address);
        }
        if ($this->isColumnModified(UserTableMap::COL_AFFILIATE_ID)) {
            $criteria->add(UserTableMap::COL_AFFILIATE_ID, $this->affiliate_id);
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
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \MESBallotBox\Propel\User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setmembershipNumber($this->getmembershipNumber());
        $copyObj->setfirstName($this->getfirstName());
        $copyObj->setlastName($this->getlastName());
        $copyObj->setemailAddress($this->getemailAddress());
        $copyObj->setaffiliateId($this->getaffiliateId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getVoters() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVoter($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCandidates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCandidate($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVotes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVote($relObj->copy($deepCopy));
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
     * @return \MESBallotBox\Propel\User Clone of current object.
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
        if ('Candidate' == $relationName) {
            return $this->initCandidates();
        }
        if ('Vote' == $relationName) {
            return $this->initVotes();
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setVoters(Collection $voters, ConnectionInterface $con = null)
    {
        /** @var ChildVoter[] $votersToDelete */
        $votersToDelete = $this->getVoters(new Criteria(), $con)->diff($voters);


        $this->votersScheduledForDeletion = $votersToDelete;

        foreach ($votersToDelete as $voterRemoved) {
            $voterRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collVoters);
    }

    /**
     * Method called to associate a ChildVoter object to this object
     * through the ChildVoter foreign key attribute.
     *
     * @param  ChildVoter $l ChildVoter
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
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
        $voter->setUser($this);
    }

    /**
     * @param  ChildVoter $voter The ChildVoter object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $this->votersScheduledForDeletion[]= $voter;
            $voter->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Voters from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Voters from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVoter[] List of ChildVoter objects
     */
    public function getVotersJoinBallot(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoterQuery::create(null, $criteria);
        $query->joinWith('Ballot', $joinBehavior);

        return $this->getVoters($query, $con);
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setCandidates(Collection $candidates, ConnectionInterface $con = null)
    {
        /** @var ChildCandidate[] $candidatesToDelete */
        $candidatesToDelete = $this->getCandidates(new Criteria(), $con)->diff($candidates);


        $this->candidatesScheduledForDeletion = $candidatesToDelete;

        foreach ($candidatesToDelete as $candidateRemoved) {
            $candidateRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collCandidates);
    }

    /**
     * Method called to associate a ChildCandidate object to this object
     * through the ChildCandidate foreign key attribute.
     *
     * @param  ChildCandidate $l ChildCandidate
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
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
        $candidate->setUser($this);
    }

    /**
     * @param  ChildCandidate $candidate The ChildCandidate object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $candidate->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Candidates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCandidate[] List of ChildCandidate objects
     */
    public function getCandidatesJoinQuestion(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCandidateQuery::create(null, $criteria);
        $query->joinWith('Question', $joinBehavior);

        return $this->getCandidates($query, $con);
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setVotes(Collection $votes, ConnectionInterface $con = null)
    {
        /** @var ChildVote[] $votesToDelete */
        $votesToDelete = $this->getVotes(new Criteria(), $con)->diff($votes);


        $this->votesScheduledForDeletion = $votesToDelete;

        foreach ($votesToDelete as $voteRemoved) {
            $voteRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collVotes);
    }

    /**
     * Method called to associate a ChildVote object to this object
     * through the ChildVote foreign key attribute.
     *
     * @param  ChildVote $l ChildVote
     * @return $this|\MESBallotBox\Propel\User The current object (for fluent API support)
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
        $vote->setUser($this);
    }

    /**
     * @param  ChildVote $vote The ChildVote object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $vote->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Votes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVote[] List of ChildVote objects
     */
    public function getVotesJoinBallot(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVoteQuery::create(null, $criteria);
        $query->joinWith('Ballot', $joinBehavior);

        return $this->getVotes($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->membership_number = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->email_address = null;
        $this->affiliate_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collCandidates) {
                foreach ($this->collCandidates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVotes) {
                foreach ($this->collVotes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collVoters = null;
        $this->collCandidates = null;
        $this->collVotes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
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
