<?php

App::uses("AppShell","Console/Command");


class ConfigTask extends AppShell {

    private $defaultFileName = 'default';

    private $configFolder = "Sdk";

    public $config_files = array();

    public $config = false;

    private $configPath = false;

    public function execute() {

        $this->setConfigFiles();

        if(!$this->config_files || count($this->config_files)<=0) {

            $this->out("AWS PHP SDK Not Configured!");

            $this->out("Before proceeding, you must configure at least one account to act as your default");

            $this->hr();

            return $this->make_config_file($this->defaultFileName);

        } elseif(count($this->config_files) === 1 && file_exists(AWS_PLUGIN_SDK_CONFIG_PATH . DS ."{$this->defaultFileName}.yaml")) {

            $this->config = $this->defaultFileName;

        } elseif(count($this->config_files)>1) {

            $this->listFiles();

        }

        $this->hr();

        $this->out("Using SDK Config: {$this->config} ....");

    }


    private function listFiles() {

        $int = 1;

        $opt = array();



        foreach($this->config_files as $k=>$file) {

            $this->out("{$int}) {$file}");
            $opt[] = $int;
            $int++;

        }

        $key = $this->in("Select a file:",$opt);

        $this->config = $this->config_files[($key-1)];

    }


    private function setConfigFiles() {

        $this->config_files = array(); //reset

        foreach(scandir(AWS_PLUGIN_SDK_CONFIG_PATH) as $file) {

            if(pathinfo($file,PATHINFO_EXTENSION) != 'yaml' || in_array($file,array(".",".."))) {
                continue;
            }

            $this->config_files[] = pathinfo($file,PATHINFO_FILENAME);

        }

    }

    public function return_config($file) {



    }

    public function set_config($file) {



    }


    public function update_config() {

        $int = 1;

        $opt = array();

        foreach($this->config_files as $file) {

            $this->out("{$int}) {$file}");
            $opt[] = $int;
            $int++;

        }

        $file = $this->in("Select a configuration to update:",$opt);

        $this->make_config_file($this->config_files[($file-1)]);

    }

    public function make_config_file($name = false) {

        if(!$name) {
            
            $fileName = $this->in("Please enter a name for this configuration:");

            if(empty($fileName)) {
                return $this->make_config_file();
            } else {
                $fileName = Inflector::underscore($fileName);
            }

        } else {

            $fileName = $name;

        }

        $this->out("Making {$fileName} configuration file.....");


        $config = array(
            "key"=>"",
            "secret"=>"",
            "region"=>""
        );

        $this->out("Enter your Amazon AWS Account Key");

        $config['key'] = $this->in("Enter Your Key");


        $this->out("Enter Your Amazon AWS Account Secret");

        $config['secret'] = $this->in("Enter Your Secrect");

        $this->out("Select your default region");

        $regionsCodes = AwsSdk::getRegions();

        $regions = array();

        $int = 1;

        $regionKeys = array();

        foreach($regionsCodes as $k=>$v) {

            $regions[$int] = $v;

            $this->out("({$int}) ".$k." : {$v}");

            $regionKeys[] = $int;

            $int++;

        }

        $regionCode = $this->in("Select a Region",$regionKeys);

        $config['region'] = $regions[$regionCode];


        if(AwsSdk::writeConfigFile($fileName,$config)) {

            $this->out("File Created: ".AWS_PLUGIN_SDK_CONFIG_PATH . DS . "{$fileName}.yaml");

        } else {

            $this->out("There was an error while creating the {$fileName}.yaml file. Please make sure the following path exists and is writable");
            $this->hr();
            $this->out(AWS_PLUGIN_SDK_CONFIG_PATH . DS );
            $this->hr();

        }


        if($fileName === 'default') {
            $this->execute();
        }


    }



}