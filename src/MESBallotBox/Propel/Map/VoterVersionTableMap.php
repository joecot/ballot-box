<?php

namespace MESBallotBox\Propel\Map;

use MESBallotBox\Propel\VoterVersion;
use MESBallotBox\Propel\VoterVersionQuery;
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
 * This class defines the structure of the 'Voter_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class VoterVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MESBallotBox.Propel.Map.VoterVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'Voter_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MESBallotBox\\Propel\\VoterVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MESBallotBox.Propel.VoterVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'Voter_version.id';

    /**
     * the column name for the ballot_id field
     */
    const COL_BALLOT_ID = 'Voter_version.ballot_id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'Voter_version.user_id';

    /**
     * the column name for the affiliate_id field
     */
    const COL_AFFILIATE_ID = 'Voter_version.affiliate_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'Voter_version.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'Voter_version.updated_at';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'Voter_version.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = 'Voter_version.version_created_at';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = 'Voter_version.version_created_by';

    /**
     * the column name for the ballot_id_version field
     */
    const COL_BALLOT_ID_VERSION = 'Voter_version.ballot_id_version';

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
        self::TYPE_PHPNAME       => array('id', 'ballotId', 'userId', 'affiliateId', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'BallotIdVersion', ),
        self::TYPE_CAMELNAME     => array('id', 'ballotId', 'userId', 'affiliateId', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', 'ballotIdVersion', ),
        self::TYPE_COLNAME       => array(VoterVersionTableMap::COL_ID, VoterVersionTableMap::COL_BALLOT_ID, VoterVersionTableMap::COL_USER_ID, VoterVersionTableMap::COL_AFFILIATE_ID, VoterVersionTableMap::COL_CREATED_AT, VoterVersionTableMap::COL_UPDATED_AT, VoterVersionTableMap::COL_VERSION, VoterVersionTableMap::COL_VERSION_CREATED_AT, VoterVersionTableMap::COL_VERSION_CREATED_BY, VoterVersionTableMap::COL_BALLOT_ID_VERSION, ),
        self::TYPE_FIELDNAME     => array('id', 'ballot_id', 'user_id', 'affiliate_id', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', 'ballot_id_version', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('id' => 0, 'ballotId' => 1, 'userId' => 2, 'affiliateId' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, 'Version' => 6, 'VersionCreatedAt' => 7, 'VersionCreatedBy' => 8, 'BallotIdVersion' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'ballotId' => 1, 'userId' => 2, 'affiliateId' => 3, 'createdAt' => 4, 'updatedAt' => 5, 'version' => 6, 'versionCreatedAt' => 7, 'versionCreatedBy' => 8, 'ballotIdVersion' => 9, ),
        self::TYPE_COLNAME       => array(VoterVersionTableMap::COL_ID => 0, VoterVersionTableMap::COL_BALLOT_ID => 1, VoterVersionTableMap::COL_USER_ID => 2, VoterVersionTableMap::COL_AFFILIATE_ID => 3, VoterVersionTableMap::COL_CREATED_AT => 4, VoterVersionTableMap::COL_UPDATED_AT => 5, VoterVersionTableMap::COL_VERSION => 6, VoterVersionTableMap::COL_VERSION_CREATED_AT => 7, VoterVersionTableMap::COL_VERSION_CREATED_BY => 8, VoterVersionTableMap::COL_BALLOT_ID_VERSION => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ballot_id' => 1, 'user_id' => 2, 'affiliate_id' => 3, 'created_at' => 4, 'updated_at' => 5, 'version' => 6, 'version_created_at' => 7, 'version_created_by' => 8, 'ballot_id_version' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('Voter_version');
        $this->setPhpName('VoterVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MESBallotBox\\Propel\\VoterVersion');
        $this->setPackage('MESBallotBox.Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'id', 'INTEGER' , 'Voter', 'id', true, 10, null);
        $this->addColumn('ballot_id', 'ballotId', 'INTEGER', true, 10, null);
        $this->addColumn('user_id', 'userId', 'INTEGER', false, 10, null);
        $this->addColumn('affiliate_id', 'affiliateId', 'INTEGER', false, 10, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version_created_by', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('ballot_id_version', 'BallotIdVersion', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Voter', '\\MESBallotBox\\Propel\\Voter', RelationMap::MANY_TO_ONE, array (
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
     * @param \MESBallotBox\Propel\VoterVersion $obj A \MESBallotBox\Propel\VoterVersion object.
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
     * @param mixed $value A \MESBallotBox\Propel\VoterVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \MESBallotBox\Propel\VoterVersion) {
                $key = serialize([(null === $value->getid() || is_scalar($value->getid()) || is_callable([$value->getid(), '__toString']) ? (string) $value->getid() : $value->getid()), (null === $value->getVersion() || is_scalar($value->getVersion()) || is_callable([$value->getVersion(), '__toString']) ? (string) $value->getVersion() : $value->getVersion())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \MESBallotBox\Propel\VoterVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)])]);
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
                ? 6 + $offset
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
        return $withPrefix ? VoterVersionTableMap::CLASS_DEFAULT : VoterVersionTableMap::OM_CLASS;
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
     * @return array           (VoterVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = VoterVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = VoterVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + VoterVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = VoterVersionTableMap::OM_CLASS;
            /** @var VoterVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            VoterVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = VoterVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = VoterVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var VoterVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                VoterVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(VoterVersionTableMap::COL_ID);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_BALLOT_ID);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_USER_ID);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_AFFILIATE_ID);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_VERSION_CREATED_BY);
            $criteria->addSelectColumn(VoterVersionTableMap::COL_BALLOT_ID_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.ballot_id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.affiliate_id');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.version_created_at');
            $criteria->addSelectColumn($alias . '.version_created_by');
            $criteria->addSelectColumn($alias . '.ballot_id_version');
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
        return Propel::getServiceContainer()->getDatabaseMap(VoterVersionTableMap::DATABASE_NAME)->getTable(VoterVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(VoterVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(VoterVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new VoterVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a VoterVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or VoterVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(VoterVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MESBallotBox\Propel\VoterVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(VoterVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(VoterVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(VoterVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = VoterVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            VoterVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                VoterVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the Voter_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return VoterVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a VoterVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or VoterVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoterVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from VoterVersion object
        }


        // Set the correct dbName
        $query = VoterVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // VoterVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
VoterVersionTableMap::buildTableMap();
