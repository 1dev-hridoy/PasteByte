   <!-- Footer -->
   <footer class="bg-dark-lighter pt-16 pb-8 border-t border-gray-800 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="animate-slide-up">
                    <a href="#" class="text-2xl font-bold text-white flex items-center mb-4">
                        <span class="text-primary mr-1"><i class="fas fa-code"></i></span>
                        Snip<span class="text-primary">Sync</span>
                    </a>
                    <p class="text-gray-400 mb-4">Share your code snippets with ease and security.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300 hover-scale">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300 hover-scale">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300 hover-scale">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300 hover-scale">
                            <i class="fab fa-discord"></i>
                        </a>
                    </div>
                </div>
                
                <div class="animate-slide-up animate-delay-100">
                    <h4 class="text-lg font-semibold mb-4">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Features</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Pricing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Integrations</a></li>
                    </ul>
                </div>
                
                <div class="animate-slide-up animate-delay-200">
                    <h4 class="text-lg font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Guides</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Support</a></li>
                    </ul>
                </div>
                
                <div class="animate-slide-up animate-delay-300">
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">About</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Privacy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Terms</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 mt-8 text-center text-gray-500 text-sm animate-fade-in">
                <p>&copy; 2025 PasteByte. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            menuToggle.innerHTML = mobileMenu.classList.contains('hidden') 
                ? '<i class="fas fa-bars text-xl"></i>' 
                : '<i class="fas fa-times text-xl"></i>';
        });
        
        // Testimonial Slider
        const slider = document.getElementById('testimonial-slider');
        const slides = document.querySelectorAll('.testimonial-slide');
        const dots = document.querySelectorAll('.testimonial-dot');
        const prevBtn = document.getElementById('prev-testimonial');
        const nextBtn = document.getElementById('next-testimonial');
        
        let currentSlide = 0;
        const slideCount = slides.length;
        
        function goToSlide(index) {
            if (index < 0) index = slideCount - 1;
            if (index >= slideCount) index = 0;
            
            slider.style.transform = `translateX(-${index * 100}%)`;
            currentSlide = index;
            
            // Update dots
            dots.forEach((dot, i) => {
                dot.classList.remove('bg-primary');
                dot.classList.add('bg-gray-600');
                if (i === currentSlide) {
                    dot.classList.remove('bg-gray-600');
                    dot.classList.add('bg-primary');
                }
            });
        }
        
        // Initialize dots
        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => goToSlide(i));
        });
        
        // Initialize buttons
        prevBtn.addEventListener('click', () => goToSlide(currentSlide - 1));
        nextBtn.addEventListener('click', () => goToSlide(currentSlide + 1));
        
        // Auto slide
        let autoSlide = setInterval(() => {
            goToSlide(currentSlide + 1);
        }, 5000);
        
        // Initialize first slide
        goToSlide(0);
        
        // Pause auto-slide on hover
        slider.addEventListener('mouseenter', () => {
            clearInterval(autoSlide);
        });
        
        slider.addEventListener('mouseleave', () => {
            autoSlide = setInterval(() => {
                goToSlide(currentSlide + 1);
            }, 5000);
        });
        
        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        menuToggle.innerHTML = '<i class="fas fa-bars text-xl"></i>';
                    }
                }
            });
        });
        
        // Add scroll animation for elements
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.bg-dark p-8, .bg-dark-lighter p-8');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    element.classList.add('opacity-100', 'translate-y-0');
                    element.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        };
        
        // Add initial classes for animation
        document.querySelectorAll('.bg-dark p-8, .bg-dark-lighter p-8').forEach(element => {
            element.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-10');
        });
        
        // Listen for scroll events
        window.addEventListener('scroll', animateOnScroll);
        
        // Trigger once on load
        animateOnScroll();
    </script>
</body>
</html>