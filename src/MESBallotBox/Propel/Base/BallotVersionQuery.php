<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\BallotVersion as ChildBallotVersion;
use MESBallotBox\Propel\BallotVersionQuery as ChildBallotVersionQuery;
use MESBallotBox\Propel\Map\BallotVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Ballot_version' table.
 *
 *
 *
 * @method     ChildBallotVersionQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildBallotVersionQuery orderByuserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildBallotVersionQuery orderByname($order = Criteria::ASC) Order by the name column
 * @method     ChildBallotVersionQuery orderBystartTime($order = Criteria::ASC) Order by the start_time column
 * @method     ChildBallotVersionQuery orderByendTime($order = Criteria::ASC) Order by the end_time column
 * @method     ChildBallotVersionQuery orderBytimezone($order = Criteria::ASC) Order by the timezone column
 * @method     ChildBallotVersionQuery orderByversionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildBallotVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildBallotVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildBallotVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildBallotVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildBallotVersionQuery orderByVoterIds($order = Criteria::ASC) Order by the Voter_ids column
 * @method     ChildBallotVersionQuery orderByVoterVersions($order = Criteria::ASC) Order by the Voter_versions column
 * @method     ChildBallotVersionQuery orderByQuestionIds($order = Criteria::ASC) Order by the Question_ids column
 * @method     ChildBallotVersionQuery orderByQuestionVersions($order = Criteria::ASC) Order by the Question_versions column
 * @method     ChildBallotVersionQuery orderByVoteIds($order = Criteria::ASC) Order by the Vote_ids column
 * @method     ChildBallotVersionQuery orderByVoteVersions($order = Criteria::ASC) Order by the Vote_versions column
 *
 * @method     ChildBallotVersionQuery groupByid() Group by the id column
 * @method     ChildBallotVersionQuery groupByuserId() Group by the user_id column
 * @method     ChildBallotVersionQuery groupByname() Group by the name column
 * @method     ChildBallotVersionQuery groupBystartTime() Group by the start_time column
 * @method     ChildBallotVersionQuery groupByendTime() Group by the end_time column
 * @method     ChildBallotVersionQuery groupBytimezone() Group by the timezone column
 * @method     ChildBallotVersionQuery groupByversionCreatedBy() Group by the version_created_by column
 * @method     ChildBallotVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildBallotVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildBallotVersionQuery groupByVersion() Group by the version column
 * @method     ChildBallotVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildBallotVersionQuery groupByVoterIds() Group by the Voter_ids column
 * @method     ChildBallotVersionQuery groupByVoterVersions() Group by the Voter_versions column
 * @method     ChildBallotVersionQuery groupByQuestionIds() Group by the Question_ids column
 * @method     ChildBallotVersionQuery groupByQuestionVersions() Group by the Question_versions column
 * @method     ChildBallotVersionQuery groupByVoteIds() Group by the Vote_ids column
 * @method     ChildBallotVersionQuery groupByVoteVersions() Group by the Vote_versions column
 *
 * @method     ChildBallotVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBallotVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBallotVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBallotVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBallotVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBallotVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBallotVersionQuery leftJoinBallot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ballot relation
 * @method     ChildBallotVersionQuery rightJoinBallot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ballot relation
 * @method     ChildBallotVersionQuery innerJoinBallot($relationAlias = null) Adds a INNER JOIN clause to the query using the Ballot relation
 *
 * @method     ChildBallotVersionQuery joinWithBallot($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ballot relation
 *
 * @method     ChildBallotVersionQuery leftJoinWithBallot() Adds a LEFT JOIN clause and with to the query using the Ballot relation
 * @method     ChildBallotVersionQuery rightJoinWithBallot() Adds a RIGHT JOIN clause and with to the query using the Ballot relation
 * @method     ChildBallotVersionQuery innerJoinWithBallot() Adds a INNER JOIN clause and with to the query using the Ballot relation
 *
 * @method     \MESBallotBox\Propel\BallotQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBallotVersion findOne(ConnectionInterface $con = null) Return the first ChildBallotVersion matching the query
 * @method     ChildBallotVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBallotVersion matching the query, or a new ChildBallotVersion object populated from the query conditions when no match is found
 *
 * @method     ChildBallotVersion findOneByid(int $id) Return the first ChildBallotVersion filtered by the id column
 * @method     ChildBallotVersion findOneByuserId(int $user_id) Return the first ChildBallotVersion filtered by the user_id column
 * @method     ChildBallotVersion findOneByname(string $name) Return the first ChildBallotVersion filtered by the name column
 * @method     ChildBallotVersion findOneBystartTime(int $start_time) Return the first ChildBallotVersion filtered by the start_time column
 * @method     ChildBallotVersion findOneByendTime(int $end_time) Return the first ChildBallotVersion filtered by the end_time column
 * @method     ChildBallotVersion findOneBytimezone(int $timezone) Return the first ChildBallotVersion filtered by the timezone column
 * @method     ChildBallotVersion findOneByversionCreatedBy(int $version_created_by) Return the first ChildBallotVersion filtered by the version_created_by column
 * @method     ChildBallotVersion findOneByCreatedAt(string $created_at) Return the first ChildBallotVersion filtered by the created_at column
 * @method     ChildBallotVersion findOneByUpdatedAt(string $updated_at) Return the first ChildBallotVersion filtered by the updated_at column
 * @method     ChildBallotVersion findOneByVersion(int $version) Return the first ChildBallotVersion filtered by the version column
 * @method     ChildBallotVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildBallotVersion filtered by the version_created_at column
 * @method     ChildBallotVersion findOneByVoterIds(array $Voter_ids) Return the first ChildBallotVersion filtered by the Voter_ids column
 * @method     ChildBallotVersion findOneByVoterVersions(array $Voter_versions) Return the first ChildBallotVersion filtered by the Voter_versions column
 * @method     ChildBallotVersion findOneByQuestionIds(array $Question_ids) Return the first ChildBallotVersion filtered by the Question_ids column
 * @method     ChildBallotVersion findOneByQuestionVersions(array $Question_versions) Return the first ChildBallotVersion filtered by the Question_versions column
 * @method     ChildBallotVersion findOneByVoteIds(array $Vote_ids) Return the first ChildBallotVersion filtered by the Vote_ids column
 * @method     ChildBallotVersion findOneByVoteVersions(array $Vote_versions) Return the first ChildBallotVersion filtered by the Vote_versions column *

 * @method     ChildBallotVersion requirePk($key, ConnectionInterface $con = null) Return the ChildBallotVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOne(ConnectionInterface $con = null) Return the first ChildBallotVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBallotVersion requireOneByid(int $id) Return the first ChildBallotVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByuserId(int $user_id) Return the first ChildBallotVersion filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByname(string $name) Return the first ChildBallotVersion filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneBystartTime(int $start_time) Return the first ChildBallotVersion filtered by the start_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByendTime(int $end_time) Return the first ChildBallotVersion filtered by the end_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneBytimezone(int $timezone) Return the first ChildBallotVersion filtered by the timezone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByversionCreatedBy(int $version_created_by) Return the first ChildBallotVersion filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByCreatedAt(string $created_at) Return the first ChildBallotVersion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByUpdatedAt(string $updated_at) Return the first ChildBallotVersion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByVersion(int $version) Return the first ChildBallotVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildBallotVersion filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByVoterIds(array $Voter_ids) Return the first ChildBallotVersion filtered by the Voter_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByVoterVersions(array $Voter_versions) Return the first ChildBallotVersion filtered by the Voter_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByQuestionIds(array $Question_ids) Return the first ChildBallotVersion filtered by the Question_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByQuestionVersions(array $Question_versions) Return the first ChildBallotVersion filtered by the Question_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByVoteIds(array $Vote_ids) Return the first ChildBallotVersion filtered by the Vote_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotVersion requireOneByVoteVersions(array $Vote_versions) Return the first ChildBallotVersion filtered by the Vote_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBallotVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBallotVersion objects based on current ModelCriteria
 * @method     ChildBallotVersion[]|ObjectCollection findByid(int $id) Return ChildBallotVersion objects filtered by the id column
 * @method     ChildBallotVersion[]|ObjectCollection findByuserId(int $user_id) Return ChildBallotVersion objects filtered by the user_id column
 * @method     ChildBallotVersion[]|ObjectCollection findByname(string $name) Return ChildBallotVersion objects filtered by the name column
 * @method     ChildBallotVersion[]|ObjectCollection findBystartTime(int $start_time) Return ChildBallotVersion objects filtered by the start_time column
 * @method     ChildBallotVersion[]|ObjectCollection findByendTime(int $end_time) Return ChildBallotVersion objects filtered by the end_time column
 * @method     ChildBallotVersion[]|ObjectCollection findBytimezone(int $timezone) Return ChildBallotVersion objects filtered by the timezone column
 * @method     ChildBallotVersion[]|ObjectCollection findByversionCreatedBy(int $version_created_by) Return ChildBallotVersion objects filtered by the version_created_by column
 * @method     ChildBallotVersion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildBallotVersion objects filtered by the created_at column
 * @method     ChildBallotVersion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildBallotVersion objects filtered by the updated_at column
 * @method     ChildBallotVersion[]|ObjectCollection findByVersion(int $version) Return ChildBallotVersion objects filtered by the version column
 * @method     ChildBallotVersion[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildBallotVersion objects filtered by the version_created_at column
 * @method     ChildBallotVersion[]|ObjectCollection findByVoterIds(array $Voter_ids) Return ChildBallotVersion objects filtered by the Voter_ids column
 * @method     ChildBallotVersion[]|ObjectCollection findByVoterVersions(array $Voter_versions) Return ChildBallotVersion objects filtered by the Voter_versions column
 * @method     ChildBallotVersion[]|ObjectCollection findByQuestionIds(array $Question_ids) Return ChildBallotVersion objects filtered by the Question_ids column
 * @method     ChildBallotVersion[]|ObjectCollection findByQuestionVersions(array $Question_versions) Return ChildBallotVersion objects filtered by the Question_versions column
 * @method     ChildBallotVersion[]|ObjectCollection findByVoteIds(array $Vote_ids) Return ChildBallotVersion objects filtered by the Vote_ids column
 * @method     ChildBallotVersion[]|ObjectCollection findByVoteVersions(array $Vote_versions) Return ChildBallotVersion objects filtered by the Vote_versions column
 * @method     ChildBallotVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BallotVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\BallotVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\BallotVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBallotVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBallotVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBallotVersionQuery) {
            return $criteria;
        }
        $query = new ChildBallotVersionQuery();
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
     * @return ChildBallotVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BallotVersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BallotVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildBallotVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, name, start_time, end_time, timezone, version_created_by, created_at, updated_at, version, version_created_at, Voter_ids, Voter_versions, Question_ids, Question_versions, Vote_ids, Vote_versions FROM Ballot_version WHERE id = :p0 AND version = :p1';
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
            /** @var ChildBallotVersion $obj */
            $obj = new ChildBallotVersion();
            $obj->hydrate($row);
            BallotVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildBallotVersion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(BallotVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(BallotVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(BallotVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(BallotVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByBallot()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByuserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByname('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByname('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByname($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the start_time column
     *
     * Example usage:
     * <code>
     * $query->filterBystartTime(1234); // WHERE start_time = 1234
     * $query->filterBystartTime(array(12, 34)); // WHERE start_time IN (12, 34)
     * $query->filterBystartTime(array('min' => 12)); // WHERE start_time > 12
     * </code>
     *
     * @param     mixed $startTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterBystartTime($startTime = null, $comparison = null)
    {
        if (is_array($startTime)) {
            $useMinMax = false;
            if (isset($startTime['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_START_TIME, $startTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startTime['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_START_TIME, $startTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_START_TIME, $startTime, $comparison);
    }

    /**
     * Filter the query on the end_time column
     *
     * Example usage:
     * <code>
     * $query->filterByendTime(1234); // WHERE end_time = 1234
     * $query->filterByendTime(array(12, 34)); // WHERE end_time IN (12, 34)
     * $query->filterByendTime(array('min' => 12)); // WHERE end_time > 12
     * </code>
     *
     * @param     mixed $endTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByendTime($endTime = null, $comparison = null)
    {
        if (is_array($endTime)) {
            $useMinMax = false;
            if (isset($endTime['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_END_TIME, $endTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endTime['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_END_TIME, $endTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_END_TIME, $endTime, $comparison);
    }

    /**
     * Filter the query on the timezone column
     *
     * Example usage:
     * <code>
     * $query->filterBytimezone(1234); // WHERE timezone = 1234
     * $query->filterBytimezone(array(12, 34)); // WHERE timezone IN (12, 34)
     * $query->filterBytimezone(array('min' => 12)); // WHERE timezone > 12
     * </code>
     *
     * @param     mixed $timezone The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterBytimezone($timezone = null, $comparison = null)
    {
        if (is_array($timezone)) {
            $useMinMax = false;
            if (isset($timezone['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_TIMEZONE, $timezone['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timezone['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_TIMEZONE, $timezone['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_TIMEZONE, $timezone, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByversionCreatedBy(1234); // WHERE version_created_by = 1234
     * $query->filterByversionCreatedBy(array(12, 34)); // WHERE version_created_by IN (12, 34)
     * $query->filterByversionCreatedBy(array('min' => 12)); // WHERE version_created_by > 12
     * </code>
     *
     * @param     mixed $versionCreatedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByversionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (is_array($versionCreatedBy)) {
            $useMinMax = false;
            if (isset($versionCreatedBy['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedBy['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
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
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_VERSION, $version, $comparison);
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
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(BallotVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the Voter_ids column
     *
     * @param     array $voterIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoterIds($voterIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTER_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($voterIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($voterIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($voterIds as $value) {
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

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTER_IDS, $voterIds, $comparison);
    }

    /**
     * Filter the query on the Voter_ids column
     * @param     mixed $voterIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoterId($voterIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($voterIds)) {
                $voterIds = '%| ' . $voterIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $voterIds = '%| ' . $voterIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTER_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voterIds, $comparison);
            } else {
                $this->addAnd($key, $voterIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTER_IDS, $voterIds, $comparison);
    }

    /**
     * Filter the query on the Voter_versions column
     *
     * @param     array $voterVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoterVersions($voterVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTER_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($voterVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($voterVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($voterVersions as $value) {
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

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTER_VERSIONS, $voterVersions, $comparison);
    }

    /**
     * Filter the query on the Voter_versions column
     * @param     mixed $voterVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoterVersion($voterVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($voterVersions)) {
                $voterVersions = '%| ' . $voterVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $voterVersions = '%| ' . $voterVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTER_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voterVersions, $comparison);
            } else {
                $this->addAnd($key, $voterVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTER_VERSIONS, $voterVersions, $comparison);
    }

    /**
     * Filter the query on the Question_ids column
     *
     * @param     array $questionIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByQuestionIds($questionIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(BallotVersionTableMap::COL_QUESTION_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($questionIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($questionIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($questionIds as $value) {
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

        return $this->addUsingAlias(BallotVersionTableMap::COL_QUESTION_IDS, $questionIds, $comparison);
    }

    /**
     * Filter the query on the Question_ids column
     * @param     mixed $questionIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByQuestionId($questionIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($questionIds)) {
                $questionIds = '%| ' . $questionIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $questionIds = '%| ' . $questionIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(BallotVersionTableMap::COL_QUESTION_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $questionIds, $comparison);
            } else {
                $this->addAnd($key, $questionIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_QUESTION_IDS, $questionIds, $comparison);
    }

    /**
     * Filter the query on the Question_versions column
     *
     * @param     array $questionVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByQuestionVersions($questionVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(BallotVersionTableMap::COL_QUESTION_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($questionVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($questionVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($questionVersions as $value) {
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

        return $this->addUsingAlias(BallotVersionTableMap::COL_QUESTION_VERSIONS, $questionVersions, $comparison);
    }

    /**
     * Filter the query on the Question_versions column
     * @param     mixed $questionVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByQuestionVersion($questionVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($questionVersions)) {
                $questionVersions = '%| ' . $questionVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $questionVersions = '%| ' . $questionVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(BallotVersionTableMap::COL_QUESTION_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $questionVersions, $comparison);
            } else {
                $this->addAnd($key, $questionVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_QUESTION_VERSIONS, $questionVersions, $comparison);
    }

    /**
     * Filter the query on the Vote_ids column
     *
     * @param     array $voteIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoteIds($voteIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTE_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($voteIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($voteIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($voteIds as $value) {
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

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTE_IDS, $voteIds, $comparison);
    }

    /**
     * Filter the query on the Vote_ids column
     * @param     mixed $voteIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoteId($voteIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($voteIds)) {
                $voteIds = '%| ' . $voteIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $voteIds = '%| ' . $voteIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTE_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteIds, $comparison);
            } else {
                $this->addAnd($key, $voteIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTE_IDS, $voteIds, $comparison);
    }

    /**
     * Filter the query on the Vote_versions column
     *
     * @param     array $voteVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoteVersions($voteVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTE_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($voteVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($voteVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($voteVersions as $value) {
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

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTE_VERSIONS, $voteVersions, $comparison);
    }

    /**
     * Filter the query on the Vote_versions column
     * @param     mixed $voteVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByVoteVersion($voteVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($voteVersions)) {
                $voteVersions = '%| ' . $voteVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $voteVersions = '%| ' . $voteVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(BallotVersionTableMap::COL_VOTE_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteVersions, $comparison);
            } else {
                $this->addAnd($key, $voteVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(BallotVersionTableMap::COL_VOTE_VERSIONS, $voteVersions, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Ballot object
     *
     * @param \MESBallotBox\Propel\Ballot|ObjectCollection $ballot The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBallotVersionQuery The current query, for fluid interface
     */
    public function filterByBallot($ballot, $comparison = null)
    {
        if ($ballot instanceof \MESBallotBox\Propel\Ballot) {
            return $this
                ->addUsingAlias(BallotVersionTableMap::COL_ID, $ballot->getid(), $comparison);
        } elseif ($ballot instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BallotVersionTableMap::COL_ID, $ballot->toKeyValue('PrimaryKey', 'id'), $comparison);
        } else {
            throw new PropelException('filterByBallot() only accepts arguments of type \MESBallotBox\Propel\Ballot or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Ballot relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function joinBallot($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Ballot');

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
            $this->addJoinObject($join, 'Ballot');
        }

        return $this;
    }

    /**
     * Use the Ballot relation Ballot object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\BallotQuery A secondary query class using the current class as primary query
     */
    public function useBallotQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBallot($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Ballot', '\MESBallotBox\Propel\BallotQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBallotVersion $ballotVersion Object to remove from the list of results
     *
     * @return $this|ChildBallotVersionQuery The current query, for fluid interface
     */
    public function prune($ballotVersion = null)
    {
        if ($ballotVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(BallotVersionTableMap::COL_ID), $ballotVersion->getid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(BallotVersionTableMap::COL_VERSION), $ballotVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Ballot_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BallotVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BallotVersionTableMap::clearInstancePool();
            BallotVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BallotVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BallotVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BallotVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BallotVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BallotVersionQuery
