<?php

class AwsPluginBootstrapException extends CakeException {
    protected $_messageTemplate = 'Aws Plugin Bootstrap Not Configured Properly: %s';
}   

class AwsPluginConfigFileNotCreatedException extends CakeException {
    protected $_messageTemplate = "Aws Plugin SDK Configuration File Not Created AwsPlug/Config/sdk.yaml: %s";
} 

class AwsPluginConfigFileInvalidException extends CakeException {
    protected $_messageTemplate = "Aws Plugin Configuation File Is Invalid AwsPlugin/Config/sdk.yaml: %s";
}