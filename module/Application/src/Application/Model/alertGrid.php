<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class alertGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Alerts list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			'id' => array (
					'title' => 'id',
					'width' => '20' 
			),
			'alertId' => array (
					'title' => 'alertId',
					'filters' => 'text' ,
			         'width' => '60' 
			),
			'positionName' => array (
					'title' => 'positionName',
					'filters' => 'text' ,
			         'width' => '60' 
			),
			'formula' => array (
					'title' => 'Days Befor',
					'filters' => 'text' ,
			         'width' => '60' 
			),			
	       'isCC' => array (
					'title' => 'isCC',
			),
		/*'edit' => array (
					'title' => 'EDIT'
			),*/
	       'delete' => array (
					'title' => 'DELETE'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('alertType')) {
			$query->where ( "alertType like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('positionName')) {
			$query->where ( "positionName like '%" . $value . "%' " );
		}
		
	/*	$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/policymanual/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		) );*/
		$this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/alert/deletealert/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		));
	}
}
