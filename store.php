<?php
include_once("./includes/__header__.php");
include_once("./includes/__navbar__.php");
include_once("./includes/__store--style__.php");

require_once './server/dbcon.php';

$db = new Database();
$conn = $db->connect();

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 8; // Number of snippets per page
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM codes WHERE privacy = 'public' AND (title LIKE :search OR description LIKE :search) LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);
$stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$snippets = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalQuery = "SELECT COUNT(*) FROM codes WHERE privacy = 'public' AND (title LIKE :search OR description LIKE :search)";
$totalStmt = $conn->prepare($totalQuery);
$totalStmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
$totalStmt->execute();
$totalSnippets = $totalStmt->fetchColumn();

$totalPages = ceil($totalSnippets / $limit);
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
            <form id="searchForm" method="GET" action="">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-grow">
                        <input type="text" name="search" placeholder="Search snippets..." class="w-full p-3 bg-dark-lighter text-white rounded-md border border-gray-700 focus:border-primary focus:outline-none transition-all duration-300" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <button type="submit" class="p-3 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Snippets Grid -->
    <div id="snippetsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($snippets as $snippet): ?>
            <div class="snippet-card bg-dark-lighter rounded-lg overflow-hidden border border-gray-800 card-shadow hover-scale animate-slide-up animate-delay-100 cursor-pointer" data-id="<?php echo $snippet['id']; ?>" onclick="window.location.href='code/<?php echo $snippet['url']; ?>'">
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
    
    <?php if ($page < $totalPages): ?>
        <!-- Load More Button -->
        <div class="text-center mt-12 animate-slide-up animate-delay-500">
            <button id="loadMoreBtn" class="px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-md transition-all duration-300 btn-hover-effect" data-page="<?php echo $page + 1; ?>">
                Load More Snippets
            </button>
        </div>
    <?php endif; ?>
</main>

<script>
document.getElementById('loadMoreBtn').addEventListener('click', function() {
    const page = this.getAttribute('data-page');
    const searchQuery = '<?php echo htmlspecialchars($searchQuery); ?>';
    
    fetch(`index.php?page=${page}&search=${searchQuery}`)
        .then(response => response.text())
        .then(data => {
            const parser = new DOMParser();
            const newDocument = parser.parseFromString(data, 'text/html');
            const newSnippets = newDocument.querySelectorAll('#snippetsGrid .snippet-card');
            const snippetsGrid = document.getElementById('snippetsGrid');
            newSnippets.forEach(snippet => {
                snippetsGrid.appendChild(snippet);
            });
            this.setAttribute('data-page', parseInt(page) + 1);
            if (parseInt(page) >= <?php echo $totalPages; ?>) {
                this.style.display = 'none';
            }
        });
});
</script>

<?php
include_once("./includes/__footer__.php"); 
?>