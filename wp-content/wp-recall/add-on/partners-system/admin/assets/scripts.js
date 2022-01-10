
function ps_ajax(object,e){
    
    if(object['confirm']){
        if(!confirm(object['confirm'])) return false;
    }
    
    if(e && jQuery(e).parents('.preloader-box')){
        rcl_preloader_show(jQuery(e).parents('.preloader-box'));
    }
    
    rcl_ajax({
        data: object
    });
    
}

function ps_send_form_data(action,e){
    
    var form = jQuery(e).parents('form');

    ps_ajax(form.serialize() + '&action=' + action, e);
    
}