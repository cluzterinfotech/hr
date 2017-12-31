<?php

namespace Application\Model;

use Application\Mapper\CompanyMapper;
use Application\Entity\CompanyEntity;

class CompanyService {
	
	private $companyMapper;
	
	public function __construct(CompanyMapper $companyMapper) {
		$this->companyMapper = $companyMapper; 
	}
	
	public function getCompanyList() {
		return $this->companyMapper->getCompanyList();
	}
	
	public function select() {
		return $this->companyMapper->select(); 
	}
	
	public function selectCompanyUser() {
		return $this->companyMapper->selectCompanyUser();
	}
	
	public function insert($entity) {
		return $this->companyMapper->insert($entity);
	}
	
	public function delete($entity) {
	    return $this->companyMapper->delete($entity);
	}
	
	public function update($entity) {
		return $this->companyMapper->update($entity);
	}
	
	public function fetchById($id) {
		return $this->companyMapper->fetchById($id); 
	}
	
	public function fetchCompanyById($id = null) {
		$company =  new CompanyEntity(); 
		$company->setId('1');
		$company->setCompanyName('Permanent');
		$company->setEmployeeIdPrefix('0');
		$company->setStatus('1');
		$company->setValue('1');
		return $company;
	} 
	
	public function fetchCompPositionById($id) {
		return $this->companyMapper->fetchCompPositionById($id);
	}
	
	public function insertCompPosition($entity) {
		return $this->companyMapper->insertCompPosition($entity);
	}
	
	public function updateCompPosition($entity) {
		return $this->companyMapper->updateCompPosition($entity); 
	}
}