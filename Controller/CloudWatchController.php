<?php 

App::uses("AwsAppController","Aws.Controller");

class CloudWatchController extends AwsAppController {


    public $uses = array();

    private $awsNamespaces = array(
        "AWS-ELB"=>"Elastic Load Balancer",
        "AWS-EC2"=>"EC2 ( Elastic Compute Cloud )",
        "AWS-RDS"=>"Relational Database Services"
    );


    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow();

        $this->set("awsNamespaces",$this->awsNamespaces);

        $this->setOperators();

    }

    private function setOperators() {

        $o = AwsSdk::getCloudWatchOperators();

        $operators = array();

        foreach($o as $k=>$v) {

            $operators[$k] = Inflector::humanize(Inflector::underscore($v));

        }

        $this->set(compact("operators"));

    }

    public function index() {
        
        $cw = AwsSdk::client("berrics")->get("CloudWatch");

        $params = array();

        if(isset($this->request->params['named']) && count($this->request->params['named'])>0) {

            if(isset($this->request->params['named']['namespace'])) {

                $params['Namespace'] = str_replace("-", "/", $this->request->params['named']['namespace']);

            }

            if(isset($this->request->params['named']['nexttoken'])) {

                $params['NextToken'] = $this->request->params['named']['nexttoken'];
                unset($params['Namepsace']);

            }
               
        }
        
        $metrics = $cw->listMetrics($params);

        $nextToken = false;

        //is there a next token?
        if(isset($metrics['NextToken'])) {
            $nextToken = $metrics['NextToken'];
        }

        $this->set(compact(
            "metrics",
            "nextToken"
        ));

    }


}