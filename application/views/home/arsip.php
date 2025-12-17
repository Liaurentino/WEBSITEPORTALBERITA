<div class="container main-container">
    
    <header class="archive-header">
        <h1 class="archive-title">
            <?php echo isset($page_title) ? $page_title : 'Semua Berita'; ?>
        </h1>
        <p class="archive-subtitle">
        Menampilkan seluruh koleksi cerita petualangan dari komunitas.
        </p>
    </header>

    <div class="news-grid">
        
        <?php if (!empty($news_list)): ?>
            <?php foreach ($news_list as $news): ?>
                <article class="card">
                    <div class="card-image">
                        <?php 
                            $img_url = !empty($news['image']) 
                                ? base_url('assets/uploads/' . $news['image']) 
                                : 'https://via.placeholder.com/400x300?text=No+Image';
                        ?>
                        <img src="<?php echo $img_url; ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                        
                        <span class="card-category">
                            <?php echo ($this->uri->segment(2) == 'trending') ? '🔥 Trending' : '📰 Berita'; ?>
                        </span>
                    </div>
                    
                    <div class="card-content">
                        <div class="card-meta">
                            📅 <?php echo date('d M Y', strtotime($news['created_at'])); ?> • 
                            👤 <?php echo htmlspecialchars($news['username']); ?>
                        </div>
                        
                        <h3>
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>">
                                <?php echo htmlspecialchars($news['title']); ?>
                            </a>
                        </h3>
                        
                        <p><?php echo character_limiter(strip_tags($news['content']), 100); ?></p>
                        
                        <div class="card-footer">
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" class="read-more">Baca Selengkapnya</a>
                            <span class="likes-count">❤️ <?php echo $news['likes_count']; ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="empty-state">
                <h3>Belum ada berita saat ini.</h3>
                <p>Jadilah yang pertama menulis cerita petualangan!</p>
                <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary">
                    Mulai Menulis
                </a>
            </div>
        <?php endif; ?>

    </div>

    <div class="page-footer-nav">
        <a href="<?php echo base_url(); ?>" class="btn btn-outline">
            ← Kembali ke Halaman Depan
        </a>
    </div>

</div>