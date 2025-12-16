<div class="container main-container" style="padding-top: 2rem;">
    <div class="admin-header" style="margin-bottom: 2rem;">
        <h1 style="color: var(--primary);">🛡️ Admin Panel</h1>
        <p>Halo, <strong><?php echo $this->session->userdata('username'); ?></strong>. Kelola website Anda di sini.</p>
    </div>

    <div class="admin-actions" style="display: flex; gap: 1rem; margin-bottom: 2rem;">
        <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-primary" style="padding: 1rem 2rem;">👥 Kelola User (Ban/Unban)</a>
        <a href="<?php echo base_url('admin/news'); ?>" class="btn btn-outline" style="padding: 1rem 2rem;">📰 Kelola Berita (Hapus)</a>
    </div>

    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0; color: #666;">Total User</h3>
            <strong style="font-size: 2.5rem; color: var(--primary);"><?php echo $stats['total_users']; ?></strong>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0; color: #666;">Total Berita</h3>
            <strong style="font-size: 2.5rem; color: var(--primary);"><?php echo $stats['total_news']; ?></strong>
        </div>
    </div>
</div>