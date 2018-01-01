<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PaysheetAllowanceGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Paysheet Allowance list', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	); 
	
	// Definition of headers
	protected $headers = array (
			/*'id' => array (
					'title' => 'Id',
					'width' => '50' 
			), */
			'allowanceName' => array (
					'title' => 'Allowance Name',
					'filters' => 'text' 
			),/*'affected' => array (
					'title' => 'Related/Affected Allowance',
					//'filters' => 'text' 
			),*/'companyName' => array (
					'title' => 'Company Name',
					'filters' => 'text' 
			),
			/*'edit' => array (
					'title' => 'EDIT'
			),
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyName')) { 
			$query->where ( "companyName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('allowanceName')) {
			$query->where ( "allowanceName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('affected')) {
			$query->where ( "affected like '%" . $value . "%' " ); 
		}*/ 
		/*$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/paysheetallowance/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		)); 
		$this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/paysheetallowance/delete/%s', 
				'vars' => array(
						'id'
				), 
				'txt' => '<span class="delete">Delete</span>'
		)); 
		$this->getHeader('delete')->getCell()
		     ->addDecorator('class', array('class' => 'removeaffectedAllowance')); */ 
	}
}
