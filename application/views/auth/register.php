<div class="auth-wrapper" style="max-width: 450px; margin: 0 auto; padding: 0 20px;">
    <div class="auth-container" style="background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 2rem; margin-top: 3rem;">
        
        <div class="auth-header" style="text-align: center; margin-bottom: 2rem;">
            <h2 style="margin: 0 0 0.5rem 0; color: var(--text-dark);">Buat Akun Baru</h2>
            <p style="color: var(--text-gray); margin: 0;">Bergabunglah dengan komunitas Adventure Today</p>
        </div>

        <form action="<?php echo base_url('auth/register'); ?>" method="POST">
            
            <div class="form-group">
                <label for="username">Username <span style="color: var(--danger);">*</span></label>
                <input type="text" id="username" name="username" class="form-control" 
                       placeholder="Pilih username unik"
                       value="<?php echo set_value('username'); ?>" 
                       required autofocus>
                <?php if (form_error('username')): ?>
                    <span class="form-error" style="color: var(--danger); font-size: 0.85rem; display: block; margin-top: 5px;"><?php echo form_error('username'); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email <span style="color: var(--danger);">*</span></label>
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="Masukkan email aktif"
                       value="<?php echo set_value('email'); ?>" 
                       required>
                <?php if (form_error('email')): ?>
                    <span class="form-error" style="color: var(--danger); font-size: 0.85rem; display: block; margin-top: 5px;"><?php echo form_error('email'); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password <span style="color: var(--danger);">*</span></label>
                <input type="password" id="password" name="password" class="form-control" 
                       placeholder="Minimal 6 karakter"
                       required>
                <?php if (form_error('password')): ?>
                    <span class="form-error" style="color: var(--danger); font-size: 0.85rem; display: block; margin-top: 5px;"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password_confirm">Konfirmasi Password <span style="color: var(--danger);">*</span></label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" 
                       placeholder="Ulangi password di atas"
                       required>
                <?php if (form_error('password_confirm')): ?>
                    <span class="form-error" style="color: var(--danger); font-size: 0.85rem; display: block; margin-top: 5px;"><?php echo form_error('password_confirm'); ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary btn-large btn-block" style="margin-top: 1rem; margin-bottom: 1rem; width: 100%; padding: 12px; background: #FF6B35; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
                Daftar Sekarang
            </button>

            <div style="text-align: center; margin: 1.5rem 0; position: relative;">
                <span style="background: var(--white); padding: 0 0.5rem; color: var(--text-gray); font-size: 0.9rem;">atau</span>
            </div>

            <div style="text-align: center;">
                <p style="color: var(--text-gray); margin: 0;">
                    Sudah punya akun? 
                    <a href="<?php echo base_url('auth/login'); ?>" style="color: var(--primary); font-weight: 600;">Login di sini</a>
                </p>
            </div>
        </form>

        <div style="border-top: 1px solid var(--border-color); margin-top: 1.5rem; padding-top: 1.5rem;">
            <p style="color: var(--text-gray); font-size: 0.9rem; text-align: center; margin: 0;">
                <a href="<?php echo base_url('home'); ?>" style="color: var(--text-gray);">Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>

<style>
    .form-group { margin-bottom: 15px; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    @media (max-width: 768px) {
        .auth-wrapper { padding: 0 15px; }
        .auth-container { padding: 1.5rem; margin-top: 1.5rem; }
    }
</style>