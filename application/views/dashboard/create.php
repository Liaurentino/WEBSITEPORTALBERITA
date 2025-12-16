<div class="create-news-wrapper" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
    <div class="create-header" style="margin-bottom: 2rem;">
        <h1 style="margin: 0 0 0.5rem 0;">Buat Berita Baru</h1>
        <p style="color: var(--text-gray); margin: 0;">Bagikan cerita petualanganmu dengan komunitas</p>
    </div>

    <div class="create-form-wrapper" style="background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); padding: 2rem;">
        <form action="<?php echo base_url('dashboard/store'); ?>" method="POST" enctype="multipart/form-data">
            <!-- Title Field -->
            <div class="form-group">
                <label for="title">Judul Berita <span style="color: var(--danger);">*</span></label>
                <input type="text" id="title" name="title" class="form-control" 
                       placeholder="Masukkan judul berita yang menarik"
                       value="<?php echo set_value('title'); ?>"
                       maxlength="255" required>
                <?php if (form_error('title')): ?>
                    <span class="form-error"><?php echo form_error('title'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Featured Image -->
            <div class="form-group">
                <label for="image">Gambar Utama</label>
                <div class="image-upload-area" style="border: 2px dashed var(--border-color); border-radius: var(--radius-lg); padding: 2rem; text-align: center; transition: var(--transition); cursor: pointer;" 
                     id="imageUploadArea"
                     onmouseover="this.style.borderColor='var(--primary)'; this.style.backgroundColor='var(--primary-light)'"
                     onmouseout="this.style.borderColor='var(--border-color)'; this.style.backgroundColor='transparent'">
                    <input type="file" id="image" name="image" class="form-control" 
                           accept="image/*" style="display: none;">
                    <div id="imagePreview" style="margin-bottom: 1rem;">
                        <p style="color: var(--text-gray); margin: 0.5rem 0;">📷 Pilih gambar untuk berita Anda</p>
                        <p style="color: var(--text-light); font-size: 0.85rem; margin: 0;">JPG, PNG atau GIF (Max 5MB)</p>
                    </div>
                </div>
                <div id="imagePreviewContainer" style="margin-top: 1rem; display: none;">
                    <img id="previewImage" src="" alt="Preview" style="max-width: 100%; height: auto; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    <button type="button" class="btn btn-small btn-danger" style="margin-top: 1rem; width: 100%;" onclick="clearImage()">
                        Hapus Gambar
                    </button>
                </div>
            </div>

            <!-- Content Field -->
            <div class="form-group">
                <label for="content">Konten Berita <span style="color: var(--danger);">*</span></label>
                <textarea id="content" name="content" class="form-control" 
                          placeholder="Tulis cerita petualanganmu di sini... (minimal 50 karakter)"
                          rows="10" required><?php echo set_value('content'); ?></textarea>
                <?php if (form_error('content')): ?>
                    <span class="form-error"><?php echo form_error('content'); ?></span>
                <?php endif; ?>
                <div style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.5rem;">
                    <span id="charCount">0</span> / 10000 karakter
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary btn-large">
                    ✓ Publikasikan Berita
                </button>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="tips-section" style="background: var(--primary-light); border-radius: var(--radius-lg); padding: 1.5rem; margin-top: 2rem;">
        <h4 style="margin: 0 0 1rem 0; color: var(--primary);">💡 Tips Membuat Berita yang Bagus</h4>
        <ul style="margin: 0; padding-left: 1.5rem; color: var(--text-gray);">
            <li>Gunakan judul yang menarik dan deskriptif</li>
            <li>Pilih gambar yang berkualitas tinggi dan relevan</li>
            <li>Tulis konten yang informatif dan mudah dipahami</li>
            <li>Gunakan paragraph yang singkat untuk readability</li>
            <li>Ceritakan pengalaman pribadi Anda secara detail</li>
        </ul>
    </div>
</div>

</div> <!-- End main-container -->

<script>
// Image upload functionality
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

// Character counter for content
const contentField = document.getElementById('content');
const charCount = document.getElementById('charCount');

contentField.addEventListener('input', () => {
    charCount.textContent = contentField.value.length;
});

// Initialize counter
charCount.textContent = contentField.value.length;
</script>