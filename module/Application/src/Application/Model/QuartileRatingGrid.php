<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class QuartileRatingGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Quartile Rating list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 20,
			'showColumnFilters' => true 
	); 
	
	// Definition of headers 
	protected $headers = array (
			/*'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),*/
			'Rating' => array (
					'title' => 'Rating',
					'filters' => 'text',
					'width' => '120'
			),
			'quartileOne' => array (
					'title' => 'Quartile One',
					'width' => '100'
					//'filters' => 'text' 
			),
			'quartileTwo' => array (
					'title' => 'Quartile Two',
					'width' => '100'
					//'filters' => 'text' 
			),
			'quartileThree' => array (
					'title' => 'Quartile Three',
					'width' => '100'
					//'filters' => 'text' 
			),'quartileFour' => array (
					'title' => 'Quartile Four',
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('Rating')) {
			$query->where ( "Rating like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('quartileOne')) {
			$query->where ( "quartileOne like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('quartileTwo')) {
			$query->where ( "quartileTwo like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('quartileThree')) {
			$query->where ( "quartileThree like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('quartileFour')) {
			$query->where ( "quartileFour like '%" . $value . "%' " );
		}  
		$this->getHeader('edit')->getCell()->addDecorator('link', array(
				'url' => '/quartilerating/edit/%s',
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
