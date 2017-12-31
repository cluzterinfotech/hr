<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class MailTest implements EntityInterface {
	
	//private $id;
	//private $mailSubject;
	
	private $id;
	private $mailSubject;
	private $mailFrom;
	private $mailTo;
	private $mailbody;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getMailSubject() {
		return $this->mailSubject;
	}
	public function setMailSubject($mailSubject) {
		$this->mailSubject = $mailSubject;
		return $this;
	}
	public function getMailFrom() {
		return $this->mailFrom;
	}
	public function setMailFrom($mailFrom) {
		$this->mailFrom = $mailFrom;
		return $this;
	}
	public function getMailTo() {
		return $this->mailTo;
	}
	public function setMailTo($mailTo) {
		$this->mailTo = $mailTo;
		return $this;
	}
	public function getMailbody() {
		return $this->mailbody;
	}
	public function setMailbody($mailbody) {
		$this->mailbody = $mailbody;
		return $this;
	}
	
}