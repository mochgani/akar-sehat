/**
 * Akar Sehat - Core JavaScript Logic
 * Version: 1.0.0
 * Author: Senior Developer
 * Description: Implements mobile menu, ScrollSpy, dynamic testimonial slider, and page effects.
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. MOBILE MENU NAVIGATION
    // ==========================================
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.getElementById('nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    const toggleMenu = () => {
        mobileMenu.classList.toggle('active');
        navMenu.classList.toggle('active');
        
        // Prevent scrolling when mobile menu is open
        document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
    };

    const closeMenu = () => {
        mobileMenu.classList.remove('active');
        navMenu.classList.remove('active');
        document.body.style.overflow = '';
    };

    if (mobileMenu && navMenu) {
        mobileMenu.addEventListener('click', toggleMenu);
        
        // Close menu when clicking a link
        navLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Close menu when clicking outside of it
        document.addEventListener('click', (event) => {
            const isClickInsideMenu = navMenu.contains(event.target);
            const isClickOnToggle = mobileMenu.contains(event.target);
            
            if (!isClickInsideMenu && !isClickOnToggle && navMenu.classList.contains('active')) {
                closeMenu();
            }
        });
    }

    // ==========================================
    // 2. STICKY HEADER EFFECT
    // ==========================================
    const navbar = document.querySelector('.navbar');
    const handleScroll = () => {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar--scrolled');
        } else {
            navbar.classList.remove('navbar--scrolled');
        }
    };
    
    window.addEventListener('scroll', handleScroll, { passive: true });
    // Initial call in case page loads scrolled
    handleScroll();

    // ==========================================
    // 3. SCROLLSPY (ACTIVE LINK NAVIGATION)
    // ==========================================
    const sections = document.querySelectorAll('section[id], header[id]');
    
    const scrollSpy = () => {
        const scrollPosition = window.scrollY + 120; // offset for navbar height

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                const activeLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);
                if (activeLink) {
                    navLinks.forEach(link => link.classList.remove('active'));
                    activeLink.classList.add('active');
                }
            }
        });

        // Special case: at the top of the page, set Home active
        if (window.scrollY < 100) {
            navLinks.forEach(link => link.classList.remove('active'));
            const homeLink = document.querySelector('.nav-link[href="#"]');
            if (homeLink) homeLink.classList.add('active');
        }
    };

    window.addEventListener('scroll', scrollSpy, { passive: true });

    // ==========================================
    // 4. TESTIMONIAL SLIDER (server-rendered cards)
    // ==========================================
    const testimonialWrapper = document.getElementById('testimonial-wrapper');
    const dotsContainer = document.getElementById('slider-dots');

    if (testimonialWrapper && dotsContainer) {
        const dots = dotsContainer.querySelectorAll('.dot');
        const total = testimonialWrapper.querySelectorAll('.testimonial-card').length;
        let currentSlide = 0;

        const goToSlide = (slideIndex) => {
            currentSlide = slideIndex;
            testimonialWrapper.style.transform = `translateX(-${slideIndex * 100}%)`;
            dots.forEach(dot => dot.classList.remove('active'));
            if (dots[slideIndex]) dots[slideIndex].classList.add('active');
        };

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                goToSlide(parseInt(e.target.getAttribute('data-slide'), 10));
            });
        });

        // Auto slide every 6 seconds
        let autoSlideInterval = setInterval(() => {
            goToSlide((currentSlide + 1) % total);
        }, 6000);

        dotsContainer.addEventListener('click', () => {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(() => {
                goToSlide((currentSlide + 1) % total);
            }, 6000);
        });
    }

    // ==========================================
    // 5. PRODUCT FAVORITE BUTTON TOGGLE
    // ==========================================
    const favButtons = document.querySelectorAll('.product-fav-btn');

    favButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const isActive = btn.classList.toggle('active');
            const svg = btn.querySelector('svg path');

            if (isActive) {
                // Filled heart — active/liked state
                btn.style.backgroundColor = '#fff0f0';
                btn.style.color = '#e74c3c';
                svg.setAttribute('fill', '#e74c3c');
                svg.setAttribute('stroke', '#e74c3c');
            } else {
                // Empty heart — default state
                btn.style.backgroundColor = '';
                btn.style.color = '';
                svg.setAttribute('fill', 'none');
                svg.setAttribute('stroke', 'currentColor');
            }
        });
    });
});
