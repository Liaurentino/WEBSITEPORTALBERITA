<div class="edit-news-wrapper" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
    <div class="edit-header" style="margin-bottom: 2rem;">
        <h1 style="margin: 0 0 0.5rem 0;">Edit Berita</h1>
        <p style="color: var(--text-gray); margin: 0;">Update cerita petualangan Anda</p>
    </div>

    <div class="edit-form-wrapper" style="background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); padding: 2rem;">
        <form action="<?php echo base_url('dashboard/update/' . $news['id']); ?>" method="POST" enctype="multipart/form-data">
            <!-- Title Field -->
            <div class="form-group">
                <label for="title">Judul Berita <span style="color: var(--danger);">*</span></label>
                <input type="text" id="title" name="title" class="form-control" 
                       placeholder="Masukkan judul berita"
                       value="<?php echo set_value('title', htmlspecialchars($news['title'])); ?>"
                       maxlength="255" required>
                <?php if (form_error('title')): ?>
                    <span class="form-error"><?php echo form_error('title'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Featured Image -->
            <div class="form-group">
                <label for="image">Gambar Utama</label>
                
                <!-- Current Image -->
                <?php if ($news['image']): ?>
                    <div style="margin-bottom: 1rem;">
                        <p style="color: var(--text-gray); font-weight: 600; margin: 0 0 0.5rem 0;">Gambar Saat Ini:</p>
                        <img src="<?php echo base_url('assets/uploads/' . $news['image']); ?>" alt="Current Image" 
                             style="max-width: 300px; height: auto; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    </div>
                <?php endif; ?>

                <!-- Upload New Image -->
                <div class="image-upload-area" style="border: 2px dashed var(--border-color); border-radius: var(--radius-lg); padding: 2rem; text-align: center; transition: var(--transition); cursor: pointer;" 
                     id="imageUploadArea"
                     onmouseover="this.style.borderColor='var(--primary)'; this.style.backgroundColor='var(--primary-light)'"
                     onmouseout="this.style.borderColor='var(--border-color)'; this.style.backgroundColor='transparent'">
                    <input type="file" id="image" name="image" class="form-control" 
                           accept="image/*" style="display: none;">
                    <div id="imagePreview">
                        <p style="color: var(--text-gray); margin: 0.5rem 0;">📷 Ganti gambar berita (opsional)</p>
                        <p style="color: var(--text-light); font-size: 0.85rem; margin: 0;">JPG, PNG atau GIF (Max 5MB)</p>
                    </div>
                </div>
                <div id="imagePreviewContainer" style="margin-top: 1rem; display: none;">
                    <p style="color: var(--text-gray); font-weight: 600; margin: 0 0 0.5rem 0;">Preview Gambar Baru:</p>
                    <img id="previewImage" src="" alt="Preview" style="max-width: 300px; height: auto; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    <button type="button" class="btn btn-small btn-danger" style="margin-top: 1rem; width: 100%;" onclick="clearImage()">
                        Batal Ganti Gambar
                    </button>
                </div>
            </div>

            <!-- Content Field -->
            <div class="form-group">
                <label for="content">Konten Berita <span style="color: var(--danger);">*</span></label>
                <textarea id="content" name="content" class="form-control" 
                          placeholder="Edit cerita petualanganmu..."
                          rows="10" required><?php echo set_value('content', htmlspecialchars($news['content'])); ?></textarea>
                <?php if (form_error('content')): ?>
                    <span class="form-error"><?php echo form_error('content'); ?></span>
                <?php endif; ?>
                <div style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.5rem;">
                    <span id="charCount">0</span> / 10000 karakter
                </div>
            </div>

            <!-- Meta Information -->
            <div style="background: var(--bg-light); padding: 1rem; border-radius: var(--radius); margin-bottom: 1.5rem;">
                <p style="margin: 0 0 0.5rem 0; color: var(--text-gray); font-size: 0.9rem;">
                    <strong>Slug:</strong> <?php echo htmlspecialchars($news['slug']); ?>
                </p>
                <p style="margin: 0 0 0.5rem 0; color: var(--text-gray); font-size: 0.9rem;">
                    <strong>Dibuat:</strong> <?php echo date('d F Y H:i', strtotime($news['created_at'])); ?>
                </p>
                <p style="margin: 0; color: var(--text-gray); font-size: 0.9rem;">
                    <strong>Terakhir diubah:</strong> <?php echo date('d F Y H:i', strtotime($news['updated_at'])); ?>
                </p>
            </div>

            <!-- Form Actions -->
            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline">Batal</a>
                <a href="<?php echo base_url('home/detail/' . $news['slug']); ?>" class="btn btn-secondary" target="_blank">
                    👁️ Lihat Berita
                </a>
                <button type="submit" class="btn btn-primary btn-large">
                    ✓ Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div style="background: #FFF3CD; border: 2px solid var(--danger); border-radius: var(--radius-lg); padding: 1.5rem; margin-top: 2rem;">
        <h4 style="margin: 0 0 1rem 0; color: var(--danger);">⚠️ Zona Berbahaya</h4>
        <p style="color: var(--text-gray); margin: 0 0 1rem 0;">
            Menghapus berita tidak dapat dibatalkan. Pastikan Anda benar-benar ingin menghapus berita ini.
        </p>
        <button type="button" class="btn btn-danger" onclick="if(confirm('Yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.')) window.location='<?php echo base_url('dashboard/delete/' . $news['id']); ?>'">
            🗑️ Hapus Berita Ini
        </button>
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