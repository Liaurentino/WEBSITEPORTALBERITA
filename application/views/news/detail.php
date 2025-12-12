<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $news['title']; ?></li>
            </ol>
        </nav>

        <h1 class="mb-3"><?= $news['title']; ?></h1>
        <div class="mb-3 text-muted">
            <span>Oleh: <strong><?= $news['username']; ?></strong></span> | 
            <span><?= date('d M Y', strtotime($news['created_at'])); ?></span>
        </div>

        <img src="<?= base_url('assets/uploads/'.$news['image']); ?>" class="img-fluid rounded mb-4 w-100" alt="<?= $news['title']; ?>">

        <div class="article-content" style="font-size: 1.1rem; line-height: 1.8;">
            <?= nl2br($news['content']); ?>
        </div>
        
        <hr class="my-5">
        
        <!-- Fitur Like -->
        <div class="text-center mb-5">
            <p>Suka berita ini?</p>
            <a href="<?= base_url('home/like/'.$news['id']); ?>" class="btn btn-outline-danger btn-lg">
                ❤️ Like / Unlike
            </a>
        </div>
    </div>
</div>