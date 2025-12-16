</div> <!-- End main-container -->

<!-- FOOTER -->
<footer>
    <div class="container">
        <div style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">🌍 Adventure Today</h3>
            <p style="margin-bottom: 1.5rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                Berbagi cerita petualanganmu, inspirasi, dan pengalaman traveling dengan komunitas global adventurer.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 1.5rem;">
                <a href="#" style="color: white; transition: 0.3s;">📘 Facebook</a>
                <a href="#" style="color: white; transition: 0.3s;">📷 Instagram</a>
                <a href="#" style="color: white; transition: 0.3s;">🐦 Twitter</a>
                <a href="#" style="color: white; transition: 0.3s;">▶️ YouTube</a>
            </div>
        </div>

        <div style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 1.5rem;">
            <p>&copy; <?php echo date('Y'); ?> Adventure Today News. All rights reserved.</p>
            <p style="font-size: 0.85rem; margin-top: 0.5rem;">Made with ❤️ for Adventurers</p>
        </div>
    </div>
</footer>

<!-- Mobile Menu JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const navbarMenu = document.querySelector('.navbar-menu');

    if (mobileMenu) {
        mobileMenu.addEventListener('click', function() {
            navbarMenu.style.display = navbarMenu.style.display === 'flex' ? 'none' : 'flex';
        });
    }

    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navbarMenu.style.display = 'none';
        });
    });
});
</script>

</body>
</html>