<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class Alert implements EntityInterface {
	
    private $id;
    private $alertId;
    private $positionId;
	private $isCC;
	
	public function setId($id) {
	    $this->id = $id;
	}
	public function getId() {
	    return $this->Id;
	}
	public function setAlertId($alertId) {
	    $this->alertId = $alertId;
	}
	public function getAlertId() {
	    return $this->alertId;
	}	
	public function setPositionId($positionId) {
	    $this->positionId = $positionId;
	}
	public function getPositionId() {
	    return $this->positionId;
	}
	public function setIsCC($isCC) {
	    $this->isCC = $isCC;
	}
	public function getIsCC() {
	    return $this->isCC;
	}
    

	
}
