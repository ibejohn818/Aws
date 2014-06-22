<script>
jQuery(document).ready(function($) {
  $("ul.pagination li.current").addClass('active').html('<a>'+$('ul.pagination li.current').html()+'</a>');
});
</script>
<style type="text/css" media="all">

.pagination-centered  {

  text-align:center;

}
span.prev, span.next {

  color:#fff;

}
</style>
<?php 

$configIndexUrl = $this->Html->url(array(
    "plugin"=>"aws",
    "controller"=>"config",
    "action"=>"index"
));

$configCreateUrl = $this->Html->url(array(
  "plugin"=>"aws",
  "controller"=>"config",
  "action"=>"create"
));

$ec2InstancesUrl = $this->Html->url(array(
  "plugin"=>"aws",
  "controller"=>"ec2",
  "action"=>"index"
));

 ?>
<div id="aws-nav-tabs">
    <ul class="nav nav-tabs">
      <li class='<?php echo ($this->request->params['controller'] == 'config') ? 'active':'' ?>'>
        <a class='dropdown-toggle' href="#" data-toggle='dropdown'>
            SDK Configuration <b class="caret"></b>
        </a>
        <ul class='dropdown-menu'>
            <li>
                <a href="<?php echo $configIndexUrl; ?>">
                    Manage Configutations
                </a>
            </li>
            <li>
                <a href="<?php echo $configCreateUrl; ?>">
                    Create Configutation
                </a>
            </li>
        </ul>
      </li>
      <li class='<?php echo ($this->request->params['controller'] == 'ec2') ? 'active':'' ?>'>
        <a href="#" class='dropdown-toggle' data-toggle='dropdown'>
          EC2 <b class="caret"></b>
        </a>
        <ul class='dropdown-menu'>
          <li>  
            <a href="<?php echo $ec2InstancesUrl; ?>">
              EC2 Instances
            </a>
          </li>
        </ul>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">

    </div>
</div>
<div style="height:15px;"></div>
<?php if (preg_match('/(index)/',$this->request['action']) && isset($this->params['paging'])): ?>
<div class="pagination-centered">
  <ul class="pager pull-left">
      <li class="previous">
      <?php echo $this->Paginator->prev("Previous"); ?>
      </li>
  </ul>
  <ul class="pager pull-right">
    <li class="next">
    <?php echo $this->Paginator->next("Next"); ?>
    </li>
  </ul>
  <ul class='pagination'>
     <?php
        $pageNav = $this->Paginator->numbers(array(
          'separator'=>"",
          'tag'=>"li",
          'modulus'=>5
        ));
        echo $pageNav;
     ?>
  </ul>
  <p>
  <?php
    echo $this->Paginator->counter(array(
    'format' => '{:count} Total Records'
    ));
    ?>  
  </p>
</div>
<?php endif; ?>