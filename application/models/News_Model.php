<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

    // 1. Ambil semua berita + Data Penulis + Jumlah Like
    // Digunakan untuk halaman Home (Grid) dan List Berita
    public function get_all_news_complete($limit = null, $offset = 0) {
        $this->db->select('news.*, users.username, COUNT(likes.id) as total_likes');
        $this->db->from('news');
        // Join ke tabel users untuk ambil nama penulis
        $this->db->join('users', 'users.id = news.user_id', 'left');
        // Join ke tabel likes untuk hitung total like
        $this->db->join('likes', 'likes.news_id = news.id', 'left');
        
        $this->db->group_by('news.id');
        $this->db->order_by('news.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array(); // Return sebagai array objek/array murni
    }

    // 2. Ambil Detail Satu Berita (Untuk halaman baca selengkapnya)
    public function get_news_detail($slug) {
        $this->db->select('news.*, users.username, COUNT(likes.id) as total_likes');
        $this->db->from('news');
        $this->db->join('users', 'users.id = news.user_id', 'left');
        $this->db->join('likes', 'likes.news_id = news.id', 'left');
        $this->db->where('news.slug', $slug);
        $this->db->group_by('news.id');
        
        return $this->db->get()->row_array();
    }

    // 3. Ambil Statistik Website (Untuk Hero Section: 50K+ Articles, dst)
    public function get_site_stats() {
        return [
            'total_news'    => $this->db->count_all('news'),
            'total_users'   => $this->db->count_all('users'),
            // Misal: hitung total likes di seluruh website
            'total_likes'   => $this->db->count_all('likes')
        ];
    }

    // 4. Fitur Tambahan: Ambil berita user tertentu (Dashboard)
    public function get_news_by_user($user_id) {
        $this->db->select('news.*, COUNT(likes.id) as total_likes');
        $this->db->from('news');
        $this->db->join('likes', 'likes.news_id = news.id', 'left');
        $this->db->where('news.user_id', $user_id);
        $this->db->group_by('news.id');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    // 5. Create, Like, Delete (Fungsi Standar)
    public function create_news($post_image) {
        $slug = url_title($this->input->post('title'), 'dash', TRUE);
        // Tambahkan string acak agar slug unik jika judul sama
        $slug .= '-' . time(); 

        $data = array(
            'title'   => $this->input->post('title'),
            'slug'    => $slug,
            'content' => $this->input->post('content'),
            'user_id' => $this->session->userdata('user_id'),
            'image'   => $post_image,
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('news', $data);
    }

    public function toggle_like($user_id, $news_id) {
        $check = $this->db->get_where('likes', ['user_id' => $user_id, 'news_id' => $news_id]);
        
        if ($check->num_rows() > 0) {
            $this->db->delete('likes', ['user_id' => $user_id, 'news_id' => $news_id]);
            return 'unliked';
        } else {
            $this->db->insert('likes', ['user_id' => $user_id, 'news_id' => $news_id]);
            return 'liked';
        }
    }

    public function delete_news($id) {
        $this->db->where('id', $id);
        return $this->db->delete('news');
    }
}