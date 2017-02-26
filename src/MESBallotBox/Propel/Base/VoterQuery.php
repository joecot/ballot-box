<?php

namespace MESBallotBox\Propel\Base;

use \Exception;
use \PDO;
use MESBallotBox\Propel\Voter as ChildVoter;
use MESBallotBox\Propel\VoterQuery as ChildVoterQuery;
use MESBallotBox\Propel\Map\VoterTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Voter' table.
 *
 *
 *
 * @method     ChildVoterQuery orderByid($order = Criteria::ASC) Order by the id column
 * @method     ChildVoterQuery orderByballotId($order = Criteria::ASC) Order by the ballot_id column
 * @method     ChildVoterQuery orderByuserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildVoterQuery orderByaffiliateId($order = Criteria::ASC) Order by the affiliate_id column
 * @method     ChildVoterQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildVoterQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildVoterQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildVoterQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildVoterQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildVoterQuery groupByid() Group by the id column
 * @method     ChildVoterQuery groupByballotId() Group by the ballot_id column
 * @method     ChildVoterQuery groupByuserId() Group by the user_id column
 * @method     ChildVoterQuery groupByaffiliateId() Group by the affiliate_id column
 * @method     ChildVoterQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildVoterQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildVoterQuery groupByVersion() Group by the version column
 * @method     ChildVoterQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildVoterQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildVoterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoterQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVoterQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVoterQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVoterQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildVoterQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildVoterQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildVoterQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildVoterQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildVoterQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildVoterQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildVoterQuery leftJoinAffiliate($relationAlias = null) Adds a LEFT JOIN clause to the query using the Affiliate relation
 * @method     ChildVoterQuery rightJoinAffiliate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Affiliate relation
 * @method     ChildVoterQuery innerJoinAffiliate($relationAlias = null) Adds a INNER JOIN clause to the query using the Affiliate relation
 *
 * @method     ChildVoterQuery joinWithAffiliate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Affiliate relation
 *
 * @method     ChildVoterQuery leftJoinWithAffiliate() Adds a LEFT JOIN clause and with to the query using the Affiliate relation
 * @method     ChildVoterQuery rightJoinWithAffiliate() Adds a RIGHT JOIN clause and with to the query using the Affiliate relation
 * @method     ChildVoterQuery innerJoinWithAffiliate() Adds a INNER JOIN clause and with to the query using the Affiliate relation
 *
 * @method     ChildVoterQuery leftJoinBallot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ballot relation
 * @method     ChildVoterQuery rightJoinBallot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ballot relation
 * @method     ChildVoterQuery innerJoinBallot($relationAlias = null) Adds a INNER JOIN clause to the query using the Ballot relation
 *
 * @method     ChildVoterQuery joinWithBallot($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ballot relation
 *
 * @method     ChildVoterQuery leftJoinWithBallot() Adds a LEFT JOIN clause and with to the query using the Ballot relation
 * @method     ChildVoterQuery rightJoinWithBallot() Adds a RIGHT JOIN clause and with to the query using the Ballot relation
 * @method     ChildVoterQuery innerJoinWithBallot() Adds a INNER JOIN clause and with to the query using the Ballot relation
 *
 * @method     ChildVoterQuery leftJoinVoterVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the VoterVersion relation
 * @method     ChildVoterQuery rightJoinVoterVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VoterVersion relation
 * @method     ChildVoterQuery innerJoinVoterVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the VoterVersion relation
 *
 * @method     ChildVoterQuery joinWithVoterVersion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the VoterVersion relation
 *
 * @method     ChildVoterQuery leftJoinWithVoterVersion() Adds a LEFT JOIN clause and with to the query using the VoterVersion relation
 * @method     ChildVoterQuery rightJoinWithVoterVersion() Adds a RIGHT JOIN clause and with to the query using the VoterVersion relation
 * @method     ChildVoterQuery innerJoinWithVoterVersion() Adds a INNER JOIN clause and with to the query using the VoterVersion relation
 *
 * @method     \MESBallotBox\Propel\UserQuery|\MESBallotBox\Propel\AffiliateQuery|\MESBallotBox\Propel\BallotQuery|\MESBallotBox\Propel\VoterVersionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoter findOne(ConnectionInterface $con = null) Return the first ChildVoter matching the query
 * @method     ChildVoter findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoter matching the query, or a new ChildVoter object populated from the query conditions when no match is found
 *
 * @method     ChildVoter findOneByid(int $id) Return the first ChildVoter filtered by the id column
 * @method     ChildVoter findOneByballotId(int $ballot_id) Return the first ChildVoter filtered by the ballot_id column
 * @method     ChildVoter findOneByuserId(int $user_id) Return the first ChildVoter filtered by the user_id column
 * @method     ChildVoter findOneByaffiliateId(int $affiliate_id) Return the first ChildVoter filtered by the affiliate_id column
 * @method     ChildVoter findOneByCreatedAt(string $created_at) Return the first ChildVoter filtered by the created_at column
 * @method     ChildVoter findOneByUpdatedAt(string $updated_at) Return the first ChildVoter filtered by the updated_at column
 * @method     ChildVoter findOneByVersion(int $version) Return the first ChildVoter filtered by the version column
 * @method     ChildVoter findOneByVersionCreatedAt(string $version_created_at) Return the first ChildVoter filtered by the version_created_at column
 * @method     ChildVoter findOneByVersionCreatedBy(string $version_created_by) Return the first ChildVoter filtered by the version_created_by column *

 * @method     ChildVoter requirePk($key, ConnectionInterface $con = null) Return the ChildVoter by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOne(ConnectionInterface $con = null) Return the first ChildVoter matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoter requireOneByid(int $id) Return the first ChildVoter filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByballotId(int $ballot_id) Return the first ChildVoter filtered by the ballot_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByuserId(int $user_id) Return the first ChildVoter filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByaffiliateId(int $affiliate_id) Return the first ChildVoter filtered by the affiliate_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByCreatedAt(string $created_at) Return the first ChildVoter filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByUpdatedAt(string $updated_at) Return the first ChildVoter filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByVersion(int $version) Return the first ChildVoter filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildVoter filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoter requireOneByVersionCreatedBy(string $version_created_by) Return the first ChildVoter filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoter[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoter objects based on current ModelCriteria
 * @method     ChildVoter[]|ObjectCollection findByid(int $id) Return ChildVoter objects filtered by the id column
 * @method     ChildVoter[]|ObjectCollection findByballotId(int $ballot_id) Return ChildVoter objects filtered by the ballot_id column
 * @method     ChildVoter[]|ObjectCollection findByuserId(int $user_id) Return ChildVoter objects filtered by the user_id column
 * @method     ChildVoter[]|ObjectCollection findByaffiliateId(int $affiliate_id) Return ChildVoter objects filtered by the affiliate_id column
 * @method     ChildVoter[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildVoter objects filtered by the created_at column
 * @method     ChildVoter[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildVoter objects filtered by the updated_at column
 * @method     ChildVoter[]|ObjectCollection findByVersion(int $version) Return ChildVoter objects filtered by the version column
 * @method     ChildVoter[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildVoter objects filtered by the version_created_at column
 * @method     ChildVoter[]|ObjectCollection findByVersionCreatedBy(string $version_created_by) Return ChildVoter objects filtered by the version_created_by column
 * @method     ChildVoter[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoterQuery extends ModelCriteria
{

    // versionable behavior

    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MESBallotBox\Propel\Base\VoterQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MESBallotBox\\Propel\\Voter', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoterQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoterQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoterQuery) {
            return $criteria;
        }
        $query = new ChildVoterQuery();
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
     * @return ChildVoter|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoterTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VoterTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildVoter A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, ballot_id, user_id, affiliate_id, created_at, updated_at, version, version_created_at, version_created_by FROM Voter WHERE id = :p0';
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
            /** @var ChildVoter $obj */
            $obj = new ChildVoter();
            $obj->hydrate($row);
            VoterTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildVoter|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VoterTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VoterTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByid($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByballotId($ballotId = null, $comparison = null)
    {
        if (is_array($ballotId)) {
            $useMinMax = false;
            if (isset($ballotId['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_BALLOT_ID, $ballotId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ballotId['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_BALLOT_ID, $ballotId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_BALLOT_ID, $ballotId, $comparison);
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
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByuserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the affiliate_id column
     *
     * Example usage:
     * <code>
     * $query->filterByaffiliateId(1234); // WHERE affiliate_id = 1234
     * $query->filterByaffiliateId(array(12, 34)); // WHERE affiliate_id IN (12, 34)
     * $query->filterByaffiliateId(array('min' => 12)); // WHERE affiliate_id > 12
     * </code>
     *
     * @see       filterByAffiliate()
     *
     * @param     mixed $affiliateId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByaffiliateId($affiliateId = null, $comparison = null)
    {
        if (is_array($affiliateId)) {
            $useMinMax = false;
            if (isset($affiliateId['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_AFFILIATE_ID, $affiliateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($affiliateId['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_AFFILIATE_ID, $affiliateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_AFFILIATE_ID, $affiliateId, $comparison);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_VERSION, $version, $comparison);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(VoterTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(VoterTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoterTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\User object
     *
     * @param \MESBallotBox\Propel\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoterQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \MESBallotBox\Propel\User) {
            return $this
                ->addUsingAlias(VoterTableMap::COL_USER_ID, $user->getid(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoterTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \MESBallotBox\Propel\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\MESBallotBox\Propel\UserQuery');
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Affiliate object
     *
     * @param \MESBallotBox\Propel\Affiliate|ObjectCollection $affiliate The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoterQuery The current query, for fluid interface
     */
    public function filterByAffiliate($affiliate, $comparison = null)
    {
        if ($affiliate instanceof \MESBallotBox\Propel\Affiliate) {
            return $this
                ->addUsingAlias(VoterTableMap::COL_AFFILIATE_ID, $affiliate->getid(), $comparison);
        } elseif ($affiliate instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoterTableMap::COL_AFFILIATE_ID, $affiliate->toKeyValue('PrimaryKey', 'id'), $comparison);
        } else {
            throw new PropelException('filterByAffiliate() only accepts arguments of type \MESBallotBox\Propel\Affiliate or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Affiliate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function joinAffiliate($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Affiliate');

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
            $this->addJoinObject($join, 'Affiliate');
        }

        return $this;
    }

    /**
     * Use the Affiliate relation Affiliate object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\AffiliateQuery A secondary query class using the current class as primary query
     */
    public function useAffiliateQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAffiliate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Affiliate', '\MESBallotBox\Propel\AffiliateQuery');
    }

    /**
     * Filter the query by a related \MESBallotBox\Propel\Ballot object
     *
     * @param \MESBallotBox\Propel\Ballot|ObjectCollection $ballot The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoterQuery The current query, for fluid interface
     */
    public function filterByBallot($ballot, $comparison = null)
    {
        if ($ballot instanceof \MESBallotBox\Propel\Ballot) {
            return $this
                ->addUsingAlias(VoterTableMap::COL_BALLOT_ID, $ballot->getid(), $comparison);
        } elseif ($ballot instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoterTableMap::COL_BALLOT_ID, $ballot->toKeyValue('PrimaryKey', 'id'), $comparison);
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
     * @return $this|ChildVoterQuery The current query, for fluid interface
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
     * Filter the query by a related \MESBallotBox\Propel\VoterVersion object
     *
     * @param \MESBallotBox\Propel\VoterVersion|ObjectCollection $voterVersion the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVoterQuery The current query, for fluid interface
     */
    public function filterByVoterVersion($voterVersion, $comparison = null)
    {
        if ($voterVersion instanceof \MESBallotBox\Propel\VoterVersion) {
            return $this
                ->addUsingAlias(VoterTableMap::COL_ID, $voterVersion->getid(), $comparison);
        } elseif ($voterVersion instanceof ObjectCollection) {
            return $this
                ->useVoterVersionQuery()
                ->filterByPrimaryKeys($voterVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVoterVersion() only accepts arguments of type \MESBallotBox\Propel\VoterVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the VoterVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function joinVoterVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('VoterVersion');

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
            $this->addJoinObject($join, 'VoterVersion');
        }

        return $this;
    }

    /**
     * Use the VoterVersion relation VoterVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MESBallotBox\Propel\VoterVersionQuery A secondary query class using the current class as primary query
     */
    public function useVoterVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVoterVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VoterVersion', '\MESBallotBox\Propel\VoterVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVoter $voter Object to remove from the list of results
     *
     * @return $this|ChildVoterQuery The current query, for fluid interface
     */
    public function prune($voter = null)
    {
        if ($voter) {
            $this->addUsingAlias(VoterTableMap::COL_ID, $voter->getid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Voter table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoterTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoterTableMap::clearInstancePool();
            VoterTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VoterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoterTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoterTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoterTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildVoterQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(VoterTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildVoterQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(VoterTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildVoterQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(VoterTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildVoterQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(VoterTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildVoterQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(VoterTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildVoterQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(VoterTableMap::COL_CREATED_AT);
    }

    // versionable behavior

    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }

    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }

    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // VoterQuery
