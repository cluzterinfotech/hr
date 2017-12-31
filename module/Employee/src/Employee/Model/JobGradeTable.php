<?php

namespace Employee\Model;

use Employee\Model\JobGrade;

/**
 * Description of JobGradeTable
 *
 * @author Wol
 */
class JobGradeTable {
	private $tableGateway;
	public function __construct($tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function saveJobGrade(JobGrade $jobGrade) {
		$data = array (
				'lkpJobGradeId' => $jobGrade->getLkpJobGradeId (),
				'jobGradeId' => $jobGrade->getJobGradeId () 
		);
		
		if (empty ( $data ['lkpJobGradeId'] )) {
			$data ['lkpJobGradeId'] = 0;
			$this->tableGateway->insert ( $data );
		} else {
			$id = $data ['lkpJobGradeId'];
			$this->tableGateway->update ( $data, array (
					'lkpJobGradeId' => $id 
			) );
		}
		
		return true;
	}
	public function fetchJobGrade($id) {
		$grade = $this->tableGateway->select ( array (
				'lkpJobGradeId' => $id 
		) );
		return $grade->current ();
	}
	public function deleteJobGrade($id) {
		$this->tableGateway->delete ( array (
				'lkpJobGradeId' => $id 
		) );
		return true;
	}
	public function fetchAll() {
		$data = $this->tableGateway->select ();
		return $data;
	}
	public function fetchAllArray() {
		$data = $this->tableGateway->select ();
		$options = array ();
		foreach ( $data as $option ) {
			$options ['options'] [] = array (
					'id' => $option->getLkpJobGradeId (),
					'name' => $option->getJobGradeId () 
			);
		}
		return $options;
	}
	public function fetchAllArrayNorm() {
		$data = $this->tableGateway->select ();
		$options = array ();
		foreach ( $data as $option ) {
			$options [$option->getLkpJobGradeId ()] = $option->getJobGradeId ();
		}
		return $options;
	}
}
