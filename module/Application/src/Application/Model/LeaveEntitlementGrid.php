<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class LeaveEntitlementGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Annual Leave Entitlement list',
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
			'yearsOfService' => array (
				'title' => 'Years Of service',
				'filters' => 'text' 
			),
			'numberOfDays' => array (
					'title' => 'Number Of Days',
					'filters' => 'text' 
			),'companyName' => array (
					'title' => 'Company',
					'filters' => 'text' 
			),
			'edit' => array (
					'title' => 'EDIT'
			)/* ,
			'delete' => array (
					'title' => 'DELETE',
					'width' => '50'
			) */
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	; 
	public function init() { }
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('yearsOfService')) {
			$query->where ( "yearsOfService like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('numberOfDays')) {
			$query->where("numberOfDays like '%" . $value . "%' ");
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyName')) {
			$query->where("companyName like '%" . $value . "%' "); 
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/entitlementannualleave/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		));
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
