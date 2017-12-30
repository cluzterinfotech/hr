<?php

namespace Lbvf\Model;

use Payment\Model\EntityInterface;

class Nomination implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $SuperiorName;
	private $OthSuperiorName;
	private $Subordinate01;
	private $Subordinate02;
	private $Subordinate03;
	private $Subordinate04;
	private $Subordinate05;
	private $Subordinate06;
	private $Subordinate07;
	private $Subordinate08;
	private $Subordinate09;
	private $Subordinate10;
	private $Peers01;
	private $Peers02;
	private $Peers03;
	private $EndorsementStatus;
	private $Reason;
	private $LbvfId;
	private $EndorsementRejected;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getEmployeeNumber() {
		return $this->employeeNumber;
	}
	public function setEmployeeNumber($employeeNumber) {
		$this->employeeNumber = $employeeNumber;
		return $this;
	}
	public function getSuperiorName() {
		return $this->SuperiorName;
	}
	public function setSuperiorName($SuperiorName) {
		$this->SuperiorName = $SuperiorName;
		return $this;
	}
	public function getOthSuperiorName() {
		return $this->OthSuperiorName;
	}
	public function setOthSuperiorName($OthSuperiorName) {
		$this->OthSuperiorName = $OthSuperiorName;
		return $this;
	}
	public function getSubordinate01() {
		return $this->Subordinate01;
	}
	public function setSubordinate01($Subordinate01) {
		$this->Subordinate01 = $Subordinate01;
		return $this;
	}
	public function getSubordinate02() {
		return $this->Subordinate02;
	}
	public function setSubordinate02($Subordinate02) {
		$this->Subordinate02 = $Subordinate02;
		return $this;
	}
	public function getSubordinate03() {
		return $this->Subordinate03;
	}
	public function setSubordinate03($Subordinate03) {
		$this->Subordinate03 = $Subordinate03;
		return $this;
	}
	public function getSubordinate04() {
		return $this->Subordinate04;
	}
	public function setSubordinate04($Subordinate04) {
		$this->Subordinate04 = $Subordinate04;
		return $this;
	}
	public function getSubordinate05() {
		return $this->Subordinate05;
	}
	public function setSubordinate05($Subordinate05) {
		$this->Subordinate05 = $Subordinate05;
		return $this;
	}
	public function getSubordinate06() {
		return $this->Subordinate06;
	}
	public function setSubordinate06($Subordinate06) {
		$this->Subordinate06 = $Subordinate06;
		return $this;
	}
	public function getSubordinate07() {
		return $this->Subordinate07;
	}
	public function setSubordinate07($Subordinate07) {
		$this->Subordinate07 = $Subordinate07;
		return $this;
	}
	public function getSubordinate08() {
		return $this->Subordinate08;
	}
	public function setSubordinate08($Subordinate08) {
		$this->Subordinate08 = $Subordinate08;
		return $this;
	}
	public function getSubordinate09() {
		return $this->Subordinate09;
	}
	public function setSubordinate09($Subordinate09) {
		$this->Subordinate09 = $Subordinate09;
		return $this;
	}
	public function getSubordinate10() {
		return $this->Subordinate10;
	}
	public function setSubordinate10($Subordinate10) {
		$this->Subordinate10 = $Subordinate10;
		return $this;
	}
	public function getPeers01() {
		return $this->Peers01;
	}
	public function setPeers01($Peers01) {
		$this->Peers01 = $Peers01;
		return $this;
	}
	public function getPeers02() {
		return $this->Peers02;
	}
	public function setPeers02($Peers02) {
		$this->Peers02 = $Peers02;
		return $this;
	}
	public function getPeers03() {
		return $this->Peers03;
	}
	public function setPeers03($Peers03) {
		$this->Peers03 = $Peers03;
		return $this;
	}
	public function getEndorsementStatus() {
		return $this->EndorsementStatus;
	}
	public function setEndorsementStatus($EndorsementStatus) {
		$this->EndorsementStatus = $EndorsementStatus;
		return $this;
	}
	public function getReason() {
		return $this->Reason;
	}
	public function setReason($Reason) {
		$this->Reason = $Reason;
		return $this;
	}
	public function getLbvfId() {
		return $this->LbvfId;
	}
	public function setLbvfId($LbvfId) {
		$this->LbvfId = $LbvfId;
		return $this;
	}
	public function getEndorsementRejected() {
		return $this->EndorsementRejected;
	}
	public function setEndorsementRejected($EndorsementRejected) {
		$this->EndorsementRejected = $EndorsementRejected;
		return $this;
	}
} 