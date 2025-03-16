-- Codes table
CREATE TABLE codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    privacy ENUM('public', 'private', 'unlisted') NOT NULL DEFAULT 'private',
    title VARCHAR(255) NOT NULL,
    description TEXT,
    codes LONGTEXT NOT NULL,
    language VARCHAR(50) NOT NULL,
    url VARCHAR(20) UNIQUE NOT NULL DEFAULT (SUBSTRING(MD5(RAND()), 1, 10)),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Password table
CREATE TABLE code_passwords (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code_id INT NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (code_id) REFERENCES codes(id) ON DELETE CASCADE
);


-- Views table
CREATE TABLE views (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code_id INT NOT NULL,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (code_id) REFERENCES some_table(id) ON DELETE CASCADE
);


-- Code copies table
CREATE TABLE copy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code_id INT NOT NULL,
    copied INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (code_id) REFERENCES some_table(id) ON DELETE CASCADE
);
