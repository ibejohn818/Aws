<?php 

App::uses("AwsAppController","Aws.Controller");


class AwsController extends AwsAppController {

    public $uses = array();

    /**
     * beforeFilter callback
     *
     * @return void
     */
    public function beforeFilter() {
            
        parent::beforeFilter();

        $this->Auth->allow();
        
    }
    

}