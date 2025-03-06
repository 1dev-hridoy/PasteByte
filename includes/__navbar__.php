<body class="bg-dark text-gray-100 font-sans overflow-x-hidden">
    <!-- Navigation -->
    <header class="fixed w-full bg-dark/80 backdrop-blur-md z-50 border-b border-gray-800">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-white flex items-center animate-fade-in">
                        <span class="text-primary mr-1"><i class="fas fa-code"></i></span>
                        Paste<span class="text-primary">Byte</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-down animate-delay-100">Home</a>
                    <a href="#features" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-down animate-delay-200">Features</a>
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-down animate-delay-300">Pricing</a>
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-down animate-delay-400">Contact</a>
                    <a href="#" class="px-4 py-2 rounded-md bg-dark-lighter hover:bg-gray-700 transition-colors duration-300 animate-slide-down animate-delay-500">Login</a>
                    <a href="#" class="px-4 py-2 rounded-md bg-primary hover:bg-primary-dark transition-colors duration-300 btn-hover-effect animate-bounce-in animate-delay-500">Sign Up</a>
                </div>
                
                <!-- Mobile Navigation Button -->
                <div class="md:hidden">
                    <button id="menu-toggle" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-fade-in">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-2 overflow-hidden">
                <div class="flex flex-col space-y-4">
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-up animate-delay-100">Home</a>
                    <a href="#features" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-up animate-delay-200">Features</a>
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-up animate-delay-300">Pricing</a>
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300 animate-slide-up animate-delay-400">Contact</a>
                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="px-4 py-2 rounded-md bg-dark-lighter hover:bg-gray-700 transition-colors duration-300 text-center w-1/2 animate-slide-up animate-delay-500">Login</a>
                        <a href="#" class="px-4 py-2 rounded-md bg-primary hover:bg-primary-dark transition-colors duration-300 text-center w-1/2 btn-hover-effect animate-slide-up animate-delay-500">Sign Up</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>