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
                $this->logger->log($e->getMessage(), Zend_Log::ERR, 'RECEIVE: ERROR');
            }
            print 0;
        }
    }

    public function getstatusAction()
    {
        $this->logger = Zend_Registry::get('logger');
        $this->getHelper('ViewRenderer')->setNoRender('false');
        try {
            if ($this->getRequest()->isPost()) {
                $this->logger->log('Post Parameters Received', Zend_Log::INFO,
                'PASS');
                $data = $this->getRequest()->getPost();
                if (! $data['response_code']) {
                    throw new Exception('Bad Parameters', '400');
                }
                $responseCode = $data['response_code'];
                $model = new Model_DbTable_Complain();
                $response = $model->getComplainStatus($responseCode);
                if ($response) {
                    $this->getResponse()->setHttpResponseCode(200);
                    $this->logger->log('Succesful Status Query', Zend_Log::INFO,
                    'SUCCESS');
                    $status = $response['status'];
                    print $status;
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
                $this->logger->log($e->getMessage(), Zend_Log::ERR, 'STATUS: ERROR');
            }
            print 0;
        }

    }

    public function queryAction()
    {
        $this->logger = Zend_Registry::get('logger');
        $this->getHelper('ViewRenderer')->setNoRender('false');
        try {
            if ($this->getRequest()->isPost()) {
                $this->logger->log('Post Parameters Received', Zend_Log::INFO,
                'PASS');
                $data = $this->getRequest()->getPost();
                if (! $data['complain_type'] || ! $data['district_id'] || ! $data['date']) {
                    throw new Exception('Bad Parameters', '400');
                }
                $model = new Model_DbTable_Complain();
                $response = $model->getComplainsByCondition($data);
                if ($response) {
                    $this->getResponse()->setHttpResponseCode(200);
                    $this->logger->log('Succesful QueryPerformed', Zend_Log::INFO,
                    'SUCCESS');
                    $model->xmlConverter($response);
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
                $this->logger->log($e->getMessage(), Zend_Log::ERR, 'QUERY: ERROR');
            }
            print 0;
        }
    }
    public function listComplainAction()
    {
        $model = new Model_DbTable_Complain();
        $response = $model->getAllComplains();
        if ($response) {
            $this->view->datas = $response->toArray();
        }
    }
}





