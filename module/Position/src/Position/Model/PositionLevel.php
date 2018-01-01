<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Production
 *
 * @author AlkhatimVip
 */
namespace Position\Model;

class PositionLevel {
	private $id;
	private $positionLevelId;
	private $levelName;
	private $levelSequence;
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setPositionLevelId($positionLevelId) {
		$this->positionLevelId = $positionLevelId;
	}
	public function getPositionLevelId() {
		return $this->positionLevelId;
	}
	public function setLevelName($levelName) {
		$this->levelName = $levelName;
	}
	public function getLevelName() {
		return $this->levelName;
	}
	public function setLevelSequence($levelSequence) {
		$this->levelSequence = $levelSequence;
	}
	public function getLevelSequence() {
		return $this->levelSequence;
	}
}