CREATE TABLE users (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	guest1 VARCHAR(50),
    guest2 VARCHAR(50),
    guest3 VARCHAR(50),
	date TIMESTAMP
);