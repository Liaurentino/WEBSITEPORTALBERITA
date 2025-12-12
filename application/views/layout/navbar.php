<nav class="navbar">
    <div class="container navbar-container">
        <div class="navbar-brand">
            <a href="<?php echo base_url('home'); ?>">
                <h1>Adventure Today</h1>
            </a>
        </div>
        
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <div class="navbar-menu">
            <ul class="nav-list">
                <li><a href="<?php echo base_url('home'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') ? 'active' : ''; ?>">Beranda</a></li>
                <li><a href="#" class="nav-link">Traveling</a></li>
                <li><a href="#" class="nav-link">Discovery</a></li>
                <li><a href="#" class="nav-link">Community</a></li>
                <li><a href="#" class="nav-link">Tentang Kami</a></li>
            </ul>

            <div class="nav-auth">
                <?php if ($this->session->userdata('user_id')): ?>
                    <span class="username">Hai, <?php echo $this->session->userdata('username'); ?></span>
                    <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline">Dashboard</a>
                    <a href="<?php echo base_url('logout'); ?>" class="btn btn-primary">Logout</a>
                <?php else: ?>
                    <a href="<?php echo base_url('login'); ?>" class="nav-link">Masuk</a>
                    <a href="<?php echo base_url('register'); ?>" class="btn btn-primary">Daftar Sekarang</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>