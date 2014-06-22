<?php

App::uses('AppModel', 'Model');

class AwsAppModel extends AppModel {

    public function __construct($id = false, $table = null, $ds = null) { 
        
        $this->tablePrefix = Configure::read("AwsPlugin.tablePrefix");
        
        parent::__construct($id, $table, $ds);
        
    }
    

}
