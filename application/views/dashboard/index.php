<div class="dashboard-wrapper" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Dashboard Header -->
    <div class="dashboard-header" style="margin-bottom: 3rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="margin: 0 0 0.5rem 0;">Dashboard</h1>
                <p style="color: var(--text-gray); margin: 0;">Kelola berita dan cerita petualangan Anda</p>
            </div>
            <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary btn-large">+ Buat Berita Baru</a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="stat-card" style="background: var(--white); padding: 1.5rem; border-radius: var(--radius-lg); border-left: 4px solid var(--primary); box-shadow: var(--shadow-sm);">
                <p style="color: var(--text-gray); margin: 0 0 0.5rem 0;">Total Berita</p>
                <h2 style="margin: 0; color: var(--primary); font-size: 2.5rem;"><?php echo $stats['total_news']; ?></h2>
            </div>
            <div class="stat-card" style="background: var(--white); padding: 1.5rem; border-radius: var(--radius-lg); border-left: 4px solid var(--secondary); box-shadow: var(--shadow-sm);">
                <p style="color: var(--text-gray); margin: 0 0 0.5rem 0;">Total Likes</p>
                <h2 style="margin: 0; color: var(--secondary); font-size: 2.5rem;">❤️ <?php echo $stats['total_likes']; ?></h2>
            </div>
            <div class="stat-card" style="background: var(--white); padding: 1.5rem; border-radius: var(--radius-lg); border-left: 4px solid var(--success); box-shadow: var(--shadow-sm);">
                <p style="color: var(--text-gray); margin: 0 0 0.5rem 0;">Total Komentar</p>
                <h2 style="margin: 0; color: var(--success); font-size: 2.5rem;">💬 <?php echo $stats['total_comments']; ?></h2>
            </div>
        </div>
    </div>

    <!-- News Table -->
    <div class="news-table-section" style="background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
            <h3 style="margin: 0;">Daftar Berita Anda</h3>
        </div>

        <?php if (empty($user_news)): ?>
            <div style="padding: 3rem; text-align: center;">
                <p style="color: var(--text-gray); font-size: 1.1rem; margin-bottom: 1.5rem;">Anda belum membuat berita apapun</p>
                <a href="<?php echo base_url('dashboard/create'); ?>" class="btn btn-primary">Buat Berita Pertama Anda</a>
            </div>
        <?php else: ?>
            <div class="table-responsive" style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: var(--bg-light);">
                        <tr>
                            <th style="padding: 1rem; text-align: left; border-bottom: 1px solid var(--border-color); font-weight: 600;">Judul</th>
                            <th style="padding: 1rem; text-align: left; border-bottom: 1px solid var(--border-color); font-weight: 600;">Tanggal</th>
                            <th style="padding: 1rem; text-align: center; border-bottom: 1px solid var(--border-color); font-weight: 600;">Likes</th>
                            <th style="padding: 1rem; text-align: center; border-bottom: 1px solid var(--border-color); font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_news as $news): ?>
                            <tr style="border-bottom: 1px solid var(--border-color); transition: var(--transition);" onmouseover="this.style.backgroundColor='var(--bg-light)'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 1rem;">
                                    <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" style="color: var(--text-dark); font-weight: 600; text-decoration: none;">
                                        <?php echo character_limiter($news['title'], 50); ?>
                                    </a>
                                </td>
                                <td style="padding: 1rem; color: var(--text-gray);">
                                    <?php echo date('d M Y', strtotime($news['created_at'])); ?>
                                </td>
                                <td style="padding: 1rem; text-align: center; color: var(--text-gray);">
                                    <span style="background: var(--bg-light); padding: 0.4rem 0.8rem; border-radius: var(--radius); display: inline-block;">
                                        ❤️ <?php echo $news['likes_count']; ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?php echo base_url('dashboard/edit/' . $news['id']); ?>" class="btn btn-small" style="background: var(--secondary); color: white; border: none;">
                                            ✏️ Edit
                                        </a>
                                        <button class="btn btn-small btn-danger" onclick="if(confirm('Yakin hapus berita ini?')) window.location='<?php echo base_url('dashboard/delete/' . $news['id']); ?>'">
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

</div> <!-- End main-container -->

<style>
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr !important;
        }

        .table-responsive {
            overflow-x: scroll;
        }

        .dashboard-header {
            flex-direction: column;
        }

        .dashboard-header > div {
            flex-direction: column !important;
            align-items: flex-start !important;
        }

        table {
            font-size: 0.9rem;
        }

        th, td {
            padding: 0.75rem !important;
        }
    }
</style>