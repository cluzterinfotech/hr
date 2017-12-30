<?php 
namespace Application\Model;

use ZfTable\AbstractTable;

class OtManualEntryGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Over time List', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true,
			//'rowAction' => '/overtimenew/updateotrow',
	);
	
	// Definition of headers 
	protected $headers = array ( 
            /*'employeeName' => array (
			    'title' => 'Employee Name',
				'filters' => 'text' 
			),*/
			'employeeName' => array (
				'title' => 'Employee Name',
				'filters' => 'text' 
			),        
			'employeeNoNOHours' => array (
				'title' => 'Normal Hours', 
				//'filters' => 'text'
			),'employeeNoHOHours' => array (
				'title' => 'Holiday Hours',  
				//'filters' => 'text'
			),'numberOfMeals' => array (
				'title' => 'Number Of Meals',  
				//'filters' => 'text'
			),'startingDate' => array (
				'title' => 'Starting Date',  
				//'filters' => 'text'
			),'endingDate' => array (
				'title' => 'Ending Date', 
				//'editable' => true
				//'filters' => 'text'
			),
    	    'remove' => array (
    	        'title' => 'REMOVE'
    	    )
			/*'delete' => array (
				'title' => 'DELETE',
				'width' => '50' 
			)*/ 
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;  
	public function init() { 
		//$this->getHeader('normalHour')->getCell()->addDecorator('editable');
		//$this->getHeader('holidayHour')->getCell()->addDecorator('editable');
		//$this->getHeader('noOfMeals')->getCell()->addDecorator('editable'); 
		//$this->getRow()->addDecorator('varattr',
				//array('name' => 'data-row' , 'value' => '%s' , 'vars' => array('id')));
	}
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		} 
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('month')) {
			$query->where ( "month like '%" . $value . "%' " );
		}
        if ($value = $this->getParamAdapter()->getValueOfFilter('year')) {
			$query->where ( "year like '%" . $value . "%' " );
		}*/
        
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/overtimemanual/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeMOvertime')); 	 
	}
} 
