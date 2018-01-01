<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class InstructionGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'LBVF Instruction list',
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
			'LbvfName' => array (
					'title' => 'LBVF Name',
					'filters' => 'text' 
			),
			'DeadLine' => array (
					'title' => 'Dead Line Nomination & Endorsement',
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('LbvfName')) {
			$query->where ( "LbvfName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('DeadLine')) {
			$query->where ( "DeadLine like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/instruction/edit/%s',
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
