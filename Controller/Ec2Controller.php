<?php 

App::uses("AwsAppController","Aws.Controller");


class Ec2Controller extends AwsAppController {

    public $uses = array(
        "Aws.Ec2Instance"
    );

    public function beforeFilter() {
        
        parent::beforeFilter();
        
    }
    

    public function index() {

        if(isset($this->request->params['named']['aws_sdk_config_id'])) {

            $config_id = $this->request->params['named']['aws_sdk_config_id'];

            $this->Ec2Instance->syncInstances($config_id);

            $this->Paginator->settings = array(
                'conditions'=>array(
                    'Ec2Instance.aws_sdk_config_id'=>$config_id
                ),
                'contain'=>array(
                    'AwsSdkConfig'
                ),
                'limit'=>250
            );

            $instances = $this->Paginator->paginate("Ec2Instance");

            $this->set(compact("instances"));

        }

        if($this->request->is('ajax')) {
            $this->render("/Elements/ec2-index");
        }

        $this->set("title_for_layout","AWS EC2 Instances");

    }


    public function security_group() {
        

    }


}