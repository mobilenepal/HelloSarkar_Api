<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initRegisterNamespace()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('App_');
    }
    
    /** -- set up 4 writers
    * 1) One writer as an e-mailer, which is filtered by Error level errors or higher
    * 2) Another writer is everything, which is filtered by Warnings and higher on production environment
    * 3) Another writer is channeled to Firebug for debugging ( disabled on production )
    * 3) The last writer saves to the session, so it can be shown on the bottom of each page ( disabled on production )
    *
    * here are the default error levels--we can use these while appending a message format which reveals
    * location ( class/method ) and the action
    *
    * EMERG   = 0;  Emergency: system is unusable
    * ALERT   = 1;  Alert: action must be taken immediately
    * CRIT    = 2;  Critical: critical conditions
    * ERR     = 3;  Error: error conditions
    * WARN    = 4;  Warning: warning conditions
    * NOTICE  = 5;  Notice: normal but significant condition
    * INFO    = 6;  Informational: informational messages
    * DEBUG   = 7;  Debug: debug messages
    */
    protected function _initLogger()
    {
        $config = $this->getOption('email');
        $logger = new App_Log();

        $db = $this->getPluginResource('db')->getDbAdapter();

        $columnMapping = array('priority' => 'priority', 'message' => 'message',
            'timestamp' => 'timestamp', 'account_id' => 'account_id', 'type' => 'type'
        );
        $logWriter = new Zend_Log_Writer_Db($db, 'watchdog', $columnMapping);
        $logger->addWriter($logWriter);

        // non-production gets firebug and session log writers
        if ( APPLICATION_ENV != 'production' )
        {
            $writer_firebug = new Zend_Log_Writer_Firebug();
            //$logger->addWriter($writer_firebug);

            $writer_session = new App_Log_Writer_Session();
            $logger->addWriter($writer_session);
        }
        // production gets email log writer
        elseif ( APPLICATION_ENV == 'production' )
        {
            $email = new Zend_Mail();

            $email->setFrom($config['fromAddress'])
                  ->addTo($config['errLogging']);

            $writer_email = new Zend_Log_Writer_Mail($email);
            $writer_email->setSubjectPrependText('Urgent: Server Errror!');

            // only email warning level "errors" or higher
            $writer_email->addFilter(Zend_Log::WARN);
            $logger->addWriter($writer_email);
        }

        Zend_Registry::set('logger', $logger);

        return $logger;
    }
    
   


}

