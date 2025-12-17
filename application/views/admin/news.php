<div class="container main-container admin-wrapper">

    <div class="admin-page-header">
        <h1>Kelola Berita</h1>
        <a href="<?php echo base_url('admin'); ?>" class="btn btn-outline">
            &larr; Dashboard
        </a>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Judul Berita</th>
                    <th>Penulis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news_list as $news): ?>
                    <tr>
                        <td>
                            <?php echo date('d/m/Y', strtotime($news['created_at'])); ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" target="_blank">
                                <?php echo htmlspecialchars($news['title']); ?>
                            </a>
                        </td>
                        <td>
                            👤 <?php echo htmlspecialchars($news['username']); ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url('admin/delete_news/' . $news['id']); ?>"
                               class="btn btn-small btn-danger"
                               onclick="return confirm('Hapus permanen berita ini?');">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>