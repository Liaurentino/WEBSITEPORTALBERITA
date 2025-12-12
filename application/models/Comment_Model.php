<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	// Ambil semua komentar berita
	public function get_by_news($news_id)
	{
		return $this->db
			->select('comments.*, users.username')
			->from('comments')
			->join('users', 'users.id = comments.user_id', 'left')
			->where('comments.news_id', $news_id)
			->order_by('comments.created_at', 'DESC')
			->get()
			->result();
	}

	// Hitung komentar
	public function count_comments($news_id)
	{
		return $this->db->where('news_id', $news_id)->count_all_results('comments');
	}

	// Tambah komentar
	public function add_comment($data)
	{
		return $this->db->insert('comments', $data);
	}

	// Delete komentar
	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('comments');
	}
}