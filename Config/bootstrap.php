<?php

//load exceptions
require_once __DIR__.'/../Error/exceptions.php';

App::uses("AwsPluginLoad","Aws.Lib");

AwsPluginLoad::load();