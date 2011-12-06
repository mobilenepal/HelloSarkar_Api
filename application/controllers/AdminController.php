<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function editComplainAction()
    {
        try{
            $id = $this->getRequest()->getParam('id');
            if(!$id) {
                throw new Exception('Invalid Request');
            }
            $modelComplain = new Model_DbTable_Complain();
            $tableData = $modelComplain->getComplain($id);
            if($tableData)
            $tableData = $tableData->toArray();
            $form = new Form_EditComplain();
            if ($this->getRequest()->isPost())
			{ 
			    $data = $this->getRequest()->isPost();
			    if($form->isValid($data))
			    {
			    $result = $modelComplain->insert($data, $id);
			    if(!$result){
			        throw new Exception('Error');
			    }
			    $this->_redirect('complain/list-complain');
			    
			    } else {
			        $form->populate($data);
			    }
			} else {			    
			    $form->populate($tableData);			    
			}			           
            $this->view->form = $form;
        } catch (Exception $e) {
            $this->_redirect('complain/list-complain');
        }
    }


}



