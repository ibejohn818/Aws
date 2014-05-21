<div class="page-header">
    <h2>
        Create Load Balancer
    </h2>
</div>
<?php 
echo $this->Form->create('Ec2LoadBalancer',array(
    "id"=>'Ec2LoadBalancerForm',
    "url"=>$this->request->here
)); 
 ?>
 <div class="row">
     <div class="col-md-12">
         <?php echo $this->Form->input("sdk_config",array('options'=>AwsSdk::getConfigs())) ?>
     </div>
 </div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->input("name"); ?>
    </div>
</div>
<div class="form-actions">
    <button class="btn btn-primary" type="submit">
        Create Load Balancer
    </button>
</div>
 <?php echo $this->Form->end(); ?>