<?php
class Home extends CI_Controller {
    
    public function index() {
        $this->load->model('News_model');
        
        $data['title'] = 'Adventure Today - Jelajahi Dunia';
        $data['hot_news'] = $this->News_model->get_hot_news();
        $data['trending'] = $this->News_model->get_trending_news();

        $this->load->view('layout/header', $data);
        $this->load->view('home/index', $data); 
        $this->load->view('layout/footer');
    }

    // Melihat detail berita
    public function view($slug = NULL) {
        $this->load->model('News_model');
        $data['news'] = $this->News_model->get_news($slug);

        if (empty($data['news'])) {
            show_404();
        }

        $data['title'] = $data['news']['title'];

        $this->load->view('layout/header', $data);
        $this->load->view('news/detail', $data);
        $this->load->view('layout/footer');
    }
    
    // Fitur Like
    public function like($id) {
        if(!$this->session->userdata('logged_in')){
            redirect('auth/login');
        }
        $this->load->model('News_model');
        $this->News_model->toggle_like($this->session->userdata('user_id'), $id);
        
        // Kembali ke halaman sebelumnya
        redirect($_SERVER['HTTP_REFERER']);
    }
}