<?php

namespace Position\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Element; 
use Zend\Form\Form; 
use Position\Model\PositionDescription;

class PositionDescriptionForm extends Form  {
	
	public function __construct($name = null) {
	    	
		parent::__construct('positionDescriptionForm');
		$this->setAttribute('noValidate','noValidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new PositionDescription()); 
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden'
		));
		
		$this->add(array(
			'name' => 'positionId',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => array(
				'class' => 'positionId',
				'id' => 'positionId',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Position Name*',
			),
		));
		
		$this->add(array(
			'name' => 'JobPurpose',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'JobPurpose',
				'id' => 'JobPurpose',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Job Purpose*', 
			),
		)); 
		
		$this->add(array(
			'name' => 'JobAcct1',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'JobAcct1',
				'id' => 'JobAcct1',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Role/Task 01*',
			),
		));
		
		$this->add(array(
			'name' => 'Kpi1',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'Kpi1',
				'id' => 'Kpi1',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Kpi 01*',
			),
		));
		
		$this->add(array(
				'name' => 'JobAcct2',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct2',
						'id' => 'JobAcct2',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 02*',
				),
		));
		
		$this->add(array(
			'name' => 'Kpi2',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'Kpi2',
				'id' => 'Kpi2',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
					'label' => 'Kpi 02*',
			),
		));
		
		$this->add(array(
				'name' => 'JobAcct3',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct3',
						'id' => 'JobAcct3',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 03*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi3',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi3',
						'id' => 'Kpi3',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 03*',
				),
		));
		
		$this->add(array(
				'name' => 'JobAcct4',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct4',
						'id' => 'JobAcct4',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 04*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi4',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi4',
						'id' => 'Kpi4',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 04*',
				),
		));
		
		$this->add(array(
				'name' => 'JobAcct5',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct5',
						'id' => 'JobAcct5',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 05*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi5',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi5',
						'id' => 'Kpi5',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 05*',
				),
		));
		
		$this->add(array(
				'name' => 'JobAcct6',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct6',
						'id' => 'JobAcct6',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 06*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi6',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi6',
						'id' => 'Kpi6',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 06*',
				),
		));
		
		$this->add(array(
				'name' => 'JobAcct7',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct7',
						'id' => 'JobAcct7',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 07*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi7',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi7',
						'id' => 'Kpi7',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 07*',
				),
		));
		
		$this->add(array(
				'name' => 'JobAcct8',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct8',
						'id' => 'JobAcct8',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 08*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi8',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi8',
						'id' => 'Kpi8',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 08*',
				),
		));
		
		$this->add(array(
				'name' => 'JobAcct9',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct9',
						'id' => 'JobAcct9',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 09*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi9',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi9',
						'id' => 'Kpi9',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 09*',
				),
		));
		
		$this->add(array(
				'name' => 'JobAcct10',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'JobAcct10',
						'id' => 'JobAcct10',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Role/Task 10*',
				),
		));
		
		$this->add(array(
				'name' => 'Kpi10',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'Kpi10',
						'id' => 'Kpi10',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Kpi 10*',
				),
		));
        
		
		$this->add(array(
			'name' => 'MajorChallenges',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'MajorChallenges',
				'id' => 'MajorChallenges',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Major Challenges',
			),
		));
		
		$this->add(array(
			'name' => 'QualificationExperience',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'QualificationExperience',
				'id' => 'QualificationExperience',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
			    'label' => 'Qualification Experience',
			),
		));
		
		$this->add(array(
			'name' => 'DevOthCoach',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'DevOthCoach',
				'id' => 'DevOthCoach',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Develop Others (Coaching and Develop Others):',
			),
		)); 
		
		$this->add(array(
				'name' => 'OpBusFocus',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'OpBusFocus',
						'id' => 'OpBusFocus',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
					'label' => 'Outperform (Business Focus):',
				),
		));
		
		$this->add(array(
				'name' => 'OpDriExec',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'OpDriExec',
						'id' => 'OpDriExec',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
					'label' => 'Outperforms(Driving Execution):',
				),
		));
		
		$this->add(array(
				'name' => 'OpNetLeading',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'OpNetLeading',
						'id' => 'OpNetLeading',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Outperforms(Networking & Leading Team):',
				),
		));
		
		$this->add(array(
				'name' => 'BehOwnOrgnEnter',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'BehOwnOrgnEnter',
						'id' => 'BehOwnOrgnEnter',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Behaves as Owner(Organisational Enterprenership):',
				),
		));
		
		$this->add(array(
				'name' => 'InsFolInsTrust',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'InsFolInsTrust',
						'id' => 'InsFolInsTrust',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Inspire Followers(Inspiring Trust and Demonstrating Integrity):',
				),
		));
		
		$this->add(array(
				'name' => 'InsFolShapeStrategy',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'InsFolShapeStrategy',
						'id' => 'InsFolShapeStrategy',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Inspire Followers(Shaping Strategy):',
				),
		));
		
		$this->add(array(
				'name' => 'FunctionalCompetencies',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'FunctionalCompetencies',
						'id' => 'FunctionalCompetencies',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Functional Competencies', 
				),
		));
		
		$this->add(array(
				'name' => 'OtherCompetencies',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'OtherCompetencies',
						'id' => 'OtherCompetencies',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Other Competencies',
				),
		));
		
		$this->add(array(
				'name' => 'BehaviouralImplication',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'BehaviouralImplication',
						'id' => 'BehaviouralImplication',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Behavioural Implication',
				),
		));
		
		$this->add(array(
				'name' => 'BdAnnualRevenue',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'BdAnnualRevenue',
						'id' => 'BdAnnualRevenue',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Business Dimension (ANNUAL REVENUE):',
				),
		)); 
		
		$this->add(array(
				'name' => 'BdCapex',
				'type' => 'Zend\Form\Element\TextArea',
				'attributes' => array(
						'class' => 'BdCapex',
						'id' => 'BdCapex',
						'required' => 'required',
						'cols'     => 5,
						'rows'     => 5,
				),
				'options' => array(
						'label' => 'Business Dimension (CAPEX):',
				),
		));
		
		$this->add(array(
			'name' => 'BdOpex',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'BdOpex',
				'id' => 'BdOpex',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Business Dimension (OPEX):',
			),
		));
		
		$this->add(array(
			'name' => 'BdManningLevel',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'BdManningLevel',
				'id' => 'BdManningLevel',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Business Dimension (MANNING LEVEL):',
			),
		)); 
		
		$this->add(array(
			'name' => 'BdOtherFeatures',
			'type' => 'Zend\Form\Element\TextArea',
			'attributes' => array(
				'class' => 'BdOtherFeatures',
				'id' => 'BdOtherFeatures',
				'required' => 'required',
				'cols'     => 5,
				'rows'     => 5,
			),
			'options' => array(
				'label' => 'Business Dimension (OTHER FEATURES):', 
			),
		)); 
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit', 
			'attributes' => array (
				'value' => 'Add Position Description',
				//'class' => 'addPromotion',
				//'id'    => 'addPromotion',
			)
		));
	}
}