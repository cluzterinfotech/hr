<?php

namespace Employee\Model;

/**
 * Description of SalaryGrade
 *
 * @author Wol
 */
class SalaryGrade {
	private $lkpSalaryGradeId;
	private $salaryGrade;
	public function setLkpSalaryGradeId($lkpSalaryGradeId) {
		$this->lkpSalaryGradeId = $lkpSalaryGradeId;
	}
	public function getLkpSalaryGradeId() {
		return $this->lkpSalaryGradeId;
	}
	public function setSalaryGrade($salaryGrade) {
		$this->salaryGrade = ( int ) $salaryGrade;
	}
	public function getSalaryGrade() {
		return $this->salaryGrade;
	}
}
