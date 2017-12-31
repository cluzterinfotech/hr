<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class OtmealGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Overtime Meal',  
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
//			'overtimeMstId' => array (
//					'title' => 'Id',
//					'width' => '50' 
//			),
            'employeeName' => array (
				'title' => 'Emaployee Name',
				'filters' => 'text' ,
                'width' => '50' 
			),
            'amount' => array (
			    'title' => 'Amount',
				'filters' => 'text' 
			),
			'numberOfMeals' => array (
				'title' => 'No. of Meals',
				'filters' => 'text' 
			),           
			/*'Total_Meal_Amount' => array (
					'title' => 'Total of Meal Amount',
					'filters' => 'text'
			),*/
			'remove' => array (
				'title' => 'REMOVE'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('OvertimeMealMstId')) {
			$query->where ( "OvertimeMealMstId like '%" . $value . "%' " );
		}
        if ($value = $this->getParamAdapter()->getValueOfFilter('amount')) {
			$query->where ( "amount like '%" . $value . "%' " );
		}
        if ($value = $this->getParamAdapter()->getValueOfFilter('numberOfMeals')) {
			$query->where ( "numberOfMeals like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('Total_Meal_Amount')) {
			$query->where ( "Total_Meal_Amount like '%" . $value . "%' " );
		}*/
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/otmeal/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeOvertimeMeal')); 
	}
} 
