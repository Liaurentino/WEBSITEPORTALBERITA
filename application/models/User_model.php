<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get user by email
    public function get_user_by_email($email) {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row_array();
    }

    // Get user by id
    public function get_user_by_id($id) {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row_array();
    }

    // Get user by username
    public function get_user_by_username($username) {
        $query = $this->db->get_where('users', ['username' => $username]);
        return $query->row_array();
    }

    // Insert new user
    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    // Update user (Bisa untuk update bio, password, dll)
    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // Check password (Verifikasi password saat ini)
    public function check_password($user_id, $password) {
        $user = $this->get_user_by_id($user_id);
        if ($user) {
            return password_verify($password, $user['password']);
        }
        return false;
    }

    // Delete user
    public function delete_user($id) {
        // Hapus berita user
        $this->db->delete('news', ['user_id' => $id]);
        
        // Hapus user
        $this->db->delete('users', ['id' => $id]);
        
        return true;
    }

    // Get all users (admin only)
    public function get_all_users($limit = NULL) {
        $query = $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get('users')->result_array();
    }

    // Check if username exists
    public function username_exists($username) {
        $query = $this->db->get_where('users', ['username' => $username]);
        return $query->num_rows() > 0;
    }

    // Check if email exists
    public function email_exists($email) {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->num_rows() > 0;
    }

    // Get user stats
    public function get_user_stats($user_id) {
        $stats['total_news'] = $this->db->where('user_id', $user_id)->count_all_results('news');
        
        // Total likes pada semua berita user
        $this->db->select('COUNT(l.id) as total_likes');
        $this->db->from('likes l');
        $this->db->join('news n', 'l.news_id = n.id');
        $this->db->where('n.user_id', $user_id);
        $stats['total_likes'] = $this->db->get()->row()->total_likes ?? 0;
        
        // Total comments pada semua berita user
        $this->db->select('COUNT(c.id) as total_comments');
        $this->db->from('comments c');
        $this->db->join('news n', 'c.news_id = n.id');
        $this->db->where('n.user_id', $user_id);
        $stats['total_comments'] = $this->db->get()->row()->total_comments ?? 0;
        
        return $stats;
    }
}