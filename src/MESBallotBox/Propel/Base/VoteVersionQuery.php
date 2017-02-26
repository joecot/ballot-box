<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\VoteVersion as ChildVoteVersion;
use MESBallotBox\Propel\VoteVersionQuery as ChildVoteVersionQuery;
use MESBallotBox\Propel\Map\VoteVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Vote_version' table.
 *
 *
 *
 * @method     ChildVoteVersionQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildVoteVersionQuery orderByballotId($order = Criteria::ASC) Order by the ballot_id column
 * @method     ChildVoteVersionQuery orderByuserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildVoteVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildVoteVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildVoteVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildVoteVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildVoteVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildVoteVersionQuery orderByBallotIdVersion($order = Criteria::ASC) Order by the ballot_id_version column
 * @method     ChildVoteVersionQuery orderByVoteItemIds($order = Criteria::ASC) Order by the Vote_item_ids column
 * @method     ChildVoteVersionQuery orderByVoteItemVersions($order = Criteria::ASC) Order by the Vote_item_versions column
 *
 * @method     ChildVoteVersionQuery groupByid() Group by the id column
 * @method     ChildVoteVersionQuery groupByballotId() Group by the ballot_id column
 * @method     ChildVoteVersionQuery groupByuserId() Group by the user_id column
 * @method     ChildVoteVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildVoteVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildVoteVersionQuery groupByVersion() Group by the version column
 * @method     ChildVoteVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildVoteVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildVoteVersionQuery groupByBallotIdVersion() Group by the ballot_id_version column
 * @method     ChildVoteVersionQuery groupByVoteItemIds() Group by the Vote_item_ids column
 * @method     ChildVoteVersionQuery groupByVoteItemVersions() Group by the Vote_item_versions column
 *
 * @method     ChildVoteVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoteVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoteVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoteVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVoteVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVoteVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVoteVersionQuery leftJoinVote($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vote relation
 * @method     ChildVoteVersionQuery rightJoinVote($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vote relation
 * @method     ChildVoteVersionQuery innerJoinVote($relationAlias = null) Adds a INNER JOIN clause to the query using the Vote relation
 *
 * @method     ChildVoteVersionQuery joinWithVote($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vote relation
 *
 * @method     ChildVoteVersionQuery leftJoinWithVote() Adds a LEFT JOIN clause and with to the query using the Vote relation
 * @method     ChildVoteVersionQuery rightJoinWithVote() Adds a RIGHT JOIN clause and with to the query using the Vote relation
 * @method     ChildVoteVersionQuery innerJoinWithVote() Adds a INNER JOIN clause and with to the query using the Vote relation
 *
 * @method     \MESBallotBox\Propel\VoteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoteVersion findOne(ConnectionInterface $con = null) Return the first ChildVoteVersion matching the query
 * @method     ChildVoteVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoteVersion matching the query, or a new ChildVoteVersion object populated from the query conditions when no match is found
 *
 * @method     ChildVoteVersion findOneByid(int $id) Return the first ChildVoteVersion filtered by the id column
 * @method     ChildVoteVersion findOneByballotId(int $ballot_id) Return the first ChildVoteVersion filtered by the ballot_id column
 * @method     ChildVoteVersion findOneByuserId(int $user_id) Return the first ChildVoteVersion filtered by the user_id column
 * @method     ChildVoteVersion findOneByCreatedAt(string $created_at) Return the first ChildVoteVersion filtered by the created_at column
 * @method     ChildVoteVersion findOneByUpdatedAt(string $updated_at) Return the first ChildVoteVersion filtered by the updated_at column
 * @method     ChildVoteVersion findOneByVersion(int $version) Return the first ChildVoteVersion filtered by the version column
 * @method     ChildVoteVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildVoteVersion filtered by the version_created_at column
 * @method     ChildVoteVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildVoteVersion filtered by the version_created_by column
 * @method     ChildVoteVersion findOneByBallotIdVersion(int $ballot_id_version) Return the first ChildVoteVersion filtered by the ballot_id_version column
 * @method     ChildVoteVersion findOneByVoteItemIds(array $Vote_item_ids) Return the first ChildVoteVersion filtered by the Vote_item_ids column
 * @method     ChildVoteVersion findOneByVoteItemVersions(array $Vote_item_versions) Return the first ChildVoteVersion filtered by the Vote_item_versions column *

 * @method     ChildVoteVersion requirePk($key, ConnectionInterface $con = null) Return the ChildVoteVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOne(ConnectionInterface $con = null) Return the first ChildVoteVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteVersion requireOneByid(int $id) Return the first ChildVoteVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByballotId(int $ballot_id) Return the first ChildVoteVersion filtered by the ballot_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByuserId(int $user_id) Return the first ChildVoteVersion filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByCreatedAt(string $created_at) Return the first ChildVoteVersion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByUpdatedAt(string $updated_at) Return the first ChildVoteVersion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByVersion(int $version) Return the first ChildVoteVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildVoteVersion filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByVersionCreatedBy(string $version_created_by) Return the first ChildVoteVersion filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByBallotIdVersion(int $ballot_id_version) Return the first ChildVoteVersion filtered by the ballot_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByVoteItemIds(array $Vote_item_ids) Return the first ChildVoteVersion filtered by the Vote_item_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteVersion requireOneByVoteItemVersions(array $Vote_item_versions) Return the first ChildVoteVersion filtered by the Vote_item_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoteVersion objects based on current ModelCriteria
 * @method     ChildVoteVersion[]|ObjectCollection findByid(int $id) Return ChildVoteVersion objects filtered by the id column
 * @method     ChildVoteVersion[]|ObjectCollection findByballotId(int $ballot_id) Return ChildVoteVersion objects filtered by the ballot_id column
 * @method     ChildVoteVersion[]|ObjectCollection findByuserId(int $user_id) Return ChildVoteVersion objects filtered by the user_id column
 * @method     ChildVoteVersion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildVoteVersion objects filtered by the created_at column
 * @method     ChildVoteVersion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildVoteVersion objects filtered by the updated_at column
 * @method     ChildVoteVersion[]|ObjectCollection findByVersion(int $version) Return ChildVoteVersion objects filtered by the version column
 * @method     ChildVoteVersion[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildVoteVersion objects filtered by the version_created_at column
 * @method     ChildVoteVersion[]|ObjectCollection findByVersionCreatedBy(string $version_created_by) Return ChildVoteVersion objects filtered by the version_created_by column
 * @method     ChildVoteVersion[]|ObjectCollection findByBallotIdVersion(int $ballot_id_version) Return ChildVoteVersion objects filtered by the ballot_id_version column
 * @method     ChildVoteVersion[]|ObjectCollection findByVoteItemIds(array $Vote_item_ids) Return ChildVoteVersion objects filtered by the Vote_item_ids column
 * @method     ChildVoteVersion[]|ObjectCollection findByVoteItemVersions(array $Vote_item_versions) Return ChildVoteVersion objects filtered by the Vote_item_versions column
 * @method     ChildVoteVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoteVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\VoteVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\VoteVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoteVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoteVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoteVersionQuery) {
            return $criteria;
        }
        $query = new ChildVoteVersionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildVoteVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoteVersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VoteVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, ballot_id, user_id, created_at, updated_at, version, version_created_at, version_created_by, ballot_id_version, Vote_item_ids, Vote_item_versions FROM Vote_version WHERE id = :p0 AND version = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildVoteVersion $obj */
            $obj = new ChildVoteVersion();
            $obj->hydrate($row);
            VoteVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildVoteVersion|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(VoteVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(VoteVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(VoteVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(VoteVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterByid(1234); // WHERE id = 1234
     * $query->filterByid(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterByid(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @see       filterByVote()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the ballot_id column
     *
     * Example usage:
     * <code>
     * $query->filterByballotId(1234); // WHERE ballot_id = 1234
     * $query->filterByballotId(array(12, 34)); // WHERE ballot_id IN (12, 34)
     * $query->filterByballotId(array('min' => 12)); // WHERE ballot_id > 12
     * </code>
     *
     * @param     mixed $ballotId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByballotId($ballotId = null, $comparison = null)
    {
        if (is_array($ballotId)) {
            $useMinMax = false;
            if (isset($ballotId['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_BALLOT_ID, $ballotId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ballotId['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_BALLOT_ID, $ballotId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_BALLOT_ID, $ballotId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByuserId(1234); // WHERE user_id = 1234
     * $query->filterByuserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByuserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByuserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%', Criteria::LIKE); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the ballot_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByBallotIdVersion(1234); // WHERE ballot_id_version = 1234
     * $query->filterByBallotIdVersion(array(12, 34)); // WHERE ballot_id_version IN (12, 34)
     * $query->filterByBallotIdVersion(array('min' => 12)); // WHERE ballot_id_version > 12
     * </code>
     *
     * @param     mixed $ballotIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByBallotIdVersion($ballotIdVersion = null, $comparison = null)
    {
        if (is_array($ballotIdVersion)) {
            $useMinMax = false;
            if (isset($ballotIdVersion['min'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_BALLOT_ID_VERSION, $ballotIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ballotIdVersion['max'])) {
                $this->addUsingAlias(VoteVersionTableMap::COL_BALLOT_ID_VERSION, $ballotIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_BALLOT_ID_VERSION, $ballotIdVersion, $comparison);
    }

    /**
     * Filter the query on the Vote_item_ids column
     *
     * @param     array $voteItemIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemIds($voteItemIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(VoteVersionTableMap::COL_VOTE_ITEM_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($voteItemIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($voteItemIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($voteItemIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_VOTE_ITEM_IDS, $voteItemIds, $comparison);
    }

    /**
     * Filter the query on the Vote_item_ids column
     * @param     mixed $voteItemIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemId($voteItemIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($voteItemIds)) {
                $voteItemIds = '%| ' . $voteItemIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $voteItemIds = '%| ' . $voteItemIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(VoteVersionTableMap::COL_VOTE_ITEM_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteItemIds, $comparison);
            } else {
                $this->addAnd($key, $voteItemIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_VOTE_ITEM_IDS, $voteItemIds, $comparison);
    }

    /**
     * Filter the query on the Vote_item_versions column
     *
     * @param     array $voteItemVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemVersions($voteItemVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(VoteVersionTableMap::COL_VOTE_ITEM_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($voteItemVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($voteItemVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($voteItemVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_VOTE_ITEM_VERSIONS, $voteItemVersions, $comparison);
    }

    /**
     * Filter the query on the Vote_item_versions column
     * @param     mixed $voteItemVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemVersion($voteItemVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($voteItemVersions)) {
                $voteItemVersions = '%| ' . $voteItemVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $voteItemVersions = '%| ' . $voteItemVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(VoteVersionTableMap::COL_VOTE_ITEM_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteItemVersions, $comparison);
            } else {
                $this->addAnd($key, $voteItemVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(VoteVersionTableMap::COL_VOTE_ITEM_VERSIONS, $voteItemVersions, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Vote object
     *
     * @param \MESBallotBox\Propel\Vote|ObjectCollection $vote The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteVersionQuery The current query, for fluid interface
     */
    public function filterByVote($vote, $comparison = null)
    {
        if ($vote instanceof \MESBallotBox\Propel\Vote) {
            return $this
                ->addUsingAlias(VoteVersionTableMap::COL_ID, $vote->getid(), $comparison);
        } elseif ($vote instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoteVersionTableMap::COL_ID, $vote->toKeyValue('PrimaryKey', 'id'), $comparison);
        } else {
            throw new PropelException('filterByVote() only accepts arguments of type \MESBallotBox\Propel\Vote or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Vote relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function joinVote($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Vote');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Vote');
        }

        return $this;
    }

    /**
     * Use the Vote relation Vote object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\VoteQuery A secondary query class using the current class as primary query
     */
    public function useVoteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVote($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Vote', '\MESBallotBox\Propel\VoteQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVoteVersion $voteVersion Object to remove from the list of results
     *
     * @return $this|ChildVoteVersionQuery The current query, for fluid interface
     */
    public function prune($voteVersion = null)
    {
        if ($voteVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(VoteVersionTableMap::COL_ID), $voteVersion->getid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(VoteVersionTableMap::COL_VERSION), $voteVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Vote_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoteVersionTableMap::clearInstancePool();
            VoteVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoteVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoteVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoteVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VoteVersionQuery
