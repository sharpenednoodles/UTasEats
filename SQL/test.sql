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
CREATE TABLE masterFoodList (
	itemID int unsigned not null auto_increment,
	name varchar(32) not null,
	price decimal(4,2) not null,
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
CREATE TABLE item_to_cafe (
	itemID int unsigned not null,
	cafeID tinyint unsigned not null,
	index(itemID),
	index(cafeID),
	foreign key (itemID) REFERENCES masterFoodList(itemID) on delete cascade,
	foreign key (cafeID) REFERENCES cafe(cafeID)
) ENGINE=InnoDB;

-- Fill in with some sample data
INSERT INTO masterFoodList(name, price, description, type) VALUES('Coffee', 4, 'A standard crappy coffee', '2');
INSERT INTO item_to_cafe VALUES (1, 1);
INSERT INTO item_to_cafe VALUES (1, 2);
INSERT INTO item_to_cafe VALUES (1, 3);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Lazenbys Sample Item 1', 4, 'Sample Lazenbys food', '1');
INSERT INTO item_to_cafe VALUES (2, 1);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Suzy Lee Sample Item 1', 9.5, 'Sample Suzy lee food', '1');
INSERT INTO item_to_cafe VALUES (3, 2);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Trade Table Sample Item 2', 3.2, 'Sample trade table drink', '2');
INSERT INTO item_to_cafe VALUES (4, 3);

-- User Account types
CREATE TABLE accountType (
	ID smallint unsigned not null auto_increment,
	accountType varchar(20),
	accessCode char(2) not null,
	primary key(ID)
) ENGINE=InnoDB;
-- Populate account types - align to res/php/userAccessLevel.php enum values
INSERT INTO accountType(accountType, accessCode) VALUES ('Board Director', 'DB');
INSERT INTO accountType(accountType, accessCode) VALUES ('Board Member', 'BM');
INSERT INTO accountType(accountType, accessCode) VALUES ('Cafe Manager', 'CM');
INSERT INTO accountType(accountType, accessCode) VALUES ('Cafe Staff', 'CS');
INSERT INTO accountType(accountType, accessCode) VALUES ('User Staff', 'UE');
INSERT INTO accountType(accountType, accessCode) VALUES ('User Student', 'US');

-- User Information table
-- TODO remove duplication between userName and accountNum fields
CREATE TABLE users (
	ID int unsigned not null auto_increment,
	-- Not full username, just the numbers
	username varchar(8) not null,
	password varchar(255) not null,
	email varchar(255) not null,
	activeAccount boolean not null default true,
	-- foreign key for account types
	accountTypeKey smallint unsigned not null,
	idNumber varchar(6),
	firstName varchar(20),
	lastName varchar(20),
	gender varchar(12) not null,
	-- Credit card information
	CCnumber varchar(20),
	CCName varchar(32),
	CCCVC varchar(3),
	CCExpDate varchar(7),
	accountBalance decimal(6,2),
	-- for cafe employees only
	cafeEmployement tinyint unsigned,
	creationTimeStamp datetime not null,
	primary key (ID),
	index (accountTypeKey),
	index(cafeEmployement),
	foreign key(accountTypeKey) REFERENCES accountType(ID),
	foreign key(cafeEmployement) REFERENCES cafe(cafeID)
) ENGINE=InnoDB;

-- User sample data
INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber, creationTimeStamp, accountBalance, gender, email) VALUES (
	'DB6969',
	-- password in plaintext = theGame1!
	'$2y$10$zhkg2E0eHHSnS0JhqGnMDeZekqgKcwpgEIz7z1peUUDnhfK1pvnZK',
	1,
	'John',
	'Smith',
	'4809257503491111',
	'MR JOHN SMITH',
	'599',
	'04/26',
	'123456',
	now(),
	999.99,
	'male',
	'johnsmith@gmail.com'
);
