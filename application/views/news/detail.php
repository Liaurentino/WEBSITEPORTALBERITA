<article class="news-detail">

    <header class="news-header">
        <h1 class="news-title">
            <?php echo htmlspecialchars($news['title']); ?>
        </h1>

        <div class="news-meta">
            <div class="meta-item">
                <span>📅</span>
                <span><?php echo date('d F Y', strtotime($news['created_at'])); ?></span>
            </div>
            <div class="meta-item">
                <span>👤</span>
                <span><?php echo htmlspecialchars($news['username']); ?></span>
            </div>
            <div class="meta-item">
                <span id="like-icon">❤️</span>
                <span id="like-count"><?php echo $news['likes_count'] ?? 0; ?></span>
            </div>
            <div class="meta-item">
                <span>💬</span>
                <span id="comment-count-meta"><?php echo $news['comments_count'] ?? 0; ?></span>
            </div>
        </div>
    </header>

    <?php if ($news['image']): ?>
        <figure class="news-image">
            <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>"
                 alt="<?php echo htmlspecialchars($news['title']); ?>">
        </figure>
    <?php endif; ?>

    <div class="news-content">
        <?php echo nl2br(htmlspecialchars($news['content'])); ?>
    </div>

    <div class="news-actions">
        <?php if ($this->session->userdata('user_id')): ?>
            <button class="btn btn-primary like-btn" data-news-id="<?php echo $news['id']; ?>" id="like-button">
                <span id="like-btn-icon"><?php echo $is_liked ? '❤️' : '🤍'; ?></span>
                <span><?php echo $is_liked ? 'Disukai' : 'Suka'; ?></span>
            </button>
        <?php else: ?>
            <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-primary">
                <span>🤍</span>
                <span>Suka</span>
            </a>
        <?php endif; ?>

        <button class="btn btn-outline" onclick="shareNews()">
            <span>📤</span>
            <span>Bagikan</span>
        </button>

        <?php if ($this->session->userdata('user_id') == $news['author_id']): ?>
            <a href="<?php echo base_url('dashboard/edit/' . $news['id']); ?>" class="btn btn-secondary">
                <span>✏️</span>
                <span>Edit</span>
            </a>
        <?php endif; ?>
    </div>

    <div class="author-card">
        <div class="author-avatar">
            <?php echo strtoupper(substr($news['username'], 0, 1)); ?>
        </div>

        <div class="author-info">
            <h3>Tentang Penulis</h3>
            <strong><?php echo htmlspecialchars($news['username']); ?></strong>
            <p>
                <?php echo !empty($news['bio']) 
                    ? nl2br(htmlspecialchars($news['bio'])) 
                    : 'Penulis ini belum menambahkan bio. Tapi dia punya cerita petualangan yang seru!'; ?>
            </p>
        </div>
    </div>

    <section class="comments-section" style="margin-top: 40px; margin-bottom: 40px;">
        <h3 style="margin-bottom: 20px;">💬 Komentar</h3>

        <?php if ($this->session->userdata('user_id')): ?>
            <form id="comment-form" style="margin-bottom: 30px;">
                <div style="display: flex; gap: 10px; flex-direction: column;">
                    <textarea id="comment-body" rows="3" placeholder="Tulis tanggapanmu tentang cerita ini..." required 
                        style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; font-family: inherit; resize: vertical;"></textarea>
                    <button type="submit" class="btn btn-primary" style="align-self: flex-start;">Kirim Komentar</button>
                </div>
            </form>
        <?php else: ?>
            <div style="background: #f1f5f9; padding: 20px; border-radius: 10px; text-align: center; margin-bottom: 30px;">
                <p style="margin: 0;">Silakan <a href="<?php echo base_url('auth/login'); ?>" style="color: var(--theme-blue); font-weight: bold;">Login</a> untuk menulis komentar.</p>
            </div>
        <?php endif; ?>

        <div id="comments-list">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment" data-comment-id="<?php echo $comment['id']; ?>" 
                         style="background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid var(--theme-blue); border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <div>
                                <strong style="font-size: 0.95rem; display: block;"><?php echo htmlspecialchars($comment['username']); ?></strong>
                                <span style="font-size: 0.8rem; color: #64748b;"><?php echo date('d M Y H:i', strtotime($comment['created_at'])); ?></span>
                            </div>
                            
                            <?php if($this->session->userdata('user_id') == $comment['user_id'] || $this->session->userdata('role') == 'admin'): ?>
                                <button onclick="deleteComment(<?php echo $comment['id']; ?>)" 
                                        style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.85rem;">
                                    Hapus
                                </button>
                            <?php endif; ?>
                        </div>
                        <p style="margin: 0; color: #334155; line-height: 1.5;"><?php echo nl2br(htmlspecialchars($comment['body'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #64748b; font-style: italic;">Belum ada komentar. Jadilah yang pertama!</p>
            <?php endif; ?>
        </div>
    </section>

    <?php if (!empty($related_news)): ?>
        <section class="related-news">
            <h2>📌 Berita Terkait</h2>
            <div class="news-grid">
                <?php foreach ($related_news as $related): ?>
                    <div class="card">
                        <div class="card-image">
                            <img src="<?php echo base_url('assets/uploads/' . $related['image']); ?>"
                                 alt="<?php echo htmlspecialchars($related['title']); ?>">
                            <span class="card-category">Terkait</span>
                        </div>
                        <div class="card-content">
                            <div class="card-meta">📅 <?php echo date('d M Y', strtotime($related['created_at'])); ?></div>
                            <h3>
                                <a href="<?php echo base_url('home/detail/' . $related['slug']); ?>">
                                    <?php echo htmlspecialchars($related['title']); ?>
                                </a>
                            </h3>
                            <p><?php echo character_limiter(strip_tags($related['content']), 80); ?></p>
                            <div class="card-footer">
                                <a href="<?php echo base_url('home/detail/' . $related['slug']); ?>" class="read-more">Baca</a>
                                <span class="likes-count">❤️ <?php echo $related['likes_count']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</article>


<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // LIKE FEATURE 
    const likeButton = document.getElementById('like-button');
    if (likeButton) {
        likeButton.addEventListener('click', function() {
            const newsId = this.dataset.newsId;
            const likeIcon = document.getElementById('like-btn-icon');
            const likeCount = document.getElementById('like-count');

            fetch('<?php echo base_url('api/toggle_like/'); ?>' + newsId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update angka di header
                        likeCount.textContent = data.total_likes;
                        
                        // Update tampilan tombol
                        if (data.is_liked) {
                            likeIcon.textContent = '❤️';
                            likeButton.querySelector('span:last-child').textContent = 'Disukai';
                        } else {
                            likeIcon.textContent = '🤍';
                            likeButton.querySelector('span:last-child').textContent = 'Suka';
                        }
                    } else {
                        if (data.message === 'Login required') {
                            alert('Silakan login terlebih dahulu untuk menyukai berita!');
                            window.location.href = '<?php echo base_url('auth/login'); ?>';
                        } else {
                            console.error('API Message:', data.message);
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }

    // COMMENT FEATURE 
    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const body = document.getElementById('comment-body').value;
            const newsId = <?php echo $news['id']; ?>;

            fetch('<?php echo base_url('api/add_comment'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ news_id: newsId, body: body })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentsList = document.getElementById('comments-list');
                    
                    // Buat elemen HTML komentar baru via JS
                    const newComment = document.createElement('div');
                    newComment.className = 'comment';
                    newComment.dataset.commentId = data.comment.id;
                    // Styling inline agar sama dengan yang PHP render
                    newComment.style.cssText = 'background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid var(--theme-blue); border-radius: 8px; padding: 15px; margin-bottom: 15px;';
                    
                    newComment.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <div>
                                <strong style="font-size: 0.95rem; display: block;"><?php echo htmlspecialchars($this->session->userdata('username')); ?></strong>
                                <span style="font-size: 0.8rem; color: #64748b;">Baru saja</span>
                            </div>
                            <button onclick="deleteComment(${data.comment.id})" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.85rem;">Hapus</button>
                        </div>
                        <p style="margin: 0; color: #334155; line-height: 1.5;">${data.comment.body}</p>
                    `;
                    
                    // Jika list kosong sebelumnya
                    if (commentsList.innerHTML.includes('Belum ada komentar')) {
                        commentsList.innerHTML = '';
                    }
                    commentsList.insertBefore(newComment, commentsList.firstChild);
                    document.getElementById('comment-body').value = '';

                    // Update jumlah komentar di header
                    const countMeta = document.getElementById('comment-count-meta');
                    if(countMeta) countMeta.textContent = parseInt(countMeta.textContent) + 1;

                } else {
                    alert(data.message || 'Gagal menambahkan komentar');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});

function deleteComment(commentId) {
    if (!confirm('Yakin ingin menghapus komentar ini?')) return;

    fetch('<?php echo base_url('api/delete_comment/'); ?>' + commentId, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
            if (commentElement) {
                commentElement.remove();
                
                // Kurangi jumlah komentar
                const countMeta = document.getElementById('comment-count-meta');
                if(countMeta) {
                    let current = parseInt(countMeta.textContent);
                    if(current > 0) countMeta.textContent = current - 1;
                }
                alert('Komentar berhasil dihapus');
            }
        } else {
            alert(data.message || 'Gagal menghapus komentar');
        }
    })
    .catch(error => console.error('Error:', error));
}

// SHARE FUNCTION 
function shareNews() {
    const url = window.location.href;
    const title = <?php echo json_encode($news['title']); ?>;
    
    if (navigator.share) {
        navigator.share({
            title: title,
            text: 'Baca cerita menarik di Adventure Today',
            url: url
        }).catch(err => console.log('Error sharing:', err));
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link disalin ke clipboard!');
        });
    }
}
</script>