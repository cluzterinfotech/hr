<?php
require_once(realpath(dirname(__FILE__)) . '/../Contract/DatabaseAdapterInterface.php');

/**
 * @access public
 * @author dhayal
 * @package Model
 */
class PdoAdapter implements DatabaseAdapterInterface {
	private $config = array ();
	private $connection;
	private $statement;
	private $fetchMode = PDO::FETCH_ASSOC;

	/**
	 * @access public
	 * @param dsn
	 * @param username
	 * @param password
	 * @param array driverOptions
	 * 
	 * 
	 * 
	 * @ParamType driverOptions array
	 */
	public function __construct($dsn, $username = null, $password = null, array_40 $driverOptions = array()) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function getStatement() {
		return $this->statement;
	}

	/**
	 * @access public
	 */
	public function connect() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function disconnect() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param sql
	 * @param array options
	 * 
	 * @ParamType options array
	 */
	public function prepare($sql, array_41 $options = array()) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param array parameters
	 * @ParamType parameters array
	 */
	public function execute(array_42 $parameters = array()) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function countAffectedRows() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param name
	 */
	public function getLastInsertId($name = null) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param fetchStyle
	 * @param cursorOrientation
	 * @param cursorOffset
	 */
	public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param fetchStyle
	 * @param column
	 */
	public function fetchAll($fetchStyle = null, $column = 0) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param table
	 * @param array bind
	 * @param boolOperator
	 * 
	 * @ParamType bind array
	 */
	public function select($table, array_43 $bind = array(), $boolOperator = "AND") {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param table
	 * @param array bind
	 * 
	 * @ParamType bind array
	 */
	public function insert($table, array_44 $bind) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param table
	 * @param array bind
	 * @param where
	 * 
	 * @ParamType bind array
	 */
	public function update($table, array_45 $bind, $where = "") {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param table
	 * @param where
	 */
	public function delete($table, $where = "") {
		// Not yet implemented
	}
}
?>