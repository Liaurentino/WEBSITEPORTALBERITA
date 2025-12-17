<div class="dashboard-wrapper">

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="dashboard-header-top">
            <div>
                <h1>Dashboard</h1>
                <p>Kelola berita dan cerita petualangan Anda</p>
            </div>
            <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary btn-large">
                + Buat Berita Baru
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card stat-primary">
                <p>Total Berita</p>
                <h2><?php echo $stats['total_news']; ?></h2>
            </div>

            <div class="stat-card stat-secondary">
                <p>Total Likes</p>
                <h2><?php echo $stats['total_likes']; ?></h2>
            </div>

            <div class="stat-card stat-success">
                <p>Total Komentar</p>
                <h2><?php echo $stats['total_comments']; ?></h2>
            </div>
        </div>
    </div>

    <!-- News Table -->
    <div class="news-table-section">
        <div class="news-table-header">
            <h3>Daftar Berita Anda</h3>
        </div>

        <?php if (empty($user_news)): ?>
            <div class="news-empty">
                <p>Anda belum membuat berita apapun</p>
                <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary">
                    Buat Berita Pertama Anda
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th class="text-center">Likes</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_news as $news): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" class="news-title-link">
                                        <?php echo character_limiter($news['title'], 50); ?>
                                    </a>
                                </td>
                                <td class="text-muted">
                                    <?php echo date('d M Y', strtotime($news['created_at'])); ?>
                                </td>
                                <td class="text-center">
                                    <span class="likes-badge">
                                        ❤️ <?php echo $news['likes_count']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="<?php echo base_url('dashboard/edit/' . $news['id']); ?>"
                                           class="btn btn-small btn-secondary">
                                            ✏️ Edit
                                        </a>
                                        <button
                                            class="btn btn-small btn-danger"
                                            onclick="if(confirm('Yakin hapus berita ini?')) window.location='<?php echo base_url('dashboard/delete/' . $news['id']); ?>'">
                                            🗑️ Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
