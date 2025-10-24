/**
 * World Recipes - Interactive JavaScript
 * Handles navigation, animations, and user interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all interactive features
    initMobileNavigation();
    initScrollAnimations();
    initCountryCardInteractions();
    initFormValidation();
    initPrintFunctionality();
    initLazyLoading();
    
    console.log('🌍 World Recipes loaded successfully!');
});

/**
 * Mobile Navigation Toggle
 */
function initMobileNavigation() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // Animate hamburger menu
            const spans = navToggle.querySelectorAll('span');
            spans.forEach((span, index) => {
                span.style.transform = navMenu.classList.contains('active') 
                    ? `rotate(${index === 0 ? 45 : index === 1 ? 0 : -45}deg) translate(${index === 1 ? '10px' : '0'}, ${index === 0 ? '8px' : index === 2 ? '-8px' : '0'})`
                    : 'none';
                span.style.opacity = index === 1 && navMenu.classList.contains('active') ? '0' : '1';
            });
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                resetHamburgerAnimation(navToggle);
            }
        });
        
        // Close mobile menu when clicking on a link
        const navLinks = navMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                resetHamburgerAnimation(navToggle);
            });
        });
    }
}

function resetHamburgerAnimation(navToggle) {
    const spans = navToggle.querySelectorAll('span');
    spans.forEach(span => {
        span.style.transform = 'none';
        span.style.opacity = '1';
    });
}

/**
 * Scroll Animations
 */
function initScrollAnimations() {
    // Smooth reveal animation for elements
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Elements to animate
    const elementsToAnimate = document.querySelectorAll(
        '.country-card, .recipe-card, .feature, .country-highlight, .contact-method, .faq-item'
    );
    
    elementsToAnimate.forEach((el, index) => {
        // Initial state
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        
        observer.observe(el);
    });
    
    // Parallax effect for hero sections
    const heroSections = document.querySelectorAll('.hero, .country-banner');
    heroSections.forEach(hero => {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            hero.style.transform = `translateY(${rate}px)`;
        });
    });
}

/**
 * Country Card Interactions
 */
function initCountryCardInteractions() {
    const countryCards = document.querySelectorAll('.country-card');
    
    countryCards.forEach(card => {
        // Add click handler for entire card
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on the button directly
            if (e.target.classList.contains('btn-explore')) return;
            
            const country = this.dataset.country;
            if (country) {
                const countryName = country.charAt(0).toUpperCase() + country.slice(1);
                window.location.href = `country.php?country=${encodeURIComponent(countryName)}`;
            }
        });
        
        // Add hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
        });
    });
    
    // Recipe card interactions
    const recipeCards = document.querySelectorAll('.recipe-card');
    recipeCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const img = this.querySelector('.recipe-image img');
            if (img) {
                img.style.transform = 'scale(1.1)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const img = this.querySelector('.recipe-image img');
            if (img) {
                img.style.transform = 'scale(1)';
            }
        });
    });
}

/**
 * Form Validation and Enhancement
 */
function initFormValidation() {
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        const inputs = contactForm.querySelectorAll('input, select, textarea');
        
        // Real-time validation
        inputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearFieldError);
        });
        
        // Form submission
        contactForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateField.call(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showFormError('Please fix the errors above before submitting.');
            } else {
                showFormLoading();
            }
        });
    }
}

function validateField() {
    const field = this;
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Remove existing error
    clearFieldError.call(field);
    
    // Required field validation
    if (field.required && !value) {
        errorMessage = 'This field is required.';
        isValid = false;
    }
    
    // Email validation
    if (field.type === 'email' && value && !isValidEmail(value)) {
        errorMessage = 'Please enter a valid email address.';
        isValid = false;
    }
    
    // Minimum length validation
    if (field.name === 'message' && value && value.length < 10) {
        errorMessage = 'Message must be at least 10 characters long.';
        isValid = false;
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    }
    
    return isValid;
}

function clearFieldError() {
    const field = this;
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
    field.style.borderColor = '#ecf0f1';
}

function showFieldError(field, message) {
    field.style.borderColor = '#e74c3c';
    
    const errorElement = document.createElement('span');
    errorElement.className = 'field-error';
    errorElement.style.cssText = 'color: #e74c3c; font-size: 0.875rem; margin-top: 0.25rem; display: block;';
    errorElement.textContent = message;
    
    field.parentNode.appendChild(errorElement);
}

function showFormError(message) {
    const existingError = document.querySelector('.form-error');
    if (existingError) existingError.remove();
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'form-error error-message';
    errorDiv.innerHTML = `<p>${message}</p>`;
    
    const form = document.querySelector('.contact-form');
    form.insertBefore(errorDiv, form.firstChild);
    
    // Scroll to error
    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function showFormLoading() {
    const submitBtn = document.querySelector('.contact-form button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '📤 Sending Message...';
        submitBtn.style.opacity = '0.7';
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Print Functionality
 */
function initPrintFunctionality() {
    // Add print styles for recipe pages
    const printButtons = document.querySelectorAll('[onclick*="print"]');
    
    printButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add print-specific styles
            document.body.classList.add('printing');
            
            // Small delay to ensure styles are applied
            setTimeout(() => {
                window.print();
                document.body.classList.remove('printing');
            }, 100);
        });
    });
    
    // Handle print events
    window.addEventListener('beforeprint', function() {
        document.body.classList.add('printing');
    });
    
    window.addEventListener('afterprint', function() {
        document.body.classList.remove('printing');
    });
}

/**
 * Lazy Loading for Images
 */
function initLazyLoading() {
    const images = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => {
            imageObserver.observe(img);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        images.forEach(img => {
            img.classList.add('loaded');
        });
    }
}

/**
 * Utility Functions
 */

// Smooth scrolling for anchor links
function smoothScrollTo(target) {
    const element = document.querySelector(target);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Add click handlers for smooth scrolling
document.addEventListener('click', function(e) {
    if (e.target.matches('a[href^="#"]')) {
        e.preventDefault();
        const target = e.target.getAttribute('href');
        smoothScrollTo(target);
    }
});

// Back to top functionality (if button exists)
function addBackToTop() {
    const backToTopHTML = `
        <button id="backToTop" style="
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            font-size: 20px;
        " title="Back to top">↑</button>
    `;
    
    document.body.insertAdjacentHTML('beforeend', backToTopHTML);
    
    const backToTopBtn = document.getElementById('backToTop');
    
    // Show/hide based on scroll position
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.visibility = 'visible';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.visibility = 'hidden';
        }
    });
    
    // Scroll to top when clicked
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Add back to top button
addBackToTop();

// Search functionality (basic)
function addSearchFeature() {
    const searchHTML = `
        <div class="search-container" style="
            position: relative;
            max-width: 400px;
            margin: 2rem auto;
            display: none;
        ">
            <input type="search" id="recipeSearch" placeholder="Search recipes..." style="
                width: 100%;
                padding: 0.75rem 1rem;
                border: 2px solid #ecf0f1;
                border-radius: 0.5rem;
                font-size: 1rem;
            ">
            <div id="searchResults" class="search-results"></div>
        </div>
    `;
    
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        heroSection.insertAdjacentHTML('afterend', searchHTML);
        
        const searchInput = document.getElementById('recipeSearch');
        const searchContainer = document.querySelector('.search-container');
        
        // Show search on recipe pages
        if (window.location.pathname.includes('country.php') || window.location.pathname.includes('index.php')) {
            searchContainer.style.display = 'block';
        }
        
        // Basic search functionality
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const recipeCards = document.querySelectorAll('.recipe-card, .country-card');
            
            recipeCards.forEach(card => {
                const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const description = card.querySelector('p')?.textContent.toLowerCase() || '';
                
                if (title.includes(searchTerm) || description.includes(searchTerm) || searchTerm === '') {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
}

// Add search feature
addSearchFeature();

/**
 * Theme Detection and Respect User Preferences
 */
function initThemeDetection() {
    // Detect user's preference for reduced motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.style.setProperty('--transition-fast', 'none');
        document.documentElement.style.setProperty('--transition-normal', 'none');
        document.documentElement.style.setProperty('--transition-slow', 'none');
    }
    
    // Detect dark mode preference (for future enhancement)
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        // Could add dark mode styles here
        console.log('User prefers dark mode');
    }
}

initThemeDetection();

/**
 * Performance Monitoring
 */
function logPerformanceMetrics() {
    if ('performance' in window) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                const perfData = performance.getEntriesByType('navigation')[0];
                if (perfData) {
                    console.log('🚀 Page Performance Metrics:');
                    console.log(`- DOM Content Loaded: ${Math.round(perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart)}ms`);
                    console.log(`- Page Load Complete: ${Math.round(perfData.loadEventEnd - perfData.loadEventStart)}ms`);
                }
            }, 0);
        });
    }
}

logPerformanceMetrics();