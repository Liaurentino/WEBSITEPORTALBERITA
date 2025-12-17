<div class="create-news-wrapper">

    <div class="create-header">
        <h1>Buat Berita Baru</h1>
        <p>Bagikan cerita petualanganmu dengan komunitas</p>
    </div>

    <div class="create-form-wrapper">
        <form action="<?php echo base_url('dashboard/store'); ?>" method="POST" enctype="multipart/form-data">

            <!-- Title Field -->
            <div class="form-group">
                <label for="title">
                    Judul Berita <span class="required">*</span>
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       class="form-control"
                       placeholder="Masukkan judul berita yang menarik"
                       value="<?php echo set_value('title'); ?>"
                       maxlength="255"
                       required>
                <?php if (form_error('title')): ?>
                    <span class="form-error"><?php echo form_error('title'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Featured Image -->
            <div class="form-group">
                <label for="image">Gambar Utama</label>

                <div class="image-upload-area" id="imageUploadArea">
                    <input type="file"
                           id="image"
                           name="image"
                           class="form-control"
                           accept="image/*">

                    <div class="image-preview" id="imagePreview">
                        <p>📷 Pilih gambar untuk berita Anda</p>
                        <p class="image-hint">JPG, PNG atau GIF. Maksimal 5MB</p>
                    </div>
                </div>

                <div class="image-preview-container" id="imagePreviewContainer">
                    <img id="previewImage" src="" alt="Preview">
                    <button type="button"
                            class="btn btn-small btn-danger btn-full"
                            onclick="clearImage()">
                        Hapus Gambar
                    </button>
                </div>
            </div>

            <!-- Content Field -->
            <div class="form-group">
                <label for="content">
                    Konten Berita <span class="required">*</span>
                </label>
                <textarea id="content"
                          name="content"
                          class="form-control"
                          placeholder="Tulis cerita petualanganmu di sini... (minimal 50 karakter)"
                          rows="10"
                          required><?php echo set_value('content'); ?></textarea>
                <?php if (form_error('content')): ?>
                    <span class="form-error"><?php echo form_error('content'); ?></span>
                <?php endif; ?>

                <div class="char-counter">
                    <span id="charCount">0</span> / 10000 karakter
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary btn-large">
                    ✓ Publikasikan Berita
                </button>
            </div>

        </form>
    </div>

</div>

<script>
const imageUploadArea = document.getElementById('imageUploadArea');
const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('imagePreview');
const imagePreviewContainer = document.getElementById('imagePreviewContainer');
const previewImage = document.getElementById('previewImage');

imageUploadArea.addEventListener('click', () => imageInput.click());

imageInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (event) => {
            previewImage.src = event.target.result;
            imagePreview.style.display = 'none';
            imagePreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

function clearImage() {
    imageInput.value = '';
    imagePreview.style.display = 'block';
    imagePreviewContainer.style.display = 'none';
}

const contentField = document.getElementById('content');
const charCount = document.getElementById('charCount');

contentField.addEventListener('input', () => {
    charCount.textContent = contentField.value.length;
});

charCount.textContent = contentField.value.length;
</script>