<?php  
namespace Position\Mapper;

use Position\Model\Position,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate; 
use Position\Model\PositionDescription;

class PositionDescriptionMapper extends AbstractDataMapper {
	
	protected $entityTable = "PositionDescription";
        	
	protected function loadEntity(array $row) { 
		 $entity = new PositionDescription();  
		 return $this->arrayToEntity($row,$entity); 
	} 
	
	public function selectPositionDescriptionList() { 
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('pd' => $this->entityTable))
		       ->columns(array('*'))
		       ->join(array('p' => 'Position'),'p.id = pd.positionId',
		              array('positionNam' => new Expression("positionName + ' ' +shortDescription")))
		       //->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = pm.employeeId',
		       		  //array('employeeName'))
		       //->join(array('l' => 'Location'), 'e.locationId = l.id', 
		       		//array('locationName'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	}  
	
}