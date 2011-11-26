<?php

class App_Log extends Zend_Log
{
    public function log($message, $priority, $type = '', $account_id = null, $extras = null)
    {
        $extras['account_id'] = 'Guest';
        $extras['type'] = $type;        
        parent::log($message, $priority, $extras);
    }
}