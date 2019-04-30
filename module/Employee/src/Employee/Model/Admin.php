<?php

namespace Employee\Model;

/**
 * Description of Admin
 *
 * @author Wol
 */
class Admin {
	private $level;
	private $company;
	public function __construct($level, $company) {
		$this->level = $level;
		$this->company = $company;
	}
	public function setLevel($level) {
		$this->level = $level;
	}
	public function getLevel() {
		return $this->level;
	}
	public function setCompany($company) {
		$this->company = $company;
	}
	public function getCompany() {
		return $this->company;
	}
}
