<?php 

App::uses("AwsAppShell","Aws.Console/Command");

class AwsShell extends AwsAppShell {


    public $tasks = array(
        "Aws.Config",
        "Aws.Services",
        "Aws.Sns",
        "Aws.CloudWatch"
    );

    private $client = false;

    private $config = false;

    public function startup() {

        parent::startup();

        require_once "Crypt/RSA.php";

        $rsa = new Crypt_RSA();

        die(print_r($rsa->createKey()));

        $this->out("<info>John Hardy's AWS Pluging for CakePHP 2.X</info>");
        $this->hr();

        $this->Config->execute();
        
        $this->config = $this->Config->config;

        $this->hr();

    }

    public function main() {

        $this->out("Select an option below or use the --help flag to see details on all the available commands");
        $this->hr();

        $this->out("1) Setup additonal SDK configurations");
        $this->out("2) Update SDK Configuration(s)");
        $this->out("3) Configure Services <info> You must have root access to this server and run this command as root or via 'sudo'</info>");
        $this->out("4) Test");
        $this->out("Q) Quit");
    
        $opt = $this->in("Choose an option:",array(1,2,3,4));

        switch(strtolower($opt)) {

            case 1:
                $this->configure_sdk();
            break;

            case 2:
                $this->Config->update_config();
            break;

            case 3:
                $this->Services->execute();
            break;

            case 4:
                $this->CloudWatch->execute($this->config);
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

        $this->Config->make_config_file();

    }

}