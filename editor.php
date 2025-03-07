<?php 
include_once("./includes/components/editor/__header__.php");
?>

    <main class="container mx-auto px-6 py-8">
        <div class="text-center mb-8 animate-slide-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-2 text-glow">
                <i class="fas fa-code text-primary"></i> Advanced Code Editor
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                Write, edit, and share your code with our powerful editor. Supports multiple languages and themes.
            </p>
        </div>

        <div class="flex flex-wrap gap-3 mb-6 animate-slide-up animate-delay-200">
            <div class="relative group">
                <select id="language" class="p-2 bg-dark-lighter text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all duration-300 hover:border-gray-500 appearance-none pr-8">
                    <option value="javascript">JavaScript</option>
                    <option value="python">Python</option>
                    <option value="cpp">C++</option>
                    <option value="java">Java</option>
                    <option value="html">HTML</option>
                    <option value="css">CSS</option>
                    <option value="php">PHP</option>
                    <option value="csharp">C#</option>
                    <option value="go">Go</option>
                    <option value="ruby">Ruby</option>
                    <option value="swift">Swift</option>
                    <option value="typescript">TypeScript</option>
                    <option value="rust">Rust</option>
                    <option value="kotlin">Kotlin</option>
                    <option value="sql">SQL</option>
                </select>
                <div class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>

            <div class="relative group">
                <select id="theme" class="p-2 bg-dark-lighter text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all duration-300 hover:border-gray-500 appearance-none pr-8">
                    <option value="vs-dark">VS Code Dark</option>
                    <option value="vs">VS Code Light</option>
                    <option value="hc-black">High Contrast</option>
                </select>
                <div class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>

            <button id="fullscreenBtn" class="p-2 bg-dark-lighter hover:bg-gray-700 text-white rounded-md border border-gray-700 transition-all duration-300 hover:border-primary flex items-center hover-scale">
                <i class="fas fa-expand"></i>
                <span class="ml-2">Full Screen</span>
            </button>
            
            <button id="runCode" class="p-2 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300 flex items-center btn-hover-effect">
                <i class="fas fa-play"></i>
                <span class="ml-2">Run Code</span>
            </button>
            
            <button id="downloadCode" class="p-2 bg-dark-lighter hover:bg-gray-700 text-white rounded-md border border-gray-700 transition-all duration-300 hover:border-primary flex items-center hover-scale">
                <i class="fas fa-download"></i>
                <span class="ml-2">Download</span>
            </button>
            
            <input type="file" id="uploadFile" class="hidden">
            <label for="uploadFile" class="p-2 bg-dark-lighter hover:bg-gray-700 text-white rounded-md border border-gray-700 transition-all duration-300 hover:border-primary flex items-center cursor-pointer hover-scale">
                <i class="fas fa-upload"></i>
                <span class="ml-2">Load File</span>
            </label>
        </div>

        <div class="relative animate-bounce-in animate-delay-300">
            <div id="editor" class="w-full h-[70vh] border border-gray-700 rounded-lg overflow-hidden editor-shadow"></div>
            <div class="absolute -bottom-4 -right-4 w-40 h-40 bg-primary/20 rounded-full blur-3xl animate-pulse-slow -z-10"></div>
            <div class="absolute -top-4 -left-4 w-40 h-40 bg-primary/20 rounded-full blur-3xl animate-pulse-slow -z-10"></div>
        </div>
        
        <div id="output" class="w-full bg-dark-lighter text-white p-4 rounded-lg mt-6 hidden border border-gray-700 animate-slide-up">
            <div class="flex items-center mb-2">
                <i class="fas fa-terminal text-primary mr-2"></i>
                <h3 class="font-semibold">Output</h3>
            </div>
            <div id="output-content" class="font-mono text-sm"></div>
        </div>
    </main>

    <script src="./assets/js/editor.js"></script>
    <?php
include_once("./includes/__footer__.php"); ?>