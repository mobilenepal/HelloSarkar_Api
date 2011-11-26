<?php

class Model_DbTable_Complain extends Zend_Db_Table_Abstract
{

    protected $_name = 'complain';

    public function insert($formData , $id=NULL)
    {
        unset($formData['submit']);
        if($id == null)
        {
            $result = parent::insert($formData);
        }
        else
        {
            $result = parent::update($formData,'complain_id =' .$id);
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

