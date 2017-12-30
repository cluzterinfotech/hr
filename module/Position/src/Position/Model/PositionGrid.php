<?php
/**
 * @access public
 * @author dhayal
 */
class PositionGrid {
	private $config = array (
			'name' => 'Filtering by column',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	);
	private $headers = array (
			'positionId' => array (
					'title' => 'Id',
					'width' => '50' 
			),
			'positionName' => array (
					'title' => 'Position Name',
					'filters' => 'text' 
			),
			'positionCode' => array (
					'title' => 'Position Code',
					'filters' => 'text' 
			),
			'sectionId' => array (
					'title' => 'Section',
					'filters' => 'text' 
			) 
	);

	/**
	 * @access public
	 */
	public function init() {
		// Not yet implemented
	}

	/**
	 * @access protected
	 * @param query
	 */
	protected function initFilters($query) {
		// Not yet implemented
	}
}
?>