<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">Login</h3>
                <?= form_open('auth/login'); ?>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                <?= form_close(); ?>
                <p class="mt-3 text-center">Belum punya akun? <a href="<?= base_url('auth/register'); ?>">Daftar disini</a></p>
            </div>
        </div>
    </div>
</div>