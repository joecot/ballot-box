<?php

namespace MESBallotBox\Propel\Map;

use MESBallotBox\Propel\BallotVersion;
use MESBallotBox\Propel\BallotVersionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'Ballot_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BallotVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MESBallotBox.Propel.Map.BallotVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'Ballot_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MESBallotBox\\Propel\\BallotVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MESBallotBox.Propel.BallotVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 17;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 17;

    /**
     * the column name for the id field
     */
    const COL_ID = 'Ballot_version.id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'Ballot_version.user_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'Ballot_version.name';

    /**
     * the column name for the start_time field
     */
    const COL_START_TIME = 'Ballot_version.start_time';

    /**
     * the column name for the end_time field
     */
    const COL_END_TIME = 'Ballot_version.end_time';

    /**
     * the column name for the timezone field
     */
    const COL_TIMEZONE = 'Ballot_version.timezone';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = 'Ballot_version.version_created_by';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'Ballot_version.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'Ballot_version.updated_at';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'Ballot_version.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = 'Ballot_version.version_created_at';

    /**
     * the column name for the Voter_ids field
     */
    const COL_VOTER_IDS = 'Ballot_version.Voter_ids';

    /**
     * the column name for the Voter_versions field
     */
    const COL_VOTER_VERSIONS = 'Ballot_version.Voter_versions';

    /**
     * the column name for the Question_ids field
     */
    const COL_QUESTION_IDS = 'Ballot_version.Question_ids';

    /**
     * the column name for the Question_versions field
     */
    const COL_QUESTION_VERSIONS = 'Ballot_version.Question_versions';

    /**
     * the column name for the Vote_ids field
     */
    const COL_VOTE_IDS = 'Ballot_version.Vote_ids';

    /**
     * the column name for the Vote_versions field
     */
    const COL_VOTE_VERSIONS = 'Ballot_version.Vote_versions';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('id', 'userId', 'name', 'startTime', 'endTime', 'timezone', 'versionCreatedBy', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VoterIds', 'VoterVersions', 'QuestionIds', 'QuestionVersions', 'VoteIds', 'VoteVersions', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'name', 'startTime', 'endTime', 'timezone', 'versionCreatedBy', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'voterIds', 'voterVersions', 'questionIds', 'questionVersions', 'voteIds', 'voteVersions', ),
        self::TYPE_COLNAME       => array(BallotVersionTableMap::COL_ID, BallotVersionTableMap::COL_USER_ID, BallotVersionTableMap::COL_NAME, BallotVersionTableMap::COL_START_TIME, BallotVersionTableMap::COL_END_TIME, BallotVersionTableMap::COL_TIMEZONE, BallotVersionTableMap::COL_VERSION_CREATED_BY, BallotVersionTableMap::COL_CREATED_AT, BallotVersionTableMap::COL_UPDATED_AT, BallotVersionTableMap::COL_VERSION, BallotVersionTableMap::COL_VERSION_CREATED_AT, BallotVersionTableMap::COL_VOTER_IDS, BallotVersionTableMap::COL_VOTER_VERSIONS, BallotVersionTableMap::COL_QUESTION_IDS, BallotVersionTableMap::COL_QUESTION_VERSIONS, BallotVersionTableMap::COL_VOTE_IDS, BallotVersionTableMap::COL_VOTE_VERSIONS, ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'name', 'start_time', 'end_time', 'timezone', 'version_created_by', 'created_at', 'updated_at', 'version', 'version_created_at', 'Voter_ids', 'Voter_versions', 'Question_ids', 'Question_versions', 'Vote_ids', 'Vote_versions', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('id' => 0, 'userId' => 1, 'name' => 2, 'startTime' => 3, 'endTime' => 4, 'timezone' => 5, 'versionCreatedBy' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, 'Version' => 9, 'VersionCreatedAt' => 10, 'VoterIds' => 11, 'VoterVersions' => 12, 'QuestionIds' => 13, 'QuestionVersions' => 14, 'VoteIds' => 15, 'VoteVersions' => 16, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'name' => 2, 'startTime' => 3, 'endTime' => 4, 'timezone' => 5, 'versionCreatedBy' => 6, 'createdAt' => 7, 'updatedAt' => 8, 'version' => 9, 'versionCreatedAt' => 10, 'voterIds' => 11, 'voterVersions' => 12, 'questionIds' => 13, 'questionVersions' => 14, 'voteIds' => 15, 'voteVersions' => 16, ),
        self::TYPE_COLNAME       => array(BallotVersionTableMap::COL_ID => 0, BallotVersionTableMap::COL_USER_ID => 1, BallotVersionTableMap::COL_NAME => 2, BallotVersionTableMap::COL_START_TIME => 3, BallotVersionTableMap::COL_END_TIME => 4, BallotVersionTableMap::COL_TIMEZONE => 5, BallotVersionTableMap::COL_VERSION_CREATED_BY => 6, BallotVersionTableMap::COL_CREATED_AT => 7, BallotVersionTableMap::COL_UPDATED_AT => 8, BallotVersionTableMap::COL_VERSION => 9, BallotVersionTableMap::COL_VERSION_CREATED_AT => 10, BallotVersionTableMap::COL_VOTER_IDS => 11, BallotVersionTableMap::COL_VOTER_VERSIONS => 12, BallotVersionTableMap::COL_QUESTION_IDS => 13, BallotVersionTableMap::COL_QUESTION_VERSIONS => 14, BallotVersionTableMap::COL_VOTE_IDS => 15, BallotVersionTableMap::COL_VOTE_VERSIONS => 16, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'name' => 2, 'start_time' => 3, 'end_time' => 4, 'timezone' => 5, 'version_created_by' => 6, 'created_at' => 7, 'updated_at' => 8, 'version' => 9, 'version_created_at' => 10, 'Voter_ids' => 11, 'Voter_versions' => 12, 'Question_ids' => 13, 'Question_versions' => 14, 'Vote_ids' => 15, 'Vote_versions' => 16, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('Ballot_version');
        $this->setPhpName('BallotVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MESBallotBox\\Propel\\BallotVersion');
        $this->setPackage('MESBallotBox.Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'id', 'INTEGER' , 'Ballot', 'id', true, 10, null);
        $this->addColumn('user_id', 'userId', 'INTEGER', true, 10, null);
        $this->addColumn('name', 'name', 'VARCHAR', true, 40, null);
        $this->addColumn('start_time', 'startTime', 'INTEGER', true, 10, null);
        $this->addColumn('end_time', 'endTime', 'INTEGER', true, 10, null);
        $this->addColumn('timezone', 'timezone', 'INTEGER', true, 10, null);
        $this->addColumn('version_created_by', 'versionCreatedBy', 'INTEGER', false, 10, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('Voter_ids', 'VoterIds', 'ARRAY', false, null, null);
        $this->addColumn('Voter_versions', 'VoterVersions', 'ARRAY', false, null, null);
        $this->addColumn('Question_ids', 'QuestionIds', 'ARRAY', false, null, null);
        $this->addColumn('Question_versions', 'QuestionVersions', 'ARRAY', false, null, null);
        $this->addColumn('Vote_ids', 'VoteIds', 'ARRAY', false, null, null);
        $this->addColumn('Vote_versions', 'VoteVersions', 'ARRAY', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Ballot', '\\MESBallotBox\\Propel\\Ballot', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \MESBallotBox\Propel\BallotVersion $obj A \MESBallotBox\Propel\BallotVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getid() || is_scalar($obj->getid()) || is_callable([$obj->getid(), '__toString']) ? (string) $obj->getid() : $obj->getid()), (null === $obj->getVersion() || is_scalar($obj->getVersion()) || is_callable([$obj->getVersion(), '__toString']) ? (string) $obj->getVersion() : $obj->getVersion())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \MESBallotBox\Propel\BallotVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \MESBallotBox\Propel\BallotVersion) {
                $key = serialize([(null === $value->getid() || is_scalar($value->getid()) || is_callable([$value->getid(), '__toString']) ? (string) $value->getid() : $value->getid()), (null === $value->getVersion() || is_scalar($value->getVersion()) || is_callable([$value->getVersion(), '__toString']) ? (string) $value->getVersion() : $value->getVersion())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \MESBallotBox\Propel\BallotVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 9 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 9 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 9 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 9 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 9 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 9 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)])]);
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 9 + $offset
                : self::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? BallotVersionTableMap::CLASS_DEFAULT : BallotVersionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (BallotVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BallotVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BallotVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BallotVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BallotVersionTableMap::OM_CLASS;
            /** @var BallotVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BallotVersionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = BallotVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BallotVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var BallotVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BallotVersionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(BallotVersionTableMap::COL_ID);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_USER_ID);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_NAME);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_START_TIME);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_END_TIME);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_TIMEZONE);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_VERSION_CREATED_BY);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_VOTER_IDS);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_VOTER_VERSIONS);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_QUESTION_IDS);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_QUESTION_VERSIONS);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_VOTE_IDS);
            $criteria->addSelectColumn(BallotVersionTableMap::COL_VOTE_VERSIONS);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.start_time');
            $criteria->addSelectColumn($alias . '.end_time');
            $criteria->addSelectColumn($alias . '.timezone');
            $criteria->addSelectColumn($alias . '.version_created_by');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.version_created_at');
            $criteria->addSelectColumn($alias . '.Voter_ids');
            $criteria->addSelectColumn($alias . '.Voter_versions');
            $criteria->addSelectColumn($alias . '.Question_ids');
            $criteria->addSelectColumn($alias . '.Question_versions');
            $criteria->addSelectColumn($alias . '.Vote_ids');
            $criteria->addSelectColumn($alias . '.Vote_versions');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(BallotVersionTableMap::DATABASE_NAME)->getTable(BallotVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BallotVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BallotVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BallotVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a BallotVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or BallotVersion object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BallotVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MESBallotBox\Propel\BallotVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BallotVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(BallotVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(BallotVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = BallotVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BallotVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BallotVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the Ballot_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BallotVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a BallotVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or BallotVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BallotVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from BallotVersion object
        }


        // Set the correct dbName
        $query = BallotVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BallotVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BallotVersionTableMap::buildTableMap();
