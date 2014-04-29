<?php 

App::uses("AppShell","Console/Command");


class CloudWatchTask extends AppShell {

    public $config = false;

    public function execute($config = false) {
        
        if(!$config) {

            $Config = $this->Tasks->load("Aws.Config");

            $Config->execute();

            $this->config = $Config->config;

        } else {
            $this->config = $config;
        }

        $sns =  AwsSdk::client($this->config)->get("CloudWatch");

        $applications = $sns->describeAlarms(array(
            
        ));

        print_r($applications);


    }

}