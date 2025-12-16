/**
 * Adventure Today News - Main JavaScript
 * Handles interactions, AJAX calls, and UI updates
 */

// ============================================
// MOBILE MENU TOGGLE
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const navbarMenu = document.querySelector('.navbar-menu');

    if (mobileMenu) {
        mobileMenu.addEventListener('click', function() {
            if (navbarMenu.classList.contains('active')) {
                navbarMenu.classList.remove('active');
                mobileMenu.classList.remove('active');
            } else {
                navbarMenu.classList.add('active');
                mobileMenu.classList.add('active');
            }
        });

        // Close menu when clicking on a link
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navbarMenu.classList.remove('active');
                mobileMenu.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideNav = navbarMenu.contains(event.target) || mobileMenu.contains(event.target);
            if (!isClickInsideNav && navbarMenu.classList.contains('active')) {
                navbarMenu.classList.remove('active');
                mobileMenu.classList.remove('active');
            }
        });
    }
});

// ============================================
// ALERT CLOSE BUTTON
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    const alertCloseButtons = document.querySelectorAll('.alert-close');
    
    alertCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            if (alert) {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        });
    });
});

// ============================================
// AUTO CLOSE ALERTS AFTER 5 SECONDS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// ============================================
// LIKE FUNCTIONALITY
// ============================================

function setupLikeButtons() {
    const likeButtons = document.querySelectorAll('.like-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const newsId = this.dataset.newsId;
            toggleLike(newsId, this);
        });
    });
}

function toggleLike(newsId, buttonElement) {
    fetch(`/adventure-today/home/like/${newsId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeIcon = buttonElement.querySelector('.like-icon');
                const likeCount = buttonElement.querySelector('.like-count');
                
                if (likeIcon) {
                    likeIcon.textContent = data.is_liked ? '❤️' : '🤍';
                }
                if (likeCount) {
                    likeCount.textContent = data.total_likes;
                }
                
                // Visual feedback
                buttonElement.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    buttonElement.style.transform = 'scale(1)';
                }, 200);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
}

// ============================================
// FORM VALIDATION
// ============================================

function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const formControls = form.querySelectorAll('.form-control');
    let isValid = true;

    formControls.forEach(control => {
        if (control.hasAttribute('required') && !control.value.trim()) {
            control.classList.add('error');
            isValid = false;

            const errorDiv = control.parentElement.querySelector('.form-error');
            if (!errorDiv) {
                const error = document.createElement('span');
                error.className = 'form-error';
                error.textContent = `${control.name} tidak boleh kosong`;
                control.parentElement.appendChild(error);
            }
        } else {
            control.classList.remove('error');
            const errorDiv = control.parentElement.querySelector('.form-error');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
    });

    return isValid;
}

// ============================================
// COPY TO CLIPBOARD
// ============================================

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Disalin ke clipboard!', 'success');
    }).catch(err => {
        console.error('Error:', err);
        showNotification('Gagal menyalin', 'error');
    });
}

// ============================================
// NOTIFICATION HELPER
// ============================================

function showNotification(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <span>${message}</span>
        <button class="alert-close" type="button">&times;</button>
    `;

    const mainContainer = document.querySelector('.main-container');
    if (mainContainer) {
        mainContainer.insertBefore(alertDiv, mainContainer.firstChild);
    } else {
        document.body.insertBefore(alertDiv, document.body.firstChild);
    }

    // Auto close after 3 seconds
    setTimeout(() => {
        alertDiv.style.transition = 'opacity 0.3s ease-out';
        alertDiv.style.opacity = '0';
        setTimeout(() => {
            alertDiv.remove();
        }, 300);
    }, 3000);

    // Close button
    alertDiv.querySelector('.alert-close').addEventListener('click', function() {
        alertDiv.style.opacity = '0';
        setTimeout(() => alertDiv.remove(), 300);
    });
}

// ============================================
// CONFIRMATION DIALOG
// ============================================

function showConfirm(message) {
    return new Promise((resolve) => {
        if (confirm(message)) {
            resolve(true);
        } else {
            resolve(false);
        }
    });
}

// ============================================
// SEARCH AUTOCOMPLETE (Optional)
// ============================================

function setupSearchAutocomplete(searchInputId, resultsContainerId) {
    const searchInput = document.getElementById(searchInputId);
    const resultsContainer = document.getElementById(resultsContainerId);

    if (!searchInput) return;

    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            if (resultsContainer) resultsContainer.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/adventure-today/api/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && resultsContainer) {
                        resultsContainer.innerHTML = '';
                        
                        if (data.data.length > 0) {
                            data.data.slice(0, 5).forEach(news => {
                                const item = document.createElement('div');
                                item.className = 'search-result-item';
                                item.innerHTML = `
                                    <a href="/adventure-today/home/detail/${news.slug}">
                                        <strong>${news.title}</strong>
                                        <p>${news.username}</p>
                                    </a>
                                `;
                                resultsContainer.appendChild(item);
                            });
                            resultsContainer.style.display = 'block';
                        }
                    }
                })
                .catch(error => console.error('Search error:', error));
        }, 300);
    });

    // Close autocomplete when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && resultsContainer) {
            resultsContainer.style.display = 'none';
        }
    });
}

// ============================================
// DEBOUNCE FUNCTION
// ============================================

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ============================================
// THROTTLE FUNCTION
// ============================================

function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ============================================
// LAZY LOAD IMAGES
// ============================================

function setupLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        images.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    }
}

// ============================================
// DARK MODE TOGGLE (Optional)
// ============================================

function setupDarkMode() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (!darkModeToggle) return;

    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    if (isDarkMode) {
        document.documentElement.style.filter = 'invert(1)';
    }

    darkModeToggle.addEventListener('click', function() {
        const isCurrentlyDark = localStorage.getItem('darkMode') === 'true';
        
        if (isCurrentlyDark) {
            document.documentElement.style.filter = 'invert(0)';
            localStorage.setItem('darkMode', 'false');
        } else {
            document.documentElement.style.filter = 'invert(1)';
            localStorage.setItem('darkMode', 'true');
        }
    });
}

// ============================================
// INITIALIZE ALL FUNCTIONS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    setupLikeButtons();
    setupLazyLoading();
    // setupDarkMode(); // Uncomment jika ingin fitur dark mode
    
    // Setup form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            // Validation bisa ditambahkan di sini jika diperlukan
        });
    });

    // Log untuk debug
    console.log('Adventure Today - Main JS loaded successfully');
});

// ============================================
// UTILITY FUNCTIONS
// ============================================

/**
 * Format angka ke format mata uang
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(amount);
}

/**
 * Format tanggal ke bahasa Indonesia
 */
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('id-ID', options);
}

/**
 * Get query parameter dari URL
 */
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

/**
 * Smooth scroll ke elemen
 */
function smoothScroll(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

// ============================================
// EXPORT FUNCTIONS (jika menggunakan module)
// ============================================

// window.AdventureToday = {
//     toggleLike,
//     showNotification,
//     validateForm,
//     copyToClipboard,
//     formatCurrency,
//     formatDate,
//     getQueryParam,
//     smoothScroll
// };