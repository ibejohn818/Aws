<?php 
 ?>
<div class="page-header">
     <h2>
         Create Launch Script
     </h2>
</div>
<?php 

echo $this->Form->create('Ec2LaunchScript',array(
    "id"=>'Ec2LaunchScriptForm',
    "url"=>$this->request->here
));

 ?>
<div id="create-launch-script">
    <?php echo $this->Form->input("name"); ?>
    <?php echo $this->Form->input("sdk_config",array("options"=>AwsSdk::getConfigs())); ?>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-primary">
        Create Script
    </button>
</div>
<?php echo $this->Form->end(); ?>