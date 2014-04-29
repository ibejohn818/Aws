<?php 

App::uses("AwsAppModel","Aws.Model");

class Ec2Instance extends AwsAppModel {

    public $hasMany = array(
        "AwsTag"=>array(
            "className"=>"Aws.AwsTag"
        )
    );



    public function api_queryInstances($config, $tags = array(), $xtra = array(), $noCache = false) {

        $token = __CLASS__."-".__METHOD__."-".md5(serialize(func_get_args()));

        if(($results = Cache::read($token,"aws-1min")) === false || $noCache) {
        
            $results = array();

            $params = array();

            foreach((array)$tags as $tag=>$value) {
                
                if(!is_array($value)) {
                    $value = array($value);
                }

                $params['Filters'][] = array(
                    'Name' => "tag:{$tag}",'Values' => $value
                );

            }

            $params = array_merge($params,$xtra);

            $ec2 = AwsSdk::client($config)->get("ec2");

            $res = $ec2->describeInstances($params);

            $reservations = $res['Reservations'];

            foreach($reservations as $reservation) {

                $instances = $reservation['Instances'];

                foreach($instances as $instance) {

                    $results[] = $this->parseApiInstance($instance,$config);

                }

            }

            Cache::write($token,$results,"aws-1min");

        }

        return $results;

    }

    public function getInstances($options = array()) {

        $this->syncApi();

        if(isset($options['conditions'])) {
            $conditions = $options['conditions'];
        } else {
            $conditions = array();
        }

        $instances = $this->find('all',array(
            'contain'=>array("AwsTag"),
            'conditions'=>$conditions
        ));

        return $instances;

    }

    private function insertInstance($ApiResult = array()) {

        $chk = $this->find("first",array(
            "fields"=>array("Ec2Instance.id"),
            "conditions"=>array(
                "instance_id"=>$ApiResult['instance_id']
            ),
            "contain"=>false
        ));

        if(!isset($chk['Ec2Instance']['id'])) {

            $this->create();
            $this->save(array(
               'instance_id'=>$ApiResult['instance_id']
            ));
            $id = $this->id;
        
        } else {

            $id = $chk['Ec2Instance']['id'];

        }

        $udata = array(
            'sdk_config'=>$ApiResult['sdk_config'],
            'instance_state'=>$ApiResult['payload']['State']['Name'],
            'serialized_api_data'=>serialize($ApiResult['payload'])
        );

        $this->create();

        $this->id = $id;

        $this->save($udata);

        $this->AwsTag->updateEc2Tags($id,$ApiResult['payload']['Tags']);

    }

    public function syncApi() {

        $configs = AwsSdk::getConfigs();

        foreach($configs as $config) {

            $this->updateAll(
                array(
                    "instance_state"=>"'unknown'"
                ),
                array(
                    "sdk_config"=>$config
                )
            );

            $res = $this->api_queryInstances($config,array(),array());

            foreach($res as $instance) {

                $this->insertInstance($instance);

            }

        }

    }

    public function parseApiInstance($instance,$sdkConfig = false) {


        return array(
            'instance_id'=>$instance['InstanceId'],
            'state'=>$instance['State']['Name'],
            'private_ip'=>$instance['PrivateIpAddress'] || '0.0.0.0',
            'public_ip'=>$instance['PublicIpAddress'] || '0.0.0.0',
            'security_groups'=>$instance['SecurityGroups'],
            "image_id"=>$instance['ImageId'],
            "sdk_config"=>$sdkConfig,
            'payload'=>$instance,
            'instance_state'=>$instance['State']
        );

    }


    public function get_security_group($config, $security_group_id) {

        $token = "aws-sg-{$config}-".md5($security_group_id);

        if (($group = Cache::read($token,"aws-1min")) === false) {
         
            $ec2 = AwsSdk::client($config)->get("ec2");

            $group = $ec2->describeSecurityGroups(array(
                        "GroupIds"=>array($security_group_id)
                    ));
            
            $group = $group['SecurityGroups'][0];

            Cache::write($token,$group,"aws-1min");

        }

        return $group;

    }

    public function get_security_groups($config) {

        $token = "aws-sq-{$config}";

        if(($groups = Cache::read($token,"aws-1min")) === false) {

            $ec2 = AwsSdk::client($config)->get("ec2");

            $groups = $ec2->describeSecurityGroups();

            $groups = $groups['SecurityGroups'];

            Cache::write($token,$groups,"aws-1min");

        }

        return $groups;

    }

    public function random_name() {

        $names = array(
            "glazed-twist",
            "lemon-tart",
            "banana-bread",
            "fruity-pebbles",
            "chicken-ramen",
            "pizza-puff",
            "rasberry-smoothie",
            "saltwater-taffy",
            "jellybean",
            "abazaba",
            "laffy-taffy",
            "buttermilk-bar"
        );

        $seed = mt_rand(1,count($names));

        return $names[$seed];

    }


}