<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class OvertimeBatchGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Overtime List', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			'ID' => array (
					'title' => 'Id',
					'width' => '50' 
			),
                        'Month' => array (
					'title' => 'Month',
					'filters' => 'text' 
			),
                        'IsPosted' => array (
					'title' => 'IsPosted',
					'filters' => 'text' 
			),
			'remove' => array (
					'title' => 'REMOVE'
			),
			'apply' => array (
					'title' => 'APPLY',
					'width' => '50' 
			) 
	); 
	public function init() { }
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('ID')) {
			$query->where ( "ID like '%" . $value . "%' " );
		}
                if ($value = $this->getParamAdapter()->getValueOfFilter('Month')) {
			$query->where ( "Month like '%" . $value . "%' " );
		}
                if ($value = $this->getParamAdapter()->getValueOfFilter('IsPosted')) {
			$query->where ( "IsPosted like '%" . $value . "%' " );
		}
		
		
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/overtime/removebatch/%s',
				'vars' => array (
						'ID'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeOvertimeBatch')); 
//***************************Apply****************************************
                
		$this->getHeader('apply')->getCell()->addDecorator('link', array (
				'url' => '/overtime/apply/%s',
				'vars' => array (
						'ID'
				),
				'txt' => 'Apply'
		)); 
		$this->getHeader('apply')->getCell()
		     ->addDecorator('class', array('class' => 'applyOvertime')); 
	}
} 
