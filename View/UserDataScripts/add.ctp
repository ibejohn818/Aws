<?php 

echo $this->Form->create('UserDataScript',array(
    "id"=>'UserDataScriptForm',
    "url"=>$this->request->here
));

 ?>
<?php 

$key = 0;

 ?>
<fieldset>
    <legend>Add Users</legend>
    <?php echo $this->element("user-add-form",array("key"=>0)) ?>
</fieldset>
<button type="submit">Add</button>
<?php echo $this->Form->end(); ?>