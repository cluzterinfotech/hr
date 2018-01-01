<?php
namespace Application\Controller;

use Zend\Console\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\AddPolicyForm;
use Application\Form\PolicyFormValidator;
use Application\Model\PolicyGrid;


class PolicymanualController extends AbstractActionController {
    
    public function indexAction() { exit; }
    
    public function listpolicyAction() { }
    
    public function ajaxlistAction() {
        $grid = $this->getGrid();
        $grid->setAdapter($this->getDbAdapter())
             ->setSource($this->getService()->select())
             ->setParamAdapter($this->getRequest()->getPost());
        return $this->htmlResponse($grid->render());
    }
    
    public function addpolicyAction() {
        $form = $this->getForm();
        $prg = $this->prg('/policymanual/addpolicy', true);
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
           //echo \Zend\Debug\Debug::dump($data);
            //exit;
            try {
                $service = $this->getService();
                $service->insert($data);
                $this->flashMessenger()->setNamespace('success')
                ->addMessage('Policy successfully');
                $this->redirect ()->toRoute('policymanual',array (
                    'action' => 'addpolicy'
                ));
            } catch(\Exception $e) {
                $this->flashMessenger()->setNamespace('error')
                ->addMessage($e->getMessage()." please check your entries");
                $this->redirect ()->toRoute('policymanual',array (
                    'action' => 'addpolicy'
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
    
    public function editAction() {
        
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
    }
    
    
    public function deleteAction() {
        
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
        $form->get('submit')->setAttribute('value','Delete policy');
        $prg = $this->prg('/policymanual/delete/'.$id, true);
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
                     ->addMessage('policy Deleted successfully');
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
        return $this->getServiceLocator()->get('PolicyMapper');
    }
    
    private function getDbAdapter() {
        return $this->getServiceLocator()->get('sqlServerAdapter');
    }
    
    private function getForm() {
        return new AddPolicyForm();
    }
    
    private function getFormValidator() {
        return new PolicyFormValidator();
    }
    
    private function getGrid() {
        return new PolicyGrid();
    }
    
}