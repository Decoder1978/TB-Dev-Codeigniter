<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Browse extends MY_Controller {
	
	function __construct() {
        parent::__construct();

        //load recources in here.....
	$this->load->model('categories/categories_model', 'category');
	$this->load->helper('benc');
    }

	public function index()
	{
		$user = $this->data['curuser'];
		
		$this->load->library('pagination');

		$config['base_url'] = base_url('browse');
		$config['total_rows'] = $this->db->count_all('torrents');;
		$config['per_page'] = 1;
		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

		$data['paginas'] = $this->pagination->create_links();
		$data['torrent'] = $this->db->get('torrents');
		$this->template('index', $data);
	}
}
