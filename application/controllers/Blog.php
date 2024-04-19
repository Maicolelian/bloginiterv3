<?php

class Blog extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();

	}

	public function index($num_page = 1) 
	{
		$num_page--;
		$num_post = $this->Post->count();
		$last_page = ceil($num_post / PAGE_SIZE);

		if ($num_page < 0) {
			$num_page = 0;
		} elseif ($num_page > $last_page) {
			// TODO
			$num_page = 0;
		}

		$offset = $num_page * PAGE_SIZE;

		$data['last_page']=$last_page;
		$data['current_page']=$num_page;
		$data['posts']=$this->Post->get_pagination($offset);
		$data['last_page']=$last_page;

		$view['body']  = $this->load->view("blog/index", $data, TRUE);
		$this->parser->parse("blog/template/body", $view);
	}

	public function post_view($c_clean_url, $clean_url = null) 
	{
		if (strpos($this->uri->uri_string(), 'blog/post_view') !== false)
			show_404();
		 
		if (!isset($clean_url)) {
			show_404();
		}

		$post = $this->Post->GetByUrlClean($clean_url);

		if (!isset($post)) {
			show_404();
		}

		$category = $this->Category->GetByUrlClean($c_clean_url);

		if (!isset($category)) {
			show_404();
		}

		$data['post']=$post;
		$view['body']  = $this->load->view("blog/utils/post_detail", $data, TRUE);
		$this->parser->parse("blog/template/body", $view);
	}
}