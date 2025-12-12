<h2>Dashboard Saya</h2>
<a href="<?= base_url('dashboard/create'); ?>" class="btn btn-success mb-3">+ Tulis Berita Baru</a>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $post) : ?>
                <tr>
                    <td><?= $post['title']; ?></td>
                    <td><?= date('d/m/Y', strtotime($post['created_at'])); ?></td>
                    <td>
                        <img src="<?= base_url('assets/uploads/'.$post['image']); ?>" width="50">
                    </td>
                    <td>
                        <!-- Edit Button (Bisa dikembangkan nanti) -->
                        <a href="#" class="btn btn-warning btn-sm text-white">Edit</a>
                        <a href="<?= base_url('dashboard/delete/'.$post['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>