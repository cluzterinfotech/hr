<?php

namespace Employee\Model;

use Payment\Model\Company;

class CompanyTable {
	private $tableGateway;
	public function __construct($tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function saveCompany(Company $company) {
		$data = array (
				'companyId' => $company->getCompanyId (),
				'companyName' => $company->getCompanyName (),
				'status' => $company->getStatus (),
				'employeeIdPrefix' => $company->getEmployeeIdPrefix (),
				'value' => $company->getValue () 
		);
		
		if (empty ( $data ['companyId'] )) {
			$data ['companyId'] = 0;
			$this->tableGateway->insert ( $data );
		} else {
			$id = $data ['companyId'];
			$this->tableGateway->update ( $data, array (
					'companyId' => $id 
			) );
		}
		
		return true;
	}
	public function fetchCompany($id) {
		$company = $this->tableGateway->select ( array (
				'companyId' => $id 
		) );
		return $company->current ();
	}
	public function fetchCompanyArray($id) {
		$company = $this->tableGateway->select ( array (
				'companyId' => $id 
		) );
		$row = $company->current ();
		
		return array (
				'companyId' => $row->getCompanyId (),
				'companyName' => $row->getCompanyName (),
				'status' => $row->getStatus (),
				'employeeIdPrefix' => $row->getEmployeeIdPrefix (),
				'value' => $row->getValue () 
		);
	}
	public function deleteCompany($id) {
		$id = ( int ) $id;
		$this->tableGateway->delete ( array (
				'companyId' => $id 
		) );
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
					'id' => $option->getCompanyId (),
					'name' => $option->getCompanyName () 
			);
		}
		return $options;
	}
	public function fetchAllNorm() {
		$data = $this->tableGateway->select ();
		$options = array ();
		foreach ( $data as $option ) {
			$options [$option->getCompanyId ()] = $option->getCompanyName ();
		}
		return $options;
	}
}
