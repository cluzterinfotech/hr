<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class BonusCriteriaGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Bonus Criteria list',
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
			'ratingTwo' => array (
					'title' => 'Rating Two',
					//'filters' => 'text'
			),'ratingH3'=> array (
					'title' => 'Rating H3',
					//'filters' => 'text'
			),'ratingS3'=> array (
					'title' => 'Rating S3',
					//'filters' => 'text'
			),'ratingM3'=> array (
					'title' => 'Rating M3',
					//'filters' => 'text'
			),'year' => array (
					'title' => 'Year',
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}*/ 
		if ($value = $this->getParamAdapter()->getValueOfFilter('year')) {
			$query->where ( "year like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('amount')) {
			$query->where ( "amount like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('Notes')) {
			$query->where ( "Notes like '%" . $value . "%' " );
		}*/
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/bonuscriteria/edit/%s', 
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
