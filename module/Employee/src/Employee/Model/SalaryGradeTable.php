<?php

namespace Employee\Model;

use Employee\Model\SalaryGrade;

/**
 * Description of SalaryGradeTable
 *
 * @author Wol
 */
class SalaryGradeTable {
	private $tableGateway;
	public function __construct($tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function saveSalaryGrade(SalaryGrade $salaryGrade) {
		$data = array (
				'lkpSalaryGradeId' => $salaryGrade->getLkpSalaryGradeId (),
				'salaryGrade' => $salaryGrade->getSalaryGrade () 
		);
		
		if (empty ( $data ['lkpSalaryGradeId'] )) {
			$data ['lkpSalaryGradeId'] = 0;
			$this->tableGateway->insert ( $data );
		} else {
			$id = $data ['lkpSalaryGradeId'];
			$this->tableGateway->update ( $data, array (
					'lkpSalaryGradeId' => $id 
			) );
		}
		
		return true;
	}
	public function fetchSalaryGrade($id) {
		$grade = $this->tableGateway->select ( array (
				'lkpSalaryGradeId' => $id 
		) );
		return $grade->current ();
	}
	public function deleteSalaryGrade($id) {
		$this->tableGateway->delete ( array (
				'lkpSalaryGradeId' => $id 
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
					'id' => $option->getLkpSalaryGradeId (),
					'name' => $option->getSalaryGrade () 
			);
		}
		return $options;
	}
	public function fetchAllArrayNorm() {
		$data = $this->tableGateway->select ();
		$options = array ();
		foreach ( $data as $option ) {
			$options [$option->getLkpSalaryGradeId ()] = $option->getSalaryGrade ();
		}
		return $options;
	}
}
