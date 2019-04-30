<?php 

namespace Employee\Model;

use Payment\Model\EntityInterface;

class EmployeeSuspend implements EntityInterface {
	
    private $id;
    private $employeeId;
    private $suspendFrom;
    private $suspendTo;
    private $reason;
    private $companyId;
    private $deletedUser;
    private $deletedDate;
    public function getId()
    {
        return $this->id;
    }

    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function getSuspendFrom()
    {
        return $this->suspendFrom;
    }

    public function getSuspendTo()
    {
        return $this->suspendTo;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function getDeletedUser()
    {
        return $this->deletedUser;
    }

    public function getDeletedDate()
    {
        return $this->deletedDate;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function setSuspendFrom($suspendFrom)
    {
        $this->suspendFrom = $suspendFrom;
    }

    public function setSuspendTo($suspendTo)
    {
        $this->suspendTo = $suspendTo;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    public function setDeletedUser($deletedUser)
    {
        $this->deletedUser = $deletedUser;
    }

    public function setDeletedDate($deletedDate)
    {
        $this->deletedDate = $deletedDate;
    } 
} 