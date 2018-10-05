# Le_chat

Le_chat is a chat application developped in PHP, javascript.  
I used the ORM Doctrine, jQuery and the CSS framework Materialize.  
This is not the final version, there is still a lot of work on it. For instance I need to fix some bugs, redesign the homepage and redesign the homepage.

## Prerequisites

You need to have `Composer`, `Python`, `MySQL` and `Mysql-connector-python` installed on your computer.

## Installation



To install this application, first clone the repo.

```
git clone https://gitlab.com/pchabanne/le_chat.git
```

then type:
```
cd le_chat
composer install
```
Now, we are sure we have all dependencies we need.


You now need to configure your database in the file `bootstrap.php`

Then, make sure your database is started and run this command :
```
vendor/bin/doctrine orm:schema-tool:create
```
The next step is just for users with an UNIX system, I do not have a solution for Windows users for now.
In this chat, an user is automatically disconnect after 10 minutes of inactivity. That's why we need that a Python script check every minutes the database and disconnect an users if he is inactive for too long.

On your terminal, type:
```
crontab -e
```
and here, just add this line:
```
* * * * * python path/to/scriptCheckDB.py > /dev/null 2>&1
```


The application is now ready!