<?php

namespace MESBallotBox\Propel\Map;

use MESBallotBox\Propel\VoteItemVersion;
use MESBallotBox\Propel\VoteItemVersionQuery;
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
 * This class defines the structure of the 'Vote_item_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class VoteItemVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MESBallotBox.Propel.Map.VoteItemVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'Vote_item_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MESBallotBox\\Propel\\VoteItemVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MESBallotBox.Propel.VoteItemVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'Vote_item_version.id';

    /**
     * the column name for the vote_id field
     */
    const COL_VOTE_ID = 'Vote_item_version.vote_id';

    /**
     * the column name for the question_id field
     */
    const COL_QUESTION_ID = 'Vote_item_version.question_id';

    /**
     * the column name for the candidate_id field
     */
    const COL_CANDIDATE_ID = 'Vote_item_version.candidate_id';

    /**
     * the column name for the answer field
     */
    const COL_ANSWER = 'Vote_item_version.answer';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'Vote_item_version.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'Vote_item_version.updated_at';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'Vote_item_version.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = 'Vote_item_version.version_created_at';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = 'Vote_item_version.version_created_by';

    /**
     * the column name for the vote_id_version field
     */
    const COL_VOTE_ID_VERSION = 'Vote_item_version.vote_id_version';

    /**
     * the column name for the question_id_version field
     */
    const COL_QUESTION_ID_VERSION = 'Vote_item_version.question_id_version';

    /**
     * the column name for the candidate_id_version field
     */
    const COL_CANDIDATE_ID_VERSION = 'Vote_item_version.candidate_id_version';

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
        self::TYPE_PHPNAME       => array('id', 'voteId', 'questionId', 'candidateId', 'answer', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'VoteIdVersion', 'QuestionIdVersion', 'CandidateIdVersion', ),
        self::TYPE_CAMELNAME     => array('id', 'voteId', 'questionId', 'candidateId', 'answer', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', 'voteIdVersion', 'questionIdVersion', 'candidateIdVersion', ),
        self::TYPE_COLNAME       => array(VoteItemVersionTableMap::COL_ID, VoteItemVersionTableMap::COL_VOTE_ID, VoteItemVersionTableMap::COL_QUESTION_ID, VoteItemVersionTableMap::COL_CANDIDATE_ID, VoteItemVersionTableMap::COL_ANSWER, VoteItemVersionTableMap::COL_CREATED_AT, VoteItemVersionTableMap::COL_UPDATED_AT, VoteItemVersionTableMap::COL_VERSION, VoteItemVersionTableMap::COL_VERSION_CREATED_AT, VoteItemVersionTableMap::COL_VERSION_CREATED_BY, VoteItemVersionTableMap::COL_VOTE_ID_VERSION, VoteItemVersionTableMap::COL_QUESTION_ID_VERSION, VoteItemVersionTableMap::COL_CANDIDATE_ID_VERSION, ),
        self::TYPE_FIELDNAME     => array('id', 'vote_id', 'question_id', 'candidate_id', 'answer', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', 'vote_id_version', 'question_id_version', 'candidate_id_version', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('id' => 0, 'voteId' => 1, 'questionId' => 2, 'candidateId' => 3, 'answer' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, 'Version' => 7, 'VersionCreatedAt' => 8, 'VersionCreatedBy' => 9, 'VoteIdVersion' => 10, 'QuestionIdVersion' => 11, 'CandidateIdVersion' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'voteId' => 1, 'questionId' => 2, 'candidateId' => 3, 'answer' => 4, 'createdAt' => 5, 'updatedAt' => 6, 'version' => 7, 'versionCreatedAt' => 8, 'versionCreatedBy' => 9, 'voteIdVersion' => 10, 'questionIdVersion' => 11, 'candidateIdVersion' => 12, ),
        self::TYPE_COLNAME       => array(VoteItemVersionTableMap::COL_ID => 0, VoteItemVersionTableMap::COL_VOTE_ID => 1, VoteItemVersionTableMap::COL_QUESTION_ID => 2, VoteItemVersionTableMap::COL_CANDIDATE_ID => 3, VoteItemVersionTableMap::COL_ANSWER => 4, VoteItemVersionTableMap::COL_CREATED_AT => 5, VoteItemVersionTableMap::COL_UPDATED_AT => 6, VoteItemVersionTableMap::COL_VERSION => 7, VoteItemVersionTableMap::COL_VERSION_CREATED_AT => 8, VoteItemVersionTableMap::COL_VERSION_CREATED_BY => 9, VoteItemVersionTableMap::COL_VOTE_ID_VERSION => 10, VoteItemVersionTableMap::COL_QUESTION_ID_VERSION => 11, VoteItemVersionTableMap::COL_CANDIDATE_ID_VERSION => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'vote_id' => 1, 'question_id' => 2, 'candidate_id' => 3, 'answer' => 4, 'created_at' => 5, 'updated_at' => 6, 'version' => 7, 'version_created_at' => 8, 'version_created_by' => 9, 'vote_id_version' => 10, 'question_id_version' => 11, 'candidate_id_version' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
        $this->setName('Vote_item_version');
        $this->setPhpName('VoteItemVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MESBallotBox\\Propel\\VoteItemVersion');
        $this->setPackage('MESBallotBox.Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'id', 'INTEGER' , 'Vote_item', 'id', true, 10, null);
        $this->addColumn('vote_id', 'voteId', 'INTEGER', true, 10, null);
        $this->addColumn('question_id', 'questionId', 'INTEGER', true, 10, null);
        $this->addColumn('candidate_id', 'candidateId', 'INTEGER', false, 10, null);
        $this->addColumn('answer', 'answer', 'INTEGER', false, 10, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version_created_by', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('vote_id_version', 'VoteIdVersion', 'INTEGER', false, null, 0);
        $this->addColumn('question_id_version', 'QuestionIdVersion', 'INTEGER', false, null, 0);
        $this->addColumn('candidate_id_version', 'CandidateIdVersion', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('VoteItem', '\\MESBallotBox\\Propel\\VoteItem', RelationMap::MANY_TO_ONE, array (
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
     * @param \MESBallotBox\Propel\VoteItemVersion $obj A \MESBallotBox\Propel\VoteItemVersion object.
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
     * @param mixed $value A \MESBallotBox\Propel\VoteItemVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \MESBallotBox\Propel\VoteItemVersion) {
                $key = serialize([(null === $value->getid() || is_scalar($value->getid()) || is_callable([$value->getid(), '__toString']) ? (string) $value->getid() : $value->getid()), (null === $value->getVersion() || is_scalar($value->getVersion()) || is_callable([$value->getVersion(), '__toString']) ? (string) $value->getVersion() : $value->getVersion())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \MESBallotBox\Propel\VoteItemVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)])]);
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
                ? 7 + $offset
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
        return $withPrefix ? VoteItemVersionTableMap::CLASS_DEFAULT : VoteItemVersionTableMap::OM_CLASS;
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
     * @return array           (VoteItemVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = VoteItemVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = VoteItemVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + VoteItemVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = VoteItemVersionTableMap::OM_CLASS;
            /** @var VoteItemVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            VoteItemVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = VoteItemVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = VoteItemVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var VoteItemVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                VoteItemVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_ID);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_VOTE_ID);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_QUESTION_ID);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_CANDIDATE_ID);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_ANSWER);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_VERSION_CREATED_BY);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_VOTE_ID_VERSION);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_QUESTION_ID_VERSION);
            $criteria->addSelectColumn(VoteItemVersionTableMap::COL_CANDIDATE_ID_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.vote_id');
            $criteria->addSelectColumn($alias . '.question_id');
            $criteria->addSelectColumn($alias . '.candidate_id');
            $criteria->addSelectColumn($alias . '.answer');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.version_created_at');
            $criteria->addSelectColumn($alias . '.version_created_by');
            $criteria->addSelectColumn($alias . '.vote_id_version');
            $criteria->addSelectColumn($alias . '.question_id_version');
            $criteria->addSelectColumn($alias . '.candidate_id_version');
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
        return Propel::getServiceContainer()->getDatabaseMap(VoteItemVersionTableMap::DATABASE_NAME)->getTable(VoteItemVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(VoteItemVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(VoteItemVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new VoteItemVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a VoteItemVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or VoteItemVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MESBallotBox\Propel\VoteItemVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(VoteItemVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(VoteItemVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(VoteItemVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = VoteItemVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            VoteItemVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                VoteItemVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the Vote_item_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return VoteItemVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a VoteItemVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or VoteItemVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from VoteItemVersion object
        }


        // Set the correct dbName
        $query = VoteItemVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // VoteItemVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
VoteItemVersionTableMap::buildTableMap();
