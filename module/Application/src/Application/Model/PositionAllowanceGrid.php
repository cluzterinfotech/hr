<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PositionAllowanceGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Position Allowance ',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	); 
	
	// Definition of headers 
	protected $headers = array (
			/* 'id' => array (
				'title' => 'Id',
				'width' => '50' 
			), */ 
			/*'empType' => array (
					'title' => 'Title',
					'filters' => 'text'
			),*/
			'positionName' => array (
				'title' => 'Position Name',
				'filters' => 'text' 
			),'allowanceName' => array (
				'title' => 'Allowance',
				'filters' => 'text' 
			),
			'companyName' => array (
				'title' => 'Company',
				'filters' => 'text'
			), 
			/*'adjustedAmount' => array (
					'title' => 'New Salary',
					//'filters' => 'text'
			),*/ 
			'edit' => array (
				'title' => 'DELETE',
				'width' => '50'
			), 
		    /*'remove' => array (
				'title' => 'DELETE' 
			)/*,   
			'delete' => array (
				'title' => 'DELETE',
				'width' => '50'
			) */ 
	)
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;  
	public function init() { }
	
	protected function initFilters($query) {
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "e.id like '%" . $value . "%' " );
		}*/
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('empType')) {
			$query->where ( "empType like '%" . $value . "%' " );
		} */
		if ($value = $this->getParamAdapter()->getValueOfFilter('allowanceName')) {
			$query->where ( "allowanceName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('positionName')) {
			$query->where ( "positionName like '%" . $value . "%' " );
		} 
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyName')) {
			$query->where ( "companyName like '%" . $value . "%' " );
		} 
		$this->getHeader('edit')->getCell()->addDecorator('link', array(
				'url' => '/positionallowance/updateexisting/%s', 
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		));  
		$this->getHeader('edit')->getCell()
		     ->addDecorator('class', array('class' => 'editPositionAllowanceRow'));
		/*$this->getHeader('remove')->getCell()->addDecorator('link', array ( 
				'url' => '/positionallowance/delete/%s', 
				'vars' => array ( 
						'id'  
				), 
				'txt' => 'Delete'  
		)); 
		$this->getHeader('remove')->getCell() 
		     ->addDecorator('class', array('class' => 'removePositionAllowanceRow')); 
		*/
		
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */  
	} 
} 