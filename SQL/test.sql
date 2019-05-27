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
	imagePath varchar(255),
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

INSERT INTO masterFoodList(name, price, description, type) VALUES('Shepards Pie', 12, 'Tasty potato pie', '1');
INSERT INTO item_to_cafe VALUES (2, 1);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Sushi', 9.5, 'Single Sushi Roll', '1');
INSERT INTO item_to_cafe VALUES (3, 2);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Butter Beer', 3.2, 'You will make a fine beater Harry', '2');
INSERT INTO item_to_cafe VALUES (4, 3);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Sandwich', 7.5, 'Fresh sandwiches from last week', '1');
INSERT INTO item_to_cafe VALUES (5, 1);
INSERT INTO item_to_cafe VALUES (5, 2);
INSERT INTO item_to_cafe VALUES (5, 3);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Yoo Mhom Ghey', 20, 'Traditional Thai Dish', '1');
INSERT INTO item_to_cafe VALUES (6, 2);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Chocolate Bar', 5.5, 'Overpriced Cadbury bar', '1');
INSERT INTO item_to_cafe VALUES (7, 1);
INSERT INTO item_to_cafe VALUES (7, 2);
INSERT INTO item_to_cafe VALUES (7, 3);

INSERT INTO masterFoodList(name, price, description, type) VALUES('Fiji Water', 10, 'Tap water filled straight into old Fiji water bottles', '2');
INSERT INTO item_to_cafe VALUES (8, 1);
INSERT INTO item_to_cafe VALUES (8, 2);
INSERT INTO item_to_cafe VALUES (8, 3);

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
INSERT INTO accountType(accountType, accessCode) VALUES ('UTAS Staff', 'UE');
INSERT INTO accountType(accountType, accessCode) VALUES ('UTAS Student', 'US');

-- User Information table
-- TODO remove duplication between userName and accountNum fields
CREATE TABLE users (
	ID int unsigned not null auto_increment,
	-- Not full username, just the numbers
	username varchar(8) not null,
	password varchar(255) not null,
	email varchar(255) not null,
	activeAccount boolean not null default true,
	imagePath varchar(255) default "res/img/defaultProfile.png",
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
	accountBalance decimal(8,2),
	-- for cafe employees only
	cafeEmployment tinyint unsigned default 1,
	creationTimeStamp datetime not null,
	primary key (ID),
	index (accountTypeKey),
	index(cafeEmployment),
	foreign key(accountTypeKey) REFERENCES accountType(ID),
	foreign key(cafeEmployment) REFERENCES cafe(cafeID)
) ENGINE=InnoDB;

-- User sample data
INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber, creationTimeStamp, accountBalance, gender, email, imagePath) VALUES (
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
	'johnsmith@gmail.com',
	'uploads/profileIMG/portrait-of-john-smith.jpg'
);

INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber, creationTimeStamp, accountBalance, gender, email, imagePath) VALUES (
	'BM4988',
	-- password in plaintext = theGame1!
	'$2y$10$offpxId36YBNdXdlZ3443es3ZEpf9EWyFIAVr0hu9eMTgfE446Wla',
	2,
	'Varg',
	'Vikernes',
	'4077804759336493',
	'MR VARG VIKERNES',
	'666',
	'06/66',
	'666',
	now(),
	0.00,
	'male',
	'ikilledeuronymous@yahoo.com',
	'uploads/profileIMG/varg.jpg'
);

INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber, creationTimeStamp, accountBalance, gender, email, imagePath) VALUES (
	'CM8023',
	-- password in plaintext = theGame1!
	'$2y$10$3Az1vwN1Pc9yDDkEV7q7c.RiDH.lLCfiKnBbCrecjqK0hMD9QVJ3q',
	3,
	'Jim',
	'Pickens',
	'5123840312092067',
	'MR JIM PICKENS',
	'234',
	'06/23',
	'888888',
	now(),
	50.00,
	'male',
	'jimpickens@hotmail.com',
	'uploads/profileIMG/jim-pickens.jpg'
);

INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber, creationTimeStamp, accountBalance, gender, email, imagePath, cafeEmployment) VALUES (
	'CS4021',
	-- password in plaintext = theGame1!
	'$2y$10$Ekz18PeQnDZ/soe4i8HTWurj5tjjlNqRjpyAN9r9KhIJVp2WUSG6a',
	4,
	'Mark',
	'Corrigan',
	'4070397998697590',
	'MR MARK CORRIGAN',
	'123',
	'06/17',
	'123445',
	now(),
	69.00,
	'male',
	'chancewouldbeafinething@gmail.com',
	'uploads/profileIMG/mark.jpg',
	2
);

INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber, creationTimeStamp, accountBalance, gender, email, imagePath) VALUES (
	'UE9248',
	-- password in plaintext = theGame1!
	'$2y$10$B3iPjB0D3ys0mtZXX/nUfOMyjMZF4Q2kkD/ysp./xusibXtOxtABW',
	5,
	'Rolf',
	'Harris',
	'5496261213228586',
	'MR ROLF HARRIS',
	'321',
	'06/27',
	'678234',
	now(),
	666.00,
	'male',
	'iamnotapedo@gmail.com',
	'uploads/profileIMG/rolf.jpg'
);

INSERT INTO users (username, password, accountTypeKey, firstName, lastName, CCnumber, CCName, CCCVC, CCExpDate, idNumber, creationTimeStamp, accountBalance, gender, email, imagePath) VALUES (
	'US1963',
	-- password in plaintext = theGame1!
	'$2y$10$YQkh0BLCSmO5toOC.pwIoeicIILjYkakxz3Gn0iP7ffjiWTQt3MOW',
	6,
	'Bryce',
	'Andrews',
	'5306934644468423',
	'MR BRYCE ANDREWS',
	'214',
	'06/17',
	'204552',
	now(),
	00.00,
	'male',
	'brycea@utas.edu.au',
	'uploads/profileIMG/ic_face.png'
);

-- Store order data
CREATE TABLE orderList (
	ID int unsigned not null auto_increment,
	userID int unsigned,
	price decimal(6, 2),
	cafeID tinyint unsigned not null,
	pickupTime TIME not null,
	orderNotes TEXT,
	paid boolean default 0,
	orderCompleted boolean default 0,
	orderPickedUp boolean default 0,
	orderDelivered boolean default 0,
	creationTimeStamp timestamp not null default current_timestamp,
	primary key(ID),
	index(userID),
	index(cafeID),
	foreign key(userID) REFERENCES users(ID),
	foreign key(cafeID) REFERENCES cafe(cafeID)
) ENGINE=InnoDB;

-- Pivot table to store items within the order
CREATE TABLE item_to_order (
	orderID int unsigned not null,
	itemID int unsigned not null,
	quantity int unsigned,
	index(orderID),
	index(itemID),
	foreign key(orderID) REFERENCES orderList(ID) on delete cascade,
	foreign key(itemID) REFERENCES masterFoodList(itemID) on delete cascade
) ENGINE=InnoDB;
