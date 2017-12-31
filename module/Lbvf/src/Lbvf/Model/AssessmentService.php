<?php 
namespace Lbvf\Model; 

use Lbvf\Model\AssessmentMapper; 

class AssessmentService  { 
	
	private $assessmentMapper; 
	    		
    public function __construct(AssessmentMapper $assessmentMapper) {
        $this->assessmentMapper = $assessmentMapper; 
    }     
    
    // identify the form 
    public function fetchById($id) {   
        return $this->assessmentMapper->fetchById($id);         
    }   
    
    public function getLbvfForm($lbvfId) {
        	
    }
    
    
   
}