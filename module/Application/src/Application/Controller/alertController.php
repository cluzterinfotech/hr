<?php
namespace Application\Controller;

use Application\Form\AddAlertForm;
use Application\Form\AlertFormValidator;
use Application\Form\PolicyFormValidator;
use Application\Model\PolicyGrid;
use Application\Model\alertGrid;
use Zend\Console\Response;
use Zend\Mvc\Controller\AbstractActionController;


class alertController extends AbstractActionController {
    
    public function indexAction() {  }
    
    public function listalertAction() { }
    
    public function ajaxlistAction() {
        $grid = $this->getGrid();
        $grid->setAdapter($this->getDbAdapter())
             ->setSource($this->getService()->getAllAlerts())
             ->setParamAdapter($this->getRequest()->getPost());
        return $this->htmlResponse($grid->render());
    }
    
    public function addalertAction() {
        $form = $this->getForm();
        $prg = $this->prg('/alert/addalert', true);
        //echo \Zend\Debug\Debug::dump( $prg );
        if ($prg instanceof Response ) {
            return $prg;
        } elseif ($prg === false) {
            return array ('form' => $form);
        }
        $formValidator = $this->getFormValidator();
        $form->setInputFilter($formValidator->getInputFilter());
        $form->setData($prg);
        if ($form->isValid()) {
            $data = $form->getData();
           echo \Zend\Debug\Debug::dump($data);
           //exit;
            try {
                $service = $this->getService();
                $service->insert($data);
                $this->flashMessenger()->setNamespace('success')
                ->addMessage('Alert successfully');
                $this->redirect ()->toRoute('alert',array (
                    'action' => 'addalert'
                ));
            } catch(\Exception $e) {
                $this->flashMessenger()->setNamespace('error')
                ->addMessage($e->getMessage()." please check your entries");
                $this->redirect ()->toRoute('alert',array (
                    'action' => 'addalert'
                ));
            }
        } else {
           echo "ERRRRRRRRRRRRRRRRRRRRORRRRRRRRRRRRRR";
        }
        return array(
            'form' => $form,
            $prg
        );
    }
    
    /*public function editAction() {
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->flashMessenger()->setNamespace('info')
            ->addMessage('Policy not found,Please Add');
            $this->redirect()->toRoute('policymanual', array(
                'action' => 'listpolicy'
            ));
        }
        $form = $this->getForm();
        $service = $this->getService();
        $policy = $service->fetchById($id);
        $form = $this->getForm();
        $form->bind($policy);
        $form->get('submit')->setAttribute('value','Update policy');
        $prg = $this->prg('/policymanual/edit/'.$id, true);
        if ($prg instanceof Response ) {
            return $prg;
        } elseif ($prg === false) {
            return array ('form' => $form);
        }
        $formValidator = $this->getFormValidator();
        $form->setInputFilter($formValidator->getInputFilter());
        $form->setData($prg);
        if ($form->isValid()) {
            $data = $form->getData();
            try {
                $service = $this->getService();
                $service->update($data);
                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('policy updated successfully');
                $this->redirect ()->toRoute('policymanual',array (
                    'action' => 'listpolicy'
                ));
            } catch(\Exception $e) {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage($e->getMessage()." please check your entries");
                $this->redirect ()->toRoute('policymanual',array (
                    'action' => 'listpolicy'
                ));
            }
        }
        return array(
            'form' => $form,
            $prg
        );
    }*/
    
    
    public function deletealertAction() {
        try{
            $id = (int) $this->params()->fromRoute('id', 0);
            $service = $this->getService();
            $alert = $service->DeleteAlertById($id);
            $this->flashMessenger()->setNamespace('success')
            ->addMessage('alert Deleted successfully');
            $this->redirect ()->toRoute('alert',array (
                'action' => 'listalert'
            ));
        }catch(\Exception $e) {
            $this->flashMessenger()->setNamespace('error')
            ->addMessage($e->getMessage()." please check your entries");
            $this->redirect ()->toRoute('alert',array (
                'action' => 'listalert'
            ));
        }
       /* echo \Zend\Debug\Debug::dump( $id );
        if (!$id) {
            $this->flashMessenger()->setNamespace('info')
            ->addMessage('Sorry Alert Not Found ,Please Add');
            $this->redirect()->toRoute('alert', array(
                'action' => 'listalert'
            ));
        }
        $form = $this->getForm();
        $service = $this->getService();
        $alert = $service->fetchAlertById($id);
        $form = $this->getForm();
        $form->bind($alert);
        $form->get('submit')->setAttribute('value','Delete Alert');
        $prg = $this->prg('/alert/deletealert/'.$id, true);
        if ($prg instanceof Response ) {
            return $prg;
        } elseif ($prg === false) {
            return array ('form' => $form);
        }
        $formValidator = $this->getFormValidator();
        $form->setInputFilter($formValidator->getInputFilter());
        $form->setData($prg);
        if ($form->isValid()) {
            $data = $form->getData();
            try {
                $service = $this->getService();
                $service->delete($data);
                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('alert Deleted successfully');
                $this->redirect ()->toRoute('alert',array (
                    'action' => 'deletealert'
                ));
            } catch(\Exception $e) {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage($e->getMessage()." please check your entries");
                $this->redirect ()->toRoute('alert',array (
                    'action' => 'listalert'
                ));
            }
        }
        return array(
            'form' => $form,
            $prg
        );*/
    } 
    
    public function usermanualreportAction() {
        $service = $this->getService();
        $manual = $service->fetchManual(); 
        return array(
            'manual' => $manual
        );
    }
    
    public function htmlResponse($html) {
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent($html);
        return $response;
    }
    
    private function getService() {
        return $this->getServiceLocator()->get('AlertService');
    }
    
    private function getDbAdapter() {
        return $this->getServiceLocator()->get('sqlServerAdapter');
    }
    

    public function getForm() {
        $form = new  AddAlertForm();
        $form->get('isCC')
        ->setOptions(array('value_options' => $this->getCcOptions()))
        ;
        $form->get('positionId')
        ->setOptions(array('value_options' => $this->getPositionList()))
        ;
        $form->get('alertId')
        ->setOptions(array('value_options' => $this->getAlertsTypes()))
        ;        
          
        return $form;
    }
    
    public function getCcOptions() {
        //$service = $this->serviceLocator->get('salaryGradeService');
        return $this->getService()->getCcOptions();
    }    
  
    public function getAlertsTypes() {
        //$service = $this->serviceLocator->get('salaryGradeService');
        return $this->getService()->getAlertsTypes();
    }     
    public function getPositionList() {
        //$service = $this->serviceLocator->get('salaryGradeService');
        return $this->getPositionService()->getPositionList();
    }
    private function getPositionService() {
        return $this->getServiceLocator()->get('positionService');
    }
    private function getFormValidator() {
        return new AlertFormValidator();
    }
    
    private function getGrid() {
        return new alertGrid();
    }
    
}