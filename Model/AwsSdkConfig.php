<?php 

App::uses("AwsAppModel","Aws.Model");


class AwsSdkConfig extends AwsAppModel {

    public function setEditValidation() {

        $this->validate = array(
            'name'=>array(
                "rule"=>'notEmpty',
                "message"=>"Name cannot be left empty"
            ),
            'sdk_key'=>array(
                'rule'=>'notEmpty',
                'message'=>'SDK Key cannot be empty'
            ),
            'sdk_secret'=>array(
                'rule'=>'notEmpty',
                'message'=>'SDK Secret cannot be empty'
            )

        );

    }

    /**
     * Returns an array of all SDK Configurations in the database.
     * The array key is the ID of the configuration.
     * @param  boolean $cache cache results for 1 minute
     * @return array         SDK Configs ordered by name ASC
     */
    public function getConfigs($cache = false) {

        $token = 'aws-sdk-configs';
        $cacheConfig = "aws-1min";

        if(($configs = Cache::write($token,$cacheConfig)) === false || !$cache) {

            $conf = $this->find('all',array(
                'contain'=>false,
                'order'=>array("AwsSdkConfig.name"=>"ASC")
            ));

            $configs = array();

            foreach($conf as $k=>$v) {
                $configs[$v['AwsSdkConfig']['id']] = $v;
            }

            Cache::write($token,$configs,$cacheConfig);

        }

        return $configs;

    }

    public function handleSave($data,$validate = false) {

        $this->create();

        $this->set($data);

        if($validate) {

            $this->setEditValidation();

            if(!$this->validates()) {
                return false;
            }

        }

        if(isset($this->data['AwsSdkConfig']['id']) && empty($this->id)) {
            $this->id = $this->data['AwsSdkConfig']['id'];
        }

        return $this->save($this->data);

    }

    public function handleDelete($id) {

        $this->getDataSource()->begin();


        if(
            $this->delete($id,false)
            ) {

            $this->getDataSource()->commit();
            return true;

        }

        $this->getDataSource()->rollback();
        return false;

    }

}