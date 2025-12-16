<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all comments for a news
    public function get_comments_by_news($news_id, $order = 'DESC') {
        $this->db->select('c.*, u.username, u.id as user_id, u.email');
        $this->db->from('comments c');
        $this->db->join('users u', 'c.user_id = u.id', 'left');
        $this->db->where('c.news_id', $news_id);
        $this->db->order_by('c.created_at', $order);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get single comment
    public function get_comment_by_id($comment_id) {
        $this->db->select('c.*, u.username, u.id as user_id, u.email');
        $this->db->from('comments c');
        $this->db->join('users u', 'c.user_id = u.id', 'left');
        $this->db->where('c.id', $comment_id);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    // Insert new comment
    public function insert_comment($data) {
        return $this->db->insert('comments', $data);
    }

    // Update comment
    public function update_comment($comment_id, $data) {
        $this->db->where('id', $comment_id);
        return $this->db->update('comments', $data);
    }

    // Delete comment
    public function delete_comment($comment_id) {
        return $this->db->delete('comments', ['id' => $comment_id]);
    }

    // Delete all comments for a news
    public function delete_comments_by_news($news_id) {
        return $this->db->delete('comments', ['news_id' => $news_id]);
    }

    // Count comments for a news
    public function count_comments_by_news($news_id) {
        return $this->db->where('news_id', $news_id)->count_all_results('comments');
    }

    // Count comments by user
    public function count_comments_by_user($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('comments');
    }

    // Check if user can delete comment (ownership)
    public function can_delete_comment($comment_id, $user_id) {
        $comment = $this->get_comment_by_id($comment_id);
        
        if (empty($comment)) {
            return FALSE;
        }

        return $comment['user_id'] == $user_id;
    }

    // Get comments with pagination
    public function get_comments_paginated($news_id, $limit, $offset) {
        $this->db->select('c.*, u.username, u.id as user_id, u.email');
        $this->db->from('comments c');
        $this->db->join('users u', 'c.user_id = u.id', 'left');
        $this->db->where('c.news_id', $news_id);
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get recent comments (for activity feed)
    public function get_recent_comments($limit = 10) {
        $this->db->select('c.*, u.username, n.title, n.slug');
        $this->db->from('comments c');
        $this->db->join('users u', 'c.user_id = u.id', 'left');
        $this->db->join('news n', 'c.news_id = n.id', 'left');
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get user's comments
    public function get_user_comments($user_id, $limit = NULL) {
        $this->db->select('c.*, n.title, n.slug');
        $this->db->from('comments c');
        $this->db->join('news n', 'c.news_id = n.id', 'left');
        $this->db->where('c.user_id', $user_id);
        $this->db->order_by('c.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Validate comment length
    public function validate_comment_body($body) {
        $length = strlen(trim($body));
        
        if ($length < 3) {
            return ['valid' => FALSE, 'message' => 'Komentar minimal 3 karakter'];
        }
        
        if ($length > 500) {
            return ['valid' => FALSE, 'message' => 'Komentar maksimal 500 karakter'];
        }
        
        return ['valid' => TRUE];
    }

    // Search comments
    public function search_comments($keyword, $limit = 20) {
        $this->db->select('c.*, u.username, n.title, n.slug');
        $this->db->from('comments c');
        $this->db->join('users u', 'c.user_id = u.id', 'left');
        $this->db->join('news n', 'c.news_id = n.id', 'left');
        
        $search_term = '%' . $this->db->escape_like_str($keyword) . '%';
        $this->db->where('c.body LIKE "' . $search_term . '"');
        
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get statistics
    public function get_comment_stats() {
        $stats['total_comments'] = $this->db->count_all('comments');
        
        // Most commented news
        $this->db->select('news_id, COUNT(*) as comment_count, n.title, n.slug');
        $this->db->from('comments c');
        $this->db->join('news n', 'c.news_id = n.id', 'left');
        $this->db->group_by('news_id');
        $this->db->order_by('comment_count', 'DESC');
        $this->db->limit(5);
        $stats['most_commented'] = $this->db->get()->result_array();
        
        return $stats;
    }
}