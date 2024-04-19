<?php

class Product extends MY_Model {

    public $table = "products";
    public $table_id = "product_id";

    function getPagination($offset = 0, $category_id = "") {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");
        $this->db->order_by("p.product_id", "asc");

        if ($category_id != "") {
            $this->db->where("p.product_category_id", $category_id);
        }

        $this->db->limit(PAGE_SIZE, $offset);

        $query = $this->db->get();

        return $query->result();
    }

    function getByProductsGroup($products_id) {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");
        $this->db->where_in("p.product_id", $products_id);
        //$this->db->order_by("p.product_id", "asc");
        //$query = $this->db->get();
        $select = $this->db->get_compiled_select();
        $select = "$select ORDER BY FIND_IN_SET(p.product_id, '".implode(",", $products_id)."')";

        $query = $this->db->query($select);
        
        return $query->result();
    }

    function getAllPost($producted = 'Si') {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");

        $query = $this->db->get();

        return $query->result();
    }

    function getByUrlClean($url_clean) {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");
        $this->db->where("p.url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }

    function find($product_id) {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");

        $this->db->where("p.product_id", $product_id);

        $query = $this->db->get();

        return $query->row();
    }

    function count($category_id = "") {

        if ($category_id != "")
            $count = $this->db->query("SELECT $this->table_id FROM $this->table WHERE product_category_id = $category_id");
        else
            $count = $this->db->query("SELECT $this->table_id FROM $this->table");

        return $count->num_rows();
    }

    function countByCUrlClean($c_url_clean, $producted = 'Si') {

        $this->db->select('COUNT(p.product_id) as count');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");
        $this->db->where("c.url_clean", $c_url_clean);
        $query = $this->db->get();
        return $query->row()->count;
    }

    function getBySearch($searchs, $category_id = null, $producted = 'Si', $order = 'desc') {
        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category, gup.group_user_product_id');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");
        if ($this->session->userdata("id") == null)
            $this->db->join("group_user_products as gup", "p.product_id = gup.product_id", 'left');
        else
            $this->db->join("group_user_products as gup", "p.product_id = gup.product_id AND gup.user_id = " . $this->session->userdata("id"), 'left');

        foreach ($searchs as $key => $search) {
            $this->db->like('p.title', $search);
        }

        if ($category_id != null && $category_id != "")
            $this->db->where("c.category_id", $category_id);

        $this->db->order_by("created_at", $order);
        $query = $this->db->get();

        return $query->result();
    }

    function getGUP($user_id, $producted = 'Si', $order = 'desc') {
        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category, gup.group_user_product_id');
        $this->db->from("$this->table as p");
        $this->db->join("product_categories as c", "c.product_category_id = p.product_category_id");
        $this->db->join("group_user_products as gup", "p.product_id = gup.product_id", 'left');
        $this->db->where('gup.user_id', $user_id);

        $this->db->order_by("created_at", $order);
        $query = $this->db->get();

        return $query->result();
    }

}
