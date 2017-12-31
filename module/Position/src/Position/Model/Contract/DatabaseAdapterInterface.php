<?php
/**
 * @access public
 * @author dhayal
 * @package Contract
 */
interface DatabaseAdapterInterface {

	/**
	 * @access public
	 */
	public function connect();

	/**
	 * @access public
	 */
	public function disconnect();

	/**
	 * @access public
	 * @param sql
	 * @param array options
	 * 
	 * @ParamType options array
	 */
	public function prepare($sql, array_47 $options = array());

	/**
	 * @access public
	 * @param array parameters
	 * @ParamType parameters array
	 */
	public function execute(array_48 $parameters = array());

	/**
	 * @access public
	 * @param fetchStyle
	 * @param cursorOrientation
	 * @param cursorOffset
	 */
	public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null);

	/**
	 * @access public
	 * @param fetchStyle
	 * @param column
	 */
	public function fetchAll($fetchStyle = null, $column = 0);

	/**
	 * @access public
	 * @param table
	 * @param array bind
	 * @param boolOperator
	 * 
	 * @ParamType bind array
	 */
	public function select($table, array_49 $bind, $boolOperator = "AND");

	/**
	 * @access public
	 * @param table
	 * @param array bind
	 * 
	 * @ParamType bind array
	 */
	public function insert($table, array_50 $bind);

	/**
	 * @access public
	 * @param table
	 * @param array bind
	 * @param where
	 * 
	 * @ParamType bind array
	 */
	public function update($table, array_51 $bind, $where = "");

	/**
	 * @access public
	 * @param table
	 * @param where
	 */
	public function delete($table, $where = "");
}
?>