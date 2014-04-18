<?php 

App::uses("AwsAppShell",'Aws.Console/Command');

class ConfigureShell extends AwsAppShell {


    public function main() {


        $this->out("What would you like to configure?");
        $this->out("(c) AWS SDK Config File: <info>Generate Config File With Your API Credentials</info>");
        $this->out("(s) Services: <info>You must run this command as 'sudo' or under the 'root' user account</info>");
        $this->out("(q) Quit");


        $opt = $this->in("Select an option",array('s','c','q'));

        switch(strtolower($opt)) {

            case 's':
                $this->configure_services();
            break;

            case 'c':
                $this->sdk_config_file();
            break;
            default:
                $this->out("Bye Bye!");
                exit(0);
            break;

        }
        

    }


    public function configure_services() {

        switch(true) {

            case is_dir("/etc/init.d"):
                $dir = "/etc/init.d";
            break;
            default:
                $dir = $this->in("Enter the full path to your service files");
            break;
        }

        if(!is_dir($dir)) {
            $this->out("<error>{$dir} does not exists foo!</error>");
        } else {
            $this->out("Success! {$dir} exists!");
        }

    }

    public function sdk_config_file() {

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

        $yaml = spyc_dump($config);

        chmod(AWS_PLUGIN_CONFIG_PATH, 0777);

        if(file_put_contents(AWS_PLUGIN_CONFIG_PATH . DS . "sdk.yaml",$yaml)) {

            $this->out("File Created: ".AWS_PLUGIN_CONFIG_PATH . DS . "sdk.yaml");

        } else {

            $this->out("There was an error while creating the sdk.yaml file. Please make sure the following path exists and is writable");
            $this->hr();
            $this->out(AWS_PLUGIN_CONFIG_PATH . DS );
            $this->hr();

        }

    }

}