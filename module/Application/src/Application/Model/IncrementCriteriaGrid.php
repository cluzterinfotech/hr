<?php 

namespace Application\Model;

use ZfTable\AbstractTable;

class IncrementCriteriaGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Increment Criteria list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 20,
			'showColumnFilters' => true 
	);  
	
	// Definition of headers 
	protected $headers = array ( 
            
			'Year' => array (
					'title' => 'Year',
					'filters' => 'text',
					'width' => '120'
			),
			'incrementFrom' => array (
					'title' => 'Increment From',
					'width' => '100'
					//'filters' => 'text' 
			),
			'joinDate' => array (
					'title' => 'Join Date', 
					'width' => '100' 
					//'filters' => 'text'
			),
			'confirmationDate' => array (
					'title' => 'Confirmation Date',
					'width' => '100'
					//'filters' => 'text' 
			),
			'colaPercentage' => array (
					'title' => 'Cola %',
					'width' => '100'
					//'filters' => 'text' 
			),'incrementAveragePercentage' => array (
					'title' => 'Average %',
					'width' => '100'
					//'filters' => 'text' 
			),
			'edit' => array (
					'title' => 'EDIT',
					'width' => '100'
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}*/ 
		if ($value = $this->getParamAdapter()->getValueOfFilter('Year')) {
			$query->where ( "Year like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('minValue')) {
			$query->where ( "minValue like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('midValue')) {
			$query->where ( "midValue like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('maxValue')) {
			$query->where ( "maxValue like '%" . $value . "%' " );
		} */
		$this->getHeader('edit')->getCell()->addDecorator('link', array(
				'url' => '/incrementcriteria/edit/%s',
				'vars' => array (
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
