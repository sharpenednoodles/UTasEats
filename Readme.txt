This is a snippet of the full readme, which is stored as readme.md

### Important Notes
* Since Alacritas is locked down, you won't be able to upload new user profile images from the websites profile page. The uploading functions still work on servers with less restrictions.
* Database related files are stored in /res/db if changing connection variables is required
* The project contains a file called test.SQL
 * This file can be used to recreate the database if required
 * The website makes use of 8 different tables, see test.sql for details
 * The website has been designed as a platform, ie it should be trivial to add additional cafes, such as The Pickled Pear. (this did introduce some design complexities database wise)

* The entire website has been built with mobile devices in mind, and as such will scale correctly to all screen sizes, repositioning cards and other elements as needed
* All management options can be access through the users profile page. This can be accessed by clicking on the users name in the navbar
* Changing a users account permissions will change the first 2 letter of their user ID to match their new permission level

### Included Accounts
By default there are multiple accounts included by default with various permission levels

| UserID | Password  | Role           |
| -------|-----------|----------------|
| DB6969 | theGame1! | Board Director |
| BM4988 | theGame1! | Board Member   |
| CM8023 | theGame1! | Café Manager(L)|
| CS4021 | theGame1! | Café Staff(SL) |
| UE9248 | theGame1! | UTAS Staff     |
| US1963 | theGame1! | UTAS Student   |

Registering a new account will generate a new userID, which will be displayed to you on creation


### Credit Card details
By default, registering a new user requires a LUHN valid MasterCard, AMEX or Visa card number. CVC and CC Expiry are only validated to ensure they meet the required formats.

Here are some LUHN valid credit card numbers you can use during registration
* 4485544390208521
* 5410540238471005
* 5170721703057160
* 4716789546870028
* 372036717234987

### File Structure
* /					General PHP page files
* /css 			CSS files
* /js				JS files (third party scripts in third party folder)
* /res/db 	Database related files
* /res/html HTML page elements
* /res/img  Image files
* /res/php  Php helper files, and page elements. See individual files for Details
* /SQL      SQL files to reset the contents of the database
* /uploads  User site uploaded images are stored here (Uploading doesn't work on Alacritas sadly)
