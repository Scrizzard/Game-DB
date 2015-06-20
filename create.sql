DROP DATABASE IF EXISTS Games;
CREATE DATABASE Games;
USE Games;

CREATE TABLE Game (
	gameID INTEGER, 
	title VARCHAR(128) NOT NULL,
	region VARCHAR(32) DEFAULT NULL,
	releaseYear INTEGER NOT NULL,
	coverImage MEDIUMBLOB DEFAULT NULL,
	rating CHAR DEFAULT NULL,
	
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
		REFERENCES Game(gameID),
	FOREIGN KEY (developerID) 
		REFERENCES Developer(developerID)
);

CREATE TABLE PublisherGame(
	gameID INTEGER,
	publisherID INTEGER,
	
	FOREIGN KEY (gameID) 
		REFERENCES Game(gameID),
	FOREIGN KEY (PublisherID) 
		REFERENCES Publisher(publisherID)
);

CREATE TABLE ConsoleGame (
	gameID INTEGER,
	consoleID INTEGER,
	
	FOREIGN KEY (gameID) 
		REFERENCES Game(gameID),
	FOREIGN KEY (consoleID) 
		REFERENCES Console(consoleID)
);

CREATE TABLE GenreGame (
	gameID INTEGER,
	genreID INTEGER,
	
	FOREIGN KEY (gameID) 
		REFERENCES Game(gameID),
	FOREIGN KEY (genreID) 
		REFERENCES Genre(genreID)
);

INSERT INTO Console (consoleName, consoleFirstParty, consoleReleaseYear, isHandheld)
	VALUES ('Xbox', 'Microsoft', '2001', b'0'),
		   ('Xbox 360', 'Microsoft', '2005', b'0'),
		   ('PSP', 'Sony', '2005', b'1'),
		   ('PSX', 'Sony', '1995', b'0'),
		   ('PS2', 'Sony', '2000', b'0'),
		   ('Gameboy', 'Nintendo', '1989', b'1'),
		   ('Gameboy Color', 'Nintendo', '1998', b'1'),
		   ('Gameboy Advance', 'Nintendo', '2001', b'1'),
		   ('DS', 'Nintendo', '2004', b'1'),
		   ('Gamecube', 'Nintendo', '2001', b'0'),
		   ('Wii', 'Nintendo', '2006', b'0'),
		   ('PC', 'N/A', 'N/A', b'0');