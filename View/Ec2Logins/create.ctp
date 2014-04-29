<?php 

$keyscan_url = $this->Html->url(array(

    "action"=>"keyscan_host"

));

 ?>
<script type="text/javascript">

jQuery(document).ready(function($) {
    
    $("#scan-host").bind("click",function(e) { 

      //  scan_host();

    });

    $("#Ec2LoginAutoRsa").bind('click',function() { 
        handleAutoRsa();
    });

});

function scan_host () {
    
    var $btn = $("#scan-host");
    var $field = $("#Ec2LoginKeyscanHost");
    var $textarea = $("#Ec2LoginKnownHosts");
    var val = $field.val();

    $btn.attr('disabled',true);

    var o = {
        url:'<?php echo $keyscan_url; ?>',
        type:'POST',
        data:{
            'data':{

                'host_name':val

            }
        },
        success:function(d) {

            $btn.attr('disabled',false);
            $field.val('');
            $textarea.append(d+"\n");

        }

    };

    $.ajax(o);

}


function handleAutoRsa() {

    var $chk = $("#Ec2LoginAutoRsa");

    var $priv = $("#Ec2LoginPrivateKeyDiv");
    var $pub = $("#Ec2LoginPublicKeyDiv");

    if($chk.is(":checked")) {

        $priv.hide();
        $pub.hide()

    } else {

        $priv.show();
        $pub.show();

    }

}

</script>
<div class="page-header">
    <h2>Create EC2 Server Login</h2>
</div>
<?php 

echo $this->Form->create('Ec2Login',array(
    "id"=>'Ec2LoginForm',
    "url"=>$this->request->here
));

 ?>
 <div class="row">
     <div class="col-md-4">

     </div>
     <div class="col-md-4">

     </div>
     <div class="col-md-4">
         <?php 


          ?>
     </div>
 </div>
<div class="row">
    <div class="col-12">

        <?php

           



            
         

         ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
         <?php 
            echo $this->Form->input("name");
            echo $this->Form->input("sudoer",array("label"=>"Sudoer <small>( Add User To Sudoers File )</small>"));
            echo $this->Form->input("known_hosts",array("label"=>"Known Hosts <i><small>( One Domain Per Line )</small></i>"));
            echo $this->Form->input("auto_rsa",array("type"=>"checkbox","label"=>"Auto Generate RSA Keys For User <i><small>( Leave Unchecked to input your own RSA Keys )</small></i>"));
            echo $this->Form->input("private_key",array("div"=>array("id"=>"Ec2LoginPrivateKeyDiv")));
            echo $this->Form->input("public_key",array("div"=>array("id"=>"Ec2LoginPublicKeyDiv")));
             echo $this->Form->input("authorized_keys");
            
          ?>
          <!--
          <div class="row">
              <div class="col-md-3">
                  <?php 
                    echo $this->Form->input("keyscan_host",array("label"=>"Host Name"));
                   ?>
              </div>
              <div class="col-md-3">
                <button class="btn btn-default" type="button" id='scan-host'>
                    Scan Host
                </button>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-3"></div>
          </div>
            -->

    </div>
</div>
<div class="form-actions">
    <button class='btn btn-primary' type="submit">
        Add Login
    </button>
</div>
<?php echo $this->Form->end(); ?>