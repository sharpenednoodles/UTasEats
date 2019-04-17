-- Test SQL File to populate DB with basic data

-- Database component, not valid for Assignment on Alacritas
DROP DATABASE IF EXISTS UTasEats;
CREATE DATABASE UTasEats;
USE UTasEats;

-- Cafe table - for storing the different cafes, and various information about them
CREATE TABLE cafe (
	cafeID tinyint unsigned not null auto_increment,
	name varchar(20) not null,
	description TEXT,
	openTime TIME not null,
	closeTime TIME not null,
	primary key (cafeID)
) ENGINE=InnoDB;

-- Insert our default cafe data
INSERT INTO cafe (name, description, openTime, closeTime) VALUES (
	'Lazenbys',
	'Overpriced food for everyone. Don\'t listen to us, see for yourself.',
	'09:00:00',
	'16:00:00'
);

INSERT INTO cafe (name, description, openTime, closeTime) VALUES (
	'Suzy Lee',
	'If you like tasty asian food, don\'t come here. Spices not included.',
	'09:00:00',
	'16:00:00'
);

INSERT INTO cafe (name, description, openTime, closeTime) VALUES (
	'Trade Table',
	'Grab a coffee from the Trade Table. The best baristas on campus. Guaranteed.',
	'09:00:00',
	'16:00:00'
);

-- Master list data
-- Food types
CREATE TABLE foodType (
	typeID tinyint unsigned not null auto_increment,
	name varchar(10) not null,
	primary key (typeID)
) ENGINE=InnoDB;

INSERT INTO foodType (name) VALUES('Food');
INSERT INTO foodType (name) VALUES('Drink');

-- masterfood list
CREATE TABLE masterfoodlist (
	itemID smallint unsigned not null auto_increment,
	name varchar(32) not null,
	price varchar(5) not null,
	description TEXT,
	type tinyint unsigned not null,
	-- dates stored as yyyy-mm-dd type
	startDate DATE,
	endDate DATE,
	primary key (itemID),
	index(type),
	foreign key (type) REFERENCES foodType(typeID)
) ENGINE=InnoDB;

-- DB to link cafe availabilities to food items
CREATE TABLE foodCafes (
	itemID smallint unsigned not null,
	cafeID tinyint unsigned not null,
	index(itemID),
	index(cafeID),
	foreign key (itemID) REFERENCES masterfoodlist(itemID),
	foreign key (cafeID) REFERENCES cafe(cafeID)
) ENGINE=InnoDB;

-- Fill in with some sample data
INSERT INTO masterfoodlist(name, price, description, type) VALUES('Coffee', '4', 'A standard crappy coffee', '2');
INSERT INTO foodCafes VALUES (1, 1);
INSERT INTO foodCafes VALUES (1, 2);
INSERT INTO foodCafes VALUES (1, 3);

INSERT INTO masterfoodlist(name, price, description, type) VALUES('Lazenbys Sample Item 1', '4', 'Sample Lazenbys food', '1');
INSERT INTO foodCafes VALUES (2, 1);

INSERT INTO masterfoodlist(name, price, description, type) VALUES('Suzy Lee Sample Item 1', '9.5', 'Sample Suzy lee food', '1');
INSERT INTO foodCafes VALUES (3, 2);

INSERT INTO masterfoodlist(name, price, description, type) VALUES('Trade Table Sample Item 2', '3.2', 'Sample trade table drink', '2');
INSERT INTO foodCafes VALUES (4, 3);

-- User Account types
CREATE TABLE accountType (
	ID smallint unsigned not null auto_increment,
	accountType varchar(20),
	primary key(ID)
) ENGINE=InnoDB;
-- Populate account types - align to res/php/userAccessLevel.php enum values
INSERT INTO accountType(accountType) VALUES ('Board Director');
INSERT INTO accountType(accountType) VALUES ('Board Member');
INSERT INTO accountType(accountType) VALUES ('Cafe Manager');
INSERT INTO accountType(accountType) VALUES ('Cafe Staff');
INSERT INTO accountType(accountType) VALUES ('User Staff');
INSERT INTO accountType(accountType) VALUES ('User Student');

-- User Information table
CREATE TABLE users (
	ID smallint unsigned not null auto_increment,
	username varchar(8) not null,
	password varchar(12) not null,
	passwordHash varchar(40),
	-- foreign key for account types
	accountTypeKey smallint unsigned not null,
	idNumber varchar(6),
	firstName varchar(20),
	lastName varchar(20),
	-- Credit card information
	CCnumber varchar(20),
	CCName varchar(32),
	CCCVC varchar(3),
	CCExpDate varchar(7),
	primary key (ID),
	index (accountTypeKey),
	foreign key(accountTypeKey) REFERENCES accountType(ID)
) ENGINE=InnoDB;

-- User sample data
INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber) VALUES (
	'DB6969',
	'theGame1!',
	1,
	'John',
	'Smith',
	'4809257503491111',
	'Mr John Smith',
	'599',
	'04/2026',
	'123456'
);
