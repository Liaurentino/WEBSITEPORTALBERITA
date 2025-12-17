<div class="profile-wrapper">

    <div class="profile-header">
        <div class="profile-header-text">
            <h1>Profil Saya</h1>
            <p>Kelola informasi akun dan biodata penulis Anda</p>
        </div>
        <div class="profile-avatar">
            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
        </div>
    </div>

    <div class="profile-form-wrapper">
        <form action="<?php echo base_url('dashboard/update_profile'); ?>" method="POST">

            <h3 class="profile-section-title">Informasi Dasar</h3>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text"
                       id="username"
                       name="username"
                       class="form-control"
                       value="<?php echo set_value('username', $user['username']); ?>"
                       required>
                <?php echo form_error('username', '<small class="form-error">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       value="<?php echo set_value('email', $user['email']); ?>"
                       required>
                <?php echo form_error('email', '<small class="form-error">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="bio">Tentang Penulis (Bio)</label>
                <textarea id="bio"
                          name="bio"
                          class="form-control"
                          rows="4"
                          placeholder="Ceritakan sedikit tentang diri Anda..."><?php echo set_value('bio', isset($user['bio']) ? $user['bio'] : ''); ?></textarea>
                <small class="form-hint">
                    Bio ini akan ditampilkan di halaman detail berita.
                </small>
            </div>

            <h3 class="profile-section-title">Ganti Password</h3>

            <div class="profile-password-box">
                <small class="password-info">
                    Kosongkan bagian ini jika tidak ingin mengubah password.
                </small>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control"
                           placeholder="Biarkan kosong jika tidak diubah">
                    <?php echo form_error('password', '<small class="form-error">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="conf_password">Konfirmasi Password Baru</label>
                    <input type="password"
                           id="conf_password"
                           name="conf_password"
                           class="form-control"
                           placeholder="Ulangi password baru">
                    <?php echo form_error('conf_password', '<small class="form-error">', '</small>'); ?>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-large">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
