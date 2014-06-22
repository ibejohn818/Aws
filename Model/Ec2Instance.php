<?php 

App::uses("AwsAppModel","Aws.Model");

class Ec2Instance extends AwsAppModel {

    public $hasMany = array(
        "AwsTag"=>array(
            "className"=>"Aws.AwsTag"
        )
    );

    public $belongsTo = array(
        'AwsSdkConfig'=>array(
            'className'=>'Aws.AwsSdkConfig'
        ),
        'AwsLaunchScript'=>array(
            'className'=>'Aws.AwsLaunchScript'
        )
    );



    public function api_queryInstances($sdk_config_id, $tags = array(), $xtra = array(), $cache = true) {

        $token = __CLASS__."-".__METHOD__."-".md5(serialize(func_get_args()));
        $cacheConfig = 'aws-1min';

        if(($results = Cache::read($token,"aws-1min")) === false || !$cache) {
        
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

            $ec2 = AwsSdk::client($sdk_config_id)->get("ec2");

            $res = $ec2->describeInstances($params);

            $reservations = $res['Reservations'];

            foreach($reservations as $reservation) {

                $instances = $reservation['Instances'];

                foreach($instances as $instance) {

                    $results[] = $this->parseApiInstance($instance,$sdk_config_id);

                }

            }

            Cache::write($token,$results,$cacheConfig);

        }

        return $results;

    }



   

    public function syncInstances($sdk_config_id = false) {

        if(
            !$sdk_config_id || 
            !(
                $config = $this->AwsSdkConfig->find('first',array(
                    'conditions'=>array(
                        'AwsSdkConfig.id'=>$sdk_config_id
                    ),
                    'contain'=>false)
                )
            )
        ) {
            throw new BadRequestException("Invalid SDK Config ID",500);
        }

        $this->updateAll(
            array(
                "instance_state"=>"'unknown'"
            ),
            array(
                "aws_sdk_config_id"=>$config['AwsSdkConfig']['id']
            )
        );

        $res = $this->api_queryInstances($config['AwsSdkConfig']['id'],array(),array());

        foreach($res as $instance) {

            $this->insertInstance($instance);

        }

    }

    public function parseApiInstance($instance,$sdk_config_id = false) {

        $data = array(
            'payload'=>serialize($instance),
            'instance_id'=>$instance['InstanceId'],
            'state'=>$instance['State'],
            'private_ip'=>$instance['PrivateIpAddress'] || '0.0.0.0',
            'public_ip'=>$instance['PublicIpAddress'] || '0.0.0.0',
            'security_groups'=>$instance['SecurityGroups'],
            "image_id"=>$instance['ImageId'],
            "aws_sdk_config_id"=>$sdk_config_id,
            'instance_state'=>$instance['State']['Name']
        );

        $dnsArray = explode(".", $instance['PrivateDnsName']);

        $data['host_name'] = $dnsArray[0];

        return $data;

    }

    private function insertInstance($instance) {

        $this->create();

        $chk = $this->find('first',array(
            'conditions'=>array(
                'Ec2Instance.instance_id'=>$instance['instance_id']
            ),
            'contain'=>false
        ));

        if(isset($chk['Ec2Instance']['id'])) {
            $this->id = $chk['Ec2Instance']['id'];
        }

        $this->save($instance);

        return $this->id;

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