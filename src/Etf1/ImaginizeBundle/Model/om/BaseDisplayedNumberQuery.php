<?php

namespace Etf1\ImaginizeBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelPDO;
use Etf1\ImaginizeBundle\Model\DisplayedNumber;
use Etf1\ImaginizeBundle\Model\DisplayedNumberPeer;
use Etf1\ImaginizeBundle\Model\DisplayedNumberQuery;

/**
 * Base class that represents a query for the 'displayedNumber' table.
 *
 * 
 *
 * @method     DisplayedNumberQuery orderById($order = Criteria::ASC) Order by the Id column
 * @method     DisplayedNumberQuery orderByNumbers($order = Criteria::ASC) Order by the Numbers column
 *
 * @method     DisplayedNumberQuery groupById() Group by the Id column
 * @method     DisplayedNumberQuery groupByNumbers() Group by the Numbers column
 *
 * @method     DisplayedNumberQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     DisplayedNumberQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     DisplayedNumberQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     DisplayedNumber findOne(PropelPDO $con = null) Return the first DisplayedNumber matching the query
 * @method     DisplayedNumber findOneOrCreate(PropelPDO $con = null) Return the first DisplayedNumber matching the query, or a new DisplayedNumber object populated from the query conditions when no match is found
 *
 * @method     DisplayedNumber findOneById(int $Id) Return the first DisplayedNumber filtered by the Id column
 * @method     DisplayedNumber findOneByNumbers(array $Numbers) Return the first DisplayedNumber filtered by the Numbers column
 *
 * @method     array findById(int $Id) Return DisplayedNumber objects filtered by the Id column
 * @method     array findByNumbers(array $Numbers) Return DisplayedNumber objects filtered by the Numbers column
 *
 * @package    propel.generator.src.Etf1.ImaginizeBundle.Model.om
 */
abstract class BaseDisplayedNumberQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseDisplayedNumberQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'imaginize', $modelName = 'Etf1\\ImaginizeBundle\\Model\\DisplayedNumber', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new DisplayedNumberQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    DisplayedNumberQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof DisplayedNumberQuery) {
			return $criteria;
		}
		$query = new DisplayedNumberQuery();
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
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    DisplayedNumber|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = DisplayedNumberPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(DisplayedNumberPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    DisplayedNumber A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `NUMBERS` FROM `displayedNumber` WHERE `ID` = :p0';
		try {
			$stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key, PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new DisplayedNumber();
			$obj->hydrate($row);
			DisplayedNumberPeer::addInstanceToPool($obj, (string) $key);
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    DisplayedNumber|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    DisplayedNumberQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(DisplayedNumberPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    DisplayedNumberQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(DisplayedNumberPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the Id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE Id = 1234
	 * $query->filterById(array(12, 34)); // WHERE Id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE Id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DisplayedNumberQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(DisplayedNumberPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the Numbers column
	 *
	 * @param     array $numbers The values to use as filter.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DisplayedNumberQuery The current query, for fluid interface
	 */
	public function filterByNumbers($numbers = null, $comparison = null)
	{
		$key = $this->getAliasedColName(DisplayedNumberPeer::NUMBERS);
		if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
			foreach ($numbers as $value) {
				$value = '%| ' . $value . ' |%';
				if($this->containsKey($key)) {
					$this->addAnd($key, $value, Criteria::LIKE);
				} else {
					$this->add($key, $value, Criteria::LIKE);
				}
			}
			return $this;
		} elseif ($comparison == Criteria::CONTAINS_SOME) {
			foreach ($numbers as $value) {
				$value = '%| ' . $value . ' |%';
				if($this->containsKey($key)) {
					$this->addOr($key, $value, Criteria::LIKE);
				} else {
					$this->add($key, $value, Criteria::LIKE);
				}
			}
			return $this;
		} elseif ($comparison == Criteria::CONTAINS_NONE) {
			foreach ($numbers as $value) {
				$value = '%| ' . $value . ' |%';
				if($this->containsKey($key)) {
					$this->addAnd($key, $value, Criteria::NOT_LIKE);
				} else {
					$this->add($key, $value, Criteria::NOT_LIKE);
				}
			}
			$this->addOr($key, null, Criteria::ISNULL);
			return $this;
		}
		return $this->addUsingAlias(DisplayedNumberPeer::NUMBERS, $numbers, $comparison);
	}

	/**
	 * Filter the query on the Numbers column
	 * @param     mixed $numbers The value to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
	 *
	 * @return    DisplayedNumberQuery The current query, for fluid interface
	 */
	public function filterByNumber($numbers = null, $comparison = null)
	{
		if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
			if (is_scalar($numbers)) {
				$numbers = '%| ' . $numbers . ' |%';
				$comparison = Criteria::LIKE;
			}
		} elseif ($comparison == Criteria::CONTAINS_NONE) {
			$numbers = '%| ' . $numbers . ' |%';
			$comparison = Criteria::NOT_LIKE;
			$key = $this->getAliasedColName(DisplayedNumberPeer::NUMBERS);
			if($this->containsKey($key)) {
				$this->addAnd($key, $numbers, $comparison);
			} else {
				$this->addAnd($key, $numbers, $comparison);
			}
			$this->addOr($key, null, Criteria::ISNULL);
			return $this;
		}
		return $this->addUsingAlias(DisplayedNumberPeer::NUMBERS, $numbers, $comparison);
	}

	/**
	 * Exclude object from result
	 *
	 * @param     DisplayedNumber $displayedNumber Object to remove from the list of results
	 *
	 * @return    DisplayedNumberQuery The current query, for fluid interface
	 */
	public function prune($displayedNumber = null)
	{
		if ($displayedNumber) {
			$this->addUsingAlias(DisplayedNumberPeer::ID, $displayedNumber->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseDisplayedNumberQuery