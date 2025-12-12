<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('News_model');

		// Check login
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}
	}

	// Daftar berita
	public function index()
	{
		$user_id = $this->session->userdata('user_id');

		// Pagination
		$page = $this->input->get('page') ? $this->input->get('page') : 0;
		$per_page = 10;

		$data['total'] = $this->News_model->count_by_user($user_id);
		$data['news'] = $this->News_model->get_by_user($user_id, $per_page, $page);

		// Setup pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url('dashboard?page=');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $per_page;
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;

		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'Pertama';
		$config['last_link'] = 'Terakhir';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Sebelumnya';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Berikutnya';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('templates/header');
		$this->load->view('dashboard/index', $data);
		$this->load->view('templates/footer');
	}

	// Halaman buat berita
	public function create()
	{
		$this->load->view('templates/header');
		$this->load->view('dashboard/create');
		$this->load->view('templates/footer');
	}

	// Proses buat berita
	public function store()
	{
		$user_id = $this->session->userdata('user_id');
		$title = $this->input->post('title');
		$content = $this->input->post('content');

		// Validasi
		if (empty($title) || empty($content)) {
			$this->session->set_flashdata('error', 'Judul dan isi berita harus diisi');
			redirect('dashboard/create');
		}

		// Handle upload gambar
		$image = '';
		if (!empty($_FILES['image']['name'])) {
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 2048;
			$config['file_name'] = 'news_' . time();

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$image = $this->upload->data('file_name');
			} else {
				$this->session->set_flashdata('error', 'Gagal upload gambar: ' . $this->upload->display_errors());
				redirect('dashboard/create');
			}
		}

		// Generate slug
		$slug = $this->News_model->generate_slug($title);

		// Insert ke database
		$data = array(
			'user_id' => $user_id,
			'title' => $title,
			'slug' => $slug,
			'content' => $content,
			'image' => $image,
			'created_at' => date('Y-m-d H:i:s')
		);

		if ($this->News_model->create($data)) {
			$this->session->set_flashdata('success', 'Berita berhasil dibuat');
			redirect('dashboard');
		} else {
			$this->session->set_flashdata('error', 'Gagal membuat berita');
			redirect('dashboard/create');
		}
	}

	// Halaman edit berita
	public function edit($id)
	{
		$user_id = $this->session->userdata('user_id');
		$data['news'] = $this->News_model->get_by_id($id);

		// Check ownership
		if ($data['news']->user_id != $user_id && $this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses');
			redirect('dashboard');
		}

		$this->load->view('templates/header');
		$this->load->view('dashboard/edit', $data);
		$this->load->view('templates/footer');
	}

	// Proses update berita
	public function update($id)
	{
		$user_id = $this->session->userdata('user_id');
		$news = $this->News_model->get_by_id($id);

		// Check ownership
		if ($news->user_id != $user_id && $this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses');
			redirect('dashboard');
		}

		$title = $this->input->post('title');
		$content = $this->input->post('content');

		if (empty($title) || empty($content)) {
			$this->session->set_flashdata('error', 'Judul dan isi berita harus diisi');
			redirect('dashboard/edit/' . $id);
		}

		// Handle upload gambar
		$image = $news->image;
		if (!empty($_FILES['image']['name'])) {
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 2048;
			$config['file_name'] = 'news_' . time();

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				// Hapus gambar lama
				if ($news->image && file_exists('./assets/uploads/' . $news->image)) {
					unlink('./assets/uploads/' . $news->image);
				}
				$image = $this->upload->data('file_name');
			} else {
				$this->session->set_flashdata('error', 'Gagal upload gambar: ' . $this->upload->display_errors());
				redirect('dashboard/edit/' . $id);
			}
		}

		// Update slug jika title berubah
		$slug = $news->slug;
		if ($news->title != $title) {
			$slug = $this->News_model->generate_slug($title);
		}

		$data = array(
			'title' => $title,
			'slug' => $slug,
			'content' => $content,
			'image' => $image
		);

		if ($this->News_model->update($id, $data)) {
			$this->session->set_flashdata('success', 'Berita berhasil diupdate');
			redirect('dashboard');
		} else {
			$this->session->set_flashdata('error', 'Gagal mengupdate berita');
			redirect('dashboard/edit/' . $id);
		}
	}

	// Hapus berita
	public function delete($id)
	{
		$user_id = $this->session->userdata('user_id');
		$news = $this->News_model->get_by_id($id);

		// Check ownership
		if ($news->user_id != $user_id && $this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses');
			redirect('dashboard');
		}

		// Hapus gambar
		if ($news->image && file_exists('./assets/uploads/' . $news->image)) {
			unlink('./assets/uploads/' . $news->image);
		}

		if ($this->News_model->delete($id)) {
			$this->session->set_flashdata('success', 'Berita berhasil dihapus');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus berita');
		}

		redirect('dashboard');
	}
}