<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class BankGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Bank list',
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
			'bankName' => array (
					'title' => 'Bank Name',
					'filters' => 'text' 
			),
			'branch' => array (
					'title' => 'Branch',
					'filters' => 'text' 
			),'accountNumber' => array (
					'title' => 'Account Number',
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('bankName')) {
			$query->where ( "bankName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('branch')) {
			$query->where ( "branch like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('accountNumber')) {
			$query->where ( "accountNumber like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/bank/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		) );
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
