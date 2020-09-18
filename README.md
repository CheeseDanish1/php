# Instructions

1. Install xampp [here](https://www.apachefriends.org/index.html)
2. Open up the command terminal and cd to the folder named `C:/xampp/htdocs` (Default for windows)
3. Delte Everything Currently In The Folder By Running The Command `rmdir /s /q .`
4. Clone this repoooo inthe directory by running the command `https://github.com/CheeseDanish1/php.git`
5. Go to the install location and open the file named `xampp-control.exe`
6. Start the modules called `Apache` and `MySQL`
7. In your broser open up phpmyadmin by going to `localhost/phpmyadmin`
8. Make a database with the name `loginsystem`
9. Create tables using the following code
```sql
CREATE TABLE users (
  user_id varchar(256) PRIMARY KEY not null,
  user_first varchar(256) not null,
  user_last varchar(256) not null,
  user_email varchar(256) not null,
  user_uid varchar(256) not null,
  user_pwd varchar(256) not null
);

CREATE TABLE profileimg (
  id int(11) AUTO_INCREMENT not null PRIMARY KEY,
  userid varchar(256) not null,
  status int(11) not null
);
```
10. Again, in your browser go to localhost/php/

# Folders

## CSS
**This is the folder where I keep all the css code**

## error-pages
**This is where the code for the 404 and 403 pages are**

## images
**Some images used throught the project**

## Includes
**This is where all the backend code is located**

## ProfileImages
**This is where the profile images go when uploaded**

---

**And that is it! You should now have the basic login system all set up.**

**If you had trouble following that, [here](https://www.youtube.com/watch?v=mXdpCRgR-xE) is a tutorial on how to set up xampp by mmtuts (Dani Krossings) He has a great youtube channel, make sure to sub to him if you enjoy his content**

Some other stuff to note

This system uses prepared statments to be safe from an sql injection. If there is a place where it is not safe please let me know.
Also, passwords are hashed(encoded) for the privacy of the users.

## And that should be everything!