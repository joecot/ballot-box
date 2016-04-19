<?php

namespace MESBallotBox\Propel\Map;

use MESBallotBox\Propel\QuestionVersion;
use MESBallotBox\Propel\QuestionVersionQuery;
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
 * This class defines the structure of the 'Question_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class QuestionVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MESBallotBox.Propel.Map.QuestionVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'Question_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MESBallotBox\\Propel\\QuestionVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MESBallotBox.Propel.QuestionVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 20;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 20;

    /**
     * the column name for the id field
     */
    const COL_ID = 'Question_version.id';

    /**
     * the column name for the ballot_id field
     */
    const COL_BALLOT_ID = 'Question_version.ballot_id';

    /**
     * the column name for the order_id field
     */
    const COL_ORDER_ID = 'Question_version.order_id';

    /**
     * the column name for the is_deleted field
     */
    const COL_IS_DELETED = 'Question_version.is_deleted';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'Question_version.type';

    /**
     * the column name for the count field
     */
    const COL_COUNT = 'Question_version.count';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'Question_version.name';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'Question_version.description';

    /**
     * the column name for the readmore field
     */
    const COL_READMORE = 'Question_version.readmore';

    /**
     * the column name for the discussion field
     */
    const COL_DISCUSSION = 'Question_version.discussion';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'Question_version.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'Question_version.updated_at';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'Question_version.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = 'Question_version.version_created_at';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = 'Question_version.version_created_by';

    /**
     * the column name for the ballot_id_version field
     */
    const COL_BALLOT_ID_VERSION = 'Question_version.ballot_id_version';

    /**
     * the column name for the Candidate_ids field
     */
    const COL_CANDIDATE_IDS = 'Question_version.Candidate_ids';

    /**
     * the column name for the Candidate_versions field
     */
    const COL_CANDIDATE_VERSIONS = 'Question_version.Candidate_versions';

    /**
     * the column name for the Vote_item_ids field
     */
    const COL_VOTE_ITEM_IDS = 'Question_version.Vote_item_ids';

    /**
     * the column name for the Vote_item_versions field
     */
    const COL_VOTE_ITEM_VERSIONS = 'Question_version.Vote_item_versions';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the type field */
    const COL_TYPE_PROPOSITION = 'proposition';
    const COL_TYPE_OFFICE = 'office';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('id', 'ballotId', 'orderId', 'isDeleted', 'type', 'count', 'name', 'description', 'readmore', 'discussion', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'BallotIdVersion', 'CandidateIds', 'CandidateVersions', 'VoteItemIds', 'VoteItemVersions', ),
        self::TYPE_CAMELNAME     => array('id', 'ballotId', 'orderId', 'isDeleted', 'type', 'count', 'name', 'description', 'readmore', 'discussion', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', 'ballotIdVersion', 'candidateIds', 'candidateVersions', 'voteItemIds', 'voteItemVersions', ),
        self::TYPE_COLNAME       => array(QuestionVersionTableMap::COL_ID, QuestionVersionTableMap::COL_BALLOT_ID, QuestionVersionTableMap::COL_ORDER_ID, QuestionVersionTableMap::COL_IS_DELETED, QuestionVersionTableMap::COL_TYPE, QuestionVersionTableMap::COL_COUNT, QuestionVersionTableMap::COL_NAME, QuestionVersionTableMap::COL_DESCRIPTION, QuestionVersionTableMap::COL_READMORE, QuestionVersionTableMap::COL_DISCUSSION, QuestionVersionTableMap::COL_CREATED_AT, QuestionVersionTableMap::COL_UPDATED_AT, QuestionVersionTableMap::COL_VERSION, QuestionVersionTableMap::COL_VERSION_CREATED_AT, QuestionVersionTableMap::COL_VERSION_CREATED_BY, QuestionVersionTableMap::COL_BALLOT_ID_VERSION, QuestionVersionTableMap::COL_CANDIDATE_IDS, QuestionVersionTableMap::COL_CANDIDATE_VERSIONS, QuestionVersionTableMap::COL_VOTE_ITEM_IDS, QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS, ),
        self::TYPE_FIELDNAME     => array('id', 'ballot_id', 'order_id', 'is_deleted', 'type', 'count', 'name', 'description', 'readmore', 'discussion', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', 'ballot_id_version', 'Candidate_ids', 'Candidate_versions', 'Vote_item_ids', 'Vote_item_versions', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('id' => 0, 'ballotId' => 1, 'orderId' => 2, 'isDeleted' => 3, 'type' => 4, 'count' => 5, 'name' => 6, 'description' => 7, 'readmore' => 8, 'discussion' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, 'Version' => 12, 'VersionCreatedAt' => 13, 'VersionCreatedBy' => 14, 'BallotIdVersion' => 15, 'CandidateIds' => 16, 'CandidateVersions' => 17, 'VoteItemIds' => 18, 'VoteItemVersions' => 19, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'ballotId' => 1, 'orderId' => 2, 'isDeleted' => 3, 'type' => 4, 'count' => 5, 'name' => 6, 'description' => 7, 'readmore' => 8, 'discussion' => 9, 'createdAt' => 10, 'updatedAt' => 11, 'version' => 12, 'versionCreatedAt' => 13, 'versionCreatedBy' => 14, 'ballotIdVersion' => 15, 'candidateIds' => 16, 'candidateVersions' => 17, 'voteItemIds' => 18, 'voteItemVersions' => 19, ),
        self::TYPE_COLNAME       => array(QuestionVersionTableMap::COL_ID => 0, QuestionVersionTableMap::COL_BALLOT_ID => 1, QuestionVersionTableMap::COL_ORDER_ID => 2, QuestionVersionTableMap::COL_IS_DELETED => 3, QuestionVersionTableMap::COL_TYPE => 4, QuestionVersionTableMap::COL_COUNT => 5, QuestionVersionTableMap::COL_NAME => 6, QuestionVersionTableMap::COL_DESCRIPTION => 7, QuestionVersionTableMap::COL_READMORE => 8, QuestionVersionTableMap::COL_DISCUSSION => 9, QuestionVersionTableMap::COL_CREATED_AT => 10, QuestionVersionTableMap::COL_UPDATED_AT => 11, QuestionVersionTableMap::COL_VERSION => 12, QuestionVersionTableMap::COL_VERSION_CREATED_AT => 13, QuestionVersionTableMap::COL_VERSION_CREATED_BY => 14, QuestionVersionTableMap::COL_BALLOT_ID_VERSION => 15, QuestionVersionTableMap::COL_CANDIDATE_IDS => 16, QuestionVersionTableMap::COL_CANDIDATE_VERSIONS => 17, QuestionVersionTableMap::COL_VOTE_ITEM_IDS => 18, QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS => 19, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ballot_id' => 1, 'order_id' => 2, 'is_deleted' => 3, 'type' => 4, 'count' => 5, 'name' => 6, 'description' => 7, 'readmore' => 8, 'discussion' => 9, 'created_at' => 10, 'updated_at' => 11, 'version' => 12, 'version_created_at' => 13, 'version_created_by' => 14, 'ballot_id_version' => 15, 'Candidate_ids' => 16, 'Candidate_versions' => 17, 'Vote_item_ids' => 18, 'Vote_item_versions' => 19, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                QuestionVersionTableMap::COL_TYPE => array(
                            self::COL_TYPE_PROPOSITION,
            self::COL_TYPE_OFFICE,
        ),
    );

    /**
     * Gets the list of values for all ENUM and SET columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM or SET column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

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
        $this->setName('Question_version');
        $this->setPhpName('QuestionVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MESBallotBox\\Propel\\QuestionVersion');
        $this->setPackage('MESBallotBox.Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'id', 'INTEGER' , 'Question', 'id', true, 10, null);
        $this->addColumn('ballot_id', 'ballotId', 'INTEGER', true, 10, null);
        $this->addColumn('order_id', 'orderId', 'INTEGER', true, 10, null);
        $this->addColumn('is_deleted', 'isDeleted', 'INTEGER', false, 10, null);
        $this->addColumn('type', 'type', 'ENUM', false, null, null);
        $this->getColumn('type')->setValueSet(array (
  0 => 'proposition',
  1 => 'office',
));
        $this->addColumn('count', 'count', 'INTEGER', false, 10, null);
        $this->addColumn('name', 'name', 'VARCHAR', true, 64, null);
        $this->addColumn('description', 'description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('readmore', 'readmore', 'VARCHAR', false, 255, null);
        $this->addColumn('discussion', 'discussion', 'VARCHAR', false, 255, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version_created_by', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('ballot_id_version', 'BallotIdVersion', 'INTEGER', false, null, 0);
        $this->addColumn('Candidate_ids', 'CandidateIds', 'ARRAY', false, null, null);
        $this->addColumn('Candidate_versions', 'CandidateVersions', 'ARRAY', false, null, null);
        $this->addColumn('Vote_item_ids', 'VoteItemIds', 'ARRAY', false, null, null);
        $this->addColumn('Vote_item_versions', 'VoteItemVersions', 'ARRAY', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Question', '\\MESBallotBox\\Propel\\Question', RelationMap::MANY_TO_ONE, array (
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
     * @param \MESBallotBox\Propel\QuestionVersion $obj A \MESBallotBox\Propel\QuestionVersion object.
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
     * @param mixed $value A \MESBallotBox\Propel\QuestionVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \MESBallotBox\Propel\QuestionVersion) {
                $key = serialize([(null === $value->getid() || is_scalar($value->getid()) || is_callable([$value->getid(), '__toString']) ? (string) $value->getid() : $value->getid()), (null === $value->getVersion() || is_scalar($value->getVersion()) || is_callable([$value->getVersion(), '__toString']) ? (string) $value->getVersion() : $value->getVersion())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \MESBallotBox\Propel\QuestionVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)])]);
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
                ? 12 + $offset
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
        return $withPrefix ? QuestionVersionTableMap::CLASS_DEFAULT : QuestionVersionTableMap::OM_CLASS;
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
     * @return array           (QuestionVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = QuestionVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = QuestionVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + QuestionVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = QuestionVersionTableMap::OM_CLASS;
            /** @var QuestionVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            QuestionVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = QuestionVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = QuestionVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var QuestionVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                QuestionVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_ID);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_BALLOT_ID);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_ORDER_ID);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_IS_DELETED);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_TYPE);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_COUNT);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_NAME);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_READMORE);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_DISCUSSION);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_VERSION_CREATED_BY);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_BALLOT_ID_VERSION);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_CANDIDATE_IDS);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_VOTE_ITEM_IDS);
            $criteria->addSelectColumn(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.ballot_id');
            $criteria->addSelectColumn($alias . '.order_id');
            $criteria->addSelectColumn($alias . '.is_deleted');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.count');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.readmore');
            $criteria->addSelectColumn($alias . '.discussion');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.version_created_at');
            $criteria->addSelectColumn($alias . '.version_created_by');
            $criteria->addSelectColumn($alias . '.ballot_id_version');
            $criteria->addSelectColumn($alias . '.Candidate_ids');
            $criteria->addSelectColumn($alias . '.Candidate_versions');
            $criteria->addSelectColumn($alias . '.Vote_item_ids');
            $criteria->addSelectColumn($alias . '.Vote_item_versions');
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
        return Propel::getServiceContainer()->getDatabaseMap(QuestionVersionTableMap::DATABASE_NAME)->getTable(QuestionVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(QuestionVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(QuestionVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new QuestionVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a QuestionVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or QuestionVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MESBallotBox\Propel\QuestionVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(QuestionVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(QuestionVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(QuestionVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = QuestionVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            QuestionVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                QuestionVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the Question_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return QuestionVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a QuestionVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or QuestionVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from QuestionVersion object
        }


        // Set the correct dbName
        $query = QuestionVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // QuestionVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
QuestionVersionTableMap::buildTableMap();
