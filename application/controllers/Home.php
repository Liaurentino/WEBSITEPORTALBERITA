<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('User_model');
        $this->load->helper('text');
    }

    public function index() {
        $data['title'] = 'Adventure Today - Temukan Cerita Petualanganmu';
        
        $data['hot_news'] = $this->News_model->get_latest_news(6);
    
        $data['trending_news'] = $this->News_model->get_trending_news(6);
        $data['recent_news'] = $this->News_model->get_latest_news(9);
        
        $data['stats'] = $this->News_model->get_site_stats();
        
        $this->load->view('layout/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('layout/footer', $data);
    }

    // Fitur Untuk Trending 
    public function trending() {
        $data['title'] = 'Berita Trending';
        $data['page_title'] = 'Trending Saat Ini';
        
        $data['news_list'] = $this->News_model->get_trending_news(12);
        
        $this->load->view('layout/header', $data);
        $this->load->view('home/list', $data); 
        $this->load->view('layout/footer', $data);
    }

    // Fitur untuk Terbaru (Latest) 
    public function latest() {
        $data['title'] = 'Berita Terbaru ';
        $data['page_title'] = 'Berita Terbaru';
        
        $data['news_list'] = $this->News_model->get_latest_news(12);
        
        $this->load->view('layout/header', $data);
        $this->load->view('home/list', $data); 
        $this->load->view('layout/footer', $data);
    }

    public function detail($slug = NULL) {
        if (empty($slug)) {
            show_404();
        }

        $news_item = $this->News_model->get_news_by_slug($slug);
        
        if (empty($news_item)) {
            show_404();
        }

        $data['news'] = $news_item;
        $data['title'] = $data['news']['title'] . ' - Adventure Today';
        $data['is_liked'] = FALSE;

        // Check if user liked this news
        if ($this->session->userdata('user_id')) {
            $check_like = $this->db->get_where('likes', [
                'user_id' => $this->session->userdata('user_id'),
                'news_id' => $data['news']['id']
            ]);
            
            if ($check_like->num_rows() > 0) {
                $data['is_liked'] = TRUE;
            }
        }

        // Get related news
        $data['related_news'] = $this->News_model->get_related_news($data['news']['id'], 3);
        
        // Get comments
        $data['comments'] = $this->News_model->get_comments($data['news']['id']);

        $this->load->view('layout/header', $data);
        $this->load->view('news/detail', $data);
        $this->load->view('layout/footer', $data);
    }
    public function news() {
        $data['title'] = 'Semua Berita - Adventure Today';
        $data['page_title'] = 'Arsip Semua Petualangan'; 
        
        $data['news_list'] = $this->News_model->get_all_news();

        $this->load->view('layout/header', $data);
        $this->load->view('home/arsip', $data); 
        $this->load->view('layout/footer', $data);
    }

    public function search() {
        $keyword = $this->input->get('q');
        
        if (empty($keyword)) {
            redirect('home');
        }

        $data['title'] = 'Hasil Pencarian: ' . htmlspecialchars($keyword);
        $data['keyword'] = $keyword;
        $data['is_search'] = TRUE;
        
        // Search news by title or content
        $data['search_results'] = $this->News_model->search_news($keyword);

        $this->load->view('layout/header', $data);
        $this->load->view('home/search', $data);
        $this->load->view('layout/footer', $data);
    }

    public function like($news_id = NULL) {
        header('Content-Type: application/json');
        
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['success' => FALSE, 'message' => 'Login required']);
            return;
        }

        if (empty($news_id)) {
            echo json_encode(['success' => FALSE, 'message' => 'Invalid news']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
    
        $news = $this->News_model->get_news_by_id($news_id);
        if (empty($news)) {
            echo json_encode(['success' => FALSE, 'message' => 'News not found']);
            return;
        }

        $this->News_model->toggle_like($user_id, $news_id);
        
        $total_likes = $this->News_model->get_likes_count($news_id);
        
        $is_liked = $this->db->get_where('likes', [
            'user_id' => $user_id,
            'news_id' => $news_id
        ])->num_rows() > 0;

        echo json_encode([
            'success' => TRUE,
            'total_likes' => $total_likes,
            'is_liked' => $is_liked
        ]);
    }
}