<?php

//load exceptions
require_once __DIR__.'/../Error/exceptions.php';


//setup the env for the plugin
App::uses("AwsPluginLoad","Aws.Lib");

AwsPluginLoad::load();

/*
To use the built in Auth component, set this property to true.
Actions are denied in the AwsAppController
 */
#Configure::write("AwsPlugin.useAuth",true);
Configure::write("AwsPlugin.useAuth",false);














# cache config

// $engine = "Memcache";
$engine = "File";

$memcache_servers = array(
    '127.0.0.1:11211'
);

$eod = ((strtotime("tomorrow 00:00:00") - time()) / 60); //minutes until tomorrow

$prefix = gethostname()."-aws-";

//trap for development machines etc.
if(preg_match('/(centvm|ip-172-31-34-34|anotherhost)/',gethostname())) {

    $memcache_servers = array(
        '127.0.0.1:11211'
    );
    $engine = "Memcache";

}


Cache::config('aws-1min', array(
    'engine' => $engine,
    'prefix' => "1MIN-{$prefix}",
    'path'=>CACHE,
    'serialize' => true,
    'duration' => "+1 Min",
    'servers'=>$memcache_servers
));


Cache::config('aws-5min', array(
    'engine' => $engine,
    'prefix' => "5MIN-{$prefix}",
    'path'=>CACHE,
    'serialize' => true,
    'duration' => "+1 Min",
    'servers'=>$memcache_servers
));

Cache::config('aws-eod', array(
    'engine' => $engine,
    'prefix' => "EOD-{$prefix}",
    'path'=>CACHE,
    'serialize' => true,
    'duration' => "+{$eod} Min",
    'servers'=>$memcache_servers
));