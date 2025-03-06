    <!-- Hero Section -->
    <section class="min-h-screen flex items-center bg-grid pt-20 overflow-hidden">
        <div class="container mx-auto px-6 py-16 md:py-24">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-12 md:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight text-glow animate-slide-up">
                        Share Your Code <br>with <span class="text-primary">Ease</span>
                    </h1>
                    <p class="text-xl text-gray-400 mb-8 max-w-lg animate-slide-up animate-delay-200">
                        PasteByte offers public, unlisted, and password-protected code sharing for developers who value both simplicity and security.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#" class="px-8 py-3 rounded-md bg-primary hover:bg-primary-dark transition-all duration-300 text-center font-medium text-white transform hover:-translate-y-1 hover:shadow-lg btn-hover-effect animate-slide-up animate-delay-300">
                            Start Sharing
                        </a>
                        <a href="#" class="px-8 py-3 rounded-md bg-dark-lighter hover:bg-gray-700 transition-all duration-300 text-center font-medium transform hover:-translate-y-1 hover:shadow-lg animate-slide-up animate-delay-400">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 relative animate-fade-in animate-delay-500">
                    <div class="relative z-10 animate-float">
                        <div class="bg-dark-lighter p-6 rounded-lg shadow-xl border border-gray-700 hover-scale">
                            <div class="flex items-center mb-4">
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="ml-4 text-xs text-gray-400">index.js</div>
                            </div>
                            <pre class="text-sm text-gray-300 overflow-x-auto"><code><span class="text-pink-400">const</span> <span class="text-blue-400">shareCode</span> <span class="text-gray-400">=</span> <span class="text-yellow-400">async</span> <span class="text-gray-400">(</span><span class="text-orange-400">code</span><span class="text-gray-400">,</span> <span class="text-orange-400">options</span><span class="text-gray-400">)</span> <span class="text-gray-400">=></span> <span class="text-gray-400">{</span>
  <span class="text-pink-400">const</span> <span class="text-blue-400">response</span> <span class="text-gray-400">=</span> <span class="text-pink-400">await</span> <span class="text-blue-400">fetch</span><span class="text-gray-400">(</span><span class="text-green-400">'https://api.PasteByte.dev/share'</span><span class="text-gray-400">,</span> <span class="text-gray-400">{</span>
    <span class="text-blue-400">method</span><span class="text-gray-400">:</span> <span class="text-green-400">'POST'</span><span class="text-gray-400">,</span>
    <span class="text-blue-400">headers</span><span class="text-gray-400">:</span> <span class="text-gray-400">{</span>
      <span class="text-green-400">'Content-Type'</span><span class="text-gray-400">:</span> <span class="text-green-400">'application/json'</span>
    <span class="text-gray-400">},</span>
    <span class="text-blue-400">body</span><span class="text-gray-400">:</span> <span class="text-blue-400">JSON</span><span class="text-gray-400">.</span><span class="text-blue-400">stringify</span><span class="text-gray-400">({</span> <span class="text-blue-400">code</span><span class="text-gray-400">,</span> <span class="text-blue-400">options</span> <span class="text-gray-400">})</span>
  <span class="text-gray-400">});</span>
  
  <span class="text-pink-400">return</span> <span class="text-pink-400">await</span> <span class="text-blue-400">response</span><span class="text-gray-400">.</span><span class="text-blue-400">json</span><span class="text-gray-400">();</span>
<span class="text-gray-400">};</span></code></pre>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-40 h-40 bg-primary/20 rounded-full blur-3xl animate-pulse-slow"></div>
                        <div class="absolute -top-4 -left-4 w-40 h-40 bg-primary/20 rounded-full blur-3xl animate-pulse-slow"></div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-purple-500/20 rounded-full blur-3xl -z-10 transform scale-110 animate-spin-slow"></div>
                </div>
            </div>
        </div>
    </section>
