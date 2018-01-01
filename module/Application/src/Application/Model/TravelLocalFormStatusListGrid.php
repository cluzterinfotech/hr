<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class TravelLocalFormStatusListGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Traveling Form Approval List',
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
			'employeeName' => array (
					'title' => 'Employee Name',
					'filters' => 'text'
			),
			/*'employeeId' => array (
					'title' => 'Employee Number',
					'filters' => 'text' 
			),*/ 
			'effectiveFrom' => array (
					'title' => 'Travel From Date',
					'filters' => 'text' 
			),
			'effectiveTo' => array (
					'title' => 'Travel To Date',
					'filters' => 'text'
			),
			'edit' => array (
					'title' => 'Approve Form'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) { 
			$query->where ( "employeeName like '%" . $value . "%' " ); 
		} 
		if ($value = $this->getParamAdapter()->getValueOfFilter('effectiveFrom')) {
			$query->where ( "effectiveFrom like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('effectiveTo')) {
			$query->where ( "effectiveTo like '%" . $value . "%' " );
		}
		
		/*$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/travelinglocal/approve/%s', 
				'vars' => array (
						'id'
				),
				'txt' => 'Approve',
				//'target' => '_blank'
		)); */
		// target="_blank" 
		$this->getHeader('edit')->getCell()->addDecorator('template', array(
				'template' => '<a href="/travelinglocal/approve/%s" >Approve</a>',
				'vars' => array('id','id')
		)); 
		//$this->getHeader('edit')->getCell()->addAttr('target', '_blank');
		//$this->getHeader('edit')->getCell()->addAttr('display', 'block');
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
