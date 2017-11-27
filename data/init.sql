CREATE TABLE inglisttable (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(50) NOT NULL,
	guest1 VARCHAR(50),
    guest2 VARCHAR(50),
    guest3 VARCHAR(50),
	date TIMESTAMP
);


/*CREATE TABLE rsvpd (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(50) NOT NULL,
    food VARCHAR(50),
    age VARCHAR(50),
	guest1 VARCHAR(50),
    guest1food VARCHAR(50),
    guest1age VARCHAR(50),
    guest2 VARCHAR(50),
    guest2food VARCHAR(50),
    guest2age VARCHAR(50),
    guest3 VARCHAR(50),
    guest3food VARCHAR(50),
    guest3age VARCHAR(50),
    comments VARCHAR(200),
	date TIMESTAMP
);*/