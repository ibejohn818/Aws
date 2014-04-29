<?php 

App::uses("AwsAppModel","Aws.Model");


class AwsUserDataScript extends AwsAppModel {



    public function getLaunchScript($id) {
            
        return $this->findById($id);

    }    

    public function available_yum_packages() {

        $token = "yum-modules";

        if(($packages = Cache::read($token,"eod")) === false) {

            $out = array();

            exec("yum search ''",$out);

            $yum = array();

            $add = false;

            $currentKey = false;

             $packages = array();$packages = array();

            foreach($out as $k=>$v) {

                $v = trim($v);

                if(preg_match('/(N\/S Matched)/i',$v)) {

                    $add = true;
                    continue;

                }

                if(preg_match('/(N\/S Matched)/i',$v) || preg_match('/(loaded plugins)/i',$v)) {
                    continue;
                }

                if(!preg_match('/(:)/',$v) || !preg_match('/([a-zA-Z])/',$v)) {
                    continue;
                }

                if(preg_match('/^:/',$v)) {

                    @$packages[$currentKey] .= " ".preg_replace('/^:/',"",$v);

                } else {

                    $m = explode(":",$v);

                    $p = explode(".",trim($m[0]));

                    $currentKey = $p[0];

                    @$packages[$currentKey] = trim($m[1]);

                }

            }

            Cache::write($token,$packages,"eod");

        }

       

        return $packages;


    }


}