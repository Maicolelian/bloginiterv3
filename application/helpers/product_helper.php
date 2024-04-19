<?php

function product_categories_to_form($categories) {
    $aCategories = array();

    foreach ($categories as $key => $c) {
        $aCategories[$c->product_category_id] = $c->name;
    }

    return $aCategories;
}

function view_detail_request($request_id) {
    
    $CI = & get_instance();
    
    $request = $CI->Request->find($request_id);
    $data["charge_id"] = $request->payment_id;
    $data["products"] = $CI->Request_product->getByRequestId($request_id);
    $data["request"] = $request;

    return $CI->load->view("store/utils/pay_stripe", $data, TRUE);
}
