<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class OtmealBatchGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Overtime Meal List', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			'OvertimeMealMstId' => array (
					'title' => 'OvertimeMealMstId',
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('OvertimeMealMstId')) {
			$query->where ( "OvertimeMealMstId like '%" . $value . "%' " );
		}
                if ($value = $this->getParamAdapter()->getValueOfFilter('Month')) {
			$query->where ( "Month like '%" . $value . "%' " );
		}
                if ($value = $this->getParamAdapter()->getValueOfFilter('IsPosted')) {
			$query->where ( "IsPosted like '%" . $value . "%' " );
		}
		
		
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/otmeal/removebatch/%s',
				'vars' => array (
						'OvertimeMealMstId'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeOvertimeBatch')); 
//***************************Apply****************************************
                
		$this->getHeader('apply')->getCell()->addDecorator('link', array (
				'url' => '/otmeal/apply/%s',
				'vars' => array (
						'OvertimeMealMstId'
				),
				'txt' => 'Apply'
		)); 
		$this->getHeader('apply')->getCell()
		     ->addDecorator('class', array('class' => 'applyOvertime')); 
	}
} 
