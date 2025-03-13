<?php
include_once("./includes/__header__.php");
include_once("./includes/__navbar__.php");
include_once("./includes/__store--style__.php");
?>


    <!-- Main Content -->
    <main class="container mx-auto px-6 pt-28 pb-16">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-glow animate-slide-up">
                Code Snippets Library
            </h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto animate-slide-up animate-delay-200">
                Browse, search, and use our collection of code snippets across multiple languages and frameworks.
            </p>
            
            <!-- Search and Filter -->
            <div class="mt-8 max-w-2xl mx-auto animate-slide-up animate-delay-300">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-grow">
                        <input type="text" placeholder="Search snippets..." class="w-full p-3 bg-dark-lighter text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all duration-300">
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="relative">
                        <select class="p-3 bg-dark-lighter text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all duration-300 appearance-none pr-10">
                            <option value="all">All Languages</option>
                            <option value="javascript">JavaScript</option>
                            <option value="python">Python</option>
                            <option value="html">HTML/CSS</option>
                            <option value="react">React</option>
                            <option value="node">Node.js</option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Snippets Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Snippet Card 1 -->
            <div class="snippet-card bg-dark-lighter rounded-lg overflow-hidden border border-gray-800 card-shadow hover-scale animate-slide-up animate-delay-100 cursor-pointer" data-id="1">
                <div class="relative">
                    <div class="language-badge px-2 py-1 bg-primary/80 text-white text-xs rounded-md">
                        JavaScript
                    </div>
                    <div class="code-preview p-4 bg-[#282c34]">
                        <pre><code class="language-javascript">// Fetch API with async/await
async function fetchData(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Fetch error:', error);
    throw error;
  }
}</code></pre>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-semibold mb-2 text-white">Fetch API Wrapper</h3>
                    <p class="text-gray-400 text-sm mb-3">A reusable async/await wrapper for the Fetch API with error handling.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">Added 2 days ago</span>
                        <div class="flex space-x-2">
                            <span class="text-primary"><i class="far fa-eye"></i> 245</span>
                            <span class="text-primary"><i class="far fa-copy"></i> 78</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Snippet Card 2 -->
            <div class="snippet-card bg-dark-lighter rounded-lg overflow-hidden border border-gray-800 card-shadow hover-scale animate-slide-up animate-delay-200 cursor-pointer" data-id="2">
                <div class="relative">
                    <div class="language-badge px-2 py-1 bg-blue-500/80 text-white text-xs rounded-md">
                        React
                    </div>
                    <div class="code-preview p-4 bg-[#282c34]">
                        <pre><code class="language-javascript">import { useState, useEffect } from 'react';

function useFetch(url) {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(url);
        const json = await response.json();
        setData(json);
        setLoading(false);
      } catch (error) {
        setError(error);
        setLoading(false);
      }
    };

    fetchData();
  }, [url]);

  return { data, loading, error };
}</code></pre>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-semibold mb-2 text-white">React useFetch Hook</h3>
                    <p class="text-gray-400 text-sm mb-3">A custom React hook for fetching data with loading and error states.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">Added 1 week ago</span>
                        <div class="flex space-x-2">
                            <span class="text-primary"><i class="far fa-eye"></i> 512</span>
                            <span class="text-primary"><i class="far fa-copy"></i> 203</span>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-12 animate-slide-up animate-delay-500">
            <button class="px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300 btn-hover-effect">
                Load More Snippets
            </button>
        </div>
    </main>
    
    </div>

<?php
include_once("./includes/__footer__.php"); 
?>