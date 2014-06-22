jQuery(document).ready(function($) {
    
    bootstrapLinks();

});

function ajaxLoad($url,$ele) {

    showLoading();

    var o = {

        url:$url,
        success:function(d) {

            $("#ec2-index").html(d);

            bootstrapLinks();
            
            hideLoading();

            $ele.dropdown('toggle');

        }   

    };

    $.ajax(o);

}

function bootstrapLinks() {

    $("#ec2-index a[rel!=noAjax],#ec2-index-options a[rel!=noAjax]").click(function() { 

        ajaxLoad($(this).attr('href'),$(this));
        return false;

    });

}

function showLoading() {

    $('.loading-div').show();

}

function hideLoading() {

    $('.loading-div').hide();

}