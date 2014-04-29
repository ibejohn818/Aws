<?php

App::uses("AwsAppModel","Aws.Model");


class AwsTag extends AwsAppModel {


    public function updateEc2Tags($Ec2InstanceId,$tags) {

        $this->deleteAll(array(
            "ec2_instance_id"=>$Ec2InstanceId
        ));

        foreach($tags as $tag) {

            $this->create();

            $this->save(array(
                'tag_key'=>$tag['Key'],
                'tag_value'=>$tag['Value'],
                'ec2_instance_id'=>$Ec2InstanceId
            ));

        }

    }


}