<section class="hero-section">
    <div class="hero-container">
        <div class="hero-text">
            <div class="badge-hero">✨ Jelajahi Petualangan Baru</div>
            <h1>Temukan Cerita Petualanganmu di Adventure Today</h1>
            <p>Bagikan pengalaman travel, tips petualangan, dan kisah inspiratif Anda dengan komunitas adventurer di seluruh dunia.</p>
            
            <div class="hero-cta">
                <?php if (!$this->session->userdata('user_id')): ?>
                    <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-primary btn-large">Mulai Berbagi</a>
                <?php else: ?>
                    <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary btn-large">Tulis Cerita</a>
                <?php endif; ?>
                <a href="#trending" class="btn btn-outline btn-large">Baca Cerita</a>
            </div>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <strong><?php echo $stats['total_news']; ?></strong>
                    <span>Berita</span>
                </div>
                <div class="stat-item">
                    <strong><?php echo $stats['total_users']; ?></strong>
                    <span>Petualang</span>
                </div>
                <div class="stat-item">
                    <strong><?php echo $stats['total_likes']; ?></strong>
                    <span>Inspirasi</span>
                </div>
            </div>
        </div>
        
        <div class="hero-image">
            <div class="image-wrapper">
                <img src="<?php echo base_url('assets/images/petualang.jpg'); ?>" alt="Adventure Hero">
            </div>
        </div>
    </div>
</section>

<section class="section" id="trending">
    <div class="section-header">
        <h2>🔥 Trending Sekarang</h2>
        <a href="#" class="view-all">Lihat Semua → </a>
    </div>
    
    <div class="news-grid">
        <?php if (!empty($trending_news)): ?>
            <?php foreach ($trending_news as $news): ?>
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                        <span class="card-category">Trending</span>
                    </div>
                    <div class="card-content">
                        <div class="card-meta">
                            📅 <?php echo date('d M Y', strtotime($news['created_at'])); ?> • 👤 <?php echo htmlspecialchars($news['username']); ?>
                        </div>
                        <h3><a href="<?php echo base_url('home/detail/' . $news['slug']); ?>"><?php echo htmlspecialchars($news['title']); ?></a></h3>
                        <p><?php echo character_limiter(strip_tags($news['content']), 120); ?></p>
                        <div class="card-footer">
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" class="read-more">Baca Selengkapnya</a>
                            <span class="likes-count">❤️ <?php echo $news['likes_count']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-data">Belum ada berita trending</p>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="section-header">
        <h2>📰 Berita Terbaru</h2>
        <a href="#" class="view-all">Lihat Semua →</a>
    </div>
    
    <div class="news-grid">
        <?php if (!empty($recent_news)): ?>
            <?php foreach ($recent_news as $news): ?>
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                        <span class="card-category">Terbaru</span>
                    </div>
                    <div class="card-content">
                        <div class="card-meta">
                            📅 <?php echo date('d M Y', strtotime($news['created_at'])); ?> • 👤 <?php echo htmlspecialchars($news['username']); ?>
                        </div>
                        <h3><a href="<?php echo base_url('home/detail/' . $news['slug']); ?>"><?php echo htmlspecialchars($news['title']); ?></a></h3>
                        <p><?php echo character_limiter(strip_tags($news['content']), 120); ?></p>
                        <div class="card-footer">
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" class="read-more">Baca Selengkapnya</a>
                            <span class="likes-count">❤️ <?php echo $news['likes_count']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-data">Belum ada berita</p>
        <?php endif; ?>
    </div>
</section>

</div>