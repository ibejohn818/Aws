
<?php echo $this->Form->input("User.{$key}.user_name") ?>
<?php echo $this->Form->input("User.{$key}.add_to_sudo",array("type"=>"checkbox")) ?>
<?php echo $this->Form->input("User.{$key}.public_key") ?>
<?php echo $this->Form->input("User.{$key}.private_key") ?>
<?php echo $this->Form->input("User.{$key}.authorized_keys",array("type"=>"textarea","help"=>"<small>Multple Keys Should Be Line Seperated</small>")) ?>
