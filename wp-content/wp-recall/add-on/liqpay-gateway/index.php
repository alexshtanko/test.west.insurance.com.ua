<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rcl_liqpay_form
 *
 * @author Андрей
 */
if(class_exists('Rcl_Payment')){

add_action('init','rcl_add_liqpay_payment');
function rcl_add_liqpay_payment(){
    $pm = new Rcl_Liqpay_Payment();
    $pm->register_payment('liqpay');
}

class Rcl_Liqpay_Payment extends Rcl_Payment{

    public $form_pay_id;

    function register_payment($form_pay_id){
        $this->form_pay_id = $form_pay_id;
        parent::add_payment($this->form_pay_id, array(
            'class'=>get_class($this),
            'request'=>'signature',
            'name'=>'Liqpay',
            'image'=>rcl_addon_url('assets/liqpay.jpg',__FILE__)
            ));
        if(is_admin()) $this->add_options();
    }

    function add_options(){
        add_filter('rcl_pay_option',(array($this,'options')));
        add_filter('rcl_pay_child_option',(array($this,'child_options')));
    }

    function options($options){
        $options[$this->form_pay_id] = __('Liqpay','rcl-liqpay');
        return $options;
    }

    function child_options($child){
        global $rmag_options;

        $opt = new Rcl_Options();

        $options =   array(
            array(
                'type' => 'text',
                'slug' => 'lq_public_key',
                'title' => __('Public Key','rcl-liqpay')
            ),
            array(
                'type' => 'password',
                'slug' => 'lq_private_key',
                'title' => __('Private Key','rcl-liqpay')
            ),
            array(
                'type' => 'select',
                'slug' => 'lq_mode',
                'title' => __('Режим работы','rcl-liqpay'),
                'values'=>array(
                    __('Рабочий','rcl-liqpay'),
                    __('Тестовый','rcl-liqpay')
                )
            )
        );

        $child .= $opt->child(
            array(
                'name'=>'connect_sale',
                'value'=>$this->form_pay_id
            ),
            array(
                $opt->options_box( __('Настройки подключения LiqPay','rcl-liqpay'), $options)
            )
        );

        return $child;
    }

    function pay_form($data){
        global $rmag_options;

        $formaction = 'https://www.liqpay.ua/api/3/checkout';
        $public_key = $rmag_options['lq_public_key'];
        $private_key = $rmag_options['lq_private_key'];

        $currency = (isset($rmag_options['primary_cur']))? $rmag_options['primary_cur']: 'RUB'; // Валюта заказа
        $desc = ($data->description)? $data->description: 'Платеж от '.get_the_author_meta('user_email',$data->user_id);
        $mode = (isset($rmag_options['lq_mode']))? $rmag_options['lq_mode']: 0;

        $baggage_data = ($data->baggage_data)? $data->baggage_data: false;

        $infoData = array(
            'baggage_data' => $baggage_data,
            'pay_type' => $data->pay_type
        );

	    if(is_int($data->submit_value)) $infoData['separate_payment'] = $data->submit_value;

        $params = array(
            'action'         => 'pay',
            'amount'         => $data->pay_summ,
            'currency'       => $currency,
            'description'    => $desc,
            'order_id'       => $data->pay_id,
            'public_key'     => $public_key,
            'sandbox'        => $mode,
            'server_url'     => get_permalink($rmag_options['page_result_pay']),
            'result_url'     => get_permalink($rmag_options['page_success_pay']),
            'customer'       => $data->user_id,
            'info'           => base64_encode(json_encode($infoData)),
            'version'        => '3',
	        'language'       => 'uk'
        );

        $jsondata = base64_encode( json_encode($params) );

        $signature = base64_encode(sha1($private_key . $jsondata . $private_key,1));

        $fields = array(
            'data' => $jsondata,
            'signature' => $signature
        );

        $form = parent::form($fields,$data,$formaction);

        return $form;
    }

    function result($data){
        global $rmag_options;

        $public_key = $rmag_options['lq_public_key'];
        $private_key = $rmag_options['lq_private_key'];

        $requestdata = json_decode(base64_decode($_REQUEST["data"]));

	    if(isset($requestdata->err_code) && $requestdata->err_code){
		    return false;
	    }

        $signature = $_REQUEST["signature"];

        $sign = base64_encode( sha1(
            $private_key .
            $_REQUEST["data"] .
            $private_key
        , 1 ));

        if ($sign !=$signature){
            rcl_mail_payment_error($sign);
            echo "bad sign\n"; exit();
        }

        $info = json_decode(base64_decode($requestdata->info));

        $data->pay_summ = $requestdata->amount;
        $data->pay_id = $requestdata->order_id;
        $data->user_id = $requestdata->customer;
        $data->pay_type = $info->pay_type;
        $data->baggage_data = $info->baggage_data;

        if(isset($info->separate_payment)){
	        $data->separate_payment = $info->separate_payment;
        }

        if(!parent::get_pay($data)) parent::insert_pay($data);

        echo "OK".$data->pay_id."\n"; exit();

    }

    function success(){
        global $rmag_options;

        $requestdata = json_decode(base64_decode($_REQUEST["data"]));

        $data = array(
            'pay_id' => $requestdata->order_id,
            'user_id' => $requestdata->customer
        );

        if(parent::get_pay((object)$data)){
            wp_redirect(get_permalink($rmag_options['page_successfully_pay'])); exit;
        } else {
            wp_die(__('Платеж не найден в базе данных','rcl-liqpay'));
        }

    }
}

}
