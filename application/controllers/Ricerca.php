<?php if (!defined("BASEPATH")) {
	exit("No direct script access allowed");
}

class Ricerca extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$this->load->database();
		$this->load->helper("url");
		$this->load->library("ElasticSearch");
	}

	public function output($output = null, $path = "admin/crud_admin")
	{
		if ($this->session->userdata("currently_logged_in")) {
			$this->template->load(
				$this->session->userdata("user_info")["role"] . "_layout",
				"contents",
				$path,
				$output
			);
		}
	}

	public function index($output = null, $path = "ricerca/ricerca")
	{
		$languages = $this->db->query(
			"SELECT * FROM `languages` WHERE id in (select distinct language_id as lan from book)"
		);

		if ($this->session->userdata("currently_logged_in")) {
			$this->template->load(
				$this->session->userdata("user_info")["role"] . "_layout",
				"contents",
				$path,
				["languages" => $languages]
			);
		}
	}
}
