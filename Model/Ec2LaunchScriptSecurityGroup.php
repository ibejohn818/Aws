<?php 

App::uses("AwsAppModel","Aws.Model");


class Ec2LaunchScriptSecurityGroup extends AwsAppModel {


    public $belongsTo = array(
        "Aws.Ec2LaunchScript"
    );

    public function handleEdit($launch_script_id,$data) {
        
        $this->deleteAll(array(
            "ec2_launch_script_id"=>$launch_script_id
        ));

        foreach($data['security_group_id'] as $id) {

            $this->create();

            $this->save(array(
                "ec2_launch_script_id"=>$launch_script_id,
                "security_group_id"=>$id
            ));

        }

    }

}