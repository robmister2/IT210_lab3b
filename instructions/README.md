# Lab 3B - PHP Part 2

## Overview

In the previous lab we had you set up authentication for your application, but in order to really understand PHP, we're going to have you "transpile" your code from the JavaScript lab into PHP. This means looking at your JavaScript and trying to figure out how to do the same thing in PHP.

This lab builds off of the previous labs (as do all of the labs), so make sure you organize your code well so you will be able to read and understand it again later. At the end of this lab, there should be almost no JavaScript in your project at all. (You should modify the JavaScript to live-capture the form data, and submit when the user adds a task. You may also keep any JavaScript to display completed tasks differently, i.e. linethrough or color change, if you used that previously. You should also keep any JavaScript to initialize any Date Picker, if you used that previously. All other functionality should be implemented in PHP.)

### Functionality

- Interact with a MySQL database while creating, reading, updating, and deleting tasks

#### Differences from Lab 2

- Using PHP instead of JavaScript
   - PHP is strictly server-side, which means all of the database-accessing happens before a response is made from the server
   - The JavaScript in Labs 2 and 3 are stirctly client-side, which means all of the database-accessing happens after the response from the server.
      - This means we can take one of two actions: use a local database (e.g. local storage), or make calls back to the server (e.g. API calls). We did the first one in lab 2, and we'll do the second one in lab 6.
- Using a database server instead of local storage
   - Because PHP runs server-side, any sorting that happens needs to be done before a response is sent from the server. This makes sorting a little more difficult in PHP than in JavaScript, so it is not required for this lab. We *would* do this by the SQL `ORDER BY` directive.
- Logging users in
   - If we didn't log users in, we wouldn't be able to easily and securely distinguish among users. We would have some kind of global task list for everyone, which sounds cool, but isn't very useful. (Twitch plays task list?)

### Concepts

- Code Transpiling

### Technologies

- UML
- PHP
- MySQL

### Resources

- [Official PHP Documentation](https://www.php.net/)
- [PHP MYSQL Introduction](https://www.tutorialrepublic.com/php-tutorial/php-mysql-introduction.php)
- [PHP Sessions](https://www.w3schools.com/php/php_sessions.asp)
- [Prepared Statements](https://www.php.net/manual/en/mysqli.prepare.php)
> NOTE: Make sure you're using "Object-Oriented Style" prepared statements, NOT "Procedural Style"

### Assignments

Lab Write-Up Instructions are in the "Content" tab in Learning Suite.

## Instructions

### Step 1: UML

Create a UML diagram of the interaction described in the entire lab (both parts) with swim lanes before you ever start coding. Really try to get the hang of how everything is working together. You can always ask the TAs for help.

### Step 2: Database Setup

#### Production Environment

1. Using PHPMyAdmin on your Production Environment (`http://192.168.90.??/phpmyadmin`), create a table called `'task'` in the `'lab_3'` database

   - Add the following fields:

      | Name      | Type      | Index     | ... | A_I | ... |
      | --------- | --------- | --------- | --- | --- | --- |
      | `id`      | `INT`     | `PRIMARY` | ... | ☒   | ... |
      | `user_id` | `INT`     |           | ... | ☐   | ... |
      | `text`    | `TEXT`    |           | ... | ☐   | ... |
      | `date`    | `DATE`    |           | ... | ☐   | ... |
      | `done`    | `BOOLEAN` |           | ... | ☐   | ... |

      > Note: The MySQL DATE type is just a fancy text or varchar that gets validated upon submission.
   - If using Type `TEXT` gives you problems, you can use `VARCHAR` instead with an appropriately long max length value for a task’s `text` property. 

1. Using PHPMyAdmin or the MySQL CLI, add a few tasks so you have some data to work with. Make sure the `user_id` field matches a user that already exists in your database.

#### Development Environment

1. Using PHPMyAdmin on your Development Environment ([`http://localhost:8080`](http://localhost:8080)), follow the same steps as above

   > IMPORTANT: When stopping your docker containers, sometimes you'll want to delete the volume associated with `mariadb` (where your MySQL database lives) using `docker-compose down -v` or `docker-compose down --volumes`. If you do this, all of the changes you made to your database will be gone. Adding the `--volumes` flag will remove your `user` table and your `task` table forever. It's not super hard to re-create them, but it might be annoying.

### Step 3: Transpile

> Because of the differences in where the code is run, and the difficulties in reproducing functionalities because of that, it becomes *very difficult* to get an automatic transpiler to convert from JavaScript to PHP. We want to copy over the general functionality, not all of the logic. DO NOT try and have your code automatically transpiled, *it will not work*.

1. Create

   - You should already have a form to create tasks from a previous lab. You will be handling the form with PHP instead of JS so make sure you remove any event listeners associated with this form.
   - If you've organized your `_action.php` files into an `actions` folder, add a new file called `create_action.php`, and set the `action` attribute of the `<form>` tag to reference it
   - Your action file needs to accomplish the following tasks:
     - Read the values passed from the form
     - Grab the id of the current user from the session (you should be saving the `user_id` to the session when a user logs in or registers)
     - Create a new task in the database using the form data and the user's id
     - Redirect back to `index.php` on success

2. Read

   - In your `index.php` file in the root of your project, do the following:
     - Connect to your MySQL database and query for tasks that match the current user's `id` with the task's `user_id` field
     - As you've done in JavaScript, print a new task to the page for each result from the query
       > TIP: it may be helpful to define a function that accepts the details of a task and then prints them out, and call that for each task.

3. Update

   - If your checkbox isn't already in a form, wrap a `<form>` tag and a `<button type="submit">` tag around it
   - Create a new action file called `update_action.php`
   - Pass the user's `id` with the rest of the form when you submit it
      > TIP: You can accomplish this with a hidden `<input>` tag who's value is the user's `id`
   - Your action file needs to accomplish the following tasks:
     1. Read the values passed from the form
     2. Update the task in the database based on the passed values
     3. Redirect back to `index.php` if the update succeeds

4. Delete

   - Wrap your delete button in a `<form>` tag
     - If your delete button is an actual `<button>` tag, change the type to `type="submit"`
     - Otherwise, wrap the element that contains your delete button in a new `<button type="submit">` tag
   - Create a new action file called `delete_action.php`
   - As with `update_action.php`, pass the user's `id` with the rest of the form when you submit it
   - Your action file needs to accomplish the following tasks:
     1. Read the values passed from the form
     2. Delete the task from the database using the values you get from the `<form>`
     3. Redirect back to `index.php` if the delete succeeds

### Step 4: General Requirements

1. All of your forms should utilize the appropriate HTTP method for its action ("post" or "get")

2. Any SQL statement that uses user-provided input should use Prepared Statements to interact with the database

3. Your website should look neat and tidy, with no text against the edge of the screen

   > HINT: You can use the `container` CSS class that comes with Bootstrap to automatically change the size of your content based on screen width!

4. Your `<nav>` element should have no other elements above it, span the entire width of the screen

5. When there is no user logged in, your home page should automatically re-direct you to the login screen

6. You should be able to switch back and forth between the login page and the register page when you're on it

7. When logged in, there should be a <kbd>Log Out</kbd> button on the `<nav>` bar in an appropriate location

8. The only `<script>` tag on your website should be the one that imports your CSS framework's JavaScript files.

# Tips

## How do I...?

Besides the resources listed at the beginning of this document, Google will be your best friend on this lab. For example you might search "PHP get form data from GET request", or "HTML hidden input", etc.

## var_dump()

In PHP there is a way to nicely print out any type of variable and it is var_dump(). This means you can give it an int, string, array or object and it will print it out for you. This can be really useful when working with results from your database.

# PHP – Part 2 Pass-off

## Minimum Requirements (90 / 100 pts)

- [ ] Choose appropriate permissions for all your files (you must explain why – 777 is not appropriate)
- [ ] UML diagram
- [ ] Code is backed up on GitHub
- [ ] `index.php` displays the user's tasks from the database
- [ ] User can create a new task, and have it reflect in the database
- [ ] User can update a task by clicking the checkbox, and have it reflect in the database
- [ ] User can delete a task, and have it reflect in the database
- [ ] All SQL statements that use user-provided input use Prepared Statements to interact with the database
- [ ] Home page automatically re-directs users to the login screen while not yet logged in
- [ ] No extraneous JavaScript (except CSS framework scripts)

## Full Requirements

- [ ] 10 Points - Php code uses Object Oriented process and SQL prepared statements for accessing the Database
   - `.php` files use bound parameters when querying the database with user-supplied values

## Style Requirements
- [ ] Site uses Bootstrap
- [ ] No *ugly* elements
- [ ] Website looks neat and tidy, with no text against the edge of the screen
- [ ] Style should match what you had for lab 2B

## UML Diagram
- [ ] UML Activity Diagram in digital from, showing functionality of your `index.php` file (checking the user is logged in, reading tasks, etc.) using swim lanes (User, Browser, Server/PHP, Database)

## Extra Credit
> Note: TAs cannot help you with extra credit!

- [ ] 10 Points - Using PHP, sanitize user input to prevent XSS attacks
- [ ] 10 Points - The form data is live-captured, and clears when the user creates a task; user can still create tasks
- [ ] 5 Points - User can sort tasks by date, then re-sort by time added
- [ ] 5 Points - User can filter out completed tasks
- [ ] 5 Points - Sort order persists over site reloads

# Writeup Questions

- Describe how prepared statements help protect against SQL injection, but not XSS.
- Describe at least two key differences between the PHP version of the task list and the JavaScript one you completed in labs 2A and 2B.
- If we created a new table `login_logout` in the database to keep track of login and logout times of our various users, what would that table's schema look like? Describe necessary fields, which fields would need to be `primary` or `unique`, and what data type you would use for each.
