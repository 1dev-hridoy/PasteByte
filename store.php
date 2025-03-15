<?php
include_once("./includes/__header__.php");
include_once("./includes/__navbar__.php");
include_once("./includes/__store--style__.php");

require_once './server/dbcon.php';

$db = new Database();
$conn = $db->connect();

$query = "SELECT * FROM codes WHERE privacy = 'public'";
$stmt = $conn->prepare($query);
$stmt->execute();
$snippets = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <button class="p-3 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300">
                    Search
                </button>
            </div>
        </div>
    </div>
    
    <!-- Snippets Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($snippets as $snippet): ?>
            <div class="snippet-card bg-dark-lighter rounded-lg overflow-hidden border border-gray-800 card-shadow hover-scale animate-slide-up animate-delay-100 cursor-pointer" data-id="<?php echo $snippet['id']; ?>">
                <div class="relative">
                    <div class="code-preview p-4 bg-[#282c34]">
                        <pre><code class="language-<?php echo $snippet['language']; ?>"><?php echo htmlspecialchars($snippet['codes']); ?></code></pre>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-semibold mb-2 text-white"><?php echo htmlspecialchars($snippet['title']); ?></h3>
                    <p class="text-gray-400 text-sm mb-3"><?php echo htmlspecialchars($snippet['description']); ?></p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">Added <?php echo date('F j, Y', strtotime($snippet['created_at'])); ?></span>
                        <div class="flex space-x-2">
                            <span class="text-primary"><i class="far fa-eye"></i> 245</span>
                            <span class="text-primary"><i class="far fa-copy"></i> 78</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Load More Button -->
    <div class="text-center mt-12 animate-slide-up animate-delay-500">
        <button class="px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300 btn-hover-effect">
            Load More Snippets
        </button>
    </div>
</main>

<?php
include_once("./includes/__footer__.php"); 
?>