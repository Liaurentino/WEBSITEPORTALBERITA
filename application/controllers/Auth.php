<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function login() {
        // 1. CEK STATUS LOGIN SAAT INI
        // Jika user iseng buka url /auth/login padahal sudah login
        if ($this->session->userdata('user_id')) {
            if ($this->session->userdata('role') == 'admin') {
                redirect('admin');
            } else {
                // PERUBAHAN DI SINI:
                // Dulu: redirect('dashboard');
                // Sekarang: redirect ke home
                redirect('home'); 
            }
        }

        $data['title'] = 'Login - Adventure Today';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('layout/header', $data);
                $this->load->view('auth/login', $data);
                $this->load->view('layout/footer', $data);
            } else {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $user = $this->User_model->get_user_by_email($email);

                if ($user && password_verify($password, $user['password'])) {
                    
                    // Cek status aktif
                    if (isset($user['is_active']) && $user['is_active'] == 0) {
                        $this->session->set_flashdata('error', 'Akun Anda telah dinonaktifkan (Banned) oleh Admin.');
                        redirect('auth/login');
                        return;
                    }

                    // Set Session
                    $this->session->set_userdata([
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ]);

                    $this->session->set_flashdata('success', 'Selamat datang, ' . $user['username'] . '!');
                    
                    // 2. LOGIKA REDIRECT SETELAH SUKSES LOGIN
                    if ($user['role'] == 'admin') {
                        // Jika Admin -> Masuk ke Panel Admin (Dashboard Admin)
                        redirect('admin'); 
                    } else {
                        // PERUBAHAN DI SINI:
                        // Jika User Biasa -> Masuk ke Home (Halaman Berita)
                        redirect('home'); 
                    }

                } else {
                    $this->session->set_flashdata('error', 'Email atau password salah!');
                    redirect('auth/login');
                }
            }
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function register() {
        // Cek jika sudah login saat mau daftar
        if ($this->session->userdata('user_id')) {
            // PERUBAHAN DI SINI JUGA:
            // Kalau sudah login jangan ke dashboard, tapi ke home
            redirect('home');
        }

        $data['title'] = 'Register - Adventure Today';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('layout/header', $data);
                $this->load->view('auth/register', $data);
                $this->load->view('layout/footer', $data);
            } else {
                $new_user = [
                    'username'   => $this->input->post('username'),
                    'email'      => $this->input->post('email'),
                    'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'role'       => 'user',
                    'is_active'  => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($this->User_model->insert_user($new_user)) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Terjadi kesalahan saat registrasi!');
                    redirect('auth/register');
                }
            }
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('auth/register', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }
}