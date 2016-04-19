<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\QuestionVersion as ChildQuestionVersion;
use MESBallotBox\Propel\QuestionVersionQuery as ChildQuestionVersionQuery;
use MESBallotBox\Propel\Map\QuestionVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Question_version' table.
 *
 *
 *
 * @method     ChildQuestionVersionQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildQuestionVersionQuery orderByballotId($order = Criteria::ASC) Order by the ballot_id column
 * @method     ChildQuestionVersionQuery orderByorderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildQuestionVersionQuery orderByisDeleted($order = Criteria::ASC) Order by the is_deleted column
 * @method     ChildQuestionVersionQuery orderBytype($order = Criteria::ASC) Order by the type column
 * @method     ChildQuestionVersionQuery orderBycount($order = Criteria::ASC) Order by the count column
 * @method     ChildQuestionVersionQuery orderByname($order = Criteria::ASC) Order by the name column
 * @method     ChildQuestionVersionQuery orderBydescription($order = Criteria::ASC) Order by the description column
 * @method     ChildQuestionVersionQuery orderByreadmore($order = Criteria::ASC) Order by the readmore column
 * @method     ChildQuestionVersionQuery orderBydiscussion($order = Criteria::ASC) Order by the discussion column
 * @method     ChildQuestionVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildQuestionVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildQuestionVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildQuestionVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildQuestionVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildQuestionVersionQuery orderByBallotIdVersion($order = Criteria::ASC) Order by the ballot_id_version column
 * @method     ChildQuestionVersionQuery orderByCandidateIds($order = Criteria::ASC) Order by the Candidate_ids column
 * @method     ChildQuestionVersionQuery orderByCandidateVersions($order = Criteria::ASC) Order by the Candidate_versions column
 * @method     ChildQuestionVersionQuery orderByVoteItemIds($order = Criteria::ASC) Order by the Vote_item_ids column
 * @method     ChildQuestionVersionQuery orderByVoteItemVersions($order = Criteria::ASC) Order by the Vote_item_versions column
 *
 * @method     ChildQuestionVersionQuery groupByid() Group by the id column
 * @method     ChildQuestionVersionQuery groupByballotId() Group by the ballot_id column
 * @method     ChildQuestionVersionQuery groupByorderId() Group by the order_id column
 * @method     ChildQuestionVersionQuery groupByisDeleted() Group by the is_deleted column
 * @method     ChildQuestionVersionQuery groupBytype() Group by the type column
 * @method     ChildQuestionVersionQuery groupBycount() Group by the count column
 * @method     ChildQuestionVersionQuery groupByname() Group by the name column
 * @method     ChildQuestionVersionQuery groupBydescription() Group by the description column
 * @method     ChildQuestionVersionQuery groupByreadmore() Group by the readmore column
 * @method     ChildQuestionVersionQuery groupBydiscussion() Group by the discussion column
 * @method     ChildQuestionVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildQuestionVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildQuestionVersionQuery groupByVersion() Group by the version column
 * @method     ChildQuestionVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildQuestionVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildQuestionVersionQuery groupByBallotIdVersion() Group by the ballot_id_version column
 * @method     ChildQuestionVersionQuery groupByCandidateIds() Group by the Candidate_ids column
 * @method     ChildQuestionVersionQuery groupByCandidateVersions() Group by the Candidate_versions column
 * @method     ChildQuestionVersionQuery groupByVoteItemIds() Group by the Vote_item_ids column
 * @method     ChildQuestionVersionQuery groupByVoteItemVersions() Group by the Vote_item_versions column
 *
 * @method     ChildQuestionVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildQuestionVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildQuestionVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildQuestionVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildQuestionVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildQuestionVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildQuestionVersionQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method     ChildQuestionVersionQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method     ChildQuestionVersionQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method     ChildQuestionVersionQuery joinWithQuestion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Question relation
 *
 * @method     ChildQuestionVersionQuery leftJoinWithQuestion() Adds a LEFT JOIN clause and with to the query using the Question relation
 * @method     ChildQuestionVersionQuery rightJoinWithQuestion() Adds a RIGHT JOIN clause and with to the query using the Question relation
 * @method     ChildQuestionVersionQuery innerJoinWithQuestion() Adds a INNER JOIN clause and with to the query using the Question relation
 *
 * @method     \MESBallotBox\Propel\QuestionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildQuestionVersion findOne(ConnectionInterface $con = null) Return the first ChildQuestionVersion matching the query
 * @method     ChildQuestionVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildQuestionVersion matching the query, or a new ChildQuestionVersion object populated from the query conditions when no match is found
 *
 * @method     ChildQuestionVersion findOneByid(int $id) Return the first ChildQuestionVersion filtered by the id column
 * @method     ChildQuestionVersion findOneByballotId(int $ballot_id) Return the first ChildQuestionVersion filtered by the ballot_id column
 * @method     ChildQuestionVersion findOneByorderId(int $order_id) Return the first ChildQuestionVersion filtered by the order_id column
 * @method     ChildQuestionVersion findOneByisDeleted(int $is_deleted) Return the first ChildQuestionVersion filtered by the is_deleted column
 * @method     ChildQuestionVersion findOneBytype(int $type) Return the first ChildQuestionVersion filtered by the type column
 * @method     ChildQuestionVersion findOneBycount(int $count) Return the first ChildQuestionVersion filtered by the count column
 * @method     ChildQuestionVersion findOneByname(string $name) Return the first ChildQuestionVersion filtered by the name column
 * @method     ChildQuestionVersion findOneBydescription(string $description) Return the first ChildQuestionVersion filtered by the description column
 * @method     ChildQuestionVersion findOneByreadmore(string $readmore) Return the first ChildQuestionVersion filtered by the readmore column
 * @method     ChildQuestionVersion findOneBydiscussion(string $discussion) Return the first ChildQuestionVersion filtered by the discussion column
 * @method     ChildQuestionVersion findOneByCreatedAt(string $created_at) Return the first ChildQuestionVersion filtered by the created_at column
 * @method     ChildQuestionVersion findOneByUpdatedAt(string $updated_at) Return the first ChildQuestionVersion filtered by the updated_at column
 * @method     ChildQuestionVersion findOneByVersion(int $version) Return the first ChildQuestionVersion filtered by the version column
 * @method     ChildQuestionVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildQuestionVersion filtered by the version_created_at column
 * @method     ChildQuestionVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildQuestionVersion filtered by the version_created_by column
 * @method     ChildQuestionVersion findOneByBallotIdVersion(int $ballot_id_version) Return the first ChildQuestionVersion filtered by the ballot_id_version column
 * @method     ChildQuestionVersion findOneByCandidateIds(array $Candidate_ids) Return the first ChildQuestionVersion filtered by the Candidate_ids column
 * @method     ChildQuestionVersion findOneByCandidateVersions(array $Candidate_versions) Return the first ChildQuestionVersion filtered by the Candidate_versions column
 * @method     ChildQuestionVersion findOneByVoteItemIds(array $Vote_item_ids) Return the first ChildQuestionVersion filtered by the Vote_item_ids column
 * @method     ChildQuestionVersion findOneByVoteItemVersions(array $Vote_item_versions) Return the first ChildQuestionVersion filtered by the Vote_item_versions column *

 * @method     ChildQuestionVersion requirePk($key, ConnectionInterface $con = null) Return the ChildQuestionVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOne(ConnectionInterface $con = null) Return the first ChildQuestionVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildQuestionVersion requireOneByid(int $id) Return the first ChildQuestionVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByballotId(int $ballot_id) Return the first ChildQuestionVersion filtered by the ballot_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByorderId(int $order_id) Return the first ChildQuestionVersion filtered by the order_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByisDeleted(int $is_deleted) Return the first ChildQuestionVersion filtered by the is_deleted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneBytype(int $type) Return the first ChildQuestionVersion filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneBycount(int $count) Return the first ChildQuestionVersion filtered by the count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByname(string $name) Return the first ChildQuestionVersion filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneBydescription(string $description) Return the first ChildQuestionVersion filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByreadmore(string $readmore) Return the first ChildQuestionVersion filtered by the readmore column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneBydiscussion(string $discussion) Return the first ChildQuestionVersion filtered by the discussion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByCreatedAt(string $created_at) Return the first ChildQuestionVersion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByUpdatedAt(string $updated_at) Return the first ChildQuestionVersion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByVersion(int $version) Return the first ChildQuestionVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildQuestionVersion filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByVersionCreatedBy(string $version_created_by) Return the first ChildQuestionVersion filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByBallotIdVersion(int $ballot_id_version) Return the first ChildQuestionVersion filtered by the ballot_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByCandidateIds(array $Candidate_ids) Return the first ChildQuestionVersion filtered by the Candidate_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByCandidateVersions(array $Candidate_versions) Return the first ChildQuestionVersion filtered by the Candidate_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByVoteItemIds(array $Vote_item_ids) Return the first ChildQuestionVersion filtered by the Vote_item_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestionVersion requireOneByVoteItemVersions(array $Vote_item_versions) Return the first ChildQuestionVersion filtered by the Vote_item_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildQuestionVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildQuestionVersion objects based on current ModelCriteria
 * @method     ChildQuestionVersion[]|ObjectCollection findByid(int $id) Return ChildQuestionVersion objects filtered by the id column
 * @method     ChildQuestionVersion[]|ObjectCollection findByballotId(int $ballot_id) Return ChildQuestionVersion objects filtered by the ballot_id column
 * @method     ChildQuestionVersion[]|ObjectCollection findByorderId(int $order_id) Return ChildQuestionVersion objects filtered by the order_id column
 * @method     ChildQuestionVersion[]|ObjectCollection findByisDeleted(int $is_deleted) Return ChildQuestionVersion objects filtered by the is_deleted column
 * @method     ChildQuestionVersion[]|ObjectCollection findBytype(int $type) Return ChildQuestionVersion objects filtered by the type column
 * @method     ChildQuestionVersion[]|ObjectCollection findBycount(int $count) Return ChildQuestionVersion objects filtered by the count column
 * @method     ChildQuestionVersion[]|ObjectCollection findByname(string $name) Return ChildQuestionVersion objects filtered by the name column
 * @method     ChildQuestionVersion[]|ObjectCollection findBydescription(string $description) Return ChildQuestionVersion objects filtered by the description column
 * @method     ChildQuestionVersion[]|ObjectCollection findByreadmore(string $readmore) Return ChildQuestionVersion objects filtered by the readmore column
 * @method     ChildQuestionVersion[]|ObjectCollection findBydiscussion(string $discussion) Return ChildQuestionVersion objects filtered by the discussion column
 * @method     ChildQuestionVersion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildQuestionVersion objects filtered by the created_at column
 * @method     ChildQuestionVersion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildQuestionVersion objects filtered by the updated_at column
 * @method     ChildQuestionVersion[]|ObjectCollection findByVersion(int $version) Return ChildQuestionVersion objects filtered by the version column
 * @method     ChildQuestionVersion[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildQuestionVersion objects filtered by the version_created_at column
 * @method     ChildQuestionVersion[]|ObjectCollection findByVersionCreatedBy(string $version_created_by) Return ChildQuestionVersion objects filtered by the version_created_by column
 * @method     ChildQuestionVersion[]|ObjectCollection findByBallotIdVersion(int $ballot_id_version) Return ChildQuestionVersion objects filtered by the ballot_id_version column
 * @method     ChildQuestionVersion[]|ObjectCollection findByCandidateIds(array $Candidate_ids) Return ChildQuestionVersion objects filtered by the Candidate_ids column
 * @method     ChildQuestionVersion[]|ObjectCollection findByCandidateVersions(array $Candidate_versions) Return ChildQuestionVersion objects filtered by the Candidate_versions column
 * @method     ChildQuestionVersion[]|ObjectCollection findByVoteItemIds(array $Vote_item_ids) Return ChildQuestionVersion objects filtered by the Vote_item_ids column
 * @method     ChildQuestionVersion[]|ObjectCollection findByVoteItemVersions(array $Vote_item_versions) Return ChildQuestionVersion objects filtered by the Vote_item_versions column
 * @method     ChildQuestionVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class QuestionVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\QuestionVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\QuestionVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildQuestionVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildQuestionVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildQuestionVersionQuery) {
            return $criteria;
        }
        $query = new ChildQuestionVersionQuery();
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
     * @return ChildQuestionVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = QuestionVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildQuestionVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, ballot_id, order_id, is_deleted, type, count, name, description, readmore, discussion, created_at, updated_at, version, version_created_at, version_created_by, ballot_id_version, Candidate_ids, Candidate_versions, Vote_item_ids, Vote_item_versions FROM Question_version WHERE id = :p0 AND version = :p1';
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
            /** @var ChildQuestionVersion $obj */
            $obj = new ChildQuestionVersion();
            $obj->hydrate($row);
            QuestionVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildQuestionVersion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(QuestionVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(QuestionVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(QuestionVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByQuestion()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByballotId($ballotId = null, $comparison = null)
    {
        if (is_array($ballotId)) {
            $useMinMax = false;
            if (isset($ballotId['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_BALLOT_ID, $ballotId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ballotId['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_BALLOT_ID, $ballotId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_BALLOT_ID, $ballotId, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByorderId(1234); // WHERE order_id = 1234
     * $query->filterByorderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByorderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByorderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the is_deleted column
     *
     * Example usage:
     * <code>
     * $query->filterByisDeleted(1234); // WHERE is_deleted = 1234
     * $query->filterByisDeleted(array(12, 34)); // WHERE is_deleted IN (12, 34)
     * $query->filterByisDeleted(array('min' => 12)); // WHERE is_deleted > 12
     * </code>
     *
     * @param     mixed $isDeleted The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByisDeleted($isDeleted = null, $comparison = null)
    {
        if (is_array($isDeleted)) {
            $useMinMax = false;
            if (isset($isDeleted['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_IS_DELETED, $isDeleted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isDeleted['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_IS_DELETED, $isDeleted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_IS_DELETED, $isDeleted, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterBytype($type = null, $comparison = null)
    {
        $valueSet = QuestionVersionTableMap::getValueSet(QuestionVersionTableMap::COL_TYPE);
        if (is_scalar($type)) {
            if (!in_array($type, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $type));
            }
            $type = array_search($type, $valueSet);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the count column
     *
     * Example usage:
     * <code>
     * $query->filterBycount(1234); // WHERE count = 1234
     * $query->filterBycount(array(12, 34)); // WHERE count IN (12, 34)
     * $query->filterBycount(array('min' => 12)); // WHERE count > 12
     * </code>
     *
     * @param     mixed $count The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterBycount($count = null, $comparison = null)
    {
        if (is_array($count)) {
            $useMinMax = false;
            if (isset($count['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_COUNT, $count['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($count['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_COUNT, $count['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_COUNT, $count, $comparison);
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(QuestionVersionTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterBydescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterBydescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterBydescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the readmore column
     *
     * Example usage:
     * <code>
     * $query->filterByreadmore('fooValue');   // WHERE readmore = 'fooValue'
     * $query->filterByreadmore('%fooValue%'); // WHERE readmore LIKE '%fooValue%'
     * </code>
     *
     * @param     string $readmore The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByreadmore($readmore = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($readmore)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $readmore)) {
                $readmore = str_replace('*', '%', $readmore);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_READMORE, $readmore, $comparison);
    }

    /**
     * Filter the query on the discussion column
     *
     * Example usage:
     * <code>
     * $query->filterBydiscussion('fooValue');   // WHERE discussion = 'fooValue'
     * $query->filterBydiscussion('%fooValue%'); // WHERE discussion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $discussion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterBydiscussion($discussion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discussion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $discussion)) {
                $discussion = str_replace('*', '%', $discussion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_DISCUSSION, $discussion, $comparison);
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION, $version, $comparison);
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
                $versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
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
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByBallotIdVersion($ballotIdVersion = null, $comparison = null)
    {
        if (is_array($ballotIdVersion)) {
            $useMinMax = false;
            if (isset($ballotIdVersion['min'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_BALLOT_ID_VERSION, $ballotIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ballotIdVersion['max'])) {
                $this->addUsingAlias(QuestionVersionTableMap::COL_BALLOT_ID_VERSION, $ballotIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_BALLOT_ID_VERSION, $ballotIdVersion, $comparison);
    }

    /**
     * Filter the query on the Candidate_ids column
     *
     * @param     array $candidateIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByCandidateIds($candidateIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(QuestionVersionTableMap::COL_CANDIDATE_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($candidateIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($candidateIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($candidateIds as $value) {
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

        return $this->addUsingAlias(QuestionVersionTableMap::COL_CANDIDATE_IDS, $candidateIds, $comparison);
    }

    /**
     * Filter the query on the Candidate_ids column
     * @param     mixed $candidateIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByCandidateId($candidateIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($candidateIds)) {
                $candidateIds = '%| ' . $candidateIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $candidateIds = '%| ' . $candidateIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(QuestionVersionTableMap::COL_CANDIDATE_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $candidateIds, $comparison);
            } else {
                $this->addAnd($key, $candidateIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_CANDIDATE_IDS, $candidateIds, $comparison);
    }

    /**
     * Filter the query on the Candidate_versions column
     *
     * @param     array $candidateVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByCandidateVersions($candidateVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($candidateVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($candidateVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($candidateVersions as $value) {
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

        return $this->addUsingAlias(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS, $candidateVersions, $comparison);
    }

    /**
     * Filter the query on the Candidate_versions column
     * @param     mixed $candidateVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByCandidateVersion($candidateVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($candidateVersions)) {
                $candidateVersions = '%| ' . $candidateVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $candidateVersions = '%| ' . $candidateVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $candidateVersions, $comparison);
            } else {
                $this->addAnd($key, $candidateVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_CANDIDATE_VERSIONS, $candidateVersions, $comparison);
    }

    /**
     * Filter the query on the Vote_item_ids column
     *
     * @param     array $voteItemIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemIds($voteItemIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(QuestionVersionTableMap::COL_VOTE_ITEM_IDS);
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

        return $this->addUsingAlias(QuestionVersionTableMap::COL_VOTE_ITEM_IDS, $voteItemIds, $comparison);
    }

    /**
     * Filter the query on the Vote_item_ids column
     * @param     mixed $voteItemIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
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
            $key = $this->getAliasedColName(QuestionVersionTableMap::COL_VOTE_ITEM_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteItemIds, $comparison);
            } else {
                $this->addAnd($key, $voteItemIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_VOTE_ITEM_IDS, $voteItemIds, $comparison);
    }

    /**
     * Filter the query on the Vote_item_versions column
     *
     * @param     array $voteItemVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemVersions($voteItemVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS);
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

        return $this->addUsingAlias(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS, $voteItemVersions, $comparison);
    }

    /**
     * Filter the query on the Vote_item_versions column
     * @param     mixed $voteItemVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
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
            $key = $this->getAliasedColName(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteItemVersions, $comparison);
            } else {
                $this->addAnd($key, $voteItemVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(QuestionVersionTableMap::COL_VOTE_ITEM_VERSIONS, $voteItemVersions, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Question object
     *
     * @param \MESBallotBox\Propel\Question|ObjectCollection $question The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function filterByQuestion($question, $comparison = null)
    {
        if ($question instanceof \MESBallotBox\Propel\Question) {
            return $this
                ->addUsingAlias(QuestionVersionTableMap::COL_ID, $question->getid(), $comparison);
        } elseif ($question instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuestionVersionTableMap::COL_ID, $question->toKeyValue('PrimaryKey', 'id'), $comparison);
        } else {
            throw new PropelException('filterByQuestion() only accepts arguments of type \MESBallotBox\Propel\Question or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Question relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function joinQuestion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Question');

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
            $this->addJoinObject($join, 'Question');
        }

        return $this;
    }

    /**
     * Use the Question relation Question object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\QuestionQuery A secondary query class using the current class as primary query
     */
    public function useQuestionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuestion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Question', '\MESBallotBox\Propel\QuestionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildQuestionVersion $questionVersion Object to remove from the list of results
     *
     * @return $this|ChildQuestionVersionQuery The current query, for fluid interface
     */
    public function prune($questionVersion = null)
    {
        if ($questionVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(QuestionVersionTableMap::COL_ID), $questionVersion->getid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(QuestionVersionTableMap::COL_VERSION), $questionVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Question_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            QuestionVersionTableMap::clearInstancePool();
            QuestionVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(QuestionVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            QuestionVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            QuestionVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // QuestionVersionQuery
