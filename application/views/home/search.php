<!-- SEARCH RESULTS SECTION -->
<section class="section">
    <div class="search-header">
        <h2 class="search-title">
            Hasil Pencarian: "<?php echo htmlspecialchars($keyword); ?>"
        </h2>

        <?php if (empty($search_results)): ?>
            <div class="no-results">
                <h3 class="no-results-title">Tidak ada hasil</h3>
                <p class="no-results-text">
                    Kami tidak menemukan berita yang sesuai dengan pencarian "<?php echo htmlspecialchars($keyword); ?>"
                </p>
                <a href="<?php echo base_url('home'); ?>" class="btn btn-primary">
                    Kembali ke Beranda
                </a>
            </div>
        <?php else: ?>
            <p class="search-count">
                Ditemukan <?php echo count($search_results); ?> hasil pencarian
            </p>
        <?php endif; ?>
    </div>

    <?php if (!empty($search_results)): ?>
        <div class="news-grid">
            <?php foreach ($search_results as $news): ?>
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>"
                             alt="<?php echo htmlspecialchars($news['title']); ?>">
                        <span class="card-category">Hasil Pencarian</span>
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
                            <?php echo character_limiter(strip_tags($news['content']), 120); ?>
                        </p>

                        <div class="card-footer">
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>"
                               class="read-more">
                                Baca Selengkapnya
                            </a>
                            <span class="likes-count">
                                ❤️ <?php echo $news['likes_count']; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

</div>
