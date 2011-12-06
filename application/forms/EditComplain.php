<?php 
class Form_EditComplain extends Zend_Form
{
    public function init()
    {
       // parent::_contruct($option);
        $this->setName('Edit Complain');
        $status = new Zend_Form_Element_Text('status');
        $status->setLabel('Status')->setRequired();
                
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Edit');
               
        $this->addElements(array($status, $submit));
        $this->setMethod('post');
        //$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/user/login');
    }
}//end of class