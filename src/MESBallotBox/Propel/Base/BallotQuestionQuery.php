<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\BallotQuestion as ChildBallotQuestion;
use MESBallotBox\Propel\BallotQuestionQuery as ChildBallotQuestionQuery;
use MESBallotBox\Propel\Map\BallotQuestionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Ballot_question' table.
 *
 *
 *
 * @method     ChildBallotQuestionQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildBallotQuestionQuery orderByballotId($order = Criteria::ASC) Order by the ballot_id column
 * @method     ChildBallotQuestionQuery orderBytype($order = Criteria::ASC) Order by the type column
 * @method     ChildBallotQuestionQuery orderBycount($order = Criteria::ASC) Order by the count column
 * @method     ChildBallotQuestionQuery orderByname($order = Criteria::ASC) Order by the name column
 * @method     ChildBallotQuestionQuery orderBydescription($order = Criteria::ASC) Order by the description column
 * @method     ChildBallotQuestionQuery orderByreadmore($order = Criteria::ASC) Order by the readmore column
 * @method     ChildBallotQuestionQuery orderBydiscussion($order = Criteria::ASC) Order by the discussion column
 *
 * @method     ChildBallotQuestionQuery groupByid() Group by the id column
 * @method     ChildBallotQuestionQuery groupByballotId() Group by the ballot_id column
 * @method     ChildBallotQuestionQuery groupBytype() Group by the type column
 * @method     ChildBallotQuestionQuery groupBycount() Group by the count column
 * @method     ChildBallotQuestionQuery groupByname() Group by the name column
 * @method     ChildBallotQuestionQuery groupBydescription() Group by the description column
 * @method     ChildBallotQuestionQuery groupByreadmore() Group by the readmore column
 * @method     ChildBallotQuestionQuery groupBydiscussion() Group by the discussion column
 *
 * @method     ChildBallotQuestionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBallotQuestionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBallotQuestionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBallotQuestionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBallotQuestionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBallotQuestionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBallotQuestionQuery leftJoinBallot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ballot relation
 * @method     ChildBallotQuestionQuery rightJoinBallot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ballot relation
 * @method     ChildBallotQuestionQuery innerJoinBallot($relationAlias = null) Adds a INNER JOIN clause to the query using the Ballot relation
 *
 * @method     ChildBallotQuestionQuery joinWithBallot($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ballot relation
 *
 * @method     ChildBallotQuestionQuery leftJoinWithBallot() Adds a LEFT JOIN clause and with to the query using the Ballot relation
 * @method     ChildBallotQuestionQuery rightJoinWithBallot() Adds a RIGHT JOIN clause and with to the query using the Ballot relation
 * @method     ChildBallotQuestionQuery innerJoinWithBallot() Adds a INNER JOIN clause and with to the query using the Ballot relation
 *
 * @method     \MESBallotBox\Propel\BallotQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBallotQuestion findOne(ConnectionInterface $con = null) Return the first ChildBallotQuestion matching the query
 * @method     ChildBallotQuestion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBallotQuestion matching the query, or a new ChildBallotQuestion object populated from the query conditions when no match is found
 *
 * @method     ChildBallotQuestion findOneByid(int $id) Return the first ChildBallotQuestion filtered by the id column
 * @method     ChildBallotQuestion findOneByballotId(int $ballot_id) Return the first ChildBallotQuestion filtered by the ballot_id column
 * @method     ChildBallotQuestion findOneBytype(int $type) Return the first ChildBallotQuestion filtered by the type column
 * @method     ChildBallotQuestion findOneBycount(int $count) Return the first ChildBallotQuestion filtered by the count column
 * @method     ChildBallotQuestion findOneByname(string $name) Return the first ChildBallotQuestion filtered by the name column
 * @method     ChildBallotQuestion findOneBydescription(string $description) Return the first ChildBallotQuestion filtered by the description column
 * @method     ChildBallotQuestion findOneByreadmore(string $readmore) Return the first ChildBallotQuestion filtered by the readmore column
 * @method     ChildBallotQuestion findOneBydiscussion(string $discussion) Return the first ChildBallotQuestion filtered by the discussion column *

 * @method     ChildBallotQuestion requirePk($key, ConnectionInterface $con = null) Return the ChildBallotQuestion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOne(ConnectionInterface $con = null) Return the first ChildBallotQuestion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBallotQuestion requireOneByid(int $id) Return the first ChildBallotQuestion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOneByballotId(int $ballot_id) Return the first ChildBallotQuestion filtered by the ballot_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOneBytype(int $type) Return the first ChildBallotQuestion filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOneBycount(int $count) Return the first ChildBallotQuestion filtered by the count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOneByname(string $name) Return the first ChildBallotQuestion filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOneBydescription(string $description) Return the first ChildBallotQuestion filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOneByreadmore(string $readmore) Return the first ChildBallotQuestion filtered by the readmore column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBallotQuestion requireOneBydiscussion(string $discussion) Return the first ChildBallotQuestion filtered by the discussion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBallotQuestion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBallotQuestion objects based on current ModelCriteria
 * @method     ChildBallotQuestion[]|ObjectCollection findByid(int $id) Return ChildBallotQuestion objects filtered by the id column
 * @method     ChildBallotQuestion[]|ObjectCollection findByballotId(int $ballot_id) Return ChildBallotQuestion objects filtered by the ballot_id column
 * @method     ChildBallotQuestion[]|ObjectCollection findBytype(int $type) Return ChildBallotQuestion objects filtered by the type column
 * @method     ChildBallotQuestion[]|ObjectCollection findBycount(int $count) Return ChildBallotQuestion objects filtered by the count column
 * @method     ChildBallotQuestion[]|ObjectCollection findByname(string $name) Return ChildBallotQuestion objects filtered by the name column
 * @method     ChildBallotQuestion[]|ObjectCollection findBydescription(string $description) Return ChildBallotQuestion objects filtered by the description column
 * @method     ChildBallotQuestion[]|ObjectCollection findByreadmore(string $readmore) Return ChildBallotQuestion objects filtered by the readmore column
 * @method     ChildBallotQuestion[]|ObjectCollection findBydiscussion(string $discussion) Return ChildBallotQuestion objects filtered by the discussion column
 * @method     ChildBallotQuestion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BallotQuestionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\BallotQuestionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\BallotQuestion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBallotQuestionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBallotQuestionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBallotQuestionQuery) {
            return $criteria;
        }
        $query = new ChildBallotQuestionQuery();
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
     * @return ChildBallotQuestion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BallotQuestionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BallotQuestionTableMap::DATABASE_NAME);
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
     * @return ChildBallotQuestion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, ballot_id, type, count, name, description, readmore, discussion FROM Ballot_question WHERE id = :p0';
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
            /** @var ChildBallotQuestion $obj */
            $obj = new ChildBallotQuestion();
            $obj->hydrate($row);
            BallotQuestionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBallotQuestion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BallotQuestionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BallotQuestionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BallotQuestionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BallotQuestionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotQuestionTableMap::COL_ID, $id, $comparison);
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
     * @see       filterByBallot()
     *
     * @param     mixed $ballotId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function filterByballotId($ballotId = null, $comparison = null)
    {
        if (is_array($ballotId)) {
            $useMinMax = false;
            if (isset($ballotId['min'])) {
                $this->addUsingAlias(BallotQuestionTableMap::COL_BALLOT_ID, $ballotId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ballotId['max'])) {
                $this->addUsingAlias(BallotQuestionTableMap::COL_BALLOT_ID, $ballotId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotQuestionTableMap::COL_BALLOT_ID, $ballotId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function filterBytype($type = null, $comparison = null)
    {
        $valueSet = BallotQuestionTableMap::getValueSet(BallotQuestionTableMap::COL_TYPE);
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

        return $this->addUsingAlias(BallotQuestionTableMap::COL_TYPE, $type, $comparison);
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function filterBycount($count = null, $comparison = null)
    {
        if (is_array($count)) {
            $useMinMax = false;
            if (isset($count['min'])) {
                $this->addUsingAlias(BallotQuestionTableMap::COL_COUNT, $count['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($count['max'])) {
                $this->addUsingAlias(BallotQuestionTableMap::COL_COUNT, $count['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BallotQuestionTableMap::COL_COUNT, $count, $comparison);
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BallotQuestionTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BallotQuestionTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BallotQuestionTableMap::COL_READMORE, $readmore, $comparison);
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BallotQuestionTableMap::COL_DISCUSSION, $discussion, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Ballot object
     *
     * @param \MESBallotBox\Propel\Ballot|ObjectCollection $ballot The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function filterByBallot($ballot, $comparison = null)
    {
        if ($ballot instanceof \MESBallotBox\Propel\Ballot) {
            return $this
                ->addUsingAlias(BallotQuestionTableMap::COL_BALLOT_ID, $ballot->getid(), $comparison);
        } elseif ($ballot instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BallotQuestionTableMap::COL_BALLOT_ID, $ballot->toKeyValue('PrimaryKey', 'id'), $comparison);
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
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
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
     * @param   ChildBallotQuestion $ballotQuestion Object to remove from the list of results
     *
     * @return $this|ChildBallotQuestionQuery The current query, for fluid interface
     */
    public function prune($ballotQuestion = null)
    {
        if ($ballotQuestion) {
            $this->addUsingAlias(BallotQuestionTableMap::COL_ID, $ballotQuestion->getid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Ballot_question table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BallotQuestionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BallotQuestionTableMap::clearInstancePool();
            BallotQuestionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BallotQuestionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BallotQuestionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BallotQuestionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BallotQuestionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BallotQuestionQuery
