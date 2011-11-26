<?php

class ComplainController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function receiveAction()
    {
        $this->getHelper('ViewRenderer')->setNoRender('false');
        try {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost();
                $model = new Model_DbTable_Complain;
                $response = $model->insert($data);
                if($response){
                    $this->getResponse()->setHttpResponseCode(200);
                    print $response;
                }
                else{
                    throw new Exception('Service Unavailable','503');
                }
            }
            else{
                throw new Exception('Bad Parameters','400');
            }
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode($e->getCode());
            print 0;
        }
        
    }

}





