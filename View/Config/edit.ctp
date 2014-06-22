<?php 

$regions = AwsSdk::regionsSelect();

 ?>
<div class="page-header">
    <h1>
        Edit AWS SDK Config
    </h1>
</div>
<?php echo $this->element('nav-tabs') ?>
<?php 
echo $this->Form->create('AwsSdkConfig',array(
    "id"=>'AwsSdkConfigForm',
    "url"=>$this->request->here
));

echo $this->Form->input("id");

 ?>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->input("name") ?>
        <?php echo $this->Form->input("sdk_region",array("options"=>$regions)) ?>     
        <?php echo $this->Form->input("sdk_key") ?>
        <?php echo $this->Form->input("sdk_secret") ?>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Save Config</button>
</div>
 <?php echo $this->Form->end(); ?>