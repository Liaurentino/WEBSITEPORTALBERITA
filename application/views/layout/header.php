<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Adventure Today'; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/news.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/auth.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/alert.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/arsip.css'); ?>">
</head>
<body>
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

            <div class="nav-search">
                <form action="<?php echo base_url('home/search'); ?>" method="GET" class="nav-search-form">
                    <input type="text" name="q" placeholder="Cari berita..." class="nav-search-input">
                    <button type="submit" class="nav-search-button">🔍</button>
                </form>
            </div>

            <ul class="nav-list">
                <?php 
                    $seg1 = $this->uri->segment(1);
                    $seg2 = $this->uri->segment(2);
                ?>
                 <li>
                    <a href="<?php echo base_url('home/arsip'); ?>" 
                       class="nav-link <?php echo ($seg2 == 'arsip') ? 'active' : ''; ?>">
                        Lihat Semua
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('home/trending'); ?>" 
                       class="nav-link <?php echo ($seg2 == 'trending') ? 'active' : ''; ?>">
                        Trending
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('home/latest'); ?>" 
                       class="nav-link <?php echo ($seg2 == 'latest') ? 'active' : ''; ?>">
                        Terbaru
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('dashboard'); ?>" 
                       class="nav-link <?php echo ($seg1 == 'dashboard') ? 'active' : ''; ?>">
                        Dashboard
                    </a>
                </li>
            </ul>

            <div class="nav-auth">
                <?php if ($this->session->userdata('user_id')): ?>
                    <span class="nav-username">
                        <?php echo htmlspecialchars($this->session->userdata('username')); ?>
                    </span>

                    <a href="<?php echo base_url('dashboard/profile'); ?>" class="btn btn-outline btn-profile">
                        👤 Profil
                    </a>

                    <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-outline2 btn-logout">
                        Logout
                    </a>
                <?php else: ?>
                    <div class="auth-group">
                        <a href="<?php echo base_url('auth/login'); ?>" class="nav-link"><strong>Masuk</strong></a>
                        <span class="auth-divider">|</span>
                        <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-register register-link"> Daftar </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>
