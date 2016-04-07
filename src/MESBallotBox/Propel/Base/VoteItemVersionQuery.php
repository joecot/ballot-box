<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\VoteItemVersion as ChildVoteItemVersion;
use MESBallotBox\Propel\VoteItemVersionQuery as ChildVoteItemVersionQuery;
use MESBallotBox\Propel\Map\VoteItemVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Vote_item_version' table.
 *
 *
 *
 * @method     ChildVoteItemVersionQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildVoteItemVersionQuery orderByvoteId($order = Criteria::ASC) Order by the vote_id column
 * @method     ChildVoteItemVersionQuery orderByquestionId($order = Criteria::ASC) Order by the question_id column
 * @method     ChildVoteItemVersionQuery orderBycandidateId($order = Criteria::ASC) Order by the candidate_id column
 * @method     ChildVoteItemVersionQuery orderByanswer($order = Criteria::ASC) Order by the answer column
 * @method     ChildVoteItemVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildVoteItemVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildVoteItemVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildVoteItemVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildVoteItemVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildVoteItemVersionQuery orderByVoteIdVersion($order = Criteria::ASC) Order by the vote_id_version column
 * @method     ChildVoteItemVersionQuery orderByQuestionIdVersion($order = Criteria::ASC) Order by the question_id_version column
 * @method     ChildVoteItemVersionQuery orderByCandidateIdVersion($order = Criteria::ASC) Order by the candidate_id_version column
 *
 * @method     ChildVoteItemVersionQuery groupByid() Group by the id column
 * @method     ChildVoteItemVersionQuery groupByvoteId() Group by the vote_id column
 * @method     ChildVoteItemVersionQuery groupByquestionId() Group by the question_id column
 * @method     ChildVoteItemVersionQuery groupBycandidateId() Group by the candidate_id column
 * @method     ChildVoteItemVersionQuery groupByanswer() Group by the answer column
 * @method     ChildVoteItemVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildVoteItemVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildVoteItemVersionQuery groupByVersion() Group by the version column
 * @method     ChildVoteItemVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildVoteItemVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildVoteItemVersionQuery groupByVoteIdVersion() Group by the vote_id_version column
 * @method     ChildVoteItemVersionQuery groupByQuestionIdVersion() Group by the question_id_version column
 * @method     ChildVoteItemVersionQuery groupByCandidateIdVersion() Group by the candidate_id_version column
 *
 * @method     ChildVoteItemVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoteItemVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoteItemVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoteItemVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVoteItemVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVoteItemVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVoteItemVersionQuery leftJoinVoteItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the VoteItem relation
 * @method     ChildVoteItemVersionQuery rightJoinVoteItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VoteItem relation
 * @method     ChildVoteItemVersionQuery innerJoinVoteItem($relationAlias = null) Adds a INNER JOIN clause to the query using the VoteItem relation
 *
 * @method     ChildVoteItemVersionQuery joinWithVoteItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the VoteItem relation
 *
 * @method     ChildVoteItemVersionQuery leftJoinWithVoteItem() Adds a LEFT JOIN clause and with to the query using the VoteItem relation
 * @method     ChildVoteItemVersionQuery rightJoinWithVoteItem() Adds a RIGHT JOIN clause and with to the query using the VoteItem relation
 * @method     ChildVoteItemVersionQuery innerJoinWithVoteItem() Adds a INNER JOIN clause and with to the query using the VoteItem relation
 *
 * @method     \MESBallotBox\Propel\VoteItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoteItemVersion findOne(ConnectionInterface $con = null) Return the first ChildVoteItemVersion matching the query
 * @method     ChildVoteItemVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoteItemVersion matching the query, or a new ChildVoteItemVersion object populated from the query conditions when no match is found
 *
 * @method     ChildVoteItemVersion findOneByid(int $id) Return the first ChildVoteItemVersion filtered by the id column
 * @method     ChildVoteItemVersion findOneByvoteId(int $vote_id) Return the first ChildVoteItemVersion filtered by the vote_id column
 * @method     ChildVoteItemVersion findOneByquestionId(int $question_id) Return the first ChildVoteItemVersion filtered by the question_id column
 * @method     ChildVoteItemVersion findOneBycandidateId(int $candidate_id) Return the first ChildVoteItemVersion filtered by the candidate_id column
 * @method     ChildVoteItemVersion findOneByanswer(int $answer) Return the first ChildVoteItemVersion filtered by the answer column
 * @method     ChildVoteItemVersion findOneByCreatedAt(string $created_at) Return the first ChildVoteItemVersion filtered by the created_at column
 * @method     ChildVoteItemVersion findOneByUpdatedAt(string $updated_at) Return the first ChildVoteItemVersion filtered by the updated_at column
 * @method     ChildVoteItemVersion findOneByVersion(int $version) Return the first ChildVoteItemVersion filtered by the version column
 * @method     ChildVoteItemVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildVoteItemVersion filtered by the version_created_at column
 * @method     ChildVoteItemVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildVoteItemVersion filtered by the version_created_by column
 * @method     ChildVoteItemVersion findOneByVoteIdVersion(int $vote_id_version) Return the first ChildVoteItemVersion filtered by the vote_id_version column
 * @method     ChildVoteItemVersion findOneByQuestionIdVersion(int $question_id_version) Return the first ChildVoteItemVersion filtered by the question_id_version column
 * @method     ChildVoteItemVersion findOneByCandidateIdVersion(int $candidate_id_version) Return the first ChildVoteItemVersion filtered by the candidate_id_version column *

 * @method     ChildVoteItemVersion requirePk($key, ConnectionInterface $con = null) Return the ChildVoteItemVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOne(ConnectionInterface $con = null) Return the first ChildVoteItemVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteItemVersion requireOneByid(int $id) Return the first ChildVoteItemVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByvoteId(int $vote_id) Return the first ChildVoteItemVersion filtered by the vote_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByquestionId(int $question_id) Return the first ChildVoteItemVersion filtered by the question_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneBycandidateId(int $candidate_id) Return the first ChildVoteItemVersion filtered by the candidate_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByanswer(int $answer) Return the first ChildVoteItemVersion filtered by the answer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByCreatedAt(string $created_at) Return the first ChildVoteItemVersion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByUpdatedAt(string $updated_at) Return the first ChildVoteItemVersion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByVersion(int $version) Return the first ChildVoteItemVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildVoteItemVersion filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByVersionCreatedBy(string $version_created_by) Return the first ChildVoteItemVersion filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByVoteIdVersion(int $vote_id_version) Return the first ChildVoteItemVersion filtered by the vote_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByQuestionIdVersion(int $question_id_version) Return the first ChildVoteItemVersion filtered by the question_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItemVersion requireOneByCandidateIdVersion(int $candidate_id_version) Return the first ChildVoteItemVersion filtered by the candidate_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteItemVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoteItemVersion objects based on current ModelCriteria
 * @method     ChildVoteItemVersion[]|ObjectCollection findByid(int $id) Return ChildVoteItemVersion objects filtered by the id column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByvoteId(int $vote_id) Return ChildVoteItemVersion objects filtered by the vote_id column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByquestionId(int $question_id) Return ChildVoteItemVersion objects filtered by the question_id column
 * @method     ChildVoteItemVersion[]|ObjectCollection findBycandidateId(int $candidate_id) Return ChildVoteItemVersion objects filtered by the candidate_id column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByanswer(int $answer) Return ChildVoteItemVersion objects filtered by the answer column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildVoteItemVersion objects filtered by the created_at column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildVoteItemVersion objects filtered by the updated_at column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByVersion(int $version) Return ChildVoteItemVersion objects filtered by the version column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildVoteItemVersion objects filtered by the version_created_at column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByVersionCreatedBy(string $version_created_by) Return ChildVoteItemVersion objects filtered by the version_created_by column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByVoteIdVersion(int $vote_id_version) Return ChildVoteItemVersion objects filtered by the vote_id_version column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByQuestionIdVersion(int $question_id_version) Return ChildVoteItemVersion objects filtered by the question_id_version column
 * @method     ChildVoteItemVersion[]|ObjectCollection findByCandidateIdVersion(int $candidate_id_version) Return ChildVoteItemVersion objects filtered by the candidate_id_version column
 * @method     ChildVoteItemVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoteItemVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\VoteItemVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\VoteItemVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoteItemVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoteItemVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoteItemVersionQuery) {
            return $criteria;
        }
        $query = new ChildVoteItemVersionQuery();
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
     * @return ChildVoteItemVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoteItemVersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VoteItemVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildVoteItemVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, vote_id, question_id, candidate_id, answer, created_at, updated_at, version, version_created_at, version_created_by, vote_id_version, question_id_version, candidate_id_version FROM Vote_item_version WHERE id = :p0 AND version = :p1';
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
            /** @var ChildVoteItemVersion $obj */
            $obj = new ChildVoteItemVersion();
            $obj->hydrate($row);
            VoteItemVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildVoteItemVersion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(VoteItemVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(VoteItemVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(VoteItemVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByVoteItem()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the vote_id column
     *
     * Example usage:
     * <code>
     * $query->filterByvoteId(1234); // WHERE vote_id = 1234
     * $query->filterByvoteId(array(12, 34)); // WHERE vote_id IN (12, 34)
     * $query->filterByvoteId(array('min' => 12)); // WHERE vote_id > 12
     * </code>
     *
     * @param     mixed $voteId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByvoteId($voteId = null, $comparison = null)
    {
        if (is_array($voteId)) {
            $useMinMax = false;
            if (isset($voteId['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VOTE_ID, $voteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($voteId['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VOTE_ID, $voteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_VOTE_ID, $voteId, $comparison);
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByquestionId($questionId = null, $comparison = null)
    {
        if (is_array($questionId)) {
            $useMinMax = false;
            if (isset($questionId['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_QUESTION_ID, $questionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionId['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_QUESTION_ID, $questionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_QUESTION_ID, $questionId, $comparison);
    }

    /**
     * Filter the query on the candidate_id column
     *
     * Example usage:
     * <code>
     * $query->filterBycandidateId(1234); // WHERE candidate_id = 1234
     * $query->filterBycandidateId(array(12, 34)); // WHERE candidate_id IN (12, 34)
     * $query->filterBycandidateId(array('min' => 12)); // WHERE candidate_id > 12
     * </code>
     *
     * @param     mixed $candidateId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterBycandidateId($candidateId = null, $comparison = null)
    {
        if (is_array($candidateId)) {
            $useMinMax = false;
            if (isset($candidateId['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_CANDIDATE_ID, $candidateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($candidateId['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_CANDIDATE_ID, $candidateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_CANDIDATE_ID, $candidateId, $comparison);
    }

    /**
     * Filter the query on the answer column
     *
     * Example usage:
     * <code>
     * $query->filterByanswer(1234); // WHERE answer = 1234
     * $query->filterByanswer(array(12, 34)); // WHERE answer IN (12, 34)
     * $query->filterByanswer(array('min' => 12)); // WHERE answer > 12
     * </code>
     *
     * @param     mixed $answer The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByanswer($answer = null, $comparison = null)
    {
        if (is_array($answer)) {
            $useMinMax = false;
            if (isset($answer['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_ANSWER, $answer['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($answer['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_ANSWER, $answer['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_ANSWER, $answer, $comparison);
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION, $version, $comparison);
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the vote_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByVoteIdVersion(1234); // WHERE vote_id_version = 1234
     * $query->filterByVoteIdVersion(array(12, 34)); // WHERE vote_id_version IN (12, 34)
     * $query->filterByVoteIdVersion(array('min' => 12)); // WHERE vote_id_version > 12
     * </code>
     *
     * @param     mixed $voteIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByVoteIdVersion($voteIdVersion = null, $comparison = null)
    {
        if (is_array($voteIdVersion)) {
            $useMinMax = false;
            if (isset($voteIdVersion['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VOTE_ID_VERSION, $voteIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($voteIdVersion['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_VOTE_ID_VERSION, $voteIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_VOTE_ID_VERSION, $voteIdVersion, $comparison);
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
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByQuestionIdVersion($questionIdVersion = null, $comparison = null)
    {
        if (is_array($questionIdVersion)) {
            $useMinMax = false;
            if (isset($questionIdVersion['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_QUESTION_ID_VERSION, $questionIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionIdVersion['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_QUESTION_ID_VERSION, $questionIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_QUESTION_ID_VERSION, $questionIdVersion, $comparison);
    }

    /**
     * Filter the query on the candidate_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByCandidateIdVersion(1234); // WHERE candidate_id_version = 1234
     * $query->filterByCandidateIdVersion(array(12, 34)); // WHERE candidate_id_version IN (12, 34)
     * $query->filterByCandidateIdVersion(array('min' => 12)); // WHERE candidate_id_version > 12
     * </code>
     *
     * @param     mixed $candidateIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByCandidateIdVersion($candidateIdVersion = null, $comparison = null)
    {
        if (is_array($candidateIdVersion)) {
            $useMinMax = false;
            if (isset($candidateIdVersion['min'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_CANDIDATE_ID_VERSION, $candidateIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($candidateIdVersion['max'])) {
                $this->addUsingAlias(VoteItemVersionTableMap::COL_CANDIDATE_ID_VERSION, $candidateIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemVersionTableMap::COL_CANDIDATE_ID_VERSION, $candidateIdVersion, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\VoteItem object
     *
     * @param \MESBallotBox\Propel\VoteItem|ObjectCollection $voteItem The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function filterByVoteItem($voteItem, $comparison = null)
    {
        if ($voteItem instanceof \MESBallotBox\Propel\VoteItem) {
            return $this
                ->addUsingAlias(VoteItemVersionTableMap::COL_ID, $voteItem->getid(), $comparison);
        } elseif ($voteItem instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoteItemVersionTableMap::COL_ID, $voteItem->toKeyValue('PrimaryKey', 'id'), $comparison);
        } else {
            throw new PropelException('filterByVoteItem() only accepts arguments of type \MESBallotBox\Propel\VoteItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the VoteItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function joinVoteItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('VoteItem');

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
            $this->addJoinObject($join, 'VoteItem');
        }

        return $this;
    }

    /**
     * Use the VoteItem relation VoteItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\VoteItemQuery A secondary query class using the current class as primary query
     */
    public function useVoteItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVoteItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VoteItem', '\MESBallotBox\Propel\VoteItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVoteItemVersion $voteItemVersion Object to remove from the list of results
     *
     * @return $this|ChildVoteItemVersionQuery The current query, for fluid interface
     */
    public function prune($voteItemVersion = null)
    {
        if ($voteItemVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(VoteItemVersionTableMap::COL_ID), $voteItemVersion->getid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(VoteItemVersionTableMap::COL_VERSION), $voteItemVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Vote_item_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoteItemVersionTableMap::clearInstancePool();
            VoteItemVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoteItemVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoteItemVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoteItemVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VoteItemVersionQuery
