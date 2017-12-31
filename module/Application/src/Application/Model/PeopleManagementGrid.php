<?php 

namespace Application\Model;

use ZfTable\AbstractTable;

class PeopleManagementGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'People Manangement And Staff Involvement list', 
			'showPagination'    => true,
			'showQuickSearch'   => false,
			'showItemPerPage'   => true,
			'itemCountPerPage'  => 10,
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			/*'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),*/
			'LbvfName' => array (
					'title' => 'LBVF', 
					'filters' => 'text' 
			),
			'edit' => array (
					'title' => 'EDIT'
			) 
	) 
	// Staff Involvement (Events)
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;  
	public function init() { }
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('LbvfName')) {
			$query->where ( "LbvfName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('overtimeHour')) {
			$query->where ( "overtimeHour like '%" . $value . "%' " );
		}*/ 
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/peoplemanagement/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		)); 
	}
}   