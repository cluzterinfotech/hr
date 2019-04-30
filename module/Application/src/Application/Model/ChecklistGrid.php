<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class ChecklistGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Check list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			/*'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),*/
			'controller' => array (
					'title' => 'Process',
					'filters' => 'text' 
			),
			'relatedController' => array (
					'title' => 'Process To Close Before',
					//'filters' => 'text' 
			),
			//checkListType
			'checkListType' => array (
					'title' => 'Process Type',
					//'filters' => 'text'
			),
			'companyName' => array (
					'title' => 'Company',
					'filters' => 'text' 
			),
			/*'edit' => array (
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('controller')) {
			$query->where ( "controller like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyName')) {
			$query->where ( "companyName like '%" . $value . "%' " ); 
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('idCard')) {
			$query->where("idCard like '%" . $value . "%' ");
		}
		$this->getHeader('edit')->getCell()->addDecorator('link',array(
				'url' => '/employeeidcard/edit/%s',
				'vars' => array(
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
