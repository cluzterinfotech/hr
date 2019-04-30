<?php

namespace Employee\Model;

/**
 * Description of History
 *
 * @author Wol
 *        
 *         record status codes
 *         0 - Rejected
 *         1 - Approved
 *         2 - Pending
 *         3 - Updated
 *        
 */
class History {
	private $addedUser;
	private $addedDate;
	private $updatedUser;
	private $updatedDate;
	private $recordStatus;
	public function __construct($user, $date) {
		$this->addedUser = $user;
		$this->addedDate = $date;
		$this->updatedUser = $user;
		$this->updatedDate = $date;
	}
	public function setAddedUser($addedUser) {
		$this->addedUser = $addedUser;
	}
	public function getAddedUser() {
		return $this->addedUser;
	}
	public function setAddedDate($addedDate) {
		$this->addedDate = $addedDate;
	}
	public function getAddedDate() {
		return $this->addedDate;
	}
	public function setUpdatedUser($updatedUser) {
		$this->updatedUser = $updatedUser;
	}
	public function getUpdatedUser() {
		return $this->updatedUser;
	}
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	public function setRecordStatus($recordStatus) {
		$this->recordStatus = $recordStatus;
	}
	public function getRecordStatus() {
		return $this->recordStatus;
	}
}
