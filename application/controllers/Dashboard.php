<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string', 'text'));
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth/login');
        }
    }

    // Display list of user's news
    public function index($page = 1) {
        $data['title'] = 'Dashboard - Berita Saya';
        
        $user_id = $this->session->userdata('user_id');
        $data['user_news'] = $this->News_model->get_user_news($user_id);
        $data['stats'] = $this->User_model->get_user_stats($user_id);
        
        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer', $data);
    }

    // Edit Profile 
    public function profile() {
        $data['title'] = 'Edit Profil Saya';
        $user_id = $this->session->userdata('user_id');
    
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/profile', $data);
        $this->load->view('layout/footer', $data);
    }

    // Update Profile 
    public function update_profile() {
        if ($this->input->method() !== 'post') {
            redirect('dashboard/profile');
        }

        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        
        $new_password = $this->input->post('password');
        if (!empty($new_password)) {
            $this->form_validation->set_rules('password', 'Password Baru', 'min_length[6]');
            $this->form_validation->set_rules('conf_password', 'Konfirmasi Password', 'matches[password]');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->profile();
            return;
        }

        // Update Data
        $update_data = [
            'username' => $this->input->post('username'),
            'email'    => $this->input->post('email'),
            'bio'      => $this->input->post('bio') 
        ];

        // Enkripsi Password
        if (!empty($new_password)) {
            $update_data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }
        if ($this->User_model->update_user($user_id, $update_data)) {
            $this->session->set_userdata('username', $update_data['username']);
            
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui! ✨');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
        }

        redirect('dashboard/profile');
    }

    // Show create news form
    public function create() {
        $data['title'] = 'Buat Berita Baru';
        
        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/create', $data);
        $this->load->view('layout/footer', $data);
    }

    // Save new news
    public function store() {
        if ($this->input->method() !== 'post') {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('title', 'Judul', 'required|min_length[10]|max_length[255]');
        $this->form_validation->set_rules('content', 'Konten', 'required|min_length[50]');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $title = $this->input->post('title');
        
        // Handle image upload
        $image = ''; 
        if (!empty($_FILES['image']['name'])) {
            $image = $this->_upload_image();
            
            if ($image === FALSE) {
                redirect('dashboard/create');
                return;
            }
        }

        $news_data = [
            'user_id' => $user_id,
            'title' => $title,
            'slug' => $this->News_model->generate_slug($title),
            'content' => $this->input->post('content'),
            'image' => $image,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->News_model->insert_news($news_data)) {
            $this->session->set_flashdata('success', 'Berita berhasil dibuat');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat berita');
            redirect('dashboard/create');
        }
    }

    // Show edit form
    public function edit($news_id = NULL) {
        if (empty($news_id)) {
            show_404();
        }

        $user_id = $this->session->userdata('user_id');
        $news = $this->News_model->get_news_by_id($news_id);
        if (empty($news) || $news['user_id'] != $user_id) {
            show_404();
        }

        $data['title'] = 'Edit Berita';
        $data['news'] = $news;

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    // Update news
    public function update($news_id = NULL) {
        if ($this->input->method() !== 'post' || empty($news_id)) {
            redirect('dashboard');
        }

        $user_id = $this->session->userdata('user_id');
        $news = $this->News_model->get_news_by_id($news_id);

        if (empty($news) || $news['user_id'] != $user_id) {
            $this->session->set_flashdata('error', 'Akses ditolak');
            redirect('dashboard');
            return;
        }

        $this->form_validation->set_rules('title', 'Judul', 'required|min_length[10]|max_length[255]');
        $this->form_validation->set_rules('content', 'Konten', 'required|min_length[50]');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($news_id);
            return;
        }

        $update_data = [
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Handle image upload logic for update
        if (!empty($_FILES['image']['name'])) {
            $image = $this->_upload_image();
            
            if ($image) {
                if ($news['image'] && file_exists(FCPATH . 'assets/uploads/' . $news['image'])) {
                    unlink(FCPATH . 'assets/uploads/' . $news['image']);
                }
                $update_data['image'] = $image;
            } else {
                redirect('dashboard/edit/' . $news_id);
                return;
            }
        }

        if ($this->News_model->update_news($news_id, $update_data)) {
            $this->session->set_flashdata('success', 'Berita berhasil diupdate');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Gagal update berita');
            redirect('dashboard/edit/' . $news_id);
        }
    }

    // Delete news
    public function delete($news_id = NULL) {
        if (empty($news_id)) {
            show_404();
        }

        $user_id = $this->session->userdata('user_id');
        $news = $this->News_model->get_news_by_id($news_id);

        if (empty($news) || $news['user_id'] != $user_id) {
            $this->session->set_flashdata('error', 'Akses ditolak');
            redirect('dashboard');
            return;
        }

        if ($news['image'] && file_exists(FCPATH . 'assets/uploads/' . $news['image'])) {
            unlink(FCPATH . 'assets/uploads/' . $news['image']);
        }

        if ($this->News_model->delete_news($news_id)) {
            $this->session->set_flashdata('success', 'Berita berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus berita');
        }

        redirect('dashboard');
    }

    // Private function upload image
    private function _upload_image() {
        $config['upload_path']   = FCPATH . 'assets/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size']      = 5120; 
        $config['file_name']     = 'news_' . time() . '_' . random_string('alnum', 8);
        $config['overwrite']     = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->data('file_name');
        } else {
            $error_msg = $this->upload->display_errors('', '');
            $this->session->set_flashdata('error', 'Upload Gagal: ' . $error_msg);
            return FALSE;
        }
    }
}