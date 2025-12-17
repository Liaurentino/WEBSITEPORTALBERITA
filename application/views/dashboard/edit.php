<div class="edit-news-wrapper">

    <!-- Header -->
    <div class="edit-header">
        <h1>Edit Berita</h1>
        <p class="text-muted">Update cerita petualangan Anda</p>
    </div>

    <!-- Form Wrapper -->
    <div class="edit-form-wrapper">
        <form action="<?php echo base_url('dashboard/update/' . $news['id']); ?>" 
              method="POST" 
              enctype="multipart/form-data">

            <!-- Title -->
            <div class="form-group">
                <label for="title">Judul Berita <span class="required">*</span></label>
                <input type="text"
                       id="title"
                       name="title"
                       class="form-control"
                       placeholder="Masukkan judul berita"
                       value="<?php echo set_value('title', htmlspecialchars($news['title'])); ?>"
                       maxlength="255"
                       required>

                <?php if (form_error('title')): ?>
                    <span class="form-error"><?php echo form_error('title'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label for="image">Gambar Utama</label>

                <?php if ($news['image']): ?>
                    <div class="current-image">
                        <p class="image-label">Gambar Saat Ini</p>
                        <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>" 
                             alt="Current Image">
                    </div>
                <?php endif; ?>

                <div class="image-upload-area" id="imageUploadArea">
                    <input type="file"
                           id="image"
                           name="image"
                           class="form-control"
                           accept="image/*"
                           hidden>

                    <div id="imagePreview">
                        <p class="upload-text">Ganti gambar berita</p>
                        <p class="upload-hint">JPG, PNG, GIF. Maksimal 5MB</p>
                    </div>
                </div>

                <div id="imagePreviewContainer" class="image-preview-container">
                    <p class="image-label">Preview Gambar Baru</p>
                    <img id="previewImage" alt="Preview">
                    <button type="button"
                            class="btn btn-small btn-danger"
                            onclick="clearImage()">
                        Batal Ganti Gambar
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content">Konten Berita <span class="required">*</span></label>
                <textarea id="content"
                          name="content"
                          class="form-control"
                          rows="10"
                          placeholder="Edit cerita petualangan Anda"
                          required><?php echo set_value('content', htmlspecialchars($news['content'])); ?></textarea>

                <?php if (form_error('content')): ?>
                    <span class="form-error"><?php echo form_error('content'); ?></span>
                <?php endif; ?>

                <div class="char-counter">
                    <span id="charCount">0</span> / 10000 karakter
                </div>
            </div>

            <!-- Meta Info -->
            <div class="edit-meta-box">
                <p><strong>Slug:</strong> <?php echo htmlspecialchars($news['slug']); ?></p>
                <p><strong>Dibuat:</strong> <?php echo date('d F Y H:i', strtotime($news['created_at'])); ?></p>
                <p><strong>Terakhir diubah:</strong> <?php echo date('d F Y H:i', strtotime($news['updated_at'])); ?></p>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline">
                    Batal
                </a>

                <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" 
                   class="btn btn-secondary" 
                   target="_blank">
                    Lihat Berita
                </a>

                <button type="submit" class="btn btn-primary btn-large">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="danger-zone">
        <h4>Menghapus Berita</h4>
        <p>Berita Akan Hilang Secara Permanen. Pastikan keputusan Anda.</p>
        <button type="button"
                class="btn btn-danger"
                onclick="if(confirm('Yakin ingin menghapus berita ini?')) 
                window.location='<?php echo base_url('dashboard/delete/' . $news['id']); ?>'">
            Hapus Berita
        </button>
    </div>

</div>

<script>
const imageUploadArea = document.getElementById('imageUploadArea');
const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('imagePreview');
const imagePreviewContainer = document.getElementById('imagePreviewContainer');
const previewImage = document.getElementById('previewImage');
const contentField = document.getElementById('content');
const charCount = document.getElementById('charCount');

imageUploadArea.addEventListener('click', () => imageInput.click());

imageInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = ev => {
        previewImage.src = ev.target.result;
        imagePreview.style.display = 'none';
        imagePreviewContainer.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

function clearImage() {
    imageInput.value = '';
    imagePreview.style.display = 'block';
    imagePreviewContainer.style.display = 'none';
}

charCount.textContent = contentField.value.length;
contentField.addEventListener('input', () => {
    charCount.textContent = contentField.value.length;
});
</script>