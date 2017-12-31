<?php

namespace Employee\Model;

/**
 * Description of JobGrade
 *
 * @author Wol
 */
class JobGrade {
	private $lkpJobGradeId;
	private $jobGradeId;
	public function setLkpJobGradeId($lkpJobGradeId) {
		$this->lkpJobGradeId = $lkpJobGradeId;
	}
	public function getLkpJobGradeId() {
		return $this->lkpJobGradeId;
	}
	public function setJobGradeId($jobGradeId) {
		$this->jobGradeId = $jobGradeId;
	}
	public function getJobGradeId() {
		return $this->jobGradeId;
	}
}
