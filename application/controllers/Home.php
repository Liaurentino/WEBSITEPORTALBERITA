<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->helper('text'); 
    }

    public function index() {
   
        $data['title'] = 'Adventure Today - Temukan Cerita Petualanganmu';

        $news_array = $this->News_model->get_all_news_complete(6); 
    
        $data['hot_news'] = json_decode(json_encode($news_array)); 
        $data['stats'] = $this->News_model->get_site_stats();
        $this->load->view('layout/header', $data);
        $this->load->view('home/index', $data); 
        $this->load->view('layout/footer', $data);
    }

    // Halaman Detail Berita
    public function detail($slug = NULL) {
    
        $news_item = $this->News_model->get_news_detail($slug);

        if (empty($news_item)) {
            show_404();
        }
        $data['news'] = (object) $news_item;
        $data['title'] = $data['news']->title . ' - Adventure Today';

        $data['is_liked'] = FALSE;
        if($this->session->userdata('user_id')){
            $check_like = $this->db->get_where('likes', [
                'user_id' => $this->session->userdata('user_id'), 
                'news_id' => $data['news']->id
            ]);
            if($check_like->num_rows() > 0){
                $data['is_liked'] = TRUE;
            }
        }

        $this->load->view('layout/header', $data);
        $this->load->view('news/detail', $data); 
        $this->load->view('layout/footer', $data);
    }

    // Fitur Pencarian (Search)
    public function search() {
        $keyword = $this->input->get('q');
        $data['title'] = 'Cari: ' . $keyword;
        
        $this->db->like('title', $keyword);
        $this->db->or_like('content', $keyword);
        $news_array = $this->News_model->get_all_news_complete(20);
        
        $data['hot_news'] = json_decode(json_encode($news_array));
        $data['is_search'] = TRUE; 

        $this->load->view('layout/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('layout/footer');
    }
}