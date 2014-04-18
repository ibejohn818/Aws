<?php 

App::uses("AwsAppController","Aws.Controller");


class CreateYumScriptController extends AwsAppController {


    public $uses = array();

    /**
     * beforeFilter callback
     *
     * @return void
     */
        public function beforeFilter() {
            
            parent::beforeFilter();

            $this->Auth->allow();

        }


    public function index() {

        $out = array();

        exec("yum list",$out);

        $yum = array();

        foreach($out as $k=>$v) {

            $v = trim($v);

            if(preg_match('/^:/',$v)) {

                $yum[($k-1)] .= " ".preg_replace('/^:/',"",$v);

            } else {

                $yum[$k] = $v;

            }

        }

        $this->set(compact("yum"));

    }
    

}