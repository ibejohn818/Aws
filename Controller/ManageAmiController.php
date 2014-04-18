<?php 

App::uses("AwsAppController","Aws.Controller");


class ManageAmiController extends AwsAppController {


    public $uses = array();

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow();

    }

    public function index() {
        
        

    }

    public function add() {
        
        if($this->request->is("post") || $this->request->is("put")) {
        
            
        
        }

    }

}