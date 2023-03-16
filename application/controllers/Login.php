<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("user_model", "user", true);
		$this->load->model("book_model", "book", true);
	}

	public function index()
	{
		header("Access-Control-Allow-Origin: *");
		if ($this->session->userdata("currently_logged_in")) {
			$role = $this->session->userdata("user_info")["role"];

			$result["message"] = "";
			$this->template->set("title", $role);
			$this->template->load(
				$role . "_layout",
				"contents",
				$role . "/home",
				$result
			);
		} else {
			$result["message"] = "";
			$this->template->set("title", "Login");
			$this->template->load(
				"login_layout",
				"contents",
				"login/login",
				$result
			);
		}
	}

	public function data()
	{
		header("Access-Control-Allow-Origin: *");
		if ($this->session->userdata("currently_logged_in")) {
			$this->load->view("data");
		} else {
			$result["message"] = "";
			$this->template->set("title", "Login");
			$this->template->load(
				"login_layout",
				"contents",
				"login/login",
				$result
			);
		}
	}

	public function invalid()
	{
		$result["message"] = "Username o password errati";
		$this->template->set("title", "Login");
		$this->template->load(
			"login_layout",
			"contents",
			"login/login",
			$result
		);
	}

	function check_database($password)
	{
		$username = $this->input->post("username");
		$result = $this->user->login($username, $password);

		if ($result) {
			$sess_array = [];

			$sess_array = [
				"id" => $result["user"]["id"],
				"username" => $result["user"]["mail"],
				"role" => $result["user"]["role"],
				"name" => $result["user"]["name"],
				"surname" => $result["user"]["surname"],
			];

			$this->session->set_userdata("user_info", $sess_array);
			$this->session->set_userdata("currently_logged_in", true);

			return true;
		} else {
			$this->form_validation->set_message(
				"check_database",
				"Invalid username or password"
			);
			return false;
		}
	}

	public function signin_validation()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules(
			"username",
			"username",
			"trim|xss_clean"
		);

		$this->form_validation->set_rules(
			"password",
			"password",
			"required|trim|callback_check_database"
		);

		if ($this->form_validation->run()) {
			$role = $this->session->userdata("user_info")["role"];

			$result["message"] = "";
			$result["role"] = $role;
			$this->template->set("title", $role);
			$this->template->load(
				$role . "_layout",
				"contents",
				$role . "/home",
				$result
			);
			return;
		} else {
			$result["message"] = "Username o password errati";

			$this->template->set("title", "Login");
			$this->template->load(
				"login_layout",
				"contents",
				"login/login",
				$result
			);
		}
	}

	public function validation()
	{
		$this->load->model("login_model");

		if ($this->login_model->log_in_correctly()) {
			return true;
		} else {
			$this->form_validation->set_message(
				"validation",
				"username o password errati."
			);
			return false;
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$result["message"] = "";
		$this->template->set("title", "Login");
		$this->template->load(
			"login_layout",
			"contents",
			"login/login",
			$result
		);
	}
}
