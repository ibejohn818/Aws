<?php 


App::uses('AwsAppController','Aws.Controller');

class Ec2LoadBalancersController extends AwsAppController {
    
    public $uses = array();

    public function beforeFilter() {
        
        parent::beforeFilter();

    }
    
    public function index() {



    }

    public function create() {

        if($this->request->is("post") || $this->request->is("put")) {
        
            $elb = AwsSdk::client($this->request->data['Ec2LoadBalancer']['sdk_config'])->get('ElasticLoadBalancing');
            
            $elb->createLoadBalancer(array(
                
            ));

        }

    }
    
    public function edit($id = NULL) {
    

    }

    public function delete($id = NULL) {

    }

}