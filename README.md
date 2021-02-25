### Lab 3 Writeup
## Robert Smith, 02/24/2021

# Executive Summary
In this lab, I used PHP to create two databases that work together. One was a database of users, with the ability to register new users and login to old ones. the second was a database of tasks that associated each task to the currently logged in user. The task list allowed users to add tasks, delete tasks, and mark tasks as completed. 

# Design Overview

## UML Diagrams
![UML 1](https://github.com/BYU-ITC-210/lab-3b-robmister2/blob/master/instructions/Lab%203a%20UML.png)
UML of registering a new user and logging in an existing one

![UML 2](https://github.com/BYU-ITC-210/lab-3b-robmister2/blob/master/instructions/Lab%203b%20UML.png)
UML of checking a user's login status, creating a task, deleting a task, and marking a task as completed

## Screenshots
![Waffle Truck Website](https://github.com/BYU-ITC-210/lab-3b-robmister2/blob/master/instructions/screenshot1.PNG)
This is the final product, with a functioning tasklist that queries the PHP database and updates it with user input

![Registration Page](https://github.com/BYU-ITC-210/lab-3b-robmister2/blob/master/instructions/screenshot2.PNG)
Registration page for new users

![PHPmyadmin](https://github.com/BYU-ITC-210/lab-3b-robmister2/blob/master/instructions/screenshot3.PNG)
PHPmyadmin showing table of tasks, note that only tasks associated with a particular user are displayed when they are logged in

## Files Included
**index.php:** This is the homepage of the tasklist. It reads user inputs and updates tasks according in the database, as well as displaying them neatly on the homepage.

**style.css:** This is used to beautify the website. several classes and elements were realigned and coloured to enhance readability. Also utilizes bootstrap classes.

**login.php:** This is the default homepage for anyone not logged in. It simply contains a username and password field, and calls login_action.php.

**register.php:** A simple page with a username, password, and confirmed password field. Used to register new users by calling register_action.php.

**login_action.php:** This queries the PHP database with the user input given to check to see if a user exists in the database, and if the provided password is correct for that user. If it is, it logs the user in (changes the logged_in variableto true) and redirects them to index.php.

**register_action.php:** This queries the PHP database with the user input given to check to see if a user exists in the database. If it does not, a user is created in the database with the provided username and password. This then logs the user in (changes the logged_in variable to true) and redirects them to index.php.

**logout_action.php:** This simply checks the session variable (which is set to remember a user being logged in) to see what user is logged in, changes their logged_in variable to false, destroys the session variable, and redirects the user to the login page.

**create_action.php:** This is called when the user submits a new task. It takes the values passed in from the form (task name and date), then assigns the task to that user and adds it to the tasks database.

**delete_action.php:** This is called when the user deletes a task. It queries the database for the task to be deleted, then removes it from the database and updates the view.

**update_action.php:** This is called when the user clicks on the checkbox next to the task. It flips the value of the "done" attribute associated with each task. Index.php is set to display the task as completed or not based on this attribute.

# Questions
* Describe how cookies are used to keep track of the state. (Where are they stored? How does the server distinguish one user from another? What sets the cookie?)

Cookies keep track of a state by saving important variables (such as a "logged_in" boolean). They are set by utilizing a PHP session. A programmer codes session variables into their code, and when the user logs in or causes that code to be executed, certain data is saved in a cookie and stored on the user's local browser. The programmer writes into the code to first and foremost check the user's browser for any saved data in cookies and make changes in what happens to the user based on the presence (or lack of presence) of a cookie and its data. The sever can distinguish one user from another based on the data stored in a cookie (like which user is logged in).

* Describe how prepared statements help protect against SQL injection, but not XSS.

Using prepared statements in PHP is similar to sanitizing user input in javascript. Basically, a query is prepared before any user input is taken. Then, the user input is injected into the prepared query but the characters therein are only treated as part of that specific input. This prevents an SQL injection from occuring because any characters that would normally change the query are treated as part of the parameter defined (for example, a semicolon is not interpreted as an end of statement anymore, just as a plain ascii character semicolon).

* Describe at least two key differences between the PHP version of the task list and the JavaScript one you completed in labs 2A and 2B.

1. The tasklist in PHP is stored on a server, rather than being stored in the JSON (like javascript). That means that it will remain the same no matter what browser is used to access it. 
2. The tasklist that appears to the user is based on which user is logged on. This is different than the javascript list, which had one tasklist per browser cache. The PHP tasklist has only one global list, but users can only see tasks associated with their account.
3. The PHP tasklist cannot be used without a connection to the PHP sever, whereas the javascript tasklist does not communicate with any server.

* If we created a new table login_logout in the database to keep track of login and logout times of our various users, what would that table's schema look like? Describe necessary fields, which fields would need to be primary or unique, and what data type you would use for each.

This schema would need three fields: A user_id, a logged_in time, and a logged_out time. The user_id would need to be unique, because each row would represent a different user, and it would simply be of data type INT (likely reuse the same user_id in our user table). The logged_in and logged_out variables would need no other fields, and they would be of type TIMESTAMP. a method could be called in the PHP when the user presses log out / in to update this variable with the current time.

# Lessons Learned

1. **Using prepared statments in PHP requires very specific syntax**

Preparing queries in PHP is quite intuative without using prepared statements. However, issues arise with SQL injections if a programmer takes this shortcut. It is much better, therefore, to use prepared statements. These can be unintuative, however, and take multiple steps. If a programmer tries to bind a parameter to a pre-prepared statement, but fails to specify what type of paramenter that is, (s for string, b for boolean etc), then the compiler will throw a rather odd error. Another error can occur if the programmer tries to bind what was returned from a query to a PHP variable that was not meant to accept the proper number of data fields. This can also throw a hard-to-debug error. The only real solution is to become familiar with prepared statement syntax and the different methods that can be utilzied by it.

2. **PHP pages can be a viewable page or just an operation**

Most programming languages have a "main" page that is thought of as the home of that program, with extra classes and functions to be called when needed. PHP pages can double as both. A programmer may use a PHP page to display HTML (since any valid HTML is also valid PHP) to a user, but they could also use a page to execute a function, and then redirect the user back to another page that is viewable. This can be a strange concept to programmers not accustomed to web development, but makes organzing a PHP-coded website much more readable and manageable. This isn't so much a problem to be solved as much as it is a different approach to programming in general.

3. **PHP and javascript are not mutually exclusive**

PHP and javascript are both very useful and powerful programming languages. Although both can accomplish most of the same things, some tasks are better suited for one language or another. A programmer may be tempted to use only PHP or only javascript in their code for the sake of convenience, but this may not always be the best choice. It is easy to switch from one language to another, simply by closing a <?php> tag and opening a < script > tag. Learning the uses of both and switching between them can sometimes be in a programmers' best interest to accomplish the task at hand. In short, javascript is very good at any client-side data manipulation or display, whereas PHP is very good at making calls to a server. Although both can perform the other's functions, it is useful knowing how to apply each of them.

# Conclusions

* Program functionailty into a website using PHP
* Use protected statements to protect against SQL injections
* Use $_post to track user input
* Use $_session to create and utilize cookies
* Save data in a PHPmyadmin database, and access and manipulate it
* use PHP to dynamically modify innerHTML
* use PHP and javascript together
* redirect users to different pages using PHP

# References

cloud.r-project.org

https://stackoverflow.com/

https://www.php.net/manual/en/index.php

