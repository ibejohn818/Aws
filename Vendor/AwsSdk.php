<?php

require_once __DIR__.'/Aws/aws-autoloader.php';

use Aws\Common\Aws;

class AwsSdk {

    private static $clients = array();

    private static $defaultConfigFile = "sdk";

    private static $regions = false;

    private static $instanceTypes = false;

    private static $cloudWatchOperators = false;

    private function __construct() { 

    }

    public static function client($config_id = false) {

        $configs = self::getConfigs();

        if(!$config_id) {
            throw new Exception("Invalid SDK CONFIG ID");
        }
        
        $config = $configs[$config_id];

        $conf = array(
            'key'=>$config['AwsSdkConfig']['sdk_key'],
            'secret'=>$config['AwsSdkConfig']['sdk_secret'],
            'region'=>$config['AwsSdkConfig']['sdk_region']
        );
        
        return Aws::factory($conf);

    }


    public static function getConfigs() {

        $configs = ClassRegistry::init("Aws.AwsSdkConfig")->getConfigs();

        return $configs;

    }

    public static function getRegions() {

        if(!self::$regions) {

            $r = array();

            $cls = new ReflectionClass('Aws\Common\Enum\Region');

            $constants = $cls->getConstants();

            self::$regions = $constants;
        }

        return self::$regions;

    }

    public static function regionsSelect() {

        $regions = self::getRegions();

        $s = array();

        foreach($regions as $k=>$v) {
            $s[$v] = "{$v} ({$k})";
        }

        return $s;

    }


    public static function getInstanceTypes() {

        if(!self::$instanceTypes) {

            $r = array();

            $cls = new ReflectionClass('Aws\Ec2\Enum\InstanceType');

            $constants = $cls->getConstants();

            self::$instanceTypes = $constants;
        }

        return self::$instanceTypes;

    }

    public static function getCloudWatchOperators() {

        if(!self::$cloudWatchOperators) {

            $r = array();

            $cls = new ReflectionClass('Aws\CloudWatch\Enum\ComparisonOperator');

            $constants = $cls->getConstants();

            self::$cloudWatchOperators = $constants;
        }

        return self::$cloudWatchOperators;

    }

    public static function writeConfigFile($file,$config = array()) {

        chmod(AWS_PLUGIN_SDK_CONFIG_PATH, 0777);

        $yaml = spyc_dump($config);

        return file_put_contents(AWS_PLUGIN_SDK_CONFIG_PATH . DS . "{$file}.yaml",$yaml);

    }

}