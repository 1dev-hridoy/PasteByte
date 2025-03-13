<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasteByte Code Editor</title>
    <script src="./assets/plugin/loader.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="./assets/js/editor.tailwind.config.js"></script>
    <link rel="stylesheet" href="./assets/css/editor.css">
</head>
<body class="bg-dark text-gray-100 font-sans overflow-x-hidden bg-grid min-h-screen">
    <!-- Header -->
    <header class="w-full bg-dark/80 backdrop-blur-md border-b border-gray-800 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <a href="index.html" class="text-2xl font-bold text-white flex items-center animate-fade-in">
                    <span class="text-primary mr-1"><i class="fas fa-code"></i></span>
                    Paste<span class="text-primary">Byte</span>
                    <span class="ml-2 text-sm bg-dark-lighter px-2 py-1 rounded-md">Editor</span>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">
                        <i class="fas fa-question-circle"></i>
                        <span class="ml-1 hidden md:inline">Help</span>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">
                        <i class="fas fa-cog"></i>
                        <span class="ml-1 hidden md:inline">Settings</span>
                    </a>
                    <a href="#" class="px-4 py-2 rounded-md bg-primary hover:bg-primary-dark transition-colors duration-300 btn-hover-effect">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span class="ml-1">Share</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
	
	<?php 
    include_once("./includes/components/editor/__header__.php");
    include_once("./server/dbcon.php");
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

    <!-- Share Modal -->
    <div id="shareModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md mx-auto mt-20 bg-dark-lighter border border-gray-700 rounded-lg shadow-xl animate-fade-in">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Share Your Code</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="shareForm">
                    <div class="space-y-4">
                        <div>
                            <label for="codeTitle" class="block text-sm font-medium text-gray-300 mb-1">Title</label>
                            <input type="text" id="codeTitle" name="title" class="w-full p-2 bg-dark text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all" placeholder="Enter a title for your code" required>
                        </div>
                        
                        <div>
                            <label for="codeDescription" class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                            <textarea id="codeDescription" name="description" rows="3" class="w-full p-2 bg-dark text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all" placeholder="Add a description (optional)"></textarea>
                        </div>
                        
                        <div>
                            <label for="codePrivacy" class="block text-sm font-medium text-gray-300 mb-1">Privacy</label>
                            <select id="codePrivacy" name="privacy" class="w-full p-2 bg-dark text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all">
                                <option value="public">Public - Anyone can view</option>
                                <option value="unlisted">Unlisted - Only people with the link can view</option>
                                <option value="private" selected>Private - Password protected</option>
                            </select>
                        </div>
                        
                        <div id="passwordContainer">
                            <label for="codePassword" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                            <input type="password" id="codePassword" name="password" class="w-full p-2 bg-dark text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all" placeholder="Enter a password">
                        </div>
                        
                        <div class="flex items-center justify-end pt-2 space-x-3">
                            <button type="button" id="cancelShare" class="px-4 py-2 bg-dark hover:bg-gray-700 text-white rounded-md border border-gray-700 transition-all">
                                Cancel
                            </button>
                            <button type="submit" id="submitShare" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md transition-all btn-hover-effect">
                                <i class="fas fa-share-alt mr-1"></i>
                                Share
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/js/editor.js"></script>
    <script src="./assets/js/share-modal.js"></script>
    <script>
// Share Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const shareButton = document.querySelector('header .btn-hover-effect');
    const shareModal = document.getElementById('shareModal');
    const closeModal = document.getElementById('closeModal');
    const cancelShare = document.getElementById('cancelShare');
    const shareForm = document.getElementById('shareForm');
    const privacySelect = document.getElementById('codePrivacy');
    const passwordContainer = document.getElementById('passwordContainer');
    
    // Editor reference - will be initialized when editor is ready
    let editorInstance;
    let currentLanguage;
    
    // Wait for editor to be fully loaded
    if (typeof monaco !== 'undefined') {
        editorInstance = monaco.editor.getModels()[0];
        initLanguageTracking();
    } else {
        // If monaco is not yet loaded, wait for it
        const checkInterval = setInterval(() => {
            if (typeof monaco !== 'undefined') {
                editorInstance = monaco.editor.getModels()[0];
                initLanguageTracking();
                clearInterval(checkInterval);
            }
        }, 100);
    }
    
    // Track the selected language
    function initLanguageTracking() {
        const languageSelect = document.getElementById('language');
        if (languageSelect) {
            currentLanguage = languageSelect.value;
            languageSelect.addEventListener('change', function() {
                currentLanguage = this.value;
            });
        }
    }

    // Show the modal when share button is clicked
    shareButton.addEventListener('click', function(e) {
        e.preventDefault();
        shareModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Prevent scrolling
    });
    
    // Close the modal when close button is clicked
    closeModal.addEventListener('click', function() {
        shareModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
    
    // Close the modal when cancel button is clicked
    cancelShare.addEventListener('click', function() {
        shareModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
    
    // Close modal when clicking outside the modal content
    shareModal.addEventListener('click', function(e) {
        if (e.target === shareModal || e.target.classList.contains('backdrop-blur-sm')) {
            shareModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
    
    // Toggle password field based on privacy selection
    privacySelect.addEventListener('change', function() {
        if (this.value === 'private') {
            passwordContainer.classList.remove('hidden');
        } else {
            passwordContainer.classList.add('hidden');
        }
    });
    
    // Submit the form
    shareForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData();
        formData.append('title', document.getElementById('codeTitle').value);
        formData.append('description', document.getElementById('codeDescription').value);
        formData.append('privacy', privacySelect.value);
        
        // Get the code from Monaco editor
        if (editorInstance) {
            const code = editorInstance.getValue();
            formData.append('code', code);
        } else {
            alert('Editor not initialized properly. Please try again.');
            return;
        }
        
        // Get the current language
        formData.append('language', currentLanguage || 'javascript');
        
        // Add password if privacy is set to private
        if (privacySelect.value === 'private') {
            const password = document.getElementById('codePassword').value;
            if (!password) {
                alert('Please enter a password for private sharing');
                return;
            }
            formData.append('password', password);
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitShare');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sharing...';
        submitBtn.disabled = true;
        
        // Send the data to the server
        fetch('./server/save_code.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Reset button state
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            
            if (data.success) {
                // Redirect to the view page
                window.location.href = `./code/${data.url}`;
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            // Reset button state
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            
            console.error('Error:', error);
            alert('An error occurred while sharing your code.');
        });
    });
});
                
document.addEventListener('DOMContentLoaded', () => {
    const shareForm = document.getElementById('shareForm');
    const shareModal = document.getElementById('shareModal');
    const submitBtn = document.getElementById('submitBtn');

    if (!shareForm || !shareModal || !submitBtn) {
        console.error('Error: Required elements not found.');
        return;
    }

    shareForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(shareForm);
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = 'Sharing...';
        submitBtn.disabled = true;

        try {
            const response = await fetch('share.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;

            if (data.success) {
                const shareUrl = `${window.location.origin}/view.php?url=${data.url}`;

                // Copy to clipboard
                const tempInput = document.createElement('input');
                tempInput.value = shareUrl;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                alert(`Code shared successfully! The link has been copied to your clipboard: ${shareUrl}`);

                // Close the modal
                shareModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');

                // Clear form
                shareForm.reset();
            } else {
                alert(`Error: ${data.message}`);
            }
        } catch (error) {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            console.error('Error:', error);
            alert('An error occurred while sharing your code.');
        }
    });
});

    </script>
    
    <?php
    include_once("./includes/__footer__.php"); 
    ?>
</body>
</html>