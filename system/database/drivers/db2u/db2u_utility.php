<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * DB2 (Uncataloged) Utility Class
 *
 * @category	Database
 * @author		Drew Harvey
 * @link		http://www.codeigniter.com/user_guide/database/
 */
class CI_DB_db2u_utility extends CI_DB_utility {

	/**
	 * Create database
	 *
	 * @access	private
	 * @param	string	the database name
	 * @return	bool
	 */
	function _create_database($name)
	{
		return "CREATE COLLECTION " . $name;
	}

	// --------------------------------------------------------------------

	/**
	 * Drop database
	 *
	 * @access	private
	 * @param	string	the database name
	 * @return	bool
	 */
	function _drop_database($name)
	{
		return "DROP COLLECTION " . $name;
	}

	// --------------------------------------------------------------------

	/**
	 * List databases
	 *
	 * @access	private
	 * @return	bool
	 */
	function _list_databases()
	{
		// Not Supported via SQL (Requires CLI)
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Drop Table
	 *
	 * @access	private
	 * @return	bool
	 */
	function _drop_table($table)
	{
		return "DROP TABLE " . $this->db->_escape_table($table);
	}

	// --------------------------------------------------------------------

	/**
	 * Optimize table query
	 *
	 * Generates a platform-specific query so that a table can be optimized
	 *
	 * @access	private
	 * @param	string	the table name
	 * @return	object
	 */
	function _optimize_table($table)
	{
		// Not Supported via SQL (Requires CLI)
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Repair table query
	 *
	 * Generates a platform-specific query so that a table can be repaired
	 *
	 * @access	private
	 * @param	string	the table name
	 * @return	object
	 */
	function _repair_table($table)
	{
		// Not Supported
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * DB2 Export
	 *
	 * @access	private
	 * @param	array	Preferences
	 * @return	mixed
	 */
	function _backup($params = array())
	{
		// Not Currently Supported
		return FALSE;
	}

}

?>