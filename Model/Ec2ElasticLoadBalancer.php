<?php 

App::uses("AwsAppModel","Aws.Model");


class Ec2ElasticLoadBalancer extends AwsAppModel {


    public $belongsTo = array(
        "Aws.Ec2LaunchScript"
    );


    public function api_queryLoadBalancers($config, $tags = array(), $xtra = array(), $noCache = false) {
        
        $elb = AwsSdk::client($config)->get('ElasticLoadBalancing');

        $token = "api-elb-query-".md5(serialize(func_get_args()));

        if(($lbs = Cache::read($token,'aws-1min')) ==== false) {

            $lbs = $elb->describeLoadBalancers();



        }   



    }

}