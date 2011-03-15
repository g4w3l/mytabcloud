<?php 
class Zend_View_Helper_JavascriptHelper extends Zend_View_Helper_Abstract
{   
    function javascriptHelper() {

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = '/mytabcloud/public/js/mytabcloud/' . $request->getControllerName() . '.js';

        $this->view->headScript()->appendScript('const NB_BEATS = ' . NB_BEATS . ';');
        //if (file_exists($file_uri)) {
            $this->view->headScript()->appendFile($file_uri);
        //}
        
        
    }
}
