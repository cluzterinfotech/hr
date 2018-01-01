<?php 
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Position;
use Application\Model\PositionGrid;
use Zend\Form\Annotation\AnnotationBuilder;
use Application\Form\PositionForm; 
use Application\Model\PositionTest;

class InfoController extends AbstractActionController  {
	
	protected $positionTable;
	protected $resultSet;
	protected $customerTable;
	protected $dbAdapter;
	protected $moduleOptions;
	protected $positionService;
	
	public function form($position) {
		$builder = new AnnotationBuilder ();
		return $builder->createForm($position);
	}
	
	public function unabletoprepareAction() { 
		return array();
	}
	
	public function nothavepermissionAction() {
		return array(); 
	}
	
	public function indexAction() {
		$position = new PositionForm ();
		$form = $this->form($position);
		/*$form->get('reportingPosition')->setValueOptions(array(
				'' => '',
				'1' => 'test a',
				'2' => 'test b' 
		));*/
		// \Zend\Debug\Debug::dump($form);
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->bind ( $position );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				// $obj = $form->getData();
				// echo $obj->absentid;
				// echo $obj->name;
			}
		}
		return array (
				'form' => $form 
		);
	}
	/*
	 * //return new ViewModel();
	 * $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
	 *
	 * $user = new User();
	 * $user->setFullName('test dhayal');
	 *
	 * $objectManager->persist($user);
	 * $objectManager->flush();
	 *
	 * //die(var_dump($user->getId()));
	 */
	public function listAction() {
		$positionService = $this->getPositionService();
		/*$this->flashMessenger()
		       ->setNamespace('info')
		       ->addMessage('Please refer checklist for associated process');*/
		// $result = $positionService->fetchAll();
		// \Zend\Debug\Debug::dump($result);
		/*
		 * $row = $positionService->fetchById('1');
		 * \Zend\Debug\Debug::dump($row,"<br/>");
		 * $row->name = 'test';
		 * \Zend\Debug\Debug::dump($row,"<br/>");
		 *
		 *
		 * $positionEntity = new PositionEntity();
		 * $positionEntity->name = 'hi';
		 * \Zend\Debug\Debug::dump($positionEntity,"<br/>");
		 * //$x = (array) $result;
		 * //var_dump(get_object_vars($result));
		 */
		/*
		 * foreach($result as $v=>$r) {
		 * //echo $r->name."<br/>";
		 * \Zend\Debug\Debug::dump($r,"<br/>");
		 * \Zend\Debug\Debug::dump($v,"<br/>");
		 * //\Zend\Debug\Debug::dump($v,"<br/>");
		 * //exit;
		 * echo "<br />";
		 * echo "Id : ".$r->id."<br/>";
		 * echo "Name : ".$r->name."<br/>";
		 * echo "Section : ".$r->section."<br/>";
		 * echo "Level : ".$r->level."<br/>";
		 * echo "sequence : ".$r->sequence."<br/>";
		 * echo "Reporting : ".$r->reportingPosition."<br/>";
		 * //echo get_object_vars($r);
		 * //echo "test";
		 * }
		 *
		 */
		// \Zend\Debug\Debug::dump((array) $result);
		// \Zend\Debug\Debug::dump($result);
		
		  $positionEntity = new PositionTest();
		  
		  $positionEntity->setLevel('2');
		  $positionEntity->setName('dhayal');
		  $positionEntity->setSequence('2');
		  $positionEntity->setSection('151');
		  $positionEntity->setStatus('1');
		  $positionEntity->setReportingPosition('3');
		
		
		// echo $positionService->insert($positionEntity);
		// echo "<br />";
		 echo $positionService->insert($positionEntity);
		 echo "<br />";
		// for($i=1317;$i<1342;$i++) {
		/*
		 * $positionEntity = new Position(array(
		 * "id" => (int)$i,
		 * 'name' => 'new value val',
		 * 'level' => '2',
		 * 'sequence' => '2',
		 * 'section' => '151',
		 * 'reportingPosition' => '3',
		 * 'status' => '1'));
		 */
		// echo $positionService->fetchById($i)."<br/>";
		// }
		
		// \Zend\Debug\Debug::dump($row);
		
		$rowx = $positionService->fetchById ('1240');
		
		$rowy = $positionService->fetchById ('1240');
		// $rowx = $positionService->fetchById('1265');
		// $rowx = $positionService->fetchById('1266');
		
		echo $rowx->getName();
		echo "<br />";
		/* echo $rowy->name;
		
		$rowx->name = 'alaa';
		$rowy->name = 'ahmed';
		
		echo "<br />";
		echo $rowx->name;
		echo "<br />";
		echo $rowy->name;  */
		\Zend\Debug\Debug::dump ( $rowx );
		//$positionService->delete ( $rowx );
		\Zend\Debug\Debug::dump ( $rowy );
		// \Zend\Debug\Debug::dump($row);
		// \Zend\Debug\Debug::dump($rowx);
		// \Zend\Debug\Debug::dump($positionEntity);
		// \Zend\Debug\Debug::dump($positionEntity->toArray());
		// $positionEntity->
		// $positionEntity->l
		/*
		 * \Zend\Debug\Debug::dump($result,'<br/>');
		 * foreach($result as $v) {
		 * foreach($v as $r) {
		 * var_dump($r,'<br />');
		 * }
		 * //echo var_dump($v,'<br />');
		 * //echo $v."<br/>";
		 * }
		 */
		exit ();
		// \Zend\Debug\Debug::dump($this->getSource());
		/*
		 * $grid = new PositionGrid();
		 * $grid->setAdapter($this->getDbAdapter())
		 * ->setSource($this->getSource())
		 * ->setParamAdapter($this->getRequest()->getPost())
		 * ;
		 * return $this->htmlResponse($grid->render());
		 */
		/*
		 * $adapter = new PdoAdapter("mysql:dbname=test", "myfancyusername",
		 * "myhardtoguesspassword");
		 *
		 * $unitOfWork = new UnitOfWork(new UserMapper($adapter,
		 * new EntityCollection), new ObjectStorage);
		 *
		 * $user1 = new User(array("name" => "John Doe",
		 * "email" => "john@example.com"));
		 * $unitOfWork->registerNew($user1);
		 *
		 * $user2 = $unitOfWork->fetchById(1);
		 * $user2->name = "Joe";
		 * $unitOfWork->registerDirty($user2);
		 *
		 * $user3 = $unitOfWork->fetchById(2);
		 * $unitOfWork->registerDeleted($user3);
		 *
		 * $user4 = $unitOfWork->fetchById(3);
		 * $user4->name = "Julie";
		 *
		 * $unitOfWork->commit();
		 * echo "section.............!";
		 * exit;
		 */
	}
	
	public function sectionAction() {
		/*try {
			
		$facade = new \TrialFacade();
		$facade->threeDifferentTransaction($this->getServiceLocator()->get('sqlServerAdapter'));
		
		} catch(\Exception $e) {
			throw $e;
		}
		exit;*/
	}
	
	public function changesAction() { }
	
	public function bootstrapAction() { }
	
	public function ajaxlistAction() {
		// \Zend\Debug\Debug::dump($this->getSource());
		$grid = new PositionGrid ();
		$grid->setAdapter($this->getDbAdapter())->setSource($this->getSource())->setParamAdapter ( $this->getRequest ()->getPost () );
		return $this->htmlResponse($grid->render());
	}
	public function addAction() {
		/*$student = new Student ();
		$builder = new AnnotationBuilder ();
		$form = $builder->createForm ( $student );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->bind ( $student );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				print_r ( $form->getData () );
			}
		}
		return array (
				'form' => $form 
		);*/
	}
	public function htmlResponse($html) {
		$response = $this->getResponse ();
		$response->setStatusCode ( 200 );
		$response->setContent ( $html );
		return $response;
	}
	public function getDbAdapter() {
		if (! $this->dbAdapter) {
			$sm = $this->getServiceLocator ();
			$this->dbAdapter = $sm->get ( 'sqlServerAdapter' );
		}
		return $this->dbAdapter;
	}
	public function getPositionTable() {
		if (! $this->positionTable) {
			$sm = $this->getServiceLocator ();
			$this->positionTable = $sm->get('Position\Model\PositionTable');
		}
		return $this->positionTable;
	}
	public function getSource() {
		return $this->getPositionTable()->fetchAll($this->getDbAdapter());
	}
	public function getPositionService() {
		if (! $this->positionService) {
			$sm = $this->getServiceLocator();
			$this->positionService = $sm->get('positionService');
		}
		return $this->positionService;
	}
}
