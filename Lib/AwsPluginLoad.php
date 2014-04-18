<?php 

class AwsPluginLoad {

    public static function load() {

        if(!defined("AWS_PLUGIN_LOADED")) {

            App::import('Aws.Vendor','Spyc');
            App::import('Aws.Vendor','AwsSdk');

            //setup admin routing
            
            if(!in_array("admin",Configure::read("Routing.prefixes"))) {

                $prefixes = Configure::read("Routing.prefixes");

                $prefixes[] = 'admin';

                Configure::write("Routing.prefixes",$prefixes);

            }

            ##setup path contants ( ** no trailing slashes! )
             
            define('AWS_PLUGIN_CONFIG_PATH', realpath(__DIR__."/../Config"));

            define('AWS_PLUGIN_SDK_CONFIG_PATH', realpath(__DIR__."/../Config/Sdk"));
            
            define('AWS_PLUGIN_SERVICES_PATH', realpath(__DIR__."/Services"));

            define('AWS_PLUGIN_DAEMONS_PATH', realpath(__DIR__."/Daemons"));

            define('AWS_PLUGIN_AMI_PATH', realpath(AWS_PLUGIN_CONFIG_PATH . DS . "AmiTemplates"));

            //check if the sdk config file is created and valid

             define('AWS_PLUGIN_LOADED',1);

           

        }

    }

}