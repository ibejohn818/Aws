<?php 

echo $this->Form->create('UserDataScript',array(
    "id"=>'UserDataScriptForm',
    "url"=>$this->request->here
));

 ?>


<div class="row">
    <div class="col-md-8">
        
        <div class="row">
            <div class="col-md-12">
<pre>
    yum update -y;
</pre>

            </div>
        </div>

    </div>
    <div class="col-md-4">
        
    </div>
</div>

<?php echo $this->Form->end(); ?>