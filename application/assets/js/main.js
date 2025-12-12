// Close alert after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });

    // Make alerts dismissible
    alerts.forEach(alert => {
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = `
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.7;
        `;
        closeBtn.addEventListener('click', () => alert.remove());
        alert.style.position = 'relative';
        alert.appendChild(closeBtn);
    });
});

// Hamburger menu for mobile
function toggleMobileMenu() {
    const menu = document.querySelector('.navbar-menu');
    menu.classList.toggle('active');
}

// Like/Unlike news via AJAX
function toggleLike(newsId) {
    fetch(`/news/like/${newsId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const likeBtn = document.querySelector(`[data-news-id="${newsId}"] .icon-heart`);
            if (likeBtn) {
                likeBtn.classList.toggle('liked');
            }
            const likeCount = document.querySelector(`[data-news-id="${newsId}"] .like-count`);
            if (likeCount) {
                likeCount.textContent = data.total_likes;
            }
        } else if (data.status === 'error') {
            alert(data.message);
            window.location.href = '/login';
        }
    })
    .catch(error => console.error('Error:', error));
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (input.value.trim() === '') {
            input.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            input.style.borderColor = '';
        }
    });

    return isValid;
}

// Image preview
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.querySelector('input[type="file"][accept="image/*"]');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    // Display preview if needed
                    console.log('Image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Character counter for textarea
function setupCharCounter(textareaSelector, maxChars = 5000) {
    const textarea = document.querySelector(textareaSelector);
    if (!textarea) return;

    textarea.addEventListener('input', function() {
        const remaining = maxChars - this.value.length;
        console.log(`${remaining} characters remaining`);
    });
}
// Close alert after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s ease';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Make alerts dismissible
    alerts.forEach(alert => {
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '✕';
        closeBtn.style.cssText = `
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        `;
        closeBtn.addEventListener('mouseover', () => closeBtn.style.opacity = '1');
        closeBtn.addEventListener('mouseout', () => closeBtn.style.opacity = '0.7');
        closeBtn.addEventListener('click', () => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
        alert.style.position = 'relative';
        alert.appendChild(closeBtn);
    });
});

// Hamburger menu for mobile
function toggleMobileMenu() {
    const menu = document.querySelector('.navbar-menu');
    menu.classList.toggle('active');
}

// Like/Unlike news via AJAX
function toggleLike(newsId) {
    fetch(`/news/like/${newsId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const likeBtn = document.querySelector(`[data-news-id="${newsId}"] .icon-heart`);
            if (likeBtn) {
                likeBtn.classList.toggle('liked');
            }
            const likeCount = document.querySelector(`[data-news-id="${newsId}"] .like-count`);
            if (likeCount) {
                likeCount.textContent = data.total_likes;
            }
        } else if (data.status === 'error') {
            alert(data.message);
            window.location.href = '/login';
        }
    })
    .catch(error => console.error('Error:', error));
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (input.value.trim() === '') {
            input.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            input.style.borderColor = '';
        }
    });

    return isValid;
}

// Image preview
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.querySelector('input[type="file"][accept="image/*"]');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    // Display preview if needed
                    console.log('Image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Character counter for textarea
function setupCharCounter(textareaSelector, maxChars = 5000) {
    const textarea = document.querySelector(textareaSelector);
    if (!textarea) return;

    textarea.addEventListener('input', function() {
        const remaining = maxChars - this.value.length;
        console.log(`${remaining} characters remaining`);
    });
}

// Active nav link
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            link.classList.add('active');
        }
    });
});

// Trending animation
document.addEventListener('DOMContentLoaded', function() {
    const trendingItems = document.querySelectorAll('.trending-item');
    trendingItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        item.classList.add('fade-in');
    });
});

// Newsletter subscription
document.addEventListener('DOMContentLoaded', function() {
    const newsletters = document.querySelectorAll('.newsletter-form');
    newsletters.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            alert(`Terima kasih! Kami akan mengirim update ke ${email}`);
            this.reset();
        });
    });
});

// Category card animation
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.category-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});