<?php

namespace Employee\Model;

use Employee\Model\FormTransaction;

/**
 * Description of FormTransactionTable
 *
 * @author Wol
 */
class FormTransactionTable {
	private $tableGateway;
	private $formName;
	private $formId;
	private $expectedActions;
	public function __construct($tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function beginFormTransaction($formName) {
		/*
		 * Set the name of form
		 */
		$this->formName = $formName;
	}
	public function addExpectedAction($name) {
		/*
		 * Add action to be completed for the form
		 */
		$this->expectedActions [] = $name;
	}
	public function saveAction($formId, $formName, $formAction) {
		try {
			$data = array (
					'id' => 0,
					'formId' => $formId,
					'formName' => $formName,
					'action' => $formAction,
					'completed' => 0 
			);
			// \Zend\Debug\Debug::dump($data);
			$this->tableGateway->insert ( $data );
		} catch ( \Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function isFormCompleted($formId) {
		/*
		 * Select all actions for this form id, check that they have all been completed
		 */
	}
	public function completedAction($name) {
		/*
		 * Tick off action as being completed
		 */
		try {
			$data = array (
					'completed' => 1 
			);
			
			$formId = $this->formId;
			$this->tableGateway->update ( $data, array (
					'formId' => $formId,
					'action' => $name 
			) );
		} catch ( \Exception $e ) {
			return $e->getMessage ();
		}
	}
	public function isPending($name) {
		/*
		 * Do we have a form that has not been completed
		 */
		$results = $this->tableGateway->select ( array (
				'formName' => $name,
				'completed' => 0 
		) );
		if ($results->count () > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function confirmFormTransactions($formId) {
		/*
		 * Sets id that form elements have in common
		 * and adds transactions to database
		 */
		$this->formId = $formId;
		$formName = $this->formName;
		$actions = $this->expectedActions;
		// If there are expected actions, add them to database
		if ($actions) {
			foreach ( $actions as $action ) {
				$this->saveAction ( $formId, $formName, $action );
			}
		}
	}
	public function rollback($name) {
	}
	public function getFormId() {
		return $this->formId;
	}
}
