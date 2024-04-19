<?php

class Request_product extends MY_Model {

    public $table = "request_products";
    public $table_id = "request_product_id";

    function getByRequestId($request_id) {

        $this->db->select('p.*, rp.price, pc.url_clean as curl_clean, rp.total, rp.count, pc.name as category');
        $this->db->from("$this->table as rp");
        $this->db->join("products as p", "p.product_id = rp.product_id");
        $this->db->join("product_categories as pc", "pc.product_category_id = p.product_category_id");
        $this->db->where("request_id", $request_id);

        $query = $this->db->get();

        return $query->result();
    }

}
