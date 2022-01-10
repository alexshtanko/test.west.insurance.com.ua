function mw_cancel_request(request_id){

    rcl_preloader_show(jQuery('#tab-wallet'));

    rcl_ajax({
        data: {
            action: 'mw_cancel_request',
            request_id: request_id
        }
    });

    return false;

}

function mw_load_user_transfer_form(user_id){

    rcl_preloader_show(jQuery('#lk-conteyner'));

    rcl_ajax({
        data: {
            action: 'mw_load_user_transfer_form',
            user_id: user_id
        }
    });

    return false;

}
