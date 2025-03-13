<?php
// Include database connection
require_once './server/dbcon.php';

// Get the URL parameter
$url = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url)) {
    // Redirect to home page if no URL provided
    header('Location: index.html');
    exit;
}

// Initialize database connection
$database = new Database();
$db = $database->connect();

if (!$db) {
    die("Database connection failed");
}

// Get code data
$query = "SELECT * FROM codes WHERE url = :url";
$stmt = $db->prepare($query);
$stmt->bindParam(':url', $url);
$stmt->execute();
$codeData = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if code exists
if (!$codeData) {
    die("Code not found");
}

// Check if code is private
$requirePassword = false;
$passwordCorrect = false;
$passwordAttempted = false;

if ($codeData['privacy'] === 'private') {
    $requirePassword = true;
    
    // Check if password is submitted
    if (isset($_POST['password'])) {
        $passwordAttempted = true;
        
        // Get password from database
        $passwordQuery = "SELECT password FROM code_passwords WHERE code_id = :code_id";
        $passwordStmt = $db->prepare($passwordQuery);
        $passwordStmt->bindParam(':code_id', $codeData['id']);
        $passwordStmt->execute();
        $passwordData = $passwordStmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password
        if ($passwordData && password_verify($_POST['password'], $passwordData['password'])) {
            $passwordCorrect = true;
        }
    }
}

include_once("./includes/__header__.php");
include_once("./includes/__navbar__.php");
?>


    <!-- Main Content -->
    <main class="container mx-auto px-6 pt-28 pb-16">
        <!-- Password Protected View -->
        <div id="password-view" class="max-w-2xl mx-auto bg-dark-lighter rounded-lg border border-gray-700 p-8 card-shadow animate-fade-in <?php if (!$requirePassword || $passwordCorrect) echo 'hidden'; ?>">
            <div class="text-center mb-8">
                <div class="inline-block p-4 bg-dark rounded-full mb-4">
                    <i class="fas fa-lock text-primary text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold mb-2">Password Protected Code</h1>
                <p class="text-gray-400">This code snippet is protected. Please enter the password to view it.</p>
            </div>
            
            <form id="password-form" method="POST" class="space-y-4">
                <div class="relative">
                    <input type="password" id="password-input" name="password" class="w-full p-4 pl-12 bg-dark text-white rounded-md border border-gray-700 focus:outline-none focus:border-primary transition-all duration-300 password-input" placeholder="Enter password" required>
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-key"></i>
                    </div>
                </div>
                
                <?php if ($passwordAttempted && !$passwordCorrect): ?>
                    <div id="password-error" class="text-red-500 text-sm">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Incorrect password. Please try again.
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300 flex items-center justify-center btn-hover-effect">
                    <i class="fas fa-unlock-alt mr-2"></i>
                    Unlock Code
                </button>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>Don't have the password? <a href="snippets.html" class="text-primary hover:underline">Browse public snippets</a></p>
            </div>
        </div>
        
        <!-- Code View -->
        <div id="code-view" class="max-w-4xl mx-auto animate-fade-in <?php if ($requirePassword && !$passwordCorrect) echo 'hidden'; ?>">
            <!-- Code Header -->
            <div class="bg-dark-lighter rounded-t-lg border border-gray-700 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 id="snippet-title" class="text-2xl font-bold mb-1"><?php echo htmlspecialchars($codeData['title']); ?></h1>
                        <p id="snippet-description" class="text-gray-400"><?php echo nl2br(htmlspecialchars($codeData['description'])); ?></p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 bg-dark text-gray-300 text-sm rounded-md flex items-center">
                            <i class="far fa-eye mr-1"></i> 245
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-3 mt-6">
                    <button id="copy-code" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300 flex items-center btn-hover-effect">
                        <i class="far fa-copy mr-2"></i> Copy Code
                    </button>
                </div>
            </div>
            
            <!-- Code Content -->
            <div class="bg-[#282c34] rounded-b-lg border-x border-b border-gray-700 overflow-hidden">
                <div class="code-container p-6">
                    <pre><code id="code-content" class="language-javascript"><?php echo htmlspecialchars($codeData['codes']); ?></code></pre>
                </div>
            </div>
            
            <!-- Snippet Info -->
            <div class="mt-8 bg-dark-lighter rounded-lg border border-gray-700 p-6">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Snippet Information</h2>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-400">
                                <span class="inline-block w-24">Created on:</span>
                                <span class="text-white"><?php echo date('F j, Y', strtotime($codeData['created_at'])); ?></span>
                            </p>
                            <p class="text-gray-400">
                                <span class="inline-block w-24">Visibility:</span>
                                <span class="text-white" id="visibility-badge"><?php echo ucfirst($codeData['privacy']); ?></span>
                            </p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('copy-code').addEventListener('click', () => {
            const code = document.getElementById('code-content').textContent;
            navigator.clipboard.writeText(code).then(() => {
                // Show success message
                const copyBtn = document.getElementById('copy-code');
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Copied!';
                
                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                }, 2000);
            });
        });
    </script>
<?php
include_once("./includes/__footer__.php"); 
?>