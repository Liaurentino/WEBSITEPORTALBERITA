<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get news by ID
    public function get_news_by_id($id) {
        $query = $this->db->get_where('news', ['id' => $id]);
        return $query->row_array();
    }

    // Get latest news with user info and like count
    public function get_latest_news($limit = 9) {
        $this->db->select('n.*, u.username, u.id as user_id, COUNT(l.id) as likes_count');
        $this->db->from('news n');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        $this->db->group_by('n.id');
        $this->db->order_by('n.created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get trending news based on likes count
    public function get_trending_news($limit = 6) {
        $this->db->select('n.*, u.username, COUNT(l.id) as likes_count');
        $this->db->from('news n');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        $this->db->where('n.created_at >', 'DATE_SUB(NOW(), INTERVAL 30 DAY)', FALSE);
        $this->db->group_by('n.id');
        $this->db->order_by('likes_count', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get news by slug with all details
    public function get_news_by_slug($slug) {
        // PERUBAHAN: Menambahkan u.bio ke dalam select
        $this->db->select('n.*, u.username, u.bio, u.id as author_id, COUNT(DISTINCT l.id) as likes_count, COUNT(DISTINCT c.id) as comments_count');
        $this->db->from('news n');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        $this->db->join('comments c', 'n.id = c.news_id', 'left');
        $this->db->where('n.slug', $slug);
        $this->db->group_by('n.id');
        
        $query = $this->db->get();
        return $query->row_array();
    }

    // Get related news (same category but different id)
    public function get_related_news($news_id, $limit = 3) {
        $this->db->select('n.*, u.username, COUNT(l.id) as likes_count');
        $this->db->from('news n');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        $this->db->where('n.id !=', $news_id);
        $this->db->group_by('n.id');
        $this->db->order_by('n.created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Search news by title or content
    public function search_news($keyword) {
        $this->db->select('n.*, u.username, COUNT(l.id) as likes_count');
        $this->db->from('news n');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        
        $search_term = '%' . $this->db->escape_like_str($keyword) . '%';
        $this->db->where('(n.title LIKE "' . $search_term . '" OR n.content LIKE "' . $search_term . '")');
        
        $this->db->group_by('n.id');
        $this->db->order_by('n.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get comments for a news
    public function get_comments($news_id) {
        $this->db->select('c.*, u.username, u.email');
        $this->db->from('comments c');
        $this->db->join('users u', 'c.user_id = u.id', 'left');
        $this->db->where('c.news_id', $news_id);
        $this->db->order_by('c.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Toggle like on news
    public function toggle_like($user_id, $news_id) {
        $check = $this->db->get_where('likes', [
            'user_id' => $user_id,
            'news_id' => $news_id
        ]);

        if ($check->num_rows() > 0) {
            // Unlike
            $this->db->delete('likes', [
                'user_id' => $user_id,
                'news_id' => $news_id
            ]);
        } else {
            // Like
            $this->db->insert('likes', [
                'user_id' => $user_id,
                'news_id' => $news_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    // Get total likes for a news
    public function get_likes_count($news_id) {
        return $this->db->where('news_id', $news_id)->count_all_results('likes');
    }

    // Get site statistics
    public function get_site_stats() {
        $stats['total_news'] = $this->db->count_all('news');
        $stats['total_users'] = $this->db->count_all('users');
        $stats['total_likes'] = $this->db->count_all('likes');
        
        return $stats;
    }

    // Get news by user (for dashboard)
    public function get_user_news($user_id, $limit = NULL) {
        $this->db->select('n.*, COUNT(l.id) as likes_count');
        $this->db->from('news n');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        $this->db->where('n.user_id', $user_id);
        $this->db->group_by('n.id');
        $this->db->order_by('n.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Insert news
    public function insert_news($data) {
        return $this->db->insert('news', $data);
    }

    // Update news
    public function update_news($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('news', $data);
    }

    // Delete news
    public function delete_news($id) {
        $this->db->delete('likes', ['news_id' => $id]);
        $this->db->delete('comments', ['news_id' => $id]);
        return $this->db->delete('news', ['id' => $id]);
    }

    // Generate unique slug
    public function generate_slug($title) {
        $slug = url_title($title, '-', TRUE);
        
        $check = $this->db->where('slug', $slug)->get('news');
        
        if ($check->num_rows() > 0) {
            $slug = $slug . '-' . date('YmdHis');
        }
        
        return $slug;
    }

    // Count news by user
    public function count_user_news($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('news');
    }
}