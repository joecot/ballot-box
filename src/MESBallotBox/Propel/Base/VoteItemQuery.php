<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\VoteItem as ChildVoteItem;
use MESBallotBox\Propel\VoteItemQuery as ChildVoteItemQuery;
use MESBallotBox\Propel\Map\VoteItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Vote_item' table.
 *
 *
 *
 * @method     ChildVoteItemQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildVoteItemQuery orderByvoteId($order = Criteria::ASC) Order by the vote_id column
 * @method     ChildVoteItemQuery orderByquestionId($order = Criteria::ASC) Order by the question_id column
 * @method     ChildVoteItemQuery orderBycandidateId($order = Criteria::ASC) Order by the candidate_id column
 * @method     ChildVoteItemQuery orderByanswer($order = Criteria::ASC) Order by the answer column
 * @method     ChildVoteItemQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildVoteItemQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildVoteItemQuery groupByid() Group by the id column
 * @method     ChildVoteItemQuery groupByvoteId() Group by the vote_id column
 * @method     ChildVoteItemQuery groupByquestionId() Group by the question_id column
 * @method     ChildVoteItemQuery groupBycandidateId() Group by the candidate_id column
 * @method     ChildVoteItemQuery groupByanswer() Group by the answer column
 * @method     ChildVoteItemQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildVoteItemQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildVoteItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoteItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoteItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoteItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVoteItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVoteItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVoteItemQuery leftJoinVote($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vote relation
 * @method     ChildVoteItemQuery rightJoinVote($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vote relation
 * @method     ChildVoteItemQuery innerJoinVote($relationAlias = null) Adds a INNER JOIN clause to the query using the Vote relation
 *
 * @method     ChildVoteItemQuery joinWithVote($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vote relation
 *
 * @method     ChildVoteItemQuery leftJoinWithVote() Adds a LEFT JOIN clause and with to the query using the Vote relation
 * @method     ChildVoteItemQuery rightJoinWithVote() Adds a RIGHT JOIN clause and with to the query using the Vote relation
 * @method     ChildVoteItemQuery innerJoinWithVote() Adds a INNER JOIN clause and with to the query using the Vote relation
 *
 * @method     ChildVoteItemQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method     ChildVoteItemQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method     ChildVoteItemQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method     ChildVoteItemQuery joinWithQuestion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Question relation
 *
 * @method     ChildVoteItemQuery leftJoinWithQuestion() Adds a LEFT JOIN clause and with to the query using the Question relation
 * @method     ChildVoteItemQuery rightJoinWithQuestion() Adds a RIGHT JOIN clause and with to the query using the Question relation
 * @method     ChildVoteItemQuery innerJoinWithQuestion() Adds a INNER JOIN clause and with to the query using the Question relation
 *
 * @method     ChildVoteItemQuery leftJoinCandidate($relationAlias = null) Adds a LEFT JOIN clause to the query using the Candidate relation
 * @method     ChildVoteItemQuery rightJoinCandidate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Candidate relation
 * @method     ChildVoteItemQuery innerJoinCandidate($relationAlias = null) Adds a INNER JOIN clause to the query using the Candidate relation
 *
 * @method     ChildVoteItemQuery joinWithCandidate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Candidate relation
 *
 * @method     ChildVoteItemQuery leftJoinWithCandidate() Adds a LEFT JOIN clause and with to the query using the Candidate relation
 * @method     ChildVoteItemQuery rightJoinWithCandidate() Adds a RIGHT JOIN clause and with to the query using the Candidate relation
 * @method     ChildVoteItemQuery innerJoinWithCandidate() Adds a INNER JOIN clause and with to the query using the Candidate relation
 *
 * @method     \MESBallotBox\Propel\VoteQuery|\MESBallotBox\Propel\QuestionQuery|\MESBallotBox\Propel\CandidateQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoteItem findOne(ConnectionInterface $con = null) Return the first ChildVoteItem matching the query
 * @method     ChildVoteItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoteItem matching the query, or a new ChildVoteItem object populated from the query conditions when no match is found
 *
 * @method     ChildVoteItem findOneByid(int $id) Return the first ChildVoteItem filtered by the id column
 * @method     ChildVoteItem findOneByvoteId(int $vote_id) Return the first ChildVoteItem filtered by the vote_id column
 * @method     ChildVoteItem findOneByquestionId(int $question_id) Return the first ChildVoteItem filtered by the question_id column
 * @method     ChildVoteItem findOneBycandidateId(int $candidate_id) Return the first ChildVoteItem filtered by the candidate_id column
 * @method     ChildVoteItem findOneByanswer(int $answer) Return the first ChildVoteItem filtered by the answer column
 * @method     ChildVoteItem findOneByCreatedAt(string $created_at) Return the first ChildVoteItem filtered by the created_at column
 * @method     ChildVoteItem findOneByUpdatedAt(string $updated_at) Return the first ChildVoteItem filtered by the updated_at column *

 * @method     ChildVoteItem requirePk($key, ConnectionInterface $con = null) Return the ChildVoteItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItem requireOne(ConnectionInterface $con = null) Return the first ChildVoteItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteItem requireOneByid(int $id) Return the first ChildVoteItem filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItem requireOneByvoteId(int $vote_id) Return the first ChildVoteItem filtered by the vote_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItem requireOneByquestionId(int $question_id) Return the first ChildVoteItem filtered by the question_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItem requireOneBycandidateId(int $candidate_id) Return the first ChildVoteItem filtered by the candidate_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItem requireOneByanswer(int $answer) Return the first ChildVoteItem filtered by the answer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItem requireOneByCreatedAt(string $created_at) Return the first ChildVoteItem filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteItem requireOneByUpdatedAt(string $updated_at) Return the first ChildVoteItem filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoteItem objects based on current ModelCriteria
 * @method     ChildVoteItem[]|ObjectCollection findByid(int $id) Return ChildVoteItem objects filtered by the id column
 * @method     ChildVoteItem[]|ObjectCollection findByvoteId(int $vote_id) Return ChildVoteItem objects filtered by the vote_id column
 * @method     ChildVoteItem[]|ObjectCollection findByquestionId(int $question_id) Return ChildVoteItem objects filtered by the question_id column
 * @method     ChildVoteItem[]|ObjectCollection findBycandidateId(int $candidate_id) Return ChildVoteItem objects filtered by the candidate_id column
 * @method     ChildVoteItem[]|ObjectCollection findByanswer(int $answer) Return ChildVoteItem objects filtered by the answer column
 * @method     ChildVoteItem[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildVoteItem objects filtered by the created_at column
 * @method     ChildVoteItem[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildVoteItem objects filtered by the updated_at column
 * @method     ChildVoteItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoteItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\VoteItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\VoteItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoteItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoteItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoteItemQuery) {
            return $criteria;
        }
        $query = new ChildVoteItemQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildVoteItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = VoteItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoteItemTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
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
     * @return ChildVoteItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, vote_id, question_id, candidate_id, answer, created_at, updated_at FROM Vote_item WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildVoteItem $obj */
            $obj = new ChildVoteItem();
            $obj->hydrate($row);
            VoteItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildVoteItem|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VoteItemTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VoteItemTableMap::COL_ID, $keys, Criteria::IN);
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
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemTableMap::COL_ID, $id, $comparison);
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
     * @see       filterByVote()
     *
     * @param     mixed $voteId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByvoteId($voteId = null, $comparison = null)
    {
        if (is_array($voteId)) {
            $useMinMax = false;
            if (isset($voteId['min'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_VOTE_ID, $voteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($voteId['max'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_VOTE_ID, $voteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemTableMap::COL_VOTE_ID, $voteId, $comparison);
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
     * @see       filterByQuestion()
     *
     * @param     mixed $questionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByquestionId($questionId = null, $comparison = null)
    {
        if (is_array($questionId)) {
            $useMinMax = false;
            if (isset($questionId['min'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_QUESTION_ID, $questionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionId['max'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_QUESTION_ID, $questionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemTableMap::COL_QUESTION_ID, $questionId, $comparison);
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
     * @see       filterByCandidate()
     *
     * @param     mixed $candidateId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterBycandidateId($candidateId = null, $comparison = null)
    {
        if (is_array($candidateId)) {
            $useMinMax = false;
            if (isset($candidateId['min'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_CANDIDATE_ID, $candidateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($candidateId['max'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_CANDIDATE_ID, $candidateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemTableMap::COL_CANDIDATE_ID, $candidateId, $comparison);
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
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByanswer($answer = null, $comparison = null)
    {
        if (is_array($answer)) {
            $useMinMax = false;
            if (isset($answer['min'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_ANSWER, $answer['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($answer['max'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_ANSWER, $answer['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemTableMap::COL_ANSWER, $answer, $comparison);
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
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(VoteItemTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteItemTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Vote object
     *
     * @param \MESBallotBox\Propel\Vote|ObjectCollection $vote The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByVote($vote, $comparison = null)
    {
        if ($vote instanceof \MESBallotBox\Propel\Vote) {
            return $this
                ->addUsingAlias(VoteItemTableMap::COL_VOTE_ID, $vote->getid(), $comparison);
        } elseif ($vote instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoteItemTableMap::COL_VOTE_ID, $vote->toKeyValue('PrimaryKey', 'id'), $comparison);
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
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
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
     * Filter the query by a related \MESBallotBox\Propel\Question object
     *
     * @param \MESBallotBox\Propel\Question|ObjectCollection $question The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByQuestion($question, $comparison = null)
    {
        if ($question instanceof \MESBallotBox\Propel\Question) {
            return $this
                ->addUsingAlias(VoteItemTableMap::COL_QUESTION_ID, $question->getid(), $comparison);
        } elseif ($question instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoteItemTableMap::COL_QUESTION_ID, $question->toKeyValue('PrimaryKey', 'id'), $comparison);
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
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
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
     * Filter the query by a related \MESBallotBox\Propel\Candidate object
     *
     * @param \MESBallotBox\Propel\Candidate|ObjectCollection $candidate The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteItemQuery The current query, for fluid interface
     */
    public function filterByCandidate($candidate, $comparison = null)
    {
        if ($candidate instanceof \MESBallotBox\Propel\Candidate) {
            return $this
                ->addUsingAlias(VoteItemTableMap::COL_CANDIDATE_ID, $candidate->getid(), $comparison);
        } elseif ($candidate instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoteItemTableMap::COL_CANDIDATE_ID, $candidate->toKeyValue('PrimaryKey', 'id'), $comparison);
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
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function joinCandidate($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useCandidateQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCandidate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Candidate', '\MESBallotBox\Propel\CandidateQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVoteItem $voteItem Object to remove from the list of results
     *
     * @return $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function prune($voteItem = null)
    {
        if ($voteItem) {
            $this->addUsingAlias(VoteItemTableMap::COL_ID, $voteItem->getid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Vote_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoteItemTableMap::clearInstancePool();
            VoteItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VoteItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoteItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoteItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoteItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(VoteItemTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(VoteItemTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(VoteItemTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(VoteItemTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(VoteItemTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildVoteItemQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(VoteItemTableMap::COL_CREATED_AT);
    }

} // VoteItemQuery
