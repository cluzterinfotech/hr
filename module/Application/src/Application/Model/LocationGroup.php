<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class LocationGroup implements EntityInterface {
	
    private $id;
    private $locationId;
    private $attendanceGroupId; 
    public function getId()
    {
        return $this->id;
    }

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function getAttendanceGroupId()
    {
        return $this->attendanceGroupId;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    public function setAttendanceGroupId($attendanceGroupId)
    {
        $this->attendanceGroupId = $attendanceGroupId;
    } 
}    