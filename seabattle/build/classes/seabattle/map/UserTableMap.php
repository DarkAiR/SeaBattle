<?php



/**
 * This class defines the structure of the 'user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.seabattle.map
 */
class UserTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'seabattle.map.UserTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
		// attributes
		$this->setName('user');
		$this->setPhpName('User');
		$this->setClassname('User');
		$this->setPackage('seabattle');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('LOGIN', 'Login', 'VARCHAR', true, 128, null);
		$this->addColumn('PASSWORD', 'Password', 'VARCHAR', true, 32, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('User2Room', 'User2Room', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'User2Rooms');
		$this->addRelation('Field', 'Field', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Fields');
	} // buildRelations()

} // UserTableMap
