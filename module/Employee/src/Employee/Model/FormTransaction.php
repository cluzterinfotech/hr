<?php

namespace Employee\Model;

/**
 * Description of FormTransaction
 *
 * @author Wol
 */
class FormTransaction {
	private $id;
	private $formId;
	private $formName;
	private $action;
	private $completed;
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setFormId($formId) {
		$this->formId = $formId;
	}
	public function getFormId() {
		return $this->formId;
	}
	public function setFormName($formName) {
		$this->formName = $formName;
	}
	public function getFormName() {
		return $this->formName;
	}
	public function setAction($action) {
		$this->action = $action;
	}
	public function getAction() {
		return $this->action;
	}
	public function setCompleted($completed) {
		$this->completed = $completed;
	}
	public function getCompleted() {
		return $this->completed;
	}
}
