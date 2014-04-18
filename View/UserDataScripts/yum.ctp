<style>
#yum-cmd {
    width:90%;
    margin:auto;
    height:200px;
}
#yum-code {
    
    width:98%;
    margin:auto;
    text-align: center;
    padding:30px;

}
</style>


<div id="yum-code">

</div>
<div class="row">
    <div class="col-md-6">
        <div class="page-header">
            <h2>
             Generate Yum Command
            </h2>
        </div>
        <table cellspacing='0' class="table table-stripped table-bordered table-hover" id='modules-table'>
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <th>
                        <input id='search-modules' type="text" class="search" placeholder="Search Modules">
                    </th>
                    <th>
                        <button class="btn btn-success" onclick='addVisible();'>Add Visible</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($yum as $module => $description): 
                      
                ?>
                 <tr class='yum-module-row' style='cursor:pointer'>
                     <td>
                         <?php echo $module; ?>
                     </td>
                     <td>
                         <?php echo $description; ?>
                         <input type="hidden" name="data[UserDataScript][][yum_module]" value='<?php echo $module; ?>'>
                     </td>
                 </tr>   
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <?php 

            echo $this->Form->create('UserDataScript',array(
                "id"=>'UserDataScriptForm',
                "url"=>array("action"=>"yum_cmd"),
                'class'=>"form"
            ));
   
         ?> 
        <div id="yum-modules">
            <div class="form-action">
                <button type="submit" class="btn btn-primary">Generate Install Command</button>
            </div>
            <table cellspacing='0' class="table table-stripped table-bordered table-hover" id='yum-modules-table'>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
         <?php echo $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    
    $("#search-modules").bind("keyup",function() { 

        var val = $("#search-modules").val();

        if(val.length<=0) {

            $("#modules-table tbody tr").show();

        } else {

            $("#modules-table tbody tr").hide();

            $("#modules-table tbody tr:contains("+val+")").show();

        }

        

    });

    $(".yum-module-row").click(function() { 

        var id = $(this).parent().parent().attr("id");

        switch(id) {

            case 'modules-table':
                $(this).appendTo("#yum-modules-table tbody");
            break;
            case 'yum-modules-table':
                $(this).appendTo("#modules-table tbody");
            break;
        }

    });

    $("#UserDataScriptForm").ajaxForm({
        beforeSubmit:function() {

             $("#yum-code").html("Loading ...... ");

            return true;

        },
        success:function(d) {

            $("#yum-code").html(d);

        }

    });





});
    function addVisible() {

        $("#modules-table .yum-module-row:visible").click();

    }

</script>