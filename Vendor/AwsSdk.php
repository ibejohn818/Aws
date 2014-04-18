<?php

require_once __DIR__.'/Aws/aws-autoloader.php';

use Aws\Common\Aws;

class AwsSdk {

    private static $clients = array();

    private static $defaultConfigFile = "sdk";

    private static $regions = false;

    private static $instanceTypes = false;

    private function __construct() { }



    public static function client($conf = 'default') {

        if(!isset(self::$clients[$conf])) {

            if(!$conf || !file_exists(AWS_PLUGIN_SDK_CONFIG_PATH . '/' . $conf . ".yaml")) {
                $conf = self::$defaultConfigFile;
            }

            $config = Spyc::YAMLLoad(AWS_PLUGIN_SDK_CONFIG_PATH . '/' . $conf . ".yaml");

            if(!array_key_exists('key', $config) || !array_key_exists('secret', $config) || !array_key_exists('region', $config)) {
                throw new AwsPluginConfigFileInvalidException("{$conf}.yaml File is invalid! Please run the aws.configure shell and create your AWS PHP SDK Configuration File");
            }

            self::$clients[$conf] = Aws::factory($config);

        }

        return self::$clients[$conf];

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


    public static function getInstanceTypes() {

        if(!self::$instanceTypes) {

            $r = array();

            $cls = new ReflectionClass('Aws\Ec2\Enum\InstanceType');

            $constants = $cls->getConstants();

            self::$instanceTypes = $constants;
        }

        return self::$instanceTypes;

    }

    public static function writeConfigFile($file,$config = array()) {

        chmod(AWS_PLUGIN_SDK_CONFIG_PATH, 0777);

        $yaml = spyc_dump($config);

        return file_put_contents(AWS_PLUGIN_SDK_CONFIG_PATH . DS . "{$file}.yaml",$yaml);

    }

}