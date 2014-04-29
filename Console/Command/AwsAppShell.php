<?php 

App::uses("AppShell","Console/Command");

class AwsAppShell extends AppShell {


    private $rsa_key_suffix = "-key";
    private $rsa_tmp_path = TMP;

    public function __construct($stdout = null, $stderr = null, $stdin = null) {

        parent::__construct($stdout,$stderr,$stdin);

        if(!defined('AWS_PLUGIN_LOADED')) {

            $err = "Aws Plugini 'bootstrap' option not configured \n In your app's Config/bootstrap.php file, ensure 'bootstrap' is set to true for the Aws Plugin \n CakePlugin::load( \n \tarray('Aws'=>array('bootstrap'=>true)\n));";

            throw new AwsPluginBootstrapException($err);

        }

    }


    protected function returnSSHLoginCmd($Ec2Login,$Ec2Instance,$privateIp = true) {

        $privKey = $this->saveRsaKey("{$login['Ec2Login']['name']}-{$this->rsa_key_suffix}",$login['Ec2Login']['private_key']);
        $pubKey = $this->saveRsaKey("{$login['Ec2Login']['name']}-{$this->rsa_key_suffix}.pub",$login['Ec2Login']['public_key']);

        $ip = ($privateIp) ? $Ec2Instance['Ec2Instance']['private_ip']:$Ec2Instance['Ec2Instance']['public_ip'];

        $cmd = "ssh -t -i $privKey {$Ec2Login['Ec2Login']['name']}@{$ip}";

        return $cmd;

    }

    protected function saveRsaKey($name,$content,$chmod = 600) {

        $fullPath = "{$this->rsa_tmp_path}/{$name}";

        if(file_exists($fullPath)) {
            return $fullPath;
        }

        file_put_contents($fullPath,$content);

        chmod($fullPath,0600);

        return $fullPath;

    }

    protected function deleteRsaKeys($Ec2Login) {
        
        $priv = "{$this->rsa_tmp_path}/{$Ec2Login['Ec2Login']['name']}-{$this->rsa_key_suffix}";
        $pub = "{$this->rsa_tmp_path}/{$Ec2Login['Ec2Login']['name']}-{$this->rsa_key_suffix}.pub";

        @unlink($priv);
        @unlink($pub);

    }
    
}