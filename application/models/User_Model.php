<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	// Ambil user berdasarkan email
	public function get_by_email($email)
	{
		return $this->db->where('email', $email)->get('users')->row();
	}

	// Ambil user berdasarkan ID
	public function get_by_id($id)
	{
		return $this->db->where('id', $id)->get('users')->row();
	}

	// Register user baru
	public function register($data)
	{
		$insert = $this->db->insert('users', $data);
		return $insert;
	}

	// Update user
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('users', $data);
	}

	// Check email sudah ada
	public function email_exists($email)
	{
		$query = $this->db->where('email', $email)->get('users');
		return $query->num_rows() > 0;
	}

	// Check username sudah ada
	public function username_exists($username)
	{
		$query = $this->db->where('username', $username)->get('users');
		return $query->num_rows() > 0;
	}
}