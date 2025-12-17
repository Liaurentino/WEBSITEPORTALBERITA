<div class="container main-container admin-wrapper">

    <div class="admin-header">
        <h1>Admin Panel</h1>
        <p>
            Halo,
            <strong><?php echo $this->session->userdata('username'); ?></strong>.
            Kelola website Anda di sini.
        </p>
    </div>

    <div class="admin-actions">
        <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-primary btn-admin">
            Kelola User (Ban/Unban)
        </a>
        <a href="<?php echo base_url('admin/news'); ?>" class="btn btn-outline btn-admin">
            Kelola Berita (Hapus)
        </a>
    </div>

    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <h3>Total User</h3>
            <strong><?php echo $stats['total_users']; ?></strong>
        </div>

        <div class="admin-stat-card">
            <h3>Total Berita</h3>
            <strong><?php echo $stats['total_news']; ?></strong>
        </div>
    </div>

</div>