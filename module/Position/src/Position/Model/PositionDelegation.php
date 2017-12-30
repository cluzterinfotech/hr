<?php

/**
 * Description of Delegation
 *
 * @author AlkhatimVip
 */
namespace Position\Model;

class PositionDelegation {
	private $id;
	private $positionId;
	private $delegatedPositionId;
	private $fromDate;
	private $toDate;
	private $positionName;
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setPositionId($positionId) {
		$this->positionId = $positionId;
	}
	public function getPositionId() {
		return $this->positionId;
	}
	public function setDelegatedPositionId($delegatedPositionId) {
		$this->delegatedPositionId = $delegatedPositionId;
	}
	public function getDelegatedPositionId() {
		return $this->delegatedPositionId;
	}
	public function setFromDate($fromDate) {
		$this->fromDate = $fromDate;
	}
	public function getFromDate() {
		return $this->fromDate;
	}
	public function setToDate($toDate) {
		$this->toDate = $toDate;
	}
	public function getToDate() {
		return $this->toDate;
	}
	public function setPositionName($positionName) {
		$this->positionName = $positionName;
	}
	public function getPositionName() {
		return $this->positionName;
	}
}