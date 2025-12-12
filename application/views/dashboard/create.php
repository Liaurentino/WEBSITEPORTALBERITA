<h2>Tulis Berita Baru</h2>

<?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

<?= form_open_multipart('dashboard/create'); ?>
    <div class="mb-3">
        <label class="form-label">Judul Berita</label>
        <input type="text" class="form-control" name="title" placeholder="Judul menarik...">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Upload Gambar (Sampul)</label>
        <input type="file" class="form-control" name="image" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Isi Berita</label>
        <textarea class="form-control" name="content" rows="10" placeholder="Tulis cerita petualanganmu..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Publish Berita</button>
    <a href="<?= base_url('dashboard'); ?>" class="btn btn-secondary">Batal</a>
</form>