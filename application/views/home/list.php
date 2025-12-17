<div class="container main-container news-container">
    <div class="section-header news-section-header">
        <h1>
            <?php echo isset($page_title) ? $page_title : 'Daftar Berita'; ?>
        </h1>
        <p class="news-subtitle">Menampilkan berita pilihan untuk Anda</p>
    </div>

    <div class="news-grid">
        <?php if (!empty($news_list)): ?>
            <?php foreach ($news_list as $news): ?>
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>"
                             alt="<?php echo htmlspecialchars($news['title']); ?>">

                        <?php if (isset($page_title) && strpos($page_title, 'Trending') !== false): ?>
                            <span class="card-category">Trending</span>
                        <?php endif; ?>
                    </div>

                    <div class="card-content">
                        <div class="card-meta">
                            📅 <?php echo date('d M Y', strtotime($news['created_at'])); ?>
                            • 👤 <?php echo htmlspecialchars($news['username']); ?>
                        </div>

                        <h3>
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>">
                                <?php echo htmlspecialchars($news['title']); ?>
                            </a>
                        </h3>

                        <p>
                            <?php echo character_limiter(strip_tags($news['content']), 100); ?>
                        </p>

                        <div class="card-footer">
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>"
                               class="read-more">
                                Baca Selengkapnya
                            </a>
                            <span class="likes-count">
                                ❤️ <?php echo isset($news['likes_count']) ? $news['likes_count'] : 0; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-data">
                <h3>Belum ada berita di kategori ini 😔</h3>
                <a href="<?php echo base_url(); ?>" class="btn btn-primary">
                    Kembali ke Beranda
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

