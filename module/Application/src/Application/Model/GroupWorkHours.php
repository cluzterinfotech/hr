<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class GroupWorkHours implements EntityInterface {
	
    private $id;
    private $locationGroup;
    private $eventId;
    private $DayName;
    private $Status;
    private $WorkingHours;
    private $startTime;
    private $endTime;
    
    public function getId()
    {
        return $this->id;
    }

    public function getLocationGroup()
    {
        return $this->locationGroup;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getDayName()
    {
        return $this->DayName;
    }

    public function getStatus()
    {
        return $this->Status;
    }

    public function getWorkingHours()
    {
        return $this->WorkingHours;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLocationGroup($locationGroup)
    {
        $this->locationGroup = $locationGroup;
    }

    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    public function setDayName($DayName)
    {
        $this->DayName = $DayName;
    }

    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    public function setWorkingHours($WorkingHours)
    {
        $this->WorkingHours = $WorkingHours;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }
}
