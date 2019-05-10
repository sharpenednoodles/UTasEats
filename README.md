# UTAS Eats

A home for my KIT202 Assignment, UTASEats - a platform to bring Uber Eats like convenience to our on campus cafes.

## For The Marker
This information has also been conveniently included within a seperate readme.txt file if you can't be bothered with markdown.

### Included Accounts
By default there are multiple accounts included by default with various permission levels

| UserID | Password | Role |
| -------|----------|-------|
| DB6969   | theGame1!   | Board Director |
| US4903 | theGame1!     | UTas Student |
| UE3495 | theGame1!     | UTas Staff |

### Credit Card details
By default, registering a new user requires a valid MasterCard, AMEX or Visa card number. CVC and CC Expiry are only validated to ensure they meet the required formats.

Here are some LUHN valid credit card numbers for you to use during registration
* 4485544390208521
* 5410540238471005
*


## Getting Started
UTAS Eats has been designed based upon the specifications for the KIT202 Secure Web Assignment 2019. Despite the name, the unit is neither secure, nor focused on modern web technologies.
### Prerequisites

```
- Apache or an equivalent server with:
	- PHP
	- MySQLi plugin
	- MySQL Server
```

### Installing

See the documentation for your server platform of choice.

Once you have a functioning Web Server with PHP and MySQL functionality:
```
- Clone the repo into your active server directory
- Try not to cry
- Cry a lot
```

## Assignment Specifications
Y.E.O.M. Pty. Ltd. has bought out Lazenbys, The Ref and The Trade Table at University of Tasmania
(UTAS).

In discussion with the staff and students at UTAS, it was discovered that the biggest
complaint was having to wait in long queues during peak times when they have just a short time to
get a meal or beverage.

To address this issue, it has been decided to develop a web site where food and drink can be pre-
ordered and pre-paid so that clients can quickly collect their meals.

### Details
Each café will have its own menu displayed by the system.
There will be a "Master List of Food & Beverages". This list will contain the ONLY items that may
appear on a menu.

Each café manager will be responsible for selecting items from the "Master List of Food & Beverages"
that will appear on their cafes menu (i.e. the manager for The Ref can select items to appear on the
menu for The Ref, but NOT for Lazenbys or The Trade Table menus).

The Director of The Board will be responsible for security access for the Board Members.

The Board Members of Y.E.O.M.
* Will control what will be available at the UT as cafes, so will be the only people who can create
and modify the master list of food and drinks.
* Will be responsible for employment and security access at the cafes.

Each café will have at least 2 staff members (numbers are determined by a Board Member), one of
whom will be assigned (by a Board Member) to be that cafes manager. Staff and managers can be
rostered to work at any café, but there can be only one manager at each café at a time.

To use the online menu system, UTAS staff and students must first register by providing their Name,
Student/Staff ID, E-mail address, mobile phone number, credit card details and password.

After registering, an e-mail will be sent to the users e-mail that contains a link that is used to confirm
registration (for the purposes of testing you should use your own e-mail account).

Payment for menu items will come from a pre-paid account. All users will have an account created
at registration that they must deposit funds into to purchase items from a menu (i.e. like the caps
printing system).

When ordering from a menu, users will be able to add comments to any item ordered. This will be
to specify any item specifics e.g. if ordering coffee, a description of the type of coffee may be supplied
such as "large soy latte +3 sugars".

Each menu is for the following day.

### User ID Ranges:
| User Type | User Code Format |
| ------------- |------------: |
| Director of the Board   | DBnnnn   |
| Board Members   | BMnnnn   |
| Café managers   | CMnnnn   |
| Café staff   | CSnnnn  |
| UTAS Employees   | UEnnnn  |
| UTAS Students | USnnnn  |

### Description of Task - Part 1 (15%)
#### Home page
This is the starting / entry point to the café menu system which will have:
* Links to each of the café menus.
* A link to a registration page.
* Login/logout section.

For Assignment 2 (Part 1) the login/logout section does not need to authenticate a user, it just needs
to change the security state/level (i.e. no database access is required).

#### Registration Page
This is where new users can register to use the system. Further details are in the [Details](#details) section
above.

Proper input validation must be applied at this point including:
* Double entry password check
* Password is:
 * 6 to 12 characters in length
 * Contains at least 1 lower case letter, 1 uppercase letter, 1 number and one of the
following special characters — ! # $

Café staff and managers do not register, they are added to the system by a Board Member. Once
added to the system, café staff can also use the menu system to order food and beverages.

For Part 1 the registration page does not need to store the registration data (i.e. no database access
is required).

#### Café Menu Page
It will display:
*  The opening and closing times of the café,
* The list of food and beverage items available at that café,
* Their cost and an initial associated order quantity of 0 (zero).

If a user is not logged in, they can only view the menu items. The comment and quantity fields for
each item cannot be viewed, and an order cannot be submitted.

If a user is logged in, they can view a menu and change any items quantity and submit it as an order.

For Part I the café menu page does not need to store a submitted order (i.e. no database access is
required).

#### Master food and beverage list page
This is where a Board Member creates, edits or removes items in the list of food and beverages that
will be available for selection by the café managers to use in their menus.

A Board Member also allocates the purchase price for each item and sets the date that the menu
applies to.
For Part 1 the master food and beverage list page does not need to store any changes to the list or
the items in it (i.e. no database access is required).

### Description of Task — Part 2A (20%)
#### Home Page
For Part 2 the login/logout section WILL need to authenticate a user (i.e. database access IS
required).
#### Registration Page
For Part 2 the registration page WILL need to store the registration data (i.e. database access IS
required).
#### Café Menu Page
It will display a total cost of all items selected to be ordered.

It will display a user's account balance which will decrease or increase in value as menu items are
added or removed from an order.

There must be an order collection time selected from a drop-down list.

All order collection times will
be on the quarter hour e.g. 12:30pm. All order collection times must be at least 30
minutes after opening and at least 60 minutes before closing.

It will not allow a user to order more than their account balance can pay for.

For Part 2 the café menu page WILL need to store a submitted order and update a user's account
balance as required (i.e. database access IS required).
#### User Account Page
This page can only be accessed while a user is logged in.
Here a user can view their account balance and deposit more funds.

For Part 2 the user account page WILL need to retrieve and update a user's account details as
required (i.e. database access IS required).
#### Menu Management Page
This page can only be accessed while the café manager is logged in.
Here the café manager can add or remove items from the menu and can change the café opening
and closing times. Opening and closing times must be on the quarter hour.
### User Management Page
Here:
* Users can change their password, mobile number or e-mail address,
* A Board Member can
 * Add or remove café staff,
 * Allocate café staff to be managers,
 * Allocate staff to a café.

### Master Food and Beverage Page
For Part 2 the master food & beverage list page WILL need to modify the list of food and beverages
that will be available for selection by the café managers to use in their menus (i.e. database access
IS required).

### Café Orders Page
This page is only available to the café staff and café manager, and lists all orders and the order
details placed. Only the current days orders will be visible.

### Description of Task — Part 2B (5%)
Part 2b Additional Features is self-directed learning and as such there will not be any formal
instruction on how to achieve it — you will need to conduct your own research and self-study.

To attempt the last 5 marks, the following 8 attributes/features must be applied to Part 1 and Part 2a
of the assignment (0.625 marks for each).

You are advised not to attempt these modifications until you have achieved a fully featured and
correctly functioning website that meets all of the Part 1 and Part 2a criteria.

Order discounts will apply:

| User  | Discount |
| ------------- | ------------- |
| Director of the Board   | 100%   |
| Board Members   | 80%   |
| Café managers   | 15%   |
| Café staff   | 10%  |
| UTAS Students   | 7%  |
| UTAS Employees  | 0%  |

All order totals are rounded to the nearest cent (i.e. a student order totalling $15.50 gets a
discount of $1.085 making the new order total $14.415, which would be recorded/processed
as $14.42

Challenge response is required for registration.

Forgot password feature is required.

Can top up account balance during an order and not lose the order details.

Pictures of users, food and beverages will be stored and displayed in appropriate areas.

Note: There is a storage limit in alacritas. Be careful not to exceed the allowance.

A basic Responsive layout is required (i.e. layout, text and image proportions are maintained
when the screen is resized).

Email addresses must have a valid format where for our purposes:

1. There is a local part followed by an @ symbol followed by a domain part,
1. There are no spaces,
1. The local part may be up to 64 characters long,
the domain part may have a maximum of 255 characters,
1. The local part contains only the ascii characters a to z, A to Z, the integer characters
0 to 9 and the special ascii characters ``! # $ % & ` * + - / = ? ^ _ ' { | } ~ ; , ``
1. The local part may contain the "." (period) character but may not start or end with it
1. And may not have 2 consecutive period characters,
1. The domain part contains only the ascii characters a to z, A to Z and the integer
characters O to 9 and the special ascii character the hyphen "—
1. The domain part must have at least one period character but may not start or end with
it and may not have 2 consecutive period characters.

What a *shitty* assignment spec...

## Authors

* **Bryce Andrews** - [sharpenednoodles](https://github.com/sharpenednoodles)

## Built With

* [Bootstrap](https://getbootstrap.com/) - The web framework used to keep my sanity, and a somewhat modern responsive design.


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* The Bootstrap Team
* Atom Team
* Saleem - for actually wanting to make the course decent
