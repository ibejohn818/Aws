<?php 

App::uses("AwsAppController","Aws.Controller");


class Ec2SecurityGroupsController extends AwsAppController {


    public $uses = array();

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow();

    }

    public function index() {

        $ec2 = AwsSdk::client()->get("Ec2");

        $groups = $ec2->describeSecurityGroups();

        $this->set(compact("groups"));

    }

    public function add() {
        

    }

    public function edit() {
        
    }

    public function delete() {
        
    }

}