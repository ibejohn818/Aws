<?php 

App::uses("AwsAppModel","Aws.Model");


class Ec2LaunchScriptLogin extends AwsAppModel {


    public $belongsTo = array(
        "Aws.Ec2Login"
    );


    public function handleEdit($launch_script_id,$data) {
        
        $this->deleteAll(array(
            "ec2_launch_script_id"=>$launch_script_id
        ));

        foreach($data['ec2_login_id'] as $id) {

            $this->create();

            $this->save(array(
                "ec2_launch_script_id"=>$launch_script_id,
                "ec2_login_id"=>$id
            ));

        }

    }

}