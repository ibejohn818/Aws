<script type="text/javascript">
jQuery(document).ready(function($) {
        $("#yum-cmd").click(function() { 

        $(this).select();

    });
});
</script>
<?php 
    $yum_cmd = false;
    

    if($this->request->is("post") || $this->request->is("put")) {

        $yum_cmd = "yum install -y ";

        foreach ($this->request->data['UserDataScript'] as $k => $v) {
                $yum_cmd .= " ".$v['yum_module'];
                // $yum_cmd .= ($k < count($this->request->data['UserDataScript'])) ? ',':'';
                
        }

        $yum_cmd = rtrim($yum_cmd,",");

    }

?>
<textarea name="" id="yum-cmd" >
<?php echo $yum_cmd; ?>
</textarea>