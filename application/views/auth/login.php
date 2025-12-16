<div class="auth-wrapper" style="max-width: 450px; margin: 0 auto; padding: 0 20px;">
    <div class="auth-container" style="background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 2rem; margin-top: 3rem;">
        
        <!-- Auth Header -->
        <div class="auth-header" style="text-align: center; margin-bottom: 2rem;">
            <h2 style="margin: 0 0 0.5rem 0; color: var(--text-dark);">Masuk ke Akun Anda</h2>
            <p style="color: var(--text-gray); margin: 0;">Lanjutkan petualangan Anda di Adventure Today</p>
        </div>

        <!-- Login Form -->
        <form action="<?php echo base_url('auth/login'); ?>" method="POST">
            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email <span style="color: var(--danger);">*</span></label>
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="Masukkan email Anda"
                       value="<?php echo set_value('email'); ?>" 
                       required autofocus>
                <?php if (form_error('email')): ?>
                    <span class="form-error"><?php echo form_error('email'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password <span style="color: var(--danger);">*</span></label>
                <input type="password" id="password" name="password" class="form-control" 
                       placeholder="Masukkan password Anda"
                       required>
                <?php if (form_error('password')): ?>
                    <span class="form-error"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Remember Me -->
            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <input type="checkbox" id="remember" name="remember" value="1" style="width: auto;">
                <label for="remember" style="margin: 0; font-weight: 400;">Ingat saya</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-large btn-block" style="margin-bottom: 1rem;">
                Masuk
            </button>

            <!-- Divider -->
            <div style="text-align: center; margin: 1.5rem 0; position: relative;">
                <span style="background: var(--white); padding: 0 0.5rem; color: var(--text-gray); font-size: 0.9rem;">atau</span>
            </div>

            <!-- Sign Up Link -->
            <div style="text-align: center;">
                <p style="color: var(--text-gray); margin: 0;">
                    Belum punya akun? 
                    <a href="<?php echo base_url('auth/register'); ?>" style="color: var(--primary); font-weight: 600;">Daftar di sini</a>
                </p>
            </div>
        </form>

        <!-- Additional Links -->
        <div style="border-top: 1px solid var(--border-color); margin-top: 1.5rem; padding-top: 1.5rem;">
            <p style="color: var(--text-gray); font-size: 0.9rem; text-align: center; margin: 0;">
                <a href="<?php echo base_url('home'); ?>" style="color: var(--text-gray);">Kembali ke Beranda</a>
            </p>
        </div>
    </div>

    <!-- Info Card -->
    <div style="background: var(--primary-light); border-radius: var(--radius-lg); padding: 1.5rem; margin-top: 2rem; text-align: center;">
        <p style="color: var(--text-dark); margin: 0;">
            <strong>Demo Account</strong><br>
            <small style="color: var(--text-gray);">Email: demo@test.com | Password: password</small>
        </p>
    </div>
</div>

</div> <!-- End main-container -->

<style>
    @media (max-width: 768px) {
        .auth-wrapper {
            padding: 0 15px;
        }

        .auth-container {
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .form-group label {
            font-size: 0.95rem;
        }
    }
</style>