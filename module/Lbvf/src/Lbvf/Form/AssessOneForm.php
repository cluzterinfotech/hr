<?php  
namespace Lbvf\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Application\Entity\AssessmentFormOne;

class AssessOneForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('assessOneForm');
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new AssessmentFormOne()); 
        
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
						'label' => '1.Recognises own strengths and development areas.', 
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
						'label' => '2.Communicates clearly, using language which is easily understood by the listener/audience.',
						'value_options' => array(
								'1' => ' 1',
								'2' => ' 2',
								'3' => ' 3',
								'4' => ' 4',
						),
				),
		));
		
		$this->add(array(
			'name' => 'Question03a',
			'type' => 'Zend\Form\Element\Radio',
			'attributes' => array('required' => 'required'),
			'options' => array(
				'label' => '3.Demonstrates high level of energy towards own work.',
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
						'label' => '4.Demonstrates a practical understanding of the organisation\'s goals and direction.',
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
						'label' => '5.Builds rapport through formal and informal setting.',
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
						'label' => '6.Systematically and efficiently delivers on commitments and responsibilities.',
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
						'label' => '7.Understands the basic commercial, financial and operational factors driving business performance.',
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
						'label' => '8.Continuously explores ways to innovate established work processes.', 
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
						'label' => '9.Proactively builds and maintain network of useful business contacts.',
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
						'label' => '10.Proactively seeks feedback to enhance own performance.',
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
						'label' => '11.Actively listens to the needs / concerns of others and responds appropriately / timely.',
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
						'label' => '12.Aims to achieve stretch goals and puts plans in place to ensure successful completion.',
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
						'label' => '13.Actively contributes to setting objectives and strategies for own and related areas.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question08c',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '14.Collaborates with others to achieve team objectives.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		));
		
		$this->add(array(
				'name' => 'Question09a',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '15.Shows self-discipline in complying with the Code of Conduct and Business Ethics.',
						'value_options' => array(
								'1' => ' 1','2' => ' 2','3' => ' 3','4' => ' 4',
						),
				),
		)); 
		
		$this->add(array(
				'name' => 'Question09b',
				'type' => 'Zend\Form\Element\Radio',
				'attributes' => array('required' => 'required'),
				'options' => array(
						'label' => '16.Prioritises actions according to their value to the business.',
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
						'label' => '17.*****Thinks creatively in approaching issues / solutions.',
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
						'label' => '18.Uses informal settings to build trusting relationships with business contacts.',
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
						'label' => '19.Seeks out and acts on opportunities to further develop own skills and capabilities.',
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
						'label' => '20.Works flexibly and respectfully with others who have different working styles.',
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
						'label' => '21.Adopts a \'can do\' attitude when faced with new challenges.',
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
						'label' => '22.Aligns own actions with the strategies of the business.',
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
						'label' => '23.Shows respect for team members and value their inputs.',
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
						'label' => '24.Demonstrates humility and sincerity.',
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
						'label' => '25.Develops well-thought out proposals that adds value to the business.',
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
						'label' => '26.Proactively proposes and implements ways to improve efficiency.',
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
						'label' => '27.Mutually shares knowledge and experiences with a wide circle of contacts.',
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
						'label' => '28.Shares knowledge with others.',
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
						'label' => '29.Proactively gets to know people from different backgrounds and cultures.',
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
						'label' => '30.Takes personal responsibility to resolve problems and works well to overcome them.',
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
						'label' => '31.Gives business ideas that are in line with the strategic direction.',
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
						'label' => '32.Shows concern for team and takes pride in team\'s achievements.',
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
						'label' => '33.Takes personal accountability for mistakes.',
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
						'label' => '34.Takes calculated and responsible risks to improve department performance.',
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
						'label' => '35.Receptive to new ideas and willing to do things differently.',
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
						'label' => '36.Leverages on network for solving problems and difficult issues.',
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