<?php

namespace Etf1\ImaginizeBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'displayedNumber' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Etf1.ImaginizeBundle.Model.map
 */
class DisplayedNumberTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Etf1.ImaginizeBundle.Model.map.DisplayedNumberTableMap';

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
		$this->setName('displayedNumber');
		$this->setPhpName('DisplayedNumber');
		$this->setClassname('Etf1\\ImaginizeBundle\\Model\\DisplayedNumber');
		$this->setPackage('src.Etf1.ImaginizeBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NUMBERS', 'Numbers', 'ARRAY', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
	} // buildRelations()

} // DisplayedNumberTableMap
