<?php
include_once("./server/dbcon.php");

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['share_code'])) {
    $privacy = $_POST['privacy'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $codes = $_POST['codes']; // Get code from POST data
    $language = $_POST['language']; // Get language from POST data
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Debug output - uncomment to see what's being received
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;
    
    // Ensure we have values for required fields
    if (empty($codes)) {
        echo "<script>alert('Error: No code content provided.');</script>";
    } else {
        $db = new Database();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("INSERT INTO codes (privacy, title, description, codes, language) VALUES (:privacy, :title, :description, :codes, :language)");
            $stmt->bindParam(':privacy', $privacy);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':codes', $codes);
            $stmt->bindParam(':language', $language);
            $stmt->execute();

            $code_id = $conn->lastInsertId();

            if ($privacy === 'private' && $password) {
                $stmt = $conn->prepare("INSERT INTO code_passwords (code_id, password) VALUES (:code_id, :password)");
                $stmt->bindParam(':code_id', $code_id);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
            }

            header("Location: ./store");
            exit();
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

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
    <style>
        /* Additional styles to ensure modal works */
        .modal-visible {
            display: flex !important;
        }
    </style>
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
                    <button type="button" onclick="openShareModal()" class="px-4 py-2 rounded-md bg-primary hover:bg-primary-dark transition-colors duration-300 btn-hover-effect">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span class="ml-1">Share</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Share Modal -->
    <div id="shareModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
        <div class="bg-white text-black rounded-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Share Your Code</h2>
            <form action="" method="post" id="shareForm">
                <input type="hidden" name="share_code" value="1">
                
                <div class="mb-4">
                    <label for="privacy" class="block text-sm font-medium text-gray-700">Privacy</label>
                    <select id="privacy" name="privacy" onchange="if(this.value==='private'){document.getElementById('passwordField').style.display='block'}else{document.getElementById('passwordField').style.display='none'}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                        <option value="unlisted">Unlisted</option>
                    </select>
                </div>
                
                <div id="passwordField" style="display: none;" class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" name="title" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm"></textarea>
                </div>
                
                <input type="hidden" id="codes" name="codes">
                <input type="hidden" id="language" name="language">
                
                <div id="debug-info" style="margin-bottom: 16px; padding: 8px; background-color: #f3f4f6; border-radius: 4px; font-size: 0.75rem;">
                    <div>Editor Status: <span id="editor-status">Checking...</span></div>
                    <div>Language: <span id="current-language">Not set</span></div>
                    <div>Code Length: <span id="code-length">0</span> characters</div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeShareModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md">Close</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md">Share</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to open the share modal
        function openShareModal() {
            console.log("Opening share modal");
            
            // Check if editor is accessible
            if (typeof window.editor === 'undefined') {
                document.getElementById('editor-status').textContent = 'Not available';
                alert("Editor is not accessible. Please wait for the editor to load and try again.");
                return;
            }
            
            // Get editor content
            const editorContent = window.editor.getValue();
            document.getElementById('codes').value = editorContent;
            document.getElementById('code-length').textContent = editorContent.length;
            document.getElementById('editor-status').textContent = 'Available';
            
            // Get current language
            const languageSelect = document.getElementById('language-select');
            let currentLanguage = "javascript"; // Default
            
            if (languageSelect) {
                currentLanguage = languageSelect.value;
                document.getElementById('current-language').textContent = currentLanguage;
            } else {
                document.getElementById('current-language').textContent = currentLanguage + ' (default)';
            }
            
            document.getElementById('language').value = currentLanguage;
            
            // Show the modal
            document.getElementById('shareModal').style.display = 'flex';
            
            console.log("Modal opened with code length: " + editorContent.length);
            console.log("Current language: " + currentLanguage);
        }
        
        // Function to close the share modal
        function closeShareModal() {
            document.getElementById('shareModal').style.display = 'none';
        }
        
        // Form submission handler
        document.getElementById('shareForm').addEventListener('submit', function(event) {
            // Get the latest editor content
            if (typeof window.editor !== 'undefined') {
                const freshContent = window.editor.getValue();
                document.getElementById('codes').value = freshContent;
                document.getElementById('code-length').textContent = freshContent.length;
                
                // Validate
                if (!freshContent || freshContent.length === 0) {
                    alert("Error: No code to share. Please write some code first.");
                    event.preventDefault();
                    return false;
                }
            } else {
                alert("Error: Editor not accessible. Please try again.");
                event.preventDefault();
                return false;
            }
            
            return true;
        });
        
        // Check if editor is available on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM loaded, checking for editor");
            
            const checkEditor = setInterval(function() {
                if (typeof window.editor !== 'undefined') {
                    console.log("Editor is now available for sharing");
                    clearInterval(checkEditor);
                }
            }, 1000);
        });
    </script>
</body>
</html>