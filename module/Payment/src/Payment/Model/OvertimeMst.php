<?php
namespace Payment\Model;

use Payment\Model\EntityInterface;

class OvertimeMst implements EntityInterface {
    /*
	private $id;
	private $positionName;
	private $organisationLevel;
	private $sequence;
	private $section;
	private $reportingPosition;
	private $status; 
	*/
    private $overtimeMstId;
	private $overtimeDate;
	private $overtimeNormalHourVaule;
	private $overtimeHolidayHourValue;
	private $companyId;
	private $isClosed;
	private $empId; 
	public function getId() {
		return $this->overtimeMstId;
	}
	
	public function setId($id) {
		$this->overtimeMstId = $id;
		return $this;
	}
	
	public function getOvertimeDate() {
		return $this->overtimeDate;
	}
	public function setOvertimeDate($overtimeDate) {
		$this->overtimeDate = $overtimeDate;
		return $this;
	}
	public function getOvertimeNormalHourVaule() {
		return $this->overtimeNormalHourVaule;
	}
	public function setOvertimeNormalHourVaule($overtimeNormalHourVaule) {
		$this->overtimeNormalHourVaule = $overtimeNormalHourVaule;
		return $this;
	}
	public function getOvertimeHolidayHourValue() {
		return $this->overtimeHolidayHourValue;
	}
	public function setOvertimeHolidayHourValue($overtimeHolidayHourValue) {
		$this->overtimeHolidayHourValue = $overtimeHolidayHourValue;
		return $this;
	}
	public function getCompanyId() {
		return $this->companyId;
	}
	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
		return $this;
	}
	public function getIsClosed() {
		return $this->isClosed;
	}
	public function setIsClosed($isClosed) {
		$this->isClosed = $isClosed;
		return $this;
	}
        	public function getempId() {
		return $this->empId;
	}
	public function setempId($empId) {
		$this->empId = $empId;
		return $this;
	}
	
}
?>