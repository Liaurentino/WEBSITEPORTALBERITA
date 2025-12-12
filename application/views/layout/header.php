<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adventure Today - Portal Berita</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/icons.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animations.css'); ?>">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <h1>🌍 Adventure Today</h1>
            </div>
            <div class="navbar-menu">
                <a href="<?php echo base_url('home'); ?>" class="nav-link">Beranda</a>
                
                <?php if ($this->session->userdata('user_id')): ?>
                    <div class="nav-user">
                        <span class="username">👤 <?php echo $this->session->userdata('username'); ?></span>
                        <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">Dashboard</a>
                        <a href="<?php echo base_url('logout'); ?>" class="nav-link btn-logout">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="nav-auth">
                        <a href="<?php echo base_url('login'); ?>" class="nav-link">Login</a>
                        <a href="<?php echo base_url('register'); ?>" class="nav-link btn-register">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Message -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            ✓ <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            ✕ <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>