<?php
class Model_DbTable_Complain extends Zend_Db_Table_Abstract
{
    protected $_name = 'complain';
    public function insert ($data, $id = NULL)
    {
        $data['status'] = 1;
        $responseCode = $this->getResponseId();
        $data['response_code'] = $responseCode;
        $data['created_on'] = date('Y-m-d g:i:s');
        if ($id == null) {
            $result = parent::insert($data);
        } else {
            $result = parent::update($data, 'complain_id =' . $id);
        }
        return $responseCode;
    }
    public function getAllComplains ()
    {
        $result = $this->select();
        return $this->fetchAll($result);
    }
    public function getComplain ($id)
    {
        $result = $this->select()->where('complain_id = ?', $id);
        return $this->fetchAll($result);
    }
    /**
     * Enter description here ...
     * @return string
     */
    public function getResponseId ()
    {
        $id = 0;
        $select = $this->select()
            ->from($this->_name, array('complain_id'))
            ->order('complain_id Desc');
        $data = $this->fetchRow($select);
        if ($data) {
            $data = $data->toArray();
            $lastid = $data['complain_id'];
            $id = $lastid + 1;
        } else {
            return id;
        }
        $time = time();
        $timeId = $time + $id;
        $responseCode = base_convert($time, 10, 36);
        return $responseCode;
    }
    /**
     * Enter description here ...
     * @param unknown_type $condition
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getComplainsByCondition ($condition = array())
    {
        $complain_type = null;
        $date = null;
        $district_id = null;
        extract($condition);
        $select = $this->select()
            ->from($this->_name, 
        array('complain_text', 'address', 'name', 'response_code', 'complain_type', 'date', 'district_id', 'status'))
            ->where('complain_type = ?', $complain_type)
            ->where('date = ?', $date)
            ->where('district_id = ?', $district_id);
        $result = $this->fetchAll($select);
        if ($result)
            $result = $result->toArray();
        return $result;
    }
    /**
     * Enter description here ...
     * @param unknown_type $responseCode
     * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
     */
    public function getComplainStatus ($responseCode)
    {
        $select = $this->select()
            ->from($this->_name, array('status'))
            ->where('response_code = ?', $responseCode);
        $result = $this->fetchRow($select);
        if ($result)
            $result = $result->toArray();
        return $result;
    }
    /**
     * Enter description here ...
     * @param unknown_type $response
     * @return mixed
     */
    public function xmlConverter ($response)
    {
        $xml = new SimpleXMLElement('<complains/>');
        foreach ($response as $responsePair) {
            $responseArray[]['complain'] = $responsePair;
        }                        
        // creating object of SimpleXMLElement
        $xmlObj = new SimpleXMLElement(
        "<?xml version=\"1.0\"?><complains></complains>");
        // function call to convert array to xml
        $result = $this->array_to_xml($responseArray, $xmlObj);
        return  $xmlObj->asXML();
        
    }
    // function defination to convert array to xml
    /**
     * Enter description here ...
     * @param unknown_type $records
     * @param unknown_type $xml_records
     * @return Ambiguous
     */
    function array_to_xml ($records, &$xml_records)
    {
        foreach ($records as $key => $value) {
            if (is_array($value)) {
                if (! is_numeric($key)) {
                    $subnode = $xml_records->addChild("$key");
                    $this->array_to_xml($value, $subnode);
                } else {
                    $this->array_to_xml($value, $xml_records);
                }
            } else {
                $result = $xml_records->addChild("$key", "$value");
            }            
        }
        return $result;
    }
}

