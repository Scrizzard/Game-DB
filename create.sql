DROP DATABASE IF EXISTS Games;
CREATE DATABASE Games;
USE Games;

CREATE TABLE Game (
	gameID INTEGER, 
	title VARCHAR(128) NOT NULL,
	region VARCHAR(32) DEFAULT NULL,
	releaseYear INTEGER NOT NULL,
	coverImage MEDIUMBLOB DEFAULT NULL,
	imageType VARCHAR(16) DEFAULT NULL,
	rating CHAR DEFAULT NULL,
	dateAdded DATE NOT NULL,
	
	PRIMARY KEY Game(gameID)
);

CREATE TABLE Genre (
	genreID INTEGER AUTO_INCREMENT,
	genreName VARCHAR(128) UNIQUE NOT NULL,
	
	PRIMARY KEY Genre(genreID)
);

CREATE TABLE Console (
	consoleID INTEGER AUTO_INCREMENT,
	consoleName VARCHAR(128) NOT NULL,
	consoleFirstParty VARCHAR(128) NOT NULL,
	consoleReleaseYear INTEGER NOT NULL,
	isHandheld BIT(1),
	
	PRIMARY KEY Console(consoleID)
); 

CREATE TABLE Developer (
	developerID INTEGER AUTO_INCREMENT,
	developerName VARCHAR(128) UNIQUE NOT NULL,
	
	PRIMARY KEY Developer(developerID)
);

CREATE TABLE Publisher(
	publisherID INTEGER AUTO_INCREMENT,
	publisherName VARCHAR(128) UNIQUE NOT NULL,
	
	PRIMARY KEY Publisher(publisherID)
);

CREATE TABLE DeveloperGame(
	gameID INTEGER,
	developerID INTEGER,
	
	FOREIGN KEY (gameID) 
		REFERENCES Game(gameID)
		ON DELETE CASCADE,
	FOREIGN KEY (developerID) 
		REFERENCES Developer(developerID)
		ON DELETE CASCADE
);

CREATE TABLE PublisherGame(
	gameID INTEGER,
	publisherID INTEGER,
	
	FOREIGN KEY (gameID) 
		REFERENCES Game(gameID)
		ON DELETE CASCADE,
	FOREIGN KEY (PublisherID) 
		REFERENCES Publisher(publisherID)
		ON DELETE CASCADE
);

CREATE TABLE ConsoleGame (
	gameID INTEGER,
	consoleID INTEGER,
	
	FOREIGN KEY (gameID) 
		REFERENCES Game(gameID)
		ON DELETE CASCADE,
	FOREIGN KEY (consoleID) 
		REFERENCES Console(consoleID)
		ON DELETE CASCADE
);

CREATE TABLE GenreGame (
	gameID INTEGER,
	genreID INTEGER,
	
	FOREIGN KEY (gameID) 
		REFERENCES Game(gameID)
		ON DELETE CASCADE,
	FOREIGN KEY (genreID) 
		REFERENCES Genre(genreID)
		ON DELETE CASCADE
);

INSERT INTO Console (consoleID, consoleName, consoleFirstParty, consoleReleaseYear, isHandheld)
	VALUES (1, 'Xbox', 'Microsoft', '2001', b'0'),
		   (2, 'Xbox 360', 'Microsoft', '2005', b'0'),
		   (3, 'PSP', 'Sony', '2005', b'1'),
		   (4, 'PSX', 'Sony', '1995', b'0'),
		   (5, 'PS2', 'Sony', '2000', b'0'),
		   (6, 'Gameboy', 'Nintendo', '1989', b'1'),
		   (7, 'Gameboy Color', 'Nintendo', '1998', b'1'),
		   (8, 'Gameboy Advance', 'Nintendo', '2001', b'1'),
		   (9, 'DS', 'Nintendo', '2004', b'1'),
		   (10, 'Gamecube', 'Nintendo', '2001', b'0'),
		   (11, 'Wii', 'Nintendo', '2006', b'0'),
		   (12, 'PC', 'N/A', 'N/A', b'0');

INSERT INTO Game (gameId, title, region, releaseYear, rating, dateAdded)
VALUES (1, 'Dark Souls', 'US', 2011, 'M', '2015-6-20'),
	   (2, 'Final Fantasy Tactics: The War of the Lions', 'NA', 2007, 'T', '2015-6-20'),
	   (3, 'Robin Hood: The Legend of Sherwood', 'NA', 2002, 'T', '2015-6-20'),
	   (4, 'Dragon Warrior Monsters', 'NA', 2000, 'E', '2015-6-20'),
	   (5, 'Advance Wars', 'NA', 2001, 'E', '2015-6-20'),
	   (6, 'Hotel Dusk Room 215', 'NA', 2007, 'T', '2015-6-20'),
	   (7, 'Bond 007: Nightfire', 2002, 'NA', 'T', '2015-6-20'),
	   (8, 'Trauma Center: Second Opinion', 'NA', 2006, 'T', '2015-6-20'),
	   (9, "Raze's Hell", 'NA', 2005, 'T', '2015-6-20'),
	   (10, 'Chromehounds', 'NA', 2006, 'T', '2015-6-20'),
	   (11, 'Legend of Dragoon', 'NA', 2000, 'T', '2015-6-20'),
	   (12, 'Katamari Damacy', 'NA', 2004, 'E', '2015-6-20'),
	   (13, 'Year Walk', 'NA', 2004, 'T', '2015-6-20');
	   
INSERT INTO ConsoleGame (gameID, consoleID)
VALUES (1, 2),
	   (2, 3),
	   (3, 12),
	   (4, 7),
	   (5, 8),
	   (6, 9),
	   (7, 10),
	   (8, 11),
	   (9, 1),
	   (10, 2),
	   (11, 4),
	   (12, 5),
	   (13, 12);