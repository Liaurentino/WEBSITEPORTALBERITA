<div class="container main-container" style="padding-top: 2rem;">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <h1>📰 Kelola Berita</h1>
        <a href="<?php echo base_url('admin'); ?>" class="btn btn-outline">&larr; Dashboard</a>
    </div>

    <div style="overflow-x: auto; background: white; border-radius: 10px; padding: 1rem; box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                    <th style="padding: 1rem; text-align: left;">Tanggal</th>
                    <th style="padding: 1rem; text-align: left;">Judul Berita</th>
                    <th style="padding: 1rem; text-align: left;">Penulis</th>
                    <th style="padding: 1rem; text-align: left;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news_list as $news): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem;"><?php echo date('d/m/Y', strtotime($news['created_at'])); ?></td>
                        <td style="padding: 1rem;">
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" target="_blank">
                                <?php echo htmlspecialchars($news['title']); ?>
                            </a>
                        </td>
                        <td style="padding: 1rem;">👤 <?php echo htmlspecialchars($news['username']); ?></td>
                        <td style="padding: 1rem;">
                            <a href="<?php echo base_url('admin/delete_news/' . $news['id']); ?>" 
                               class="btn btn-small btn-danger"
                               onclick="return confirm('Hapus permanen berita ini?');">🗑️ Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>