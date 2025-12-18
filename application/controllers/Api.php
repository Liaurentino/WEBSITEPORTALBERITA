<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->library('form_validation');
        header('Content-Type: application/json');
    }


    // LIKE FUNCTION 
    public function toggle_like($news_id = NULL) {
        if (empty($news_id)) {
            echo json_encode(['success' => FALSE, 'message' => 'Invalid request']);
            return;
        }
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['success' => FALSE, 'message' => 'Login required']);
            return;
        }
        $news = $this->News_model->get_news_by_id($news_id);
        if (empty($news)) {
            echo json_encode(['success' => FALSE, 'message' => 'News not found']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
    
        $this->News_model->toggle_like($user_id, $news_id);
        
        $total_likes = $this->News_model->get_likes_count($news_id);
        $is_liked = $this->db->get_where('likes', [
            'user_id' => $user_id,
            'news_id' => $news_id
        ])->num_rows() > 0;

        echo json_encode([
            'success' => TRUE,
            'message' => $is_liked ? 'Liked' : 'Unliked',
            'total_likes' => $total_likes,
            'is_liked' => $is_liked
        ]);
    }

    // COMMENT FUNCTIONALITY

    public function add_comment() {
        $input = json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['success' => FALSE, 'message' => 'Login required']);
            return;
        }
        if (empty($input['news_id']) || empty($input['body'])) {
            echo json_encode(['success' => FALSE, 'message' => 'Invalid request']);
            return;
        }

        $news_id = intval($input['news_id']);
        $body = trim($input['body']);

        if (strlen($body) < 3 || strlen($body) > 500) {
            echo json_encode(['success' => FALSE, 'message' => 'Comment must be 3-500 characters']);
            return;
        }

    
        $news = $this->News_model->get_news_by_id($news_id);
        if (empty($news)) {
            echo json_encode(['success' => FALSE, 'message' => 'News not found']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $username = $this->session->userdata('username');

        $comment_data = [
            'user_id' => $user_id,
            'news_id' => $news_id,
            'body' => htmlspecialchars($body),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('comments', $comment_data)) {
            $comment_id = $this->db->insert_id();
            
            echo json_encode([
                'success' => TRUE,
                'message' => 'Comment added successfully',
                'comment' => [
                    'id' => $comment_id,
                    'username' => $username,
                    'body' => $body,
                    'created_at' => date('d M Y - H:i', strtotime($comment_data['created_at']))
                ]
            ]);
        } else {
            echo json_encode(['success' => FALSE, 'message' => 'Failed to add comment']);
        }
    }

    // Delete comment
    public function delete_comment($comment_id = NULL) {
        if (empty($comment_id)) {
            echo json_encode(['success' => FALSE, 'message' => 'Invalid request']);
            return;
        }

        if (!$this->session->userdata('user_id')) {
            echo json_encode(['success' => FALSE, 'message' => 'Login required']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $comment = $this->db->get_where('comments', ['id' => $comment_id])->row_array();

        if (empty($comment)) {
            echo json_encode(['success' => FALSE, 'message' => 'Comment not found']);
            return;
        }

        if ($comment['user_id'] != $user_id) {
            echo json_encode(['success' => FALSE, 'message' => 'Access denied']);
            return;
        }

        if ($this->db->delete('comments', ['id' => $comment_id])) {
            echo json_encode([
                'success' => TRUE,
                'message' => 'Comment deleted successfully'
            ]);
        } else {
            echo json_encode(['success' => FALSE, 'message' => 'Failed to delete comment']);
        }
    }


    public function get_comments($news_id = NULL) {
        if (empty($news_id)) {
            echo json_encode(['success' => FALSE, 'message' => 'Invalid request']);
            return;
        }

        // Check if news exists
        $news = $this->News_model->get_news_by_id($news_id);
        if (empty($news)) {
            echo json_encode(['success' => FALSE, 'message' => 'News not found']);
            return;
        }

        $comments = $this->db->select('c.*, u.username, u.id as user_id')
            ->from('comments c')
            ->join('users u', 'c.user_id = u.id', 'left')
            ->where('c.news_id', $news_id)
            ->order_by('c.created_at', 'DESC')
            ->get()
            ->result_array();

        echo json_encode([
            'success' => TRUE,
            'data' => $comments
        ]);
    }

 
    // SEARCH FUNCTIONALITY
    public function search() {
        $keyword = $this->input->get('q');

        if (empty($keyword)) {
            echo json_encode(['success' => FALSE, 'message' => 'Empty keyword']);
            return;
        }

        $results = $this->News_model->search_news($keyword);

        echo json_encode([
            'success' => TRUE,
            'count' => count($results),
            'data' => $results
        ]);
    }

  
    // NEWS STATISTICS
    public function get_news_stats($news_id = NULL) {
        if (empty($news_id)) {
            echo json_encode(['success' => FALSE, 'message' => 'Invalid request']);
            return;
        }

        $news = $this->News_model->get_news_by_id($news_id);

        if (empty($news)) {
            echo json_encode(['success' => FALSE, 'message' => 'News not found']);
            return;
        }

        $likes_count = $this->News_model->get_likes_count($news_id);
        
        $comments_count = $this->db->where('news_id', $news_id)
            ->count_all_results('comments');

        echo json_encode([
            'success' => TRUE,
            'data' => [
                'news_id' => $news_id,
                'title' => $news['title'],
                'likes' => $likes_count,
                'comments' => $comments_count
            ]
        ]);
    }

    // GET TRENDING NEWS
    public function get_trending() {
        $limit = $this->input->get('limit', 6);
        $trending = $this->News_model->get_trending_news($limit);

        echo json_encode([
            'success' => TRUE,
            'count' => count($trending),
            'data' => $trending
        ]);
    }


    // GET LATEST NEWS
    public function get_latest() {
        $limit = $this->input->get('limit', 9);
        $latest = $this->News_model->get_latest_news($limit);

        echo json_encode([
            'success' => TRUE,
            'count' => count($latest),
            'data' => $latest
        ]);
    }
}