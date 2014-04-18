<?php 

App::uses("AwsAppShell","Aws.Console/Command");

class AwsShell extends AwsAppShell {


    public $tasks = array("Aws.Config");

    private $client = false;

    public function startup() {

        parent::startup();

        $this->out("<info>John Hardy's AWS Pluging for CakePHP 2.4X</info>");
        $this->hr();

        $this->Config->execute();
        
        $this->hr();

        //create the sdk client
        $this->client = AwsSdk::client($this->Config->config);
    }

    public function main() {

        $this->out("Select an option below or use the --help flag to see details on all the available commands");
        $this->hr();

        $this->out("1) Setup additonal SDK configurations");
        $this->out("2) Configure Services <info> You must have root access to this server and run this command as root or via 'sudo'</info>");
        $this->out("Q) Quit");
    
        $opt = $this->in("Choose an option:");

        switch(strtolower($opt)) {

            case 1:
                $this->configure_sdk();
            break;
            default:
                exit(0);
            break;

        }


    }

    public function test() {

        $this->out(sha1_file(AWS_PLUGIN_SDK_CONFIG_PATH . DS . "default.yaml"));

    }

    public function configure_sdk() {

        $this->Config->execute();

    }

}