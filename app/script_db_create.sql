/*DROP TABLE decks;
DROP TABLE stacks;
DROP TABLE lobbies;
DROP TABLE games;
DROP TABLE cards;
DROP TABLE users;
DROP TABLE menus;
*/

CREATE TABLE users (     
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,     
	login VARCHAR(30),       
	pwd VARCHAR(30)
);

CREATE TABLE cards (     
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	s1 INT UNSIGNED,
	s2 INT UNSIGNED,
	s3 INT UNSIGNED,
	s4 INT UNSIGNED,
	s5 INT UNSIGNED,
	s6 INT UNSIGNED,
	s7 INT UNSIGNED,
	s8 INT UNSIGNED
);

CREATE TABLE games (     
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(30),  
	nbJoueur INT UNSIGNED DEFAULT 1,
	nbJoueurMax INT UNSIGNED DEFAULT 4,
	status INT,
	id_creator INT UNSIGNED,
	FOREIGN KEY (id_creator) REFERENCES users(id)
);

CREATE TABLE lobbies (     
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_user INT UNSIGNED,
	id_game INT UNSIGNED,
	FOREIGN KEY (id_user) REFERENCES users(id),
	FOREIGN KEY (id_game) REFERENCES games(id)
);

CREATE TABLE stacks (     
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	ordre INT,
	id_card INT UNSIGNED,
	id_game INT UNSIGNED,
	FOREIGN KEY (id_card) REFERENCES cards(id),
	FOREIGN KEY (id_game) REFERENCES games(id)
);

CREATE TABLE decks (     
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	ordre INT,
	id_user INT UNSIGNED,
	id_stack INT UNSIGNED,
	FOREIGN KEY (id_user) REFERENCES users(id),
	FOREIGN KEY (id_stack) REFERENCES stacks(id)
);

CREATE TABLE menus (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255), 
	controller VARCHAR(255), 
	action VARCHAR(255) 
);
