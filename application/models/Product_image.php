<?php

class Product_image extends MY_Model {

    public $table = "product_images";
    public $table_id = "product_image_id";

    function getByUrlClean($url_clean) {

        $this->db->select();
        $this->db->from("$this->table");
        $this->db->where("url_clean", $url_clean);

        $query = $this->db->get();

        return $query->result();
    }

    function getByProductId($product_id) {

        $this->db->select();
        $this->db->from($this->table);
        $this->db->where("product_id", $product_id);

        $query = $this->db->get();

        return $query->result();
    }
    
       function getByImageName($name) {

        $this->db->select();
        $this->db->from($this->table);
        $this->db->where("image", $name);

        $query = $this->db->get();

        return $query->row();
    }

}
