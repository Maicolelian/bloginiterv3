<?php

function posted()
{
    return array("no" => "no", "si" => "si");
}

function categories_to_form($categories) {
    $aCategories = array();

    foreach ($categories as $key => $c) {
        $aCategories[$c->category_id] = $c->name;
    }

    return $aCategories;
}

function clean_name($name)
{
    return convert_accented_characters(url_title($name, '-', TRUE));
}

function image_post($post_id) {
    $CI = & get_instance();
    $post = $CI->Post->find($post_id);

    if (isset($post) && $post->image != "") 
        return base_url() . "uploads/post/" . $post->image;
    return base_url() . "assets/img/logo_black.png";
}
function all_images() {
    $CI = & get_instance();
    $CI->load->helper('directory');

    $dir = "uploads/post";
    $files = directory_map($dir);

    return $files;
}