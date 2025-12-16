<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('User_model');
        
        // PROTEKSI: Cek login dan Cek Role Admin
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman admin.');
            redirect('home'); // Tendang balik ke home jika bukan admin
        }
    }

    // Halaman Utama Admin
    public function index() {
        $data['title'] = 'Admin Panel - Dashboard';
        $data['stats'] = $this->News_model->get_site_stats(); // Menggunakan fungsi stats yang sudah ada
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('layout/footer', $data);
    }

    // --- MANAJEMEN USER (BAN/UNBAN) ---
    public function users() {
        $data['title'] = 'Kelola Pengguna';
        // Pastikan User_model punya fungsi get_all_users()
        $data['users'] = $this->User_model->get_all_users(); 
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('layout/footer', $data);
    }

    public function ban_user($user_id) {
        // Jangan biarkan admin nge-ban dirinya sendiri
        if ($user_id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda tidak bisa mem-banned diri sendiri.');
            redirect('admin/users');
            return;
        }

        // Update is_active jadi 0
        $this->db->where('id', $user_id);
        $this->db->update('users', ['is_active' => 0]);
        
        $this->session->set_flashdata('success', 'User berhasil di-banned.');
        redirect('admin/users');
    }

    public function unban_user($user_id) {
        // Update is_active jadi 1
        $this->db->where('id', $user_id);
        $this->db->update('users', ['is_active' => 1]);
        
        $this->session->set_flashdata('success', 'User berhasil diaktifkan kembali.');
        redirect('admin/users');
    }

    // --- MANAJEMEN BERITA (HAPUS) ---
    public function news() {
        $data['title'] = 'Kelola Semua Berita';
        // Ambil 100 berita terbaru
        $data['news_list'] = $this->News_model->get_latest_news(100); 
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/news', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete_news($news_id) {
        $news = $this->News_model->get_news_by_id($news_id);
        
        if ($news) {
            // Hapus file gambar jika ada
            if ($news['image'] && file_exists(FCPATH . 'assets/uploads/' . $news['image'])) {
                unlink(FCPATH . 'assets/uploads/' . $news['image']);
            }
            
            // Hapus data dari DB
            $this->News_model->delete_news($news_id);
            $this->session->set_flashdata('success', 'Berita berhasil dihapus paksa oleh Admin.');
        } else {
            $this->session->set_flashdata('error', 'Berita tidak ditemukan.');
        }
        
        redirect('admin/news');
    }
}