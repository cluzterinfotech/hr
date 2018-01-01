<?php 
namespace Application\Model;

use ZfTable\AbstractTable;

class AttendanceGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Attendance List (Enter HH.MM format)', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true,
			'rowAction' => '/overtimenew/updateotrow',
	);
	
	// Definition of headers 
	protected $headers = array ( 
            /*'employeeName' => array (
			    'title' => 'Employee Name',
				'filters' => 'text' 
			),*/
			'attendanceDate' => array (
				'title' => 'Date',
				//'filters' => 'text' 
			),        
			'startingTime' => array (
				'title' => 'In Time', 
				//'filters' => 'text'
			),'endingTime' => array (
				'title' => 'Out Time',  
				//'filters' => 'text'
			),'duration' => array (
				'title' => 'Total Hrs',  
				//'filters' => 'text'
			),'difference' => array (
				'title' => 'OT Hrs',  
				//'filters' => 'text'
			),'normalHour' => array (
				'title' => 'Actual OT', 
				'editable' => true
				//'filters' => 'text'
			),'holidayHour' => array (
				'title' => 'Actual Holiday OT',  
				'editable' => true
				//'filters' => 'text'
			),'noOfMeals' => array (
				'title' => 'No. Of Meal',  
				'editable' => true
				//'filters' => 'text'
			), 
			/*'edit' => array (
				'title' => 'EDIT'
			),*/
			/*'delete' => array (
				'title' => 'DELETE',
				'width' => '50' 
			)*/ 
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;  
	public function init() { 
		$this->getHeader('normalHour')->getCell()->addDecorator('editable');
		$this->getHeader('holidayHour')->getCell()->addDecorator('editable');
		$this->getHeader('noOfMeals')->getCell()->addDecorator('editable'); 
		$this->getRow()->addDecorator('varattr',
				array('name' => 'data-row' , 'value' => '%s' , 'vars' => array('id')));
	}
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		} 
		if ($value = $this->getParamAdapter()->getValueOfFilter('month')) {
			$query->where ( "month like '%" . $value . "%' " );
		}
        if ($value = $this->getParamAdapter()->getValueOfFilter('year')) {
			$query->where ( "year like '%" . $value . "%' " );
		}
        
		/*$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/overtimenew/edit/%s', 
				'vars' => array ('id'),
				'txt' => 'Edit/Update'
		));  
		$this->getHeader('edit')->getCell()
		     ->addDecorator('class', array('class' => 'editOvertime'));*/ 
		 
	}
} 
