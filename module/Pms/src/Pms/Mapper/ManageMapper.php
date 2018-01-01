<?php

namespace Pms\Mapper;

use Pms\Model\Manage, 
Application\Abstraction\AbstractDataMapper, 
Application\Contract\EntityCollectionInterface, 
Application\Contract\DataMapperInterface, 
Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;

class ManageMapper extends AbstractDataMapper {
	
	protected $entityTable = "Pms_Fyear";
	
	protected function loadEntity(array $row) {
		$entity = new Manage ();
		return $this->arrayToEntity ( $row, $entity );
	}
	public function getCurrentActivityList($id) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array ('id','Curr_Activity'))
		       ->where(array('id' => $id ));
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute()->current();
		return $this->toPmsFeList ( $results );
	}
	protected function toPmsFeList($results) {
		$currAct = $results ['Curr_Activity'];
		
		if ($currAct == 1) {
			$arr = array (
					'1' => 'IPC Open',
					'0' => 'IPC Close',
					'2' => 'Mid-Year Open' 
			);
		} elseif ($currAct == 2) {
			$arr = array (
					'2' => 'Mid-Year Open',
					'3' => 'Mid-Year Close',
					'4' => 'Year End Open' 
			);
		} elseif ($currAct == 3) {
			$arr = array (
					// '2' => 'Mid-Year Open',
					'4' => 'Year End Open',
					'5' => 'Year End Close',
					'6' => 'HRPC Open' 
			);
		} elseif ($currAct == 4) {
			$arr = array (
					// '4' => 'Year End Open',
					'6' => 'HRPC Open',
					'7' => 'HRPC Close' 
			);
		}
		return $arr;
	}
	
	public function updateRow($formVal) {
		$values = $this->entityToArray ( $formVal );
		// $db = $this->getDb();
		// Zend_Debug::dump($id);
		$notes = $values ['IPC_Notes'];
		$currActivity = $values ['Current_Activity'];
		$data = array ();
		
		$today = date ( "Y-m-d" );
		
		if ($currActivity == 0 || $currActivity == 1) {
			//
			$ipc = $currActivity;
			$data ['IPC_Open_Date'] = $today;
			$myr = 0;
			$yend = 0;
			$hrpc = 0;
			$ca = 1;
			$data ['IPC_Notes'] = $notes;
		} elseif ($currActivity == 2 || $currActivity == 3) {
			
			$myr = 0;
			
			if ($currActivity == 2) {
				$myr = 1;
				$data ['MYR_Open_Date'] = $today;
				$data ['IPC_Close_Date'] = $today;
			}
			$ipc = 0;
			$yend = 0;
			$hrpc = 0;
			$ca = 2;
			// $myrOpenDt = date('Y-m-d');
			// $ipcCloseDt = date('Y-m-d');
			$data ['MYR_Notes'] = $notes;
		} elseif ($currActivity == 4 || $currActivity == 5) {
			$yend = 0;
			if ($currActivity == 4) {
				$yend = 1;
				$data ['MYR_Close_Date'] = $today;
				$data ['YED_Open_Date'] = $today;
			}
			$ipc = 0;
			$myr = 0;
			$hrpc = 0;
			$ca = 3;
			$data ['YED_Notes'] = $notes;
		} elseif ($currActivity == 6 || $currActivity == 7) {
			
			if ($currActivity == 4) {
				$hrpc = 1;
				$data ['MYR_Close_Date'] = $today;
				$data ['YED_Open_Date'] = $today;
			} else {
				$hrpc = 0;
				$data ['YED_Close_Date'] = $today;
			}
			$ipc = 0;
			$myr = 0;
			$yend = 0;
			$ca = 4;
		}
		
		$data ['IPC_Open_Close'] = $ipc;
		$data ['MYR_Open_Close'] = $myr;
		$data ['YED_Open_Close'] = $yend;
		$data ['HRPC_Review_Open_Close'] = $hrpc;
		$data ['Reports_Status'] = $values ['Reports_Status'];
		
		// $data['Close_Year'] = $notes;
		$data ['Curr_Activity'] = $ca;
		$data ['id'] = $id;
		// Zend_Debug::dump($data);
		// Zend_Debug::dump($id);
		// exit;
		
		// $where = "id='".$id."'";
		$this->update ( $data );
	}
}