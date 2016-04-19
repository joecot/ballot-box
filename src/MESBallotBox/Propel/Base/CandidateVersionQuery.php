<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\CandidateVersion as ChildCandidateVersion;
use MESBallotBox\Propel\CandidateVersionQuery as ChildCandidateVersionQuery;
use MESBallotBox\Propel\Map\CandidateVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Candidate_version' table.
 *
 *
 *
 * @method     ChildCandidateVersionQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildCandidateVersionQuery orderByquestionId($order = Criteria::ASC) Order by the question_id column
 * @method     ChildCandidateVersionQuery orderByisDeleted($order = Criteria::ASC) Order by the is_deleted column
 * @method     ChildCandidateVersionQuery orderByuserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildCandidateVersionQuery orderByapplication($order = Criteria::ASC) Order by the application column
 * @method     ChildCandidateVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCandidateVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildCandidateVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildCandidateVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildCandidateVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildCandidateVersionQuery orderByQuestionIdVersion($order = Criteria::ASC) Order by the question_id_version column
 * @method     ChildCandidateVersionQuery orderByVoteItemIds($order = Criteria::ASC) Order by the Vote_item_ids column
 * @method     ChildCandidateVersionQuery orderByVoteItemVersions($order = Criteria::ASC) Order by the Vote_item_versions column
 *
 * @method     ChildCandidateVersionQuery groupByid() Group by the id column
 * @method     ChildCandidateVersionQuery groupByquestionId() Group by the question_id column
 * @method     ChildCandidateVersionQuery groupByisDeleted() Group by the is_deleted column
 * @method     ChildCandidateVersionQuery groupByuserId() Group by the user_id column
 * @method     ChildCandidateVersionQuery groupByapplication() Group by the application column
 * @method     ChildCandidateVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCandidateVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildCandidateVersionQuery groupByVersion() Group by the version column
 * @method     ChildCandidateVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildCandidateVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildCandidateVersionQuery groupByQuestionIdVersion() Group by the question_id_version column
 * @method     ChildCandidateVersionQuery groupByVoteItemIds() Group by the Vote_item_ids column
 * @method     ChildCandidateVersionQuery groupByVoteItemVersions() Group by the Vote_item_versions column
 *
 * @method     ChildCandidateVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCandidateVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCandidateVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCandidateVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCandidateVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCandidateVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCandidateVersionQuery leftJoinCandidate($relationAlias = null) Adds a LEFT JOIN clause to the query using the Candidate relation
 * @method     ChildCandidateVersionQuery rightJoinCandidate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Candidate relation
 * @method     ChildCandidateVersionQuery innerJoinCandidate($relationAlias = null) Adds a INNER JOIN clause to the query using the Candidate relation
 *
 * @method     ChildCandidateVersionQuery joinWithCandidate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Candidate relation
 *
 * @method     ChildCandidateVersionQuery leftJoinWithCandidate() Adds a LEFT JOIN clause and with to the query using the Candidate relation
 * @method     ChildCandidateVersionQuery rightJoinWithCandidate() Adds a RIGHT JOIN clause and with to the query using the Candidate relation
 * @method     ChildCandidateVersionQuery innerJoinWithCandidate() Adds a INNER JOIN clause and with to the query using the Candidate relation
 *
 * @method     \MESBallotBox\Propel\CandidateQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCandidateVersion findOne(ConnectionInterface $con = null) Return the first ChildCandidateVersion matching the query
 * @method     ChildCandidateVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCandidateVersion matching the query, or a new ChildCandidateVersion object populated from the query conditions when no match is found
 *
 * @method     ChildCandidateVersion findOneByid(int $id) Return the first ChildCandidateVersion filtered by the id column
 * @method     ChildCandidateVersion findOneByquestionId(int $question_id) Return the first ChildCandidateVersion filtered by the question_id column
 * @method     ChildCandidateVersion findOneByisDeleted(int $is_deleted) Return the first ChildCandidateVersion filtered by the is_deleted column
 * @method     ChildCandidateVersion findOneByuserId(int $user_id) Return the first ChildCandidateVersion filtered by the user_id column
 * @method     ChildCandidateVersion findOneByapplication(string $application) Return the first ChildCandidateVersion filtered by the application column
 * @method     ChildCandidateVersion findOneByCreatedAt(string $created_at) Return the first ChildCandidateVersion filtered by the created_at column
 * @method     ChildCandidateVersion findOneByUpdatedAt(string $updated_at) Return the first ChildCandidateVersion filtered by the updated_at column
 * @method     ChildCandidateVersion findOneByVersion(int $version) Return the first ChildCandidateVersion filtered by the version column
 * @method     ChildCandidateVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildCandidateVersion filtered by the version_created_at column
 * @method     ChildCandidateVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildCandidateVersion filtered by the version_created_by column
 * @method     ChildCandidateVersion findOneByQuestionIdVersion(int $question_id_version) Return the first ChildCandidateVersion filtered by the question_id_version column
 * @method     ChildCandidateVersion findOneByVoteItemIds(array $Vote_item_ids) Return the first ChildCandidateVersion filtered by the Vote_item_ids column
 * @method     ChildCandidateVersion findOneByVoteItemVersions(array $Vote_item_versions) Return the first ChildCandidateVersion filtered by the Vote_item_versions column *

 * @method     ChildCandidateVersion requirePk($key, ConnectionInterface $con = null) Return the ChildCandidateVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOne(ConnectionInterface $con = null) Return the first ChildCandidateVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCandidateVersion requireOneByid(int $id) Return the first ChildCandidateVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByquestionId(int $question_id) Return the first ChildCandidateVersion filtered by the question_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByisDeleted(int $is_deleted) Return the first ChildCandidateVersion filtered by the is_deleted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByuserId(int $user_id) Return the first ChildCandidateVersion filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByapplication(string $application) Return the first ChildCandidateVersion filtered by the application column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByCreatedAt(string $created_at) Return the first ChildCandidateVersion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByUpdatedAt(string $updated_at) Return the first ChildCandidateVersion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByVersion(int $version) Return the first ChildCandidateVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildCandidateVersion filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByVersionCreatedBy(string $version_created_by) Return the first ChildCandidateVersion filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByQuestionIdVersion(int $question_id_version) Return the first ChildCandidateVersion filtered by the question_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByVoteItemIds(array $Vote_item_ids) Return the first ChildCandidateVersion filtered by the Vote_item_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCandidateVersion requireOneByVoteItemVersions(array $Vote_item_versions) Return the first ChildCandidateVersion filtered by the Vote_item_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCandidateVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCandidateVersion objects based on current ModelCriteria
 * @method     ChildCandidateVersion[]|ObjectCollection findByid(int $id) Return ChildCandidateVersion objects filtered by the id column
 * @method     ChildCandidateVersion[]|ObjectCollection findByquestionId(int $question_id) Return ChildCandidateVersion objects filtered by the question_id column
 * @method     ChildCandidateVersion[]|ObjectCollection findByisDeleted(int $is_deleted) Return ChildCandidateVersion objects filtered by the is_deleted column
 * @method     ChildCandidateVersion[]|ObjectCollection findByuserId(int $user_id) Return ChildCandidateVersion objects filtered by the user_id column
 * @method     ChildCandidateVersion[]|ObjectCollection findByapplication(string $application) Return ChildCandidateVersion objects filtered by the application column
 * @method     ChildCandidateVersion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildCandidateVersion objects filtered by the created_at column
 * @method     ChildCandidateVersion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildCandidateVersion objects filtered by the updated_at column
 * @method     ChildCandidateVersion[]|ObjectCollection findByVersion(int $version) Return ChildCandidateVersion objects filtered by the version column
 * @method     ChildCandidateVersion[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildCandidateVersion objects filtered by the version_created_at column
 * @method     ChildCandidateVersion[]|ObjectCollection findByVersionCreatedBy(string $version_created_by) Return ChildCandidateVersion objects filtered by the version_created_by column
 * @method     ChildCandidateVersion[]|ObjectCollection findByQuestionIdVersion(int $question_id_version) Return ChildCandidateVersion objects filtered by the question_id_version column
 * @method     ChildCandidateVersion[]|ObjectCollection findByVoteItemIds(array $Vote_item_ids) Return ChildCandidateVersion objects filtered by the Vote_item_ids column
 * @method     ChildCandidateVersion[]|ObjectCollection findByVoteItemVersions(array $Vote_item_versions) Return ChildCandidateVersion objects filtered by the Vote_item_versions column
 * @method     ChildCandidateVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CandidateVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\CandidateVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\CandidateVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCandidateVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCandidateVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCandidateVersionQuery) {
            return $criteria;
        }
        $query = new ChildCandidateVersionQuery();
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
     * @return ChildCandidateVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CandidateVersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CandidateVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildCandidateVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, question_id, is_deleted, user_id, application, created_at, updated_at, version, version_created_at, version_created_by, question_id_version, Vote_item_ids, Vote_item_versions FROM Candidate_version WHERE id = :p0 AND version = :p1';
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
            /** @var ChildCandidateVersion $obj */
            $obj = new ChildCandidateVersion();
            $obj->hydrate($row);
            CandidateVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildCandidateVersion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CandidateVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CandidateVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CandidateVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByCandidate()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the question_id column
     *
     * Example usage:
     * <code>
     * $query->filterByquestionId(1234); // WHERE question_id = 1234
     * $query->filterByquestionId(array(12, 34)); // WHERE question_id IN (12, 34)
     * $query->filterByquestionId(array('min' => 12)); // WHERE question_id > 12
     * </code>
     *
     * @param     mixed $questionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByquestionId($questionId = null, $comparison = null)
    {
        if (is_array($questionId)) {
            $useMinMax = false;
            if (isset($questionId['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_QUESTION_ID, $questionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionId['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_QUESTION_ID, $questionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_QUESTION_ID, $questionId, $comparison);
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByisDeleted($isDeleted = null, $comparison = null)
    {
        if (is_array($isDeleted)) {
            $useMinMax = false;
            if (isset($isDeleted['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_IS_DELETED, $isDeleted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isDeleted['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_IS_DELETED, $isDeleted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_IS_DELETED, $isDeleted, $comparison);
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByuserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the application column
     *
     * Example usage:
     * <code>
     * $query->filterByapplication('fooValue');   // WHERE application = 'fooValue'
     * $query->filterByapplication('%fooValue%'); // WHERE application LIKE '%fooValue%'
     * </code>
     *
     * @param     string $application The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByapplication($application = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($application)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $application)) {
                $application = str_replace('*', '%', $application);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_APPLICATION, $application, $comparison);
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION, $version, $comparison);
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CandidateVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the question_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByQuestionIdVersion(1234); // WHERE question_id_version = 1234
     * $query->filterByQuestionIdVersion(array(12, 34)); // WHERE question_id_version IN (12, 34)
     * $query->filterByQuestionIdVersion(array('min' => 12)); // WHERE question_id_version > 12
     * </code>
     *
     * @param     mixed $questionIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByQuestionIdVersion($questionIdVersion = null, $comparison = null)
    {
        if (is_array($questionIdVersion)) {
            $useMinMax = false;
            if (isset($questionIdVersion['min'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_QUESTION_ID_VERSION, $questionIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionIdVersion['max'])) {
                $this->addUsingAlias(CandidateVersionTableMap::COL_QUESTION_ID_VERSION, $questionIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_QUESTION_ID_VERSION, $questionIdVersion, $comparison);
    }

    /**
     * Filter the query on the Vote_item_ids column
     *
     * @param     array $voteItemIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemIds($voteItemIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(CandidateVersionTableMap::COL_VOTE_ITEM_IDS);
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

        return $this->addUsingAlias(CandidateVersionTableMap::COL_VOTE_ITEM_IDS, $voteItemIds, $comparison);
    }

    /**
     * Filter the query on the Vote_item_ids column
     * @param     mixed $voteItemIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
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
            $key = $this->getAliasedColName(CandidateVersionTableMap::COL_VOTE_ITEM_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteItemIds, $comparison);
            } else {
                $this->addAnd($key, $voteItemIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_VOTE_ITEM_IDS, $voteItemIds, $comparison);
    }

    /**
     * Filter the query on the Vote_item_versions column
     *
     * @param     array $voteItemVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItemVersions($voteItemVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(CandidateVersionTableMap::COL_VOTE_ITEM_VERSIONS);
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

        return $this->addUsingAlias(CandidateVersionTableMap::COL_VOTE_ITEM_VERSIONS, $voteItemVersions, $comparison);
    }

    /**
     * Filter the query on the Vote_item_versions column
     * @param     mixed $voteItemVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
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
            $key = $this->getAliasedColName(CandidateVersionTableMap::COL_VOTE_ITEM_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $voteItemVersions, $comparison);
            } else {
                $this->addAnd($key, $voteItemVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(CandidateVersionTableMap::COL_VOTE_ITEM_VERSIONS, $voteItemVersions, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Candidate object
     *
     * @param \MESBallotBox\Propel\Candidate|ObjectCollection $candidate The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function filterByCandidate($candidate, $comparison = null)
    {
        if ($candidate instanceof \MESBallotBox\Propel\Candidate) {
            return $this
                ->addUsingAlias(CandidateVersionTableMap::COL_ID, $candidate->getid(), $comparison);
        } elseif ($candidate instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CandidateVersionTableMap::COL_ID, $candidate->toKeyValue('PrimaryKey', 'id'), $comparison);
        } else {
            throw new PropelException('filterByCandidate() only accepts arguments of type \MESBallotBox\Propel\Candidate or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Candidate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function joinCandidate($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Candidate');

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
            $this->addJoinObject($join, 'Candidate');
        }

        return $this;
    }

    /**
     * Use the Candidate relation Candidate object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\CandidateQuery A secondary query class using the current class as primary query
     */
    public function useCandidateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCandidate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Candidate', '\MESBallotBox\Propel\CandidateQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCandidateVersion $candidateVersion Object to remove from the list of results
     *
     * @return $this|ChildCandidateVersionQuery The current query, for fluid interface
     */
    public function prune($candidateVersion = null)
    {
        if ($candidateVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CandidateVersionTableMap::COL_ID), $candidateVersion->getid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CandidateVersionTableMap::COL_VERSION), $candidateVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Candidate_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CandidateVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CandidateVersionTableMap::clearInstancePool();
            CandidateVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CandidateVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CandidateVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CandidateVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CandidateVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CandidateVersionQuery
