<?php
class News_model extends CI_Model {

    // Ambil semua berita (untuk keperluan umum)
    public function get_news($slug = FALSE) {
        if ($slug === FALSE) {
            $this->db->order_by('created_at', 'DESC');
            return $this->db->get('news')->result_array();
        }
        // Ambil satu berita + nama penulis
        $this->db->select('news.*, users.username');
        $this->db->join('users', 'users.id = news.user_id');
        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }

    // Ambil Berita Terbaru (HOT NEWS)
    public function get_hot_news() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('news', 3)->result_array(); // Ambil 3
    }

    // Ambil Berita Trending (Berdasarkan jumlah like)
    public function get_trending_news() {
        $this->db->select('news.*, COUNT(likes.id) as total_likes');
        $this->db->from('news');
        $this->db->join('likes', 'likes.news_id = news.id', 'left');
        $this->db->group_by('news.id');
        $this->db->order_by('total_likes', 'DESC');
        $this->db->limit(3);
        return $this->db->get()->result_array();
    }

    // Ambil berita milik user tertentu (Dashboard)
    public function get_news_by_user($user_id) {
        return $this->db->get_where('news', ['user_id' => $user_id])->result_array();
    }

    // Tambah berita
    public function create_news($post_image) {
        $slug = url_title($this->input->post('title'), 'dash', TRUE);
        $data = array(
            'title'   => $this->input->post('title'),
            'slug'    => $slug,
            'content' => $this->input->post('content'),
            'user_id' => $this->session->userdata('user_id'),
            'image'   => $post_image
        );
        return $this->db->insert('news', $data);
    }

    // Cek apakah user sudah like berita ini
    public function check_like($user_id, $news_id) {
        return $this->db->get_where('likes', ['user_id' => $user_id, 'news_id' => $news_id]);
    }

    // Toggle Like
    public function toggle_like($user_id, $news_id) {
        $check = $this->check_like($user_id, $news_id);
        if ($check->num_rows() > 0) {
            // Jika sudah like, hapus (Unlike)
            $this->db->delete('likes', ['user_id' => $user_id, 'news_id' => $news_id]);
            return 'unliked';
        } else {
            // Jika belum, tambah (Like)
            $this->db->insert('likes', ['user_id' => $user_id, 'news_id' => $news_id]);
            return 'liked';
        }
    }
    
    // Hapus Berita
    public function delete_news($id) {
        $this->db->where('id', $id);
        $this->db->delete('news');
        return true;
    }
}