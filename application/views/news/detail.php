<article class="news-article" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
    <header class="article-header" style="margin-bottom: 2rem;">
        <h1 style="margin: 0 0 1rem 0; font-size: 2.2rem; line-height: 1.3;">
            <?php echo htmlspecialchars($news['title']); ?>
        </h1>
        
        <div class="article-meta" style="display: flex; flex-wrap: wrap; gap: 2rem; color: var(--text-gray); font-size: 0.95rem; padding-bottom: 1.5rem; border-bottom: 2px solid var(--border-color);">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span>📅</span>
                <span><?php echo date('d F Y', strtotime($news['created_at'])); ?></span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span>👤</span>
                <span><?php echo htmlspecialchars($news['username']); ?></span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span id="like-icon">❤️</span>
                <span id="like-count"><?php echo $news['likes_count'] ?? 0; ?></span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span>💬</span>
                <span><?php echo $news['comments_count'] ?? 0; ?></span>
            </div>
        </div>
    </header>

    <?php if ($news['image']): ?>
        <figure style="margin: 2rem 0; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg);">
            <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>" 
                 alt="<?php echo htmlspecialchars($news['title']); ?>" 
                 style="width: 100%; height: auto; object-fit: cover; display: block;">
        </figure>
    <?php endif; ?>

    <div class="article-content" style="font-size: 1.05rem; line-height: 1.8; color: var(--text-gray); margin: 2rem 0;">
        <?php echo nl2br(htmlspecialchars($news['content'])); ?>
    </div>

    <div class="article-actions" style="display: flex; gap: 1rem; margin: 3rem 0; padding: 2rem; background: var(--bg-light); border-radius: var(--radius-lg); flex-wrap: wrap;">
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

        <?php if ($this->session->userdata('user_id') && $this->session->userdata('user_id') == $news['author_id']): ?>
            <a href="<?php echo base_url('dashboard/edit/' . $news['id']); ?>" class="btn btn-secondary">
                <span>✏️</span>
                <span>Edit</span>
            </a>
        <?php endif; ?>
    </div>

    <div class="author-card" style="background: var(--white); border: 2px solid var(--border-color); border-radius: var(--radius-lg); padding: 2rem; margin: 3rem 0; display: flex; gap: 20px; align-items: flex-start;">
        <div style="width: 60px; height: 60px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; flex-shrink: 0;">
            <?php echo strtoupper(substr($news['username'], 0, 1)); ?>
        </div>
        
        <div>
            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; color: var(--primary);">Tentang Penulis</h3>
            <strong style="display: block; font-size: 1.1rem; margin-bottom: 0.5rem;">
                <?php echo htmlspecialchars($news['username']); ?>
            </strong>
            <p style="color: var(--text-gray); margin: 0; line-height: 1.6;">
                <?php 
                if (!empty($news['bio'])) {
                    echo nl2br(htmlspecialchars($news['bio'])); 
                } else {
                    echo "Penulis ini belum menambahkan bio. Tapi dia punya cerita petualangan yang seru!";
                }
                ?>
            </p>
        </div>
    </div>

    <?php if (!empty($related_news)): ?>
        <section style="margin: 3rem 0;">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.8rem;">📌 Berita Terkait</h2>
            <div class="news-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                <?php foreach ($related_news as $related): ?>
                    <div class="card">
                        <div class="card-image">
                            <img src="<?php echo base_url('assets/uploads/' . $related['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($related['title']); ?>"
                                 style="width: 100%; height: 150px; object-fit: cover; display: block;">
                            <span class="card-category">Terkait</span>
                        </div>
                        <div class="card-content">
                            <div class="card-meta">📅 <?php echo date('d M Y', strtotime($related['created_at'])); ?></div>
                            <h3 style="margin: 0.5rem 0;"><a href="<?php echo base_url('home/detail/' . $related['slug']); ?>" style="color: var(--text-dark);">
                                <?php echo htmlspecialchars($related['title']); ?>
                            </a></h3>
                            <p style="margin: 0.5rem 0; font-size: 0.9rem;"><?php echo character_limiter(strip_tags($related['content']), 80); ?></p>
                            <div class="card-footer" style="border-top: 1px solid var(--border-color); padding-top: 0.8rem; margin-top: 0.8rem;">
                                <a href="<?php echo base_url('home/detail/' . $related['slug']); ?>" class="read-more">Baca</a>
                                <span class="likes-count">❤️ <?php echo $related['likes_count']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="comments-section" style="margin: 3rem 0;">
        <h2 style="margin-bottom: 1.5rem; font-size: 1.8rem;">💬 Komentar (<?php echo count($comments); ?>)</h2>

        <?php if ($this->session->userdata('user_id')): ?>
            <div class="comment-form" style="background: var(--white); border: 2px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 2rem;">
                <h4 style="margin: 0 0 1rem 0;">Tulis Komentar</h4>
                <form id="comment-form" style="display: flex; flex-direction: column; gap: 1rem;">
                    <textarea id="comment-body" name="body" rows="4" class="form-control" 
                              placeholder="Bagikan pendapat Anda tentang berita ini..." required></textarea>
                    <button type="submit" class="btn btn-primary" style="align-self: flex-start;">
                        ✓ Kirim Komentar
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="comment-login-notice" style="background: var(--primary-light); border-left: 4px solid var(--primary); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 2rem; text-align: center;">
                <p style="margin: 0; color: var(--text-dark);">
                    <strong>Ingin berkomentar?</strong> Silakan 
                    <a href="<?php echo base_url('auth/login'); ?>" style="color: var(--primary); font-weight: 600;">login</a> 
                    atau <a href="<?php echo base_url('auth/register'); ?>" style="color: var(--primary); font-weight: 600;">daftar</a> terlebih dahulu.
                </p>
            </div>
        <?php endif; ?>

        <div class="comments-list" id="comments-list">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment" data-comment-id="<?php echo $comment['id']; ?>" 
                         style="background: var(--white); border: 1px solid var(--border-color); border-left: 4px solid var(--primary); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.8rem;">
                            <div>
                                <strong style="font-size: 0.95rem;"><?php echo htmlspecialchars($comment['username']); ?></strong>
                                <div style="font-size: 0.85rem; color: var(--text-light);">
                                    <?php echo date('d M Y - H:i', strtotime($comment['created_at'])); ?>
                                </div>
                            </div>
                            <?php if ($this->session->userdata('user_id') == $comment['user_id']): ?>
                                <button class="btn btn-small btn-danger" style="font-size: 0.8rem;" 
                                        onclick="deleteComment(<?php echo $comment['id']; ?>)">
                                    Hapus
                                </button>
                            <?php endif; ?>
                        </div>
                        <p style="color: var(--text-gray); margin: 0;"><?php echo htmlspecialchars($comment['body']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="background: var(--bg-light); border-radius: var(--radius-lg); padding: 2rem; text-align: center;">
                    <p style="color: var(--text-gray); margin: 0;">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</article>

</div> 

<script>
// ============================================
// LIKE FUNCTIONALITY (Updated for Api.php)
// ============================================
const likeButton = document.getElementById('like-button');
if (likeButton) {
    likeButton.addEventListener('click', function() {
        const newsId = this.dataset.newsId;
        const likeIcon = document.getElementById('like-btn-icon');
        const likeCount = document.getElementById('like-count');

        // PERUBAHAN PENTING: Menggunakan api/toggle_like sesuai controller Api.php
        fetch('<?php echo base_url('api/toggle_like/'); ?>' + newsId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeCount.textContent = data.total_likes;
                    
                    // Update tampilan tombol berdasarkan status
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

// ============================================
// SHARE FUNCTIONALITY
// ============================================
function shareNews() {
    const url = window.location.href;
    const title = '<?php echo htmlspecialchars($news['title']); ?>';
    
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

// ============================================
// ADD COMMENT FUNCTIONALITY
// ============================================
const commentForm = document.getElementById('comment-form');
if (commentForm) {
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const body = document.getElementById('comment-body').value;
        const newsId = <?php echo $news['id']; ?>;

        fetch('<?php echo base_url('api/add_comment'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                news_id: newsId,
                body: body
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new comment to list
                const commentsList = document.getElementById('comments-list');
                const newComment = document.createElement('div');
                newComment.className = 'comment';
                newComment.dataset.commentId = data.comment.id;
                newComment.style.cssText = 'background: var(--white); border: 1px solid var(--border-color); border-left: 4px solid var(--primary); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1rem;';
                
                newComment.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.8rem;">
                        <div>
                            <strong style="font-size: 0.95rem;"><?php echo htmlspecialchars($this->session->userdata('username')); ?></strong>
                            <div style="font-size: 0.85rem; color: var(--text-light);">
                                ${data.comment.created_at}
                            </div>
                        </div>
                        <button class="btn btn-small btn-danger" style="font-size: 0.8rem;" 
                                onclick="deleteComment(${data.comment.id})">
                            Hapus
                        </button>
                    </div>
                    <p style="color: var(--text-gray); margin: 0;">${data.comment.body}</p>
                `;
                
                // Clear form and show new comment
                if (commentsList.innerHTML.includes('Belum ada komentar')) {
                    commentsList.innerHTML = '';
                }
                commentsList.insertBefore(newComment, commentsList.firstChild);
                document.getElementById('comment-body').value = '';
                
                // Update comment count
                const commentCountEl = document.querySelector('.article-meta').querySelectorAll('div')[3].querySelector('span:last-child');
                commentCountEl.textContent = parseInt(commentCountEl.textContent) + 1;
            } else {
                alert(data.message || 'Gagal menambahkan komentar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi');
        });
    });
}

// ============================================
// DELETE COMMENT FUNCTIONALITY
// ============================================
function deleteComment(commentId) {
    if (!confirm('Yakin ingin menghapus komentar ini?')) return;

    fetch('<?php echo base_url('api/delete_comment/'); ?>' + commentId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
            if (commentElement) {
                commentElement.remove();
                
                // Update comment count (Optional)
                const commentCountEl = document.querySelector('.article-meta').querySelectorAll('div')[3].querySelector('span:last-child');
                const currentCount = parseInt(commentCountEl.textContent);
                if(currentCount > 0) {
                     commentCountEl.textContent = currentCount - 1;
                }
                
                alert('Komentar berhasil dihapus');
            }
        } else {
            alert(data.message || 'Gagal menghapus komentar');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi');
    });
}
</script>