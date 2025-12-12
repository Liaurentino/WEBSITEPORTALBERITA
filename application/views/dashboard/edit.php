<main class="container">
    <section class="dashboard">
        <h2>Edit Berita</h2>

        <form action="<?php echo base_url('dashboard/update/' . $news->id); ?>" method="POST" enctype="multipart/form-data" class="form-create">
            <div class="form-group">
                <label for="title">Judul Berita</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo $news->title; ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Gambar</label>
                <?php if ($news->image): ?>
                    <div class="current-image">
                        <img src="<?php echo base_url('assets/uploads/' . $news->image); ?>" alt="Current image" style="max-width: 200px;">
                        <p>Gambar saat ini</p>
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small>Kosongkan jika tidak ingin mengubah gambar</small>
            </div>

            <div class="form-group">
                <label for="content">Isi Berita</label>
                <textarea id="content" name="content" class="form-control editor" rows="10" required><?php echo $news->content; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </section>
</main>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '.editor',
    height: 400,
    plugins: 'lists link image code',
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image',
    menubar: false
});
</script>