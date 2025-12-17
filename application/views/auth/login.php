<div class="auth-wrapper">
    <div class="auth-container">

        <!-- Auth Header -->
        <div class="auth-header">
            <h2>Masuk ke Akun Anda</h2>
            <p>Lanjutkan petualangan Anda di Adventure Today</p>
        </div>

        <!-- Login Form -->
        <form action="<?php echo base_url('auth/login'); ?>" method="POST">

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">
                    Email <span class="required">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="Masukkan email Anda"
                    value="<?php echo set_value('email'); ?>"
                    required
                    autofocus
                >
                <?php if (form_error('email')): ?>
                    <span class="form-error"><?php echo form_error('email'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">
                    Password <span class="required">*</span>
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password Anda"
                    required
                >
                <?php if (form_error('password')): ?>
                    <span class="form-error"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Remember Me -->
            <div class="form-group remember-group">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Ingat saya</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-large btn-block auth-submit">
                Masuk
            </button>

            <!-- Divider -->
            <div class="auth-divider">
                <span>atau</span>
            </div>

            <!-- Sign Up Link -->
            <div class="auth-link">
                <p>
                    Belum punya akun?
                    <a href="<?php echo base_url('auth/register'); ?>">Daftar di sini</a>
                </p>
            </div>
        </form>

        <!-- Additional Links -->
        <div class="auth-footer">
            <p>
                <a href="<?php echo base_url('home'); ?>">Kembali ke Beranda</a>
            </p>
        </div>
    </div>

</div> <!-- End main-container -->
