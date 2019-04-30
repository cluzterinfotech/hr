<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class AttendanceGroup implements EntityInterface {
	
    private $id;
    private $groupName;
    public function getId()
    {
        return $this->id;
    }

    public function getGroupName()
    {
        return $this->groupName;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }
} 