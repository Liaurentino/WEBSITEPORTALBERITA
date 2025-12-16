<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Likes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Check if user liked a news
    public function is_liked($user_id, $news_id) {
        $query = $this->db->get_where('likes', [
            'user_id' => $user_id,
            'news_id' => $news_id
        ]);
        
        return $query->num_rows() > 0;
    }

    // Get like record
    public function get_like($user_id, $news_id) {
        $query = $this->db->get_where('likes', [
            'user_id' => $user_id,
            'news_id' => $news_id
        ]);
        
        return $query->row_array();
    }

    // Add like
    public function add_like($user_id, $news_id) {
        // Check if already liked
        if ($this->is_liked($user_id, $news_id)) {
            return FALSE;
        }

        $data = [
            'user_id' => $user_id,
            'news_id' => $news_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->db->insert('likes', $data);
    }

    // Remove like
    public function remove_like($user_id, $news_id) {
        return $this->db->delete('likes', [
            'user_id' => $user_id,
            'news_id' => $news_id
        ]);
    }

    // Toggle like (like if not liked, unlike if liked)
    public function toggle_like($user_id, $news_id) {
        if ($this->is_liked($user_id, $news_id)) {
            return $this->remove_like($user_id, $news_id);
        } else {
            return $this->add_like($user_id, $news_id);
        }
    }

    // Count likes for a news
    public function count_likes($news_id) {
        return $this->db->where('news_id', $news_id)->count_all_results('likes');
    }

    // Count likes by user (how many times user liked)
    public function count_likes_by_user($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('likes');
    }

    // Get all users who liked a news
    public function get_users_who_liked($news_id, $limit = NULL) {
        $this->db->select('u.id, u.username, l.created_at');
        $this->db->from('likes l');
        $this->db->join('users u', 'l.user_id = u.id', 'left');
        $this->db->where('l.news_id', $news_id);
        $this->db->order_by('l.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get news liked by user
    public function get_news_liked_by_user($user_id, $limit = NULL) {
        $this->db->select('n.*, u.username, COUNT(l2.id) as likes_count');
        $this->db->from('likes l');
        $this->db->join('news n', 'l.news_id = n.id', 'left');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l2', 'n.id = l2.news_id', 'left');
        $this->db->where('l.user_id', $user_id);
        $this->db->group_by('l.news_id');
        $this->db->order_by('l.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Delete all likes for a news (when news is deleted)
    public function delete_likes_by_news($news_id) {
        return $this->db->delete('likes', ['news_id' => $news_id]);
    }

    // Delete all likes by user
    public function delete_likes_by_user($user_id) {
        return $this->db->delete('likes', ['user_id' => $user_id]);
    }

    // Get trending news by likes count
    public function get_trending_by_likes($limit = 10, $days = 30) {
        $this->db->select('n.*, u.username, COUNT(l.id) as likes_count');
        $this->db->from('news n');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        $this->db->where('n.created_at >', 'DATE_SUB(NOW(), INTERVAL ' . $days . ' DAY)', FALSE);
        $this->db->group_by('n.id');
        $this->db->order_by('likes_count', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get top liked news all time
    public function get_top_liked_news($limit = 10) {
        $this->db->select('n.*, u.username, COUNT(l.id) as likes_count');
        $this->db->from('news n');
        $this->db->join('users u', 'n.user_id = u.id', 'left');
        $this->db->join('likes l', 'n.id = l.news_id', 'left');
        $this->db->group_by('n.id');
        $this->db->order_by('likes_count', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get like statistics
    public function get_like_stats() {
        $stats['total_likes'] = $this->db->count_all('likes');
        
        // Most liked news
        $this->db->select('news_id, COUNT(*) as like_count, n.title, n.slug');
        $this->db->from('likes l');
        $this->db->join('news n', 'l.news_id = n.id', 'left');
        $this->db->group_by('news_id');
        $this->db->order_by('like_count', 'DESC');
        $this->db->limit(5);
        $stats['most_liked'] = $this->db->get()->result_array();
        
        // Most active likers
        $this->db->select('user_id, COUNT(*) as like_count, u.username');
        $this->db->from('likes l');
        $this->db->join('users u', 'l.user_id = u.id', 'left');
        $this->db->group_by('user_id');
        $this->db->order_by('like_count', 'DESC');
        $this->db->limit(5);
        $stats['most_active_likers'] = $this->db->get()->result_array();
        
        return $stats;
    }

    // Get likes with pagination
    public function get_likes_paginated($news_id, $limit, $offset) {
        $this->db->select('u.id, u.username, l.created_at');
        $this->db->from('likes l');
        $this->db->join('users u', 'l.user_id = u.id', 'left');
        $this->db->where('l.news_id', $news_id);
        $this->db->order_by('l.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // Check if user is most active liker (optional)
    public function get_user_like_rank($user_id) {
        $this->db->select('user_id, COUNT(*) as like_count');
        $this->db->from('likes');
        $this->db->group_by('user_id');
        $this->db->order_by('like_count', 'DESC');
        
        $users = $this->db->get()->result_array();
        
        $rank = 0;
        foreach ($users as $key => $user) {
            $rank++;
            if ($user['user_id'] == $user_id) {
                return $rank;
            }
        }
        
        return NULL; // User not in top likers
    }

    // Get news likes detail for news owner (for statistics)
    public function get_news_likes_detail($news_id) {
        $this->db->select('COUNT(*) as total_likes');
        $this->db->from('likes');
        $this->db->where('news_id', $news_id);
        $total = $this->db->get()->row()->total_likes;

        $this->db->select('user_id');
        $this->db->from('likes');
        $this->db->where('news_id', $news_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);
        $latest = $this->db->get()->row();

        return [
            'total' => $total,
            'latest_liker_id' => $latest ? $latest->user_id : NULL
        ];
    }
}