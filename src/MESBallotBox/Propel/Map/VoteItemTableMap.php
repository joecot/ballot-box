<?php

namespace MESBallotBox\Propel\Map;

use MESBallotBox\Propel\VoteItem;
use MESBallotBox\Propel\VoteItemQuery;
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
 * This class defines the structure of the 'Vote_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class VoteItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MESBallotBox.Propel.Map.VoteItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'Vote_item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MESBallotBox\\Propel\\VoteItem';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MESBallotBox.Propel.VoteItem';

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
    const COL_ID = 'Vote_item.id';

    /**
     * the column name for the vote_id field
     */
    const COL_VOTE_ID = 'Vote_item.vote_id';

    /**
     * the column name for the question_id field
     */
    const COL_QUESTION_ID = 'Vote_item.question_id';

    /**
     * the column name for the candidate_id field
     */
    const COL_CANDIDATE_ID = 'Vote_item.candidate_id';

    /**
     * the column name for the answer field
     */
    const COL_ANSWER = 'Vote_item.answer';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'Vote_item.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'Vote_item.updated_at';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'Vote_item.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = 'Vote_item.version_created_at';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = 'Vote_item.version_created_by';

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
        self::TYPE_PHPNAME       => array('id', 'voteId', 'questionId', 'candidateId', 'answer', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'voteId', 'questionId', 'candidateId', 'answer', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(VoteItemTableMap::COL_ID, VoteItemTableMap::COL_VOTE_ID, VoteItemTableMap::COL_QUESTION_ID, VoteItemTableMap::COL_CANDIDATE_ID, VoteItemTableMap::COL_ANSWER, VoteItemTableMap::COL_CREATED_AT, VoteItemTableMap::COL_UPDATED_AT, VoteItemTableMap::COL_VERSION, VoteItemTableMap::COL_VERSION_CREATED_AT, VoteItemTableMap::COL_VERSION_CREATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'vote_id', 'question_id', 'candidate_id', 'answer', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('id' => 0, 'voteId' => 1, 'questionId' => 2, 'candidateId' => 3, 'answer' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, 'Version' => 7, 'VersionCreatedAt' => 8, 'VersionCreatedBy' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'voteId' => 1, 'questionId' => 2, 'candidateId' => 3, 'answer' => 4, 'createdAt' => 5, 'updatedAt' => 6, 'version' => 7, 'versionCreatedAt' => 8, 'versionCreatedBy' => 9, ),
        self::TYPE_COLNAME       => array(VoteItemTableMap::COL_ID => 0, VoteItemTableMap::COL_VOTE_ID => 1, VoteItemTableMap::COL_QUESTION_ID => 2, VoteItemTableMap::COL_CANDIDATE_ID => 3, VoteItemTableMap::COL_ANSWER => 4, VoteItemTableMap::COL_CREATED_AT => 5, VoteItemTableMap::COL_UPDATED_AT => 6, VoteItemTableMap::COL_VERSION => 7, VoteItemTableMap::COL_VERSION_CREATED_AT => 8, VoteItemTableMap::COL_VERSION_CREATED_BY => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'vote_id' => 1, 'question_id' => 2, 'candidate_id' => 3, 'answer' => 4, 'created_at' => 5, 'updated_at' => 6, 'version' => 7, 'version_created_at' => 8, 'version_created_by' => 9, ),
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
        $this->setName('Vote_item');
        $this->setPhpName('VoteItem');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MESBallotBox\\Propel\\VoteItem');
        $this->setPackage('MESBallotBox.Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'id', 'INTEGER', true, 10, null);
        $this->addForeignKey('vote_id', 'voteId', 'INTEGER', 'Vote', 'id', true, 10, null);
        $this->addForeignKey('question_id', 'questionId', 'INTEGER', 'Question', 'id', true, 10, null);
        $this->addForeignKey('candidate_id', 'candidateId', 'INTEGER', 'Candidate', 'id', false, 10, null);
        $this->addColumn('answer', 'answer', 'INTEGER', false, 10, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version_created_by', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Vote', '\\MESBallotBox\\Propel\\Vote', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':vote_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Question', '\\MESBallotBox\\Propel\\Question', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':question_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Candidate', '\\MESBallotBox\\Propel\\Candidate', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':candidate_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('VoteItemVersion', '\\MESBallotBox\\Propel\\VoteItemVersion', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'VoteItemVersions', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'true', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', 'indices' => 'false', ),
            'validate' => array('rule1' => array ('column' => 'question_id','validator' => 'NotNull','options' => array ('message' => 'Question required',),), ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to Vote_item     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        VoteItemVersionTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? VoteItemTableMap::CLASS_DEFAULT : VoteItemTableMap::OM_CLASS;
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
     * @return array           (VoteItem object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = VoteItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = VoteItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + VoteItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = VoteItemTableMap::OM_CLASS;
            /** @var VoteItem $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            VoteItemTableMap::addInstanceToPool($obj, $key);
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
            $key = VoteItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = VoteItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var VoteItem $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                VoteItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(VoteItemTableMap::COL_ID);
            $criteria->addSelectColumn(VoteItemTableMap::COL_VOTE_ID);
            $criteria->addSelectColumn(VoteItemTableMap::COL_QUESTION_ID);
            $criteria->addSelectColumn(VoteItemTableMap::COL_CANDIDATE_ID);
            $criteria->addSelectColumn(VoteItemTableMap::COL_ANSWER);
            $criteria->addSelectColumn(VoteItemTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(VoteItemTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(VoteItemTableMap::COL_VERSION);
            $criteria->addSelectColumn(VoteItemTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(VoteItemTableMap::COL_VERSION_CREATED_BY);
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
        return Propel::getServiceContainer()->getDatabaseMap(VoteItemTableMap::DATABASE_NAME)->getTable(VoteItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(VoteItemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(VoteItemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new VoteItemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a VoteItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or VoteItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MESBallotBox\Propel\VoteItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(VoteItemTableMap::DATABASE_NAME);
            $criteria->add(VoteItemTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = VoteItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            VoteItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                VoteItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the Vote_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return VoteItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a VoteItem or Criteria object.
     *
     * @param mixed               $criteria Criteria or VoteItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from VoteItem object
        }

        if ($criteria->containsKey(VoteItemTableMap::COL_ID) && $criteria->keyContainsValue(VoteItemTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.VoteItemTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = VoteItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // VoteItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
VoteItemTableMap::buildTableMap();
