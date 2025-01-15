CREATE TABLE demandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('enseignant') DEFAULT 'enseignant',
    date_demande TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
