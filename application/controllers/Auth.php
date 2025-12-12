<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	// Halaman Login
	public function login()
	{
		if ($this->session->userdata('user_id')) {
			redirect('home');
		}

		$this->load->view('templates/header');
		$this->load->view('auth/login');
		$this->load->view('templates/footer');
	}

	// Halaman Register
	public function register()
	{
		if ($this->session->userdata('user_id')) {
			redirect('home');
		}

		$this->load->view('templates/header');
		$this->load->view('auth/register');
		$this->load->view('templates/footer');
	}

	// Proses Login
	public function do_login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		if (empty($email) || empty($password)) {
			$this->session->set_flashdata('error', 'Email dan password harus diisi');
			redirect('login');
		}

		$user = $this->User_model->get_by_email($email);

		if (!$user) {
			$this->session->set_flashdata('error', 'Email tidak terdaftar');
			redirect('login');
		}

		if (!password_verify($password, $user->password)) {
			$this->session->set_flashdata('error', 'Password salah');
			redirect('login');
		}

		// Set session
		$session_data = array(
			'user_id' => $user->id,
			'username' => $user->username,
			'email' => $user->email,
			'role' => $user->role
		);
		$this->session->set_userdata($session_data);

		$this->session->set_flashdata('success', 'Login berhasil');
		redirect('home');
	}

	// Proses Register
	public function do_register()
	{
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$confirm_password = $this->input->post('confirm_password');

		// Validasi
		if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
			$this->session->set_flashdata('error', 'Semua field harus diisi');
			redirect('register');
		}

		if (strlen($username) < 3) {
			$this->session->set_flashdata('error', 'Username minimal 3 karakter');
			redirect('register');
		}

		if ($password !== $confirm_password) {
			$this->session->set_flashdata('error', 'Password tidak cocok');
			redirect('register');
		}

		if (strlen($password) < 6) {
			$this->session->set_flashdata('error', 'Password minimal 6 karakter');
			redirect('register');
		}

		// Check email & username sudah ada
		if ($this->User_model->email_exists($email)) {
			$this->session->set_flashdata('error', 'Email sudah terdaftar');
			redirect('register');
		}

		if ($this->User_model->username_exists($username)) {
			$this->session->set_flashdata('error', 'Username sudah terdaftar');
			redirect('register');
		}

		// Register
		$data = array(
			'username' => $username,
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'role' => 'user'
		);

		if ($this->User_model->register($data)) {
			$this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login');
			redirect('login');
		} else {
			$this->session->set_flashdata('error', 'Gagal melakukan registrasi');
			redirect('register');
		}
	}

	// Logout
	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Logout berhasil');
		redirect('home');
	}
}