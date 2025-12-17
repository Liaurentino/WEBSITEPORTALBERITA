<div class="auth-wrapper">
    <div class="auth-container">

        <div class="auth-header">
            <h2>Buat Akun Baru</h2>
            <p>Bergabunglah dengan komunitas Adventure Today</p>
        </div>

        <form action="<?php echo base_url('auth/register'); ?>" method="POST">

            <div class="form-group">
                <label for="username">
                    Username <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    placeholder="Pilih username unik"
                    value="<?php echo set_value('username'); ?>"
                    required
                    autofocus
                >
                <?php if (form_error('username')): ?>
                    <span class="form-error"><?php echo form_error('username'); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">
                    Email <span class="required">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="Masukkan email aktif"
                    value="<?php echo set_value('email'); ?>"
                    required
                >
                <?php if (form_error('email')): ?>
                    <span class="form-error"><?php echo form_error('email'); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">
                    Password <span class="required">*</span>
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Minimal 6 karakter"
                    required
                >
                <?php if (form_error('password')): ?>
                    <span class="form-error"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password_confirm">
                    Konfirmasi Password <span class="required">*</span>
                </label>
                <input
                    type="password"
                    id="password_confirm"
                    name="password_confirm"
                    class="form-control"
                    placeholder="Ulangi password di atas"
                    required
                >
                <?php if (form_error('password_confirm')): ?>
                    <span class="form-error"><?php echo form_error('password_confirm'); ?></span>
                <?php endif; ?>
            </div>

            <button
                type="submit"
                class="btn btn-primary btn-large btn-block auth-submit"
            >
                Daftar Sekarang
            </button>

            <div class="auth-divider">
                <span>atau</span>
            </div>

            <div class="auth-link">
                <p>
                    Sudah punya akun?
                    <a href="<?php echo base_url('auth/login'); ?>">Login di sini</a>
                </p>
            </div>
        </form>

        <div class="auth-footer">
            <p>
                <a href="<?php echo base_url('home'); ?>">Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>
