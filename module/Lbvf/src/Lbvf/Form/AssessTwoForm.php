<?php  
namespace Lbvf\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Application\Entity\AssessmentFormTwo;

class AssessTwoForm extends Form
{
	public function construct($name = null)
	{
		parent::construct('assessTwoForm');
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new AssessmentFormTwo()); 
        
		$this->add(array(
				'name' => 'id',
				'type' => 'Zend\Form\Element\Hidden',
				'attributes' => array(
						'class' => 'locationId',
						'id' => 'locationId',
				),
				'options' => array(
						'label' => 'undefined',
				),
		));
        
		$this->add(array(
				'name' => 'employeeNumber',
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'class' => 'employeeNumber',
						'id' => 'employeeNumber',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Employee Name*',
				),
		));
		
		$this->add(array(
				'name' => 'Question01a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '1. Makes conscious effort into understanding people strengths and development needs..', 
						'value_options' => array(
								'1' => ' 1',
								'2' => ' 2',
								'3' => ' 3',
								'4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question01b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '2. Presents information persuasively and adjusts communication tactics when needed.',
						'value_options' => array(
								'1' => ' 1',
								'2' => ' 2',
								'3' => ' 3',
								'4' => ' 4',
						),
				),
		));
		
		$this->add(array(
			'name' => 'Question02a',
			'type' => 'Zend\Form\Element\Radio',
			'attributes' => array('required' => 'required'),
			'options' => array(
				'label' => '3. Responds well to challenges, maintaining high levels of energy, enthusiasm and work pace.',
				'value_options' => array(
					'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
				),
			),
		));
		
		$this->add(array(
				'name' => 'Question02b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '4. Clearly articulates own business strategy and provides clear strategic direction to others.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question03a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '5. Promotes open communication by actively seeking and discussing the views and opinions of team members.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
        
		$this->add(array(
				'name' => 'Question03b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '6. Aligns own actions to words and encourages the same to employees in executing their responsibilities.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question04a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '7. Identifies and anticipates future business opportunities and challenges.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Question04b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '8. Develops and shares best practices to encourage innovation.', 
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question05a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '9. Constantly strengthens business relationships well beyond own work area.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Question05b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '10. Translates business opportunities into realistic and timely actions. ',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question06a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '11. Builds trust and consensus by understanding and responding to others’ concerns.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question06b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '12. Put time and effort to coach and motivate others to improve their performance and close gaps.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Question07a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '13. Proactively contributes to setting objectives and strategies for the business.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question07b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '14. Encourages the team to work together with a shared purpose.	',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question08a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '15. Personally demonstrates high standards of ethical conduct and ensures team compliance to rules and regulations.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Question08b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '16. Is alert to opportunities that add real value to the business, and acts quickly to capitalise.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Question17',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '17. Responds positively to new ideas and motivates employees to embrace change',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		
		
		
		$this->add(array(
				'name' => 'Question18',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '18. Builds strong relationships with strategically important business contacts.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
	    
		$this->add(array(
				'name' => 'Question19',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '19. Provides others with timely and constructive feedback.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question20',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '20. Puts in extra effort to ensure that unit / section results meet and exceed expectations.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
	    
		$this->add(array(
				'name' => 'Question21',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '21. Acknowledges and praise the accomplishments of others and take action on non-performance.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		$this->add(array(
				'name' => 'Question22',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '22. Efficiently aligns own and team work area to support wider business strategies.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		
		$this->add(array(
				'name' => 'Question23',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '23. Invests time in engaging informally and frequently with team members to develop rapport.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		
		$this->add(array(
				'name' => 'Question24',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '24. Demonstrates humility and sincerity.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		
		$this->add(array(
				'name' => 'Question25',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '25. Helps create competitive advantage by developing well-considered business proposals, taking into consideration risk factors.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		$this->add(array(
				'name' => 'Question26',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '26. Proposes major changes and gets them accepted through effective stakeholder engagement.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		$this->add(array(
				'name' => 'Question27',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '27. Uses own business network to stay close to the latest developments in the external environment.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		$this->add(array(
				'name' => 'Question28',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '28. Is self-motivated and self-directed for personal and professional development.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		$this->add(array(
				'name' => 'Question29',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '29. Is tactful and diplomatic when dealing with others from diverse backgrounds.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		$this->add(array(
				'name' => 'Question30',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '30. Encourages and drives others to persevere and remain focused.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		$this->add(array(
				'name' => 'Question31',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '31. Keeps current with changes in the industry.	',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
			
		
		$this->add(array(
				'name' => 'Question32',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '32. Shows concern for the welfare and well-being of the team.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		
		$this->add(array(
				'name' => 'Question33',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '33. Takes personal accountability for mistakes.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
				
		
		$this->add(array(
				'name' => 'Question34',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '34. Treats people from diverse background fairly and equally..',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
				
		
		$this->add(array(
				'name' => 'Question35',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '35. Demonstrates creativity and generates new ideas for potential solutions..',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
				
		
		$this->add(array(
				'name' => 'Question36',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '36. Leverages on network to identify opportunities for the organisation..',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Strength',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Strength.',
				),
		));
		
		$this->add(array(
				'name' => 'DevelopmentAreas',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array(
					'required' => 'required',
				),
				'options' => array(
					'label' => 'DevelopmentAreas', 
				),
		));
		
		
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Add'
			)
		));
		
	}
}