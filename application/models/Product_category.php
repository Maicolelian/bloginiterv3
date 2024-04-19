<?php

class Product_category extends MY_Model {

    public $table = "product_categories";
    public $table_id = "product_category_id";

    function getByUrlClean($url_clean) {

        $this->db->select();
        $this->db->from("$this->table");
        $this->db->where("url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }

}
