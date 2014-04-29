<?php 

App::uses("AppShell","Console/Command");


class SnsTask extends AppShell {


    public $config = false;

    public function execute($config = false) {
        
        if(!$config) {

            $Config = $this->Tasks->load("Aws.Config");

            $Config->execute();

            $this->config = $Config->config;

        } else {
            $this->config = $config;
        }

        $sns =  AwsSdk::client($this->config)->get("Sns");

        $applications = $sns->listSubscriptions();

        print_r($applications);


    }

}