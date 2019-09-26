<?php

class Everlytic_Productapi_IndexController extends Mage_Core_Controller_Front_Action{
    public function indexAction(){
        $product = $this->getRequest()->getParam('product');
        $key =  Mage::getSingleton('core/session')->getFormKey();;
        if (empty($product)){
            $this->_redirect('');
        }
        else{
            $this->_redirect('checkout/cart/add', array('product'=>$product, 'form_key'=>$key));
        }
    }
}