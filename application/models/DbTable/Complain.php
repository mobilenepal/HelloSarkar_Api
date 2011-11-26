<?php

class Model_DbTable_Complain extends Zend_Db_Table_Abstract
{

    protected $_name = 'complain';

    public function insert($data , $id=NULL)
    {
        $data['status']=1;
        $data['response_code']=$this->getresponsecode();
        $data['created_on']=date('Y-m-d g:i:s');
        if($id == null)
        {
            $result = parent::insert($data);
        }
        else
        {
            $result = parent::update($data,'complain_id =' .$id);
        }
        return $result;
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
}

