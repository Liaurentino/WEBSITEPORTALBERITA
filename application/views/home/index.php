<main>
    <section class="hero-section">
        <div class="container hero-container">
            <div class="hero-text">
                <span class="badge-hero">Edisi Petualangan</span>
                <h1>Jelajahi Dunia,<br>Temukan Ceritamu.</h1>
                <p>Baca ribuan artikel inspiratif dari para traveler dunia. Mulai petualangan barumu hari ini bersama komunitas kami.</p>
                <div class="hero-cta">
                    <a href="#explore" class="btn btn-large btn-primary">Mulai Membaca</a>
                    <a href="<?php echo base_url('register'); ?>" class="btn btn-large btn-outline">Bergabung</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <strong><?php echo isset($stats['total_news']) ? $stats['total_news'] : '50K+'; ?></strong>
                        <span>Artikel</span>
                    </div>
                    <div class="stat-item">
                        <strong>120+</strong>
                        <span>Negara</span>
                    </div>
                    <div class="stat-item">
                        <strong><?php echo isset($stats['total_users']) ? $stats['total_users'] : '10K+'; ?></strong>
                        <span>Penulis</span>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Adventure">
                </div>
            </div>
        </div>
    </section>

   
    <section class="section container" id="explore">
        <div class="section-header">
            <h2>Sedang Trending</h2>
            <a href="#" class="view-all">Lihat Semua <span class="arrow">→</span></a>
        </div>

        <div class="news-grid">
            <?php if (!empty($hot_news)): ?>
                <?php foreach ($hot_news as $news): ?>
                    <article class="card">
                        <div class="card-image">
                            <?php if ($news->image): ?>
                                <img src="<?php echo base_url('assets/uploads/' . $news->image); ?>" alt="<?php echo $news->title; ?>">
                            <?php else: ?>
                                <div class="placeholder-img">📷</div>
                            <?php endif; ?>
                            <span class="card-category">Travel</span>
                        </div>
                        <div class="card-content">
                            <div class="card-meta">
                                <span class="author"><?php echo $news->username; ?></span> • 
                                <span class="date"><?php echo date('d M', strtotime($news->created_at)); ?></span>
                            </div>
                            <h3>
                                <a href="<?php echo base_url('news/detail/' . $news->slug); ?>">
                                    <?php echo $news->title; ?>
                                </a>
                            </h3>
                            <p><?php echo substr(strip_tags($news->content), 0, 100); ?>...</p>
                            <div class="card-footer">
                                <a href="<?php echo base_url('news/detail/' . $news->slug); ?>" class="read-more">Baca Selengkapnya</a>
                                <div class="likes-count"><?php echo $news->total_likes; ?></div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada berita trending saat ini.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

