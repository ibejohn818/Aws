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

        $options = array();

        if(isset($this->request->params['named']['TagKey']) && isset($this->request->params['named']['TagValue'])) {

            $ids = $this->Ec2Instance->AwsTag->find("all",array(
                "fields"=>array(
                    'AwsTag.ec2_instance_id'
                ),
                'conditions'=>array(
                    'AwsTag.tag_key'=>$this->request->params['named']['TagKey'],
                    'AwsTag.tag_value'=>$this->request->params['named']['TagValue']
                ),
                'contain'=>false
            ));

            $ids = Set::extract("/AwsTag/ec2_instance_id",$ids);

            $options['conditions']['Ec2Instance.id'] = $ids;

        }

        $instances = $this->Ec2Instance->getInstances($options);
        
        $this->set(compact("instances"));

    }


    public function security_group() {
        
        $group = $this->Ec2Instance->get_security_group($this->request->params['named']['config'],$this->request->params['named']['security_group_id']);

        $this->set(compact("group"));

    }


}