<?php

namespace Employee\Model;

use Employee\Model\Location;

/**
 * Description of LocationTable
 *
 * @author Wol
 */
class LocationTable {
	private $tableGateway;
	public function __construct($tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function saveLocation(Location $location) {
		$data = array (
				'locationId' => $location->getLocationId (),
				'locationName' => $location->getLocationName (),
				'overtimeHour' => $location->getOvertimeHour (),
				'isHaveHardship' => $location->getIsHaveHardship () 
		);
		
		if (empty ( $data ['locationId'] )) {
			$data ['locationId'] = 0;
			$this->tableGateway->insert ( $data );
		} else {
			$id = $data ['locationId'];
			$this->tableGateway->update ( $data, array (
					'locationId' => $id 
			) );
		}
		
		return true;
	}
	public function fetchLocation($id) {
		$location = $this->tableGateway->select ( array (
				'locationId' => $id 
		) );
		return $location->current ();
	}
	public function deleteLocation($id) {
		$id = ( int ) $id;
		$this->tableGateway->delete ( array (
				'locationId' => $id 
		) );
	}
	public function fetchAll() {
		$data = $this->tableGateway->select ();
		return $data;
	}
	public function fetchAllArray() {
		$data = $this->tableGateway->select ();
		$options = array ();
		foreach ( $data as $option ) {
			$options ['options'] [] = array (
					'id' => $option->getLocationId (),
					'name' => $option->getLocationName () 
			);
		}
		return $options;
	}
	public function fetchAllArrayNorm() {
		$data = $this->tableGateway->select ();
		$options = array ();
		foreach ( $data as $option ) {
			$options [$option->getLocationId ()] = $option->getLocationName ();
		}
		return $options;
	}
}
