<?php 
if(!function_exists('settings')){
    
    function segment(){
        $request = \Config\Services::request();

        return $request;
    }

       
}
?>