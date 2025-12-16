<div class="create-news-wrapper" style="max-width: 800px; margin: 0 auto; padding: 2rem 20px;">
    
    <div class="create-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0 0 0.5rem 0;">Profil Saya</h1>
            <p style="color: var(--text-gray); margin: 0;">Kelola informasi akun dan biodata penulis Anda</p>
        </div>
        <div style="width: 60px; height: 60px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;">
            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
        </div>
    </div>

    <div class="create-form-wrapper" style="background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); padding: 2rem;">
        
        <form action="<?php echo base_url('dashboard/update_profile'); ?>" method="POST">
            
            <h3 style="margin-top: 0; color: var(--primary); border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 1.5rem;">📝 Informasi Dasar</h3>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" 
                       value="<?php echo set_value('username', $user['username']); ?>" required>
                <?php echo form_error('username', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?php echo set_value('email', $user['email']); ?>" required>
                <?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="bio">Tentang Penulis (Bio)</label>
                <textarea id="bio" name="bio" class="form-control" rows="4" 
                          placeholder="Ceritakan sedikit tentang diri Anda... (Akan muncul di halaman detail berita)"><?php echo set_value('bio', isset($user['bio']) ? $user['bio'] : ''); ?></textarea>
                <small style="color: #888;">Bio ini akan membantu pembaca mengenal Anda lebih dekat.</small>
            </div>

            <h3 style="margin-top: 2rem; color: var(--primary); border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 1.5rem;">🔒 Ganti Password</h3>
            <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 1.5rem;">
                <small style="display: block; margin-bottom: 1rem; color: #666;">ℹ️ Kosongkan bagian ini jika tidak ingin mengubah password.</small>
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Biarkan kosong jika tetap">
                    <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="conf_password">Konfirmasi Password Baru</label>
                    <input type="password" id="conf_password" name="conf_password" class="form-control" placeholder="Ulangi password baru">
                    <?php echo form_error('conf_password', '<small class="text-danger">', '</small>'); ?>
                </div>
            </div>

            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline">Kembali</a>
                <button type="submit" class="btn btn-primary btn-large">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>