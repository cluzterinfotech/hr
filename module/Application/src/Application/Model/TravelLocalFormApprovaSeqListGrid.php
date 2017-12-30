<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class TravelLocalFormApprovaSeqListGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Traveling Form Approval Sequence List',
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
			'ApprovalLevelName' => array (
					'title' => 'Approval Level', 
					'filters' => 'text'
			), 
			'ApprovalSequence' => array (
					'title' => 'Approval Sequence',
					'filters' => 'text' 
			)/*,
			'effectiveTo' => array (
					'title' => 'Travel To Date',
					'filters' => 'text'
			),
			'edit' => array (
					'title' => 'Approve Form'
			)*/ 
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;  
	public function init() { }
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('ApprovalLevelName')) { 
			$query->where ( "ApprovalLevelName like '%" . $value . "%' " ); 
		} 
		if ($value = $this->getParamAdapter()->getValueOfFilter('ApprovalSequence')) {
			$query->where ( "ApprovalSequence like '%" . $value . "%' " );
		} 
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('effectiveTo')) {
			$query->where ( "effectiveTo like '%" . $value . "%' " );
		} 
		/*$this->getHeader('edit')->getCell()->addDecorator('template', array(
				'template' => '<a href="/travelinglocal/approve/%s" >Approve</a>',
				'vars' => array('id','id')
		)); */
		//$this->getHeader('edit')->getCell()->addAttr('target', '_blank');
		//$this->getHeader('edit')->getCell()->addAttr('display', 'block');
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
} 