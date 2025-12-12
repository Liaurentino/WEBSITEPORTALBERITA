<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adventure Today - Portal Berita</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body
<main class="container">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di Adventure Today</h1>
            <p>Temukan cerita inspiratif dan petualangan menarik setiap hari</p>
            <div class="hero-buttons">
                <?php if (!$this->session->userdata('user_id')): ?>
                    <a href="<?php echo base_url('register'); ?>" class="btn btn-primary btn-lg">Mulai Sekarang</a>
                <?php else: ?>
                    <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary btn-lg">Tulis Berita</a>
                <?php endif; ?>
                <a href="#trending" class="btn btn-secondary btn-lg">Jelajahi</a>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section">
        <form action="<?php echo base_url('home/search'); ?>" method="GET" class="search-form">
            <div class="search-container">
                <input type="text" name="q" class="search-input" placeholder="Cari berita, penulis, atau topik...">
                <button type="submit" class="search-btn">
                    <i class="icon-search"></i> Cari
                </button>
            </div>
        </form>
    </section>

    <!-- Hot News Section -->
    <section class="section" id="hot-news">
        <div class="section-header">
            <h2 class="section-title">🔥 Berita Terbaru</h2>
            <a href="#" class="view-all">Lihat Semua →</a>
        </div>
        
        <?php if (!empty($hot_news)): ?>
            <div class="news-grid hot-news">
                <?php foreach ($hot_news as $news): ?>
                    <article class="news-card large featured">
                        <div class="news-card-image-wrapper">
                            <?php if ($news->image): ?>
                                <img src="<?php echo base_url('assets/uploads/' . $news->image); ?>" alt="<?php echo $news->title; ?>" class="news-image">
                            <?php else: ?>
                                <div class="news-image placeholder">
                                    <i class="icon-image"></i>
                                </div>
                            <?php endif; ?>
                            <div class="news-badge hot">HOT</div>
                            <div class="news-overlay"></div>
                        </div>
                        <div class="news-content">
                            <div class="news-category">
                                <span class="category-tag">Terbaru</span>
                            </div>
                            <h3>
                                <a href="<?php echo base_url('news/detail/' . $news->slug); ?>">
                                    <?php echo substr($news->title, 0, 70); ?><?php echo strlen($news->title) > 70 ? '...' : ''; ?>
                                </a>
                            </h3>
                            <p class="news-excerpt"><?php echo substr(strip_tags($news->content), 0, 150); ?>...</p>
                            <div class="news-meta">
                                <span class="author">
                                    <i class="icon-user"></i> <?php echo $news->username; ?>
                                </span>
                                <span class="date">
                                    <i class="icon-calendar"></i> <?php echo date('d M Y', strtotime($news->created_at)); ?>
                                </span>
                                <span class="reading-time">
                                    <i class="icon-clock"></i> 5 min baca
                                </span>
                            </div>
                            <div class="news-footer">
                                <div class="news-stats">
                                    <span class="likes" data-news-id="<?php echo $news->id; ?>">
                                        <i class="icon-heart <?php echo isset($news->is_liked) && $news->is_liked ? 'liked' : ''; ?>"></i> 
                                        <span id="like-count-<?php echo $news->id; ?>"><?php echo $news->total_likes; ?></span>
                                    </span>
                                </div>
                                <a href="<?php echo base_url('news/detail/' . $news->slug); ?>" class="read-more">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Belum ada berita. Jadilah yang pertama! <a href="<?php echo base_url('register'); ?>">Daftar sekarang</a></p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Trending Section -->
    <section class="section" id="trending">
        <div class="section-header">
            <h2 class="section-title">📈 Trending Sekarang</h2>
            <span class="section-subtitle">Berita paling populer hari ini</span>
        </div>

        <?php if (!empty($trending_news)): ?>
            <div class="trending-container">
                <div class="trending-list">
                    <?php $i = 1; foreach ($trending_news as $news): ?>
                        <div class="trending-item" data-rank="<?php echo $i; ?>">
                            <div class="trending-rank">
                                <span class="rank-number"><?php echo $i; ?></span>
                                <?php if ($i <= 3): ?>
                                    <span class="rank-icon">🏆</span>
                                <?php endif; ?>
                            </div>
                            <div class="trending-image">
                                <?php if ($news->image): ?>
                                    <img src="<?php echo base_url('assets/uploads/' . $news->image); ?>" alt="<?php echo $news->title; ?>">
                                <?php else: ?>
                                    <div class="placeholder-image">
                                        <i class="icon-image"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="trending-content">
                                <h4>
                                    <a href="<?php echo base_url('news/detail/' . $news->slug); ?>">
                                        <?php echo $news->title; ?>
                                    </a>
                                </h4>
                                <p class="trending-excerpt"><?php echo substr(strip_tags($news->content), 0, 80); ?>...</p>
                                <p class="trending-meta">
                                    <span class="author"><?php echo $news->username; ?></span>
                                    <span class="separator">•</span>
                                    <span class="stats">
                                        <i class="icon-heart"></i> <?php echo $news->total_likes; ?> likes
                                    </span>
                                </p>
                            </div>
                            <div class="trending-arrow">
                                <i class="icon-arrow-right"></i>
                            </div>
                        </div>
                        <?php $i++; endforeach; ?>
                </div>

                <!-- Trending Stats -->
                <div class="trending-stats">
                    <div class="stat-card">
                        <div class="stat-icon heart">
                            <i class="icon-heart"></i>
                        </div>
                        <div class="stat-content">
                            <h5>Total Likes</h5>
                            <p class="stat-value"><?php echo array_sum(array_map(function($n) { return $n->total_likes; }, $trending_news)); ?></p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon users">
                            <i class="icon-users"></i>
                        </div>
                        <div class="stat-content">
                            <h5>Total Penulis</h5>
                            <p class="stat-value"><?php echo $total; ?></p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon articles">
                            <i class="icon-articles"></i>
                        </div>
                        <div class="stat-content">
                            <h5>Total Berita</h5>
                            <p class="stat-value"><?php echo $total; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Belum ada berita trending. Mulai berkontribusi sekarang!</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Categories Section -->
    <section class="section">
        <h2 class="section-title">📚 Kategori Populer</h2>
        <div class="categories-grid">
            <a href="#" class="category-card">
                <div class="category-icon">🌍</div>
                <h4>Traveling</h4>
                <p class="category-count">245 berita</p>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">⛺</div>
                <h4>Outdoor</h4>
                <p class="category-count">189 berita</p>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">🏔️</div>
                <h4>Mountain</h4>
                <p class="category-count">156 berita</p>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">🌊</div>
                <h4>Water Sports</h4>
                <p class="category-count">134 berita</p>
            </a>
        </div>
    </section>

    <!-- All News Section with Sidebar -->
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">📰 Semua Berita</h2>
            <div class="sort-options">
                <select class="sort-select" onchange="location = this.value;">
                    <option value="<?php echo base_url('home?sort=newest'); ?>">Terbaru</option>
                    <option value="<?php echo base_url('home?sort=oldest'); ?>">Terlama</option>
                    <option value="<?php echo base_url('home?sort=popular'); ?>">Paling Suka</option>
                </select>
            </div>
        </div>

        <div class="news-container">
            <!-- Main Content -->
            <div class="news-main">
                <?php if (!empty($news)): ?>
                    <div class="news-grid">
                        <?php foreach ($news as $item): ?>
                            <article class="news-card">
                                <div class="news-card-wrapper">
                                    <div class="news-card-image">
                                        <?php if ($item->image): ?>
                                            <img src="<?php echo base_url('assets/uploads/' . $item->image); ?>" alt="<?php echo $item->title; ?>" class="news-image">
                                        <?php else: ?>
                                            <div class="news-image placeholder">
                                                <i class="icon-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="news-content">
                                        <h3>
                                            <a href="<?php echo base_url('news/detail/' . $item->slug); ?>">
                                                <?php echo substr($item->title, 0, 50); ?><?php echo strlen($item->title) > 50 ? '...' : ''; ?>
                                            </a>
                                        </h3>
                                        <p class="news-excerpt"><?php echo substr(strip_tags($item->content), 0, 80); ?>...</p>
                                        <div class="news-meta">
                                            <span class="author">
                                                <i class="icon-user"></i> <?php echo $item->username; ?>
                                            </span>
                                            <span class="date">
                                                <i class="icon-calendar"></i> <?php echo date('d M', strtotime($item->created_at)); ?>
                                            </span>
                                        </div>
                                        <div class="news-footer">
                                            <span class="likes" onclick="toggleLike(<?php echo $item->id; ?>)">
                                                <i class="icon-heart <?php echo isset($item->is_liked) && $item->is_liked ? 'liked' : ''; ?>"></i> 
                                                <span id="like-count-<?php echo $item->id; ?>"><?php echo $item->total_likes; ?></span>
                                            </span>
                                            <a href="<?php echo base_url('news/detail/' . $item->slug); ?>" class="read-more">Baca →</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <?php echo $pagination; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <h3>Belum ada berita</h3>
                        <p>Mulai berbagi cerita petualangan Anda sekarang!</p>
                        <a href="<?php echo base_url('register'); ?>" class="btn btn-primary">Daftar Sekarang</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <!-- Newsletter -->
                <div class="sidebar-widget newsletter-widget">
                    <h4>📧 Newsletter</h4>
                    <p>Dapatkan berita terbaru langsung ke inbox Anda</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Email Anda" required>
                        <button type="submit" class="btn btn-primary btn-sm">Subscribe</button>
                    </form>
                </div>

                <!-- Popular Authors -->
                <div class="sidebar-widget">
                    <h4>👥 Penulis Terpopuler</h4>
                    <ul class="authors-list">
                        <li class="author-item">
                            <div class="author-avatar">JD</div>
                            <div class="author-info">
                                <h5>John Doe</h5>
                                <p>25 berita</p>
                            </div>
                        </li>
                        <li class="author-item">
                            <div class="author-avatar">SA</div>
                            <div class="author-info">
                                <h5>Sarah Adams</h5>
                                <p>18 berita</p>
                            </div>
                        </li>
                        <li class="author-item">
                            <div class="author-avatar">MC</div>
                            <div class="author-info">
                                <h5>Mike Clark</h5>
                                <p>12 berita</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- About -->
                <div class="sidebar-widget about-widget">
                    <h4>ℹ️ Tentang Adventure Today</h4>
                    <p>Platform berbagi cerita dan petualangan untuk traveler, explorer, dan adventure enthusiast di seluruh dunia.</p>
                    <div class="about-links">
                        <a href="#">Tentang Kami</a>
                        <a href="#">Kebijakan</a>
                        <a href="#">Kontak</a>
                    </div>
                </div>

                <!-- Tags -->
                <div class="sidebar-widget">
                    <h4>🏷️ Tag Populer</h4>
                    <div class="tags-container">
                        <span class="tag">Travel</span>
                        <span class="tag">Adventure</span>
                        <span class="tag">Outdoor</span>
                        <span class="tag">Mountain</span>
                        <span class="tag">Beach</span>
                        <span class="tag">Photography</span>
                        <span class="tag">Nature</span>
                        <span class="tag">Hiking</span>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="cta-content">
            <h2>Mulai Berbagi Cerita Petualangan Anda</h2>
            <p>Jadilah bagian dari komunitas Adventure Today dan inspirasikan jutaan orang dengan cerita unik Anda</p>
            <?php if (!$this->session->userdata('user_id')): ?>
                <div class="cta-buttons">
                    <a href="<?php echo base_url('register'); ?>" class="btn btn-primary btn-lg">Daftar Gratis</a>
                    <a href="<?php echo base_url('login'); ?>" class="btn btn-secondary btn-lg">Sudah Punya Akun?</a>
                </div>
            <?php else: ?>
                <div class="cta-buttons">
                    <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary btn-lg">Tulis Cerita Baru</a>
                    <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-secondary btn-lg">Kelola Cerita Saya</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
            </body>

<script>
function toggleLike(newsId) {
    <?php if (!$this->session->userdata('user_id')): ?>
        alert('Anda harus login untuk memberikan like');
        window.location.href = '<?php echo base_url('login'); ?>';
        return;
    <?php endif; ?>

    fetch('<?php echo base_url('news/like/'); ?>' + newsId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const likeCount = document.getElementById('like-count-' + newsId);
            if (likeCount) {
                likeCount.textContent = data.total_likes;
            }
            const heartIcon = event.target.closest('.likes').querySelector('.icon-heart');
            if (heartIcon) {
                heartIcon.classList.toggle('liked');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
