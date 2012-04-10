<?php


/**
 * Base class that represents a query for the 'room' table.
 *
 * 
 *
 * @method     RoomQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     RoomQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     RoomQuery orderByTimeStamp($order = Criteria::ASC) Order by the time_stamp column
 *
 * @method     RoomQuery groupById() Group by the id column
 * @method     RoomQuery groupByState() Group by the state column
 * @method     RoomQuery groupByTimeStamp() Group by the time_stamp column
 *
 * @method     RoomQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     RoomQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     RoomQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     RoomQuery leftJoinUser2Room($relationAlias = null) Adds a LEFT JOIN clause to the query using the User2Room relation
 * @method     RoomQuery rightJoinUser2Room($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User2Room relation
 * @method     RoomQuery innerJoinUser2Room($relationAlias = null) Adds a INNER JOIN clause to the query using the User2Room relation
 *
 * @method     Room findOne(PropelPDO $con = null) Return the first Room matching the query
 * @method     Room findOneOrCreate(PropelPDO $con = null) Return the first Room matching the query, or a new Room object populated from the query conditions when no match is found
 *
 * @method     Room findOneById(int $id) Return the first Room filtered by the id column
 * @method     Room findOneByState(int $state) Return the first Room filtered by the state column
 * @method     Room findOneByTimeStamp(string $time_stamp) Return the first Room filtered by the time_stamp column
 *
 * @method     array findById(int $id) Return Room objects filtered by the id column
 * @method     array findByState(int $state) Return Room objects filtered by the state column
 * @method     array findByTimeStamp(string $time_stamp) Return Room objects filtered by the time_stamp column
 *
 * @package    propel.generator.seabattle.om
 */
abstract class BaseRoomQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseRoomQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'Room', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new RoomQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    RoomQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof RoomQuery) {
			return $criteria;
		}
		$query = new RoomQuery();
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
	 * @return    Room|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = RoomPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(RoomPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    Room A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `STATE`, `TIME_STAMP` FROM `room` WHERE `ID` = :p0';
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
			$obj = new Room();
			$obj->hydrate($row);
			RoomPeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    Room|array|mixed the result, formatted by the current formatter
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
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(RoomPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(RoomPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(RoomPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the state column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByState(1234); // WHERE state = 1234
	 * $query->filterByState(array(12, 34)); // WHERE state IN (12, 34)
	 * $query->filterByState(array('min' => 12)); // WHERE state > 12
	 * </code>
	 *
	 * @param     mixed $state The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function filterByState($state = null, $comparison = null)
	{
		if (is_array($state)) {
			$useMinMax = false;
			if (isset($state['min'])) {
				$this->addUsingAlias(RoomPeer::STATE, $state['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($state['max'])) {
				$this->addUsingAlias(RoomPeer::STATE, $state['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RoomPeer::STATE, $state, $comparison);
	}

	/**
	 * Filter the query on the time_stamp column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTimeStamp('2011-03-14'); // WHERE time_stamp = '2011-03-14'
	 * $query->filterByTimeStamp('now'); // WHERE time_stamp = '2011-03-14'
	 * $query->filterByTimeStamp(array('max' => 'yesterday')); // WHERE time_stamp > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $timeStamp The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function filterByTimeStamp($timeStamp = null, $comparison = null)
	{
		if (is_array($timeStamp)) {
			$useMinMax = false;
			if (isset($timeStamp['min'])) {
				$this->addUsingAlias(RoomPeer::TIME_STAMP, $timeStamp['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($timeStamp['max'])) {
				$this->addUsingAlias(RoomPeer::TIME_STAMP, $timeStamp['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RoomPeer::TIME_STAMP, $timeStamp, $comparison);
	}

	/**
	 * Filter the query by a related User2Room object
	 *
	 * @param     User2Room $user2Room  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function filterByUser2Room($user2Room, $comparison = null)
	{
		if ($user2Room instanceof User2Room) {
			return $this
				->addUsingAlias(RoomPeer::ID, $user2Room->getRoomId(), $comparison);
		} elseif ($user2Room instanceof PropelCollection) {
			return $this
				->useUser2RoomQuery()
				->filterByPrimaryKeys($user2Room->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByUser2Room() only accepts arguments of type User2Room or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the User2Room relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function joinUser2Room($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('User2Room');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'User2Room');
		}

		return $this;
	}

	/**
	 * Use the User2Room relation User2Room object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    User2RoomQuery A secondary query class using the current class as primary query
	 */
	public function useUser2RoomQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUser2Room($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'User2Room', 'User2RoomQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Room $room Object to remove from the list of results
	 *
	 * @return    RoomQuery The current query, for fluid interface
	 */
	public function prune($room = null)
	{
		if ($room) {
			$this->addUsingAlias(RoomPeer::ID, $room->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseRoomQuery