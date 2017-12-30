<?php 
 
namespace Employee\Model;

use Employee\Mapper\EmployeeDeductionMapper;
use Payment\Model\Company;
use Payment\Model\DateRange;
use Application\Persistence\TransactionDatabase; 

class EmployeeDeductionService  {
	
	protected $employeeDeductionMapper;
	
	protected $transaction; 
	
	protected $service;
	
	protected $phoneDeductionInfo = 'PhoneDeductionInfo'; 
	
	public function __construct(EmployeeDeductionMapper $deductionMapper,
			TransactionDatabase $transaction,$sm) { 
		$this->employeeDeductionMapper = $deductionMapper;
		$this->transaction = $transaction;   
		$this->service = $sm; 
	}
	
	public function selectEmployeeTelephone() {
		return $this->employeeDeductionMapper->selectEmployeeTelephone($this->phoneDeductionInfo);
	}
	
	public function saveEmployeeDeduction($formValues,Company $company) {
		$data = array (
			'employeeNumberTelephone' => $formValues['employeeNumberTelephone'],
			'phoneNumber'             => $formValues['phoneNumber'],
			//'companyId'               => $company->getId(),   
		); 
		$this->employeeDeductionMapper->saveEmployeeDeduction($data,$this->phoneDeductionInfo);
	}
	
	public function removeEmployeePhoneDeduction($id) { 
		return $this->employeeDeductionMapper->removeEmployeeDeduction($id,$this->phoneDeductionInfo);
	}
	
	public function close(Company $company,$lastMonth,$routeInfo) {
		try {
			$this->transaction->beginTransaction();
			$companyId = $company->getId(); 
			$this->closeTelephone($companyId,$lastMonth);  
			$this->getCheckListService()->closeLog($routeInfo);
			$this->transaction->commit();
		} catch(\Exception $e) {
			$this->transaction->rollBack();
			throw $e;
		} 
	}
	
	public function getEmployeeIdByPhone($phone) {
		return $this->employeeDeductionMapper->getEmployeeIdByPhone($phone,$this->phoneDeductionInfo);
	}
	
	public function closeTelephone($companyId,$lastMonth) {
		return $this->employeeDeductionMapper->closeTelephone($companyId,$lastMonth); 
	}
	
	public function removeUnclosedPhone($companyId,$lastMonth) {
		return $this->employeeDeductionMapper->removeUnclosedPhone($companyId,$lastMonth);
	}
	
	public function insertPhone(array $attendanceArray) {
		$mst = array(
				'employeeNumberTelephone'  => $dateRange->getFromDate(),
				'phoneAmount'              => $company->getId(), 
		);
	} 
	
	public function insertPhoneMst(array $mst) {
		return $this->employeeDeductionMapper->insertPhoneMst($mst); 
	}
	
	public function insertPhoneDtls(array $dtls) {
		return $this->employeeDeductionMapper->insertPhoneDtls($dtls); 
	}
	
	public function isPhoneClosed($companyId,$lastMonth) {
		// @todo check is already available 
		return $this->employeeDeductionMapper->isPhoneClosed($companyId,$lastMonth); 
	    //return 0; 	
	}
	
	public function getCheckListService() {
		return $this->service->get('checkListService');
	} 
	
}