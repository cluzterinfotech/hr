<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class UserCompanyPositionGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'User (Company and Position)', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	); 
	
	// Definition of headers 
	protected $headers = array (
			'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),
			'positionName' => array (
					'title' => 'Position Name',
					'filters' => 'text' 
			),'companyName' => array (
					'title' => 'Company Name',
					'filters' => 'text' 
			), 
			'edit' => array (
					'title' => 'EDIT'
			),
			'delete' => array (
					'title' => 'DELETE',
					'width' => '50'
			)
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	; 
	public function init() { }
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyName')) {
			$query->where ( "companyName like '%" . $value . "%' " );
		}if ($value = $this->getParamAdapter()->getValueOfFilter('positionName')) {
			$query->where ( "positionName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('branch')) {
			$query->where ( "branch like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('accountNumber')) {
			$query->where ( "accountNumber like '%" . $value . "%' " );
		}*/
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/usercompanyposition/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		)); 
		$this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/usercompanyposition/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); 
	}
}
