<?php  
namespace Lbvf\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods; 
use Application\Entity\AssessmentFormThree;

class AssessThreeForm extends Form
{
	public function construct($name = null)
	{
		parent::construct('assessThreeForm');
		$this->setAttribute('method', 'post'); 
		$this->setAttribute('novalidate');
		$this->setHydrator(new ClassMethods(false))->setObject(new AssessmentFormThree()); 
        
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
						'label' => '1.Accurately identifies people\'s strengths, development needs and potential.', 
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
				'label' => '2.Presents ideas convincingly and seeks to present and share beneficial ideas at inter-departmental and / or high level committee meetings.',
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
						'label' => '3.Sets challenging goals and actively monitors progress.',
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
						'label' => '4.Shows strong commitment towards realising the organisation\'s long term vision and goals.',
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
						'label' => '5.Facilitates exchange of ideas and opinions among teams from across the business.	',
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
						'label' => '6.Upholds and exemplifies efficient approaches in delivering responsibilities.',
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
						'label' => '7.Champions innovative and value-creating business initiative.', 
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
						'label' => '8.Captures innovation and ideas from internal and external best practices and adapt to enhance own area.',
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
						'label' => '9.Builds an extensive and value-adding network, both within PETRONAS and globally.',
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
						'label' => '10.Guides and supports team and others to identify and create development opportunities. ',
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
						'label' => '11.Nurtures mutually supportive working environment.',
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
						'label' => '12.Motivates team to sustain performance when faced with challenges.',
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
						'label' => '13.Engage across functions to achieve the business strategic directions.',
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
						'label' => '14.Ensures that everyone feels part of the team and that their contributions are valued.',
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
						'label' => '15.Promotes high standards of ethical conduct and takes effective action on non-compliance.',
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
						'label' => '16.Anticipates and addresses current and future key commercial and financial issues which impact department opportunities.',
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
						'label' => '17.Inspires others to be creative and to continuously introduce innovation.',
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
						'label' => '18.Targets key individuals and organisations to establish strategically important business relationships.',
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
						'label' => '19.Provides insightful and constructive feedback that enhances people performance.',
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
						'label' => '20.Promotes a harmonious working environment and manage to resolve conflicts if any.',
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
						'label' => '21.Acknowledges and encourages others to recognize accomplishments and clearly communicate consequences for non-performance.',
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
						'label' => '22.Proactively shapes the future strategic direction for own business area.',
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
						'label' => '23.Promotes cooperation between teams and encourages others to work together towards a collective purpose.',
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
						'label' => '25.Capitalises on opportunities to improve or protect the long term financial performance of the business.',
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
						'label' => '26.Propose bold changes in working practices that have impact across departments and disciplines.',
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
						'label' => '27. Drives collaboration with international industry peers.',
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
						'label' => '28.Encourages and supports the identification and development of talented people.',
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
						'label' => '29.Is receptive to the very different perspectives of other departments and functional groups.',
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
						'label' => '30.Motivates others to maintain high levels of performance and enthusiasm in face of setbacks.	',
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
						'label' => '31.Contributes significantly to high level strategic discussion in shaping business strategies.',
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
						'label' => '32.Encourages team members to leverage on each other\'s diverse skills and abilities.',
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
						'label' => '34.Encourages and promotes commercial, business and risk savviness among employees.',
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
						'label' => '35.Motivates others to embrace change and to seize the opportunities that it provides.',
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
						'label' => '36.Constructively works with external business partners to secure business opportunities.',
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