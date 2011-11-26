<?php

class Model_DbTable_Complain extends Zend_Db_Table_Abstract
{

    protected $_name = 'complain';

    public function insert($data , $id=NULL)
    {
        $data['status']=1;
        $responseCode = $this->getResponseId();
        $data['response_code']= $responseCode;
        $data['created_on']=date('Y-m-d g:i:s');
        if($id == null)
        {
            $result = parent::insert($data);
        }
        else
        {
            $result = parent::update($data,'complain_id =' .$id);
        }
        return $responseCode;
    }

    public function getAllComplains()
    {
        $result = $this->select();
        return $this->fetchAll($result);
    }

    public function getComplain($id)
    {
        $result = $this->select()
        ->where('complain_id = ?',$id);
        return $this->fetchAll($result);
    }
    
    public function getResponseId()
    {    $id = 0;        
         $select = $this->select()->from($this->_name, array('complain_id'))->order('complain_id Desc');
         $data = $this->fetchRow($select);
         if($data)
         {
             $data = $data->toArray();
             $lastid = $data['complain_id']; 
             $id = $lastid +1 ;                
         } else {
             return id;    
         }                          
         $time = time();
         $timeId = $time + $id;
         $responseCode = base_convert($time, 10, 36);
         return $responseCode;                        
    }
}

