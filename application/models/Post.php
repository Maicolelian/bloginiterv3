<?php

class Post extends MY_Model 
{
    public $table = "posts";
    public $table_id = "post_id";

    function get_pagination($offset = 0, $posted = 'Si', $order = 'desc') {
        $this->db->select('p.*, c.url_clean as c_url_clean');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c","c.category_id = p.category_id");
        $this->db->where("posted", $posted);
        $this->db->order_by("created_at", $order);
        $this->db->limit(PAGE_SIZE, $offset);
        $query = $this->db->get();

        return $query->result();
    }

    function GetByUrlClean($url_clean, $posted = 'Si') {
        $this->db->select('p.*, c.url_clean as c_url_clean');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c","c.category_id = p.category_id");
        $this->db->where("posted", $posted);
        $this->db->where("p.url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }
}