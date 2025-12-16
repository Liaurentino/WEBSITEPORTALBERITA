<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Adventure Today'; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">

    <style>
        /* Definisi Warna Biru Gelap (Navy) sesuai Teks Logo */
        :root {
            /* Warna Biru Tua / Navy */
            --theme-blue: #1e3a8a; 
            --theme-hover: #1e40af;
        }

        /* Efek Transisi Halus */
        .nav-link {
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            color: inherit; /* Ikut warna bawaan */
        }

        /* 1. Efek saat Mouse Nempel (Hover) -> JADI BIRU GELAP */
        .nav-link:hover {
            color: var(--theme-blue); 
            transform: translateY(-2px); 
            font-weight: 600;
        }

        /* 2. Efek saat Halaman Aktif (Active) -> JADI BIRU GELAP */
        .nav-link.active {
            font-weight: bold;
            color: var(--theme-blue); 
        }
        
        /* Garis bawah untuk yang aktif */
        .nav-link.active::after {
            content: '';
            display: block;
            width: 100%;
            height: 3px; 
            background: var(--theme-blue);
            margin-top: 4px;
            border-radius: 2px;
        }
    </style>
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
            
            <div class="navbar-menu" style="display: flex; align-items: center; gap: 20px; width: 100%; justify-content: space-between;">
                
                <div class="nav-search" style="flex-grow: 1; max-width: 300px; margin-left: 20px;">
                    <form action="<?php echo base_url('home/search'); ?>" method="GET" style="display: flex; align-items: center; background: #f1f1f1; border-radius: 20px; padding: 5px 15px;">
                        <input type="text" name="q" placeholder="Cari berita..." style="border: none; background: transparent; outline: none; width: 100%; padding: 5px;">
                        <button type="submit" style="border: none; background: transparent; cursor: pointer;">🔍</button>
                    </form>
                </div>

                <ul class="nav-list" style="display: flex; gap: 20px; list-style: none; margin: 0; padding: 0;">
                    <?php 
                        $seg1 = $this->uri->segment(1); // home, dashboard
                        $seg2 = $this->uri->segment(2); // trending, latest
                    ?>

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
                        <span class="username" style="margin-right: 10px; font-weight: bold;">
                            <?php echo htmlspecialchars($this->session->userdata('username')); ?>
                        </span>
                        
                        <a href="<?php echo base_url('dashboard/profile'); ?>" class="btn btn-outline" style="margin-right: 5px; border: 1px solid #1e3a8a; color: #1e3a8a; padding: 5px 15px; border-radius: 5px; text-decoration: none;">👤 Profil</a>

                        <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-outline" style="border: 1px solid #dc3545; color: #dc3545; padding: 5px 15px; border-radius: 5px; text-decoration: none;">Logout</a>
                    <?php else: ?>
                        <div class="auth-group" style="display: flex; align-items: center; gap: 10px;">
                            <a href="<?php echo base_url('auth/login'); ?>" class="nav-link" style="font-weight: bold;">Masuk</a>
                            <span style="color: #ccc;">|</span>
                            <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-primary" style="background-color: #1e3a8a; color: white; padding: 8px 20px; border-radius: 5px; text-decoration: none;">Daftar</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>