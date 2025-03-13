<?php
// Include database connection
require_once 'dbcon.php';

// Set headers for JSON response
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get form data
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$privacy = $_POST['privacy'] ?? 'private';
$code = $_POST['code'] ?? '';
$language = $_POST['language'] ?? 'javascript';
$password = $_POST['password'] ?? '';

// Validate required fields
if (empty($title) || empty($code)) {
    echo json_encode(['success' => false, 'message' => 'Title and code are required']);
    exit;
}

// Validate privacy setting
if (!in_array($privacy, ['public', 'private', 'unlisted'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid privacy setting']);
    exit;
}

// Validate password if privacy is set to private
if ($privacy === 'private' && empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Password is required for private sharing']);
    exit;
}

try {
    // Initialize database connection
    $database = new Database();
    $db = $database->connect();
    
    if (!$db) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }
    
    // Begin transaction
    $db->beginTransaction();
    
    // Insert code data
    $insertCodeQuery = "INSERT INTO codes (title, description, privacy, codes, language) 
                        VALUES (:title, :description, :privacy, :codes, :language)";
    
    $codeStmt = $db->prepare($insertCodeQuery);
    $codeStmt->bindParam(':title', $title);
    $codeStmt->bindParam(':description', $description);
    $codeStmt->bindParam(':privacy', $privacy);
    $codeStmt->bindParam(':codes', $code);
    $codeStmt->bindParam(':language', $language);
    
    if (!$codeStmt->execute()) {
        throw new Exception("Failed to save code");
    }
    
    // Get the inserted code's ID
    $codeId = $db->lastInsertId();
    
    // Get the generated URL
    $urlQuery = "SELECT url FROM codes WHERE id = :id";
    $urlStmt = $db->prepare($urlQuery);
    $urlStmt->bindParam(':id', $codeId);
    $urlStmt->execute();
    $urlResult = $urlStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$urlResult) {
        throw new Exception("Failed to retrieve URL");
    }
    
    $url = $urlResult['url'];
    
    // If privacy is private, insert password
    if ($privacy === 'private') {
        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $insertPasswordQuery = "INSERT INTO code_passwords (code_id, password) 
                                VALUES (:code_id, :password)";
        
        $passwordStmt = $db->prepare($insertPasswordQuery);
        $passwordStmt->bindParam(':code_id', $codeId);
        $passwordStmt->bindParam(':password', $hashedPassword);
        
        if (!$passwordStmt->execute()) {
            throw new Exception("Failed to save password");
        }
    }
    
    // Commit transaction
    $db->commit();
    
    // Return success response with URL
    echo json_encode([
        'success' => true,
        'message' => 'Code saved successfully',
        'url' => $url
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($db)) {
        $db->rollBack();
    }
    
    // Return error response
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>