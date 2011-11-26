<?php
class ComplainController extends Zend_Controller_Action
{
    protected $logger;
    public function init ()
    {
        /* Initialize action controller here */
    }
    public function receiveAction ()
    {
        $this->logger = Zend_Registry::get('logger');
        $this->getHelper('ViewRenderer')->setNoRender('false');
        try {
            if ($this->getRequest()->isPost()) {
                $this->logger->log('Post Parameters Received', Zend_Log::INFO, 
                'PASS');
                $data = $this->getRequest()->getPost();
                if (! $data['complain_type'] || ! $data['district_id'] || ! $data['address']  || ! $data['complain_text'] || ! $data['date']) {
                    throw new Exception('Bad Parameters', '400');
                }
                $model = new Model_DbTable_Complain();
                $response = $model->insert($data);
                if ($response) {
                    $this->getResponse()->setHttpResponseCode(200);
                    $this->logger->log('Succesful Post', Zend_Log::INFO, 
                    'SUCCESS');
                    print $response;
                } else {
                    throw new Exception('Service Unavailable', '503');
                }
            } else {
                throw new Exception('Bad Parameters', '400');
            }
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode($e->getCode());
            if ($e->getCode() == 503) {
                $this->logger->log($e->getMessage(), Zend_Log::WARN, 
                'SYSTEM ERROR');
            } else {
                $this->logger->log($e->getMessage(), Zend_Log::ERR, 'ERROR');
            }
            print 0;
        }
    }
}





