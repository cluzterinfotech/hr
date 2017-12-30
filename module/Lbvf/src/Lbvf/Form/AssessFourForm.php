<?php  
namespace Lbvf\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Application\Entity\AssessmentFormFour;

class AssessFourForm extends Form
{
	public function construct($name = null)
	{
		parent::construct('assessFourForm');
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new AssessmentFormFour()); 
        
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
						'label' => '1.Creates a culture that values strength and encourages staff development at all levels.', 
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
				'label' => '2.Delivers compelling messages that appeal to emotions, mind and values within and beyond the organization.',
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
						'label' => '3.Exudes high energy, vigor, and enthusiasm to the organization in achieving organizational goals even in the face of uncertainty.',
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
						'label' => '4.Provides a long-term global vision for business viability and growth.',
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
						'label' => '5.Promotes cross-team collaboration and encourages sharing of resources among teams.',
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
						'label' => '6.Creates an ecosystem of trust for staff to deliver their responsibilities.',
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
						'label' => '7.Inspires others to create and seize opportunities to enhance the commercial fundamentals and business performance.', 
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
						'label' => '8.Consistently communicates a long-term vision for ground-breaking change.',
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
						'label' => '9.Develops strategic alliances and high level contacts globally to help drive PETRONAS’ business forward.',
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
						'label' => '10.Recognizes and develops potential leaders.',
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
						'label' => '11.Encourages culture of positive relationship with key individuals within and beyond departments.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question12',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '12.Ensures that key stakeholders are aware of business progress and that their expectations are aligned.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Question13',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '13.Inspires others to translate vision and strategies into action.	',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question14',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '14.Instills a sense of shared values and purpose across multiple teams.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question15',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '15.Creates a culture where high ethical standards are the norm and where non-compliance is unacceptable.	',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question16',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '16.Champions initiatives that have significant business and commercial impact.	',
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
						'label' => '17.Visibly supports, champions and drives for change and innovation at all levels.',
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
						'label' => '18.Establishes insider status to reach out to global partners and stakeholders.',
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
						'label' => '19.Creates a climate of leaders developing leaders that shares and imparts their knowledge and experience.',
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
						'label' => '20.Balances interdepartmental / divisional relationships towards resolving potential disagreements.',
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
						'label' => '21.Instills performance-driven culture at all levels and holds people accountable.',
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
						'label' => '22.Compellingly communicates the business vision to all stakeholders.',
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
						'label' => '23.Creates a diverse and inclusive environment which values teams with different cultures, ideas and experiences.',
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
						'label' => '24.Demonstrates humility and sincerity and encourages the same in others.',
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
						'label' => '25.Guides the business into major new and financially beneficial areas of growth or productivity.',
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
						'label' => '26.Brings about a culture of innovation which drives superior business performance.',
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
						'label' => '27.Capitalizes on global partnerships to secure opportunities and build support for the organization.',
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
						'label' => '28.Provides opportunity for others to practice open and continuous coaching / feedback.',
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
						'label' => '29.Creates a conducive working environments by inviting and accepting diverse views and opinions.',
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
						'label' => '30.Anticipates possible barriers to success and addresses these proactively in order to stay on course.	',
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
						'label' => '31.Formulates distinctive strategies that make a real difference.',
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
						'label' => '32.Places trust, confidence and empowers the team.',
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
						'label' => '33.Be a role model by admitting and taking responsibility for mistakes.',
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
						'label' => '34.Instills in others the entrepreneurial self-confidence to seize opportunities and take calculated well-balanced risk.',
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
						'label' => '35.Recognizes and celebrates others’ contribution to successful change.',
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
						'label' => '36.Effectively uses and broadens personal networks in various parts of the industry to achieve business goals.',
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