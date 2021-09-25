# Le_chat
⚠️ Ceci est un vieux projet datant de 2018 ⚠️
⚠️ Bien qu'il soit plus ou moins fonctionnel, le code est un peu brouillon. Si vous lisez ceci, c'est que le code n'est pas maintenu ⚠️
Le_chat is a chat application developped in PHP, javascript.  
I used the ORM Doctrine, jQuery and the CSS framework Materialize.  
This is not the final version, there is still a lot of work on it. For instance I need to fix some bugs, redesign the homepage, add some features, and change the awful sound which is playing when a message is sent.

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
The next step is only for UNIX systems users, I do not have a solution for Windows users for now.
In this chat, an user is automatically disconnected if inactive for 10 minutes. This is why we need a Python script check of the database every minutes to spot inactive users.

On your terminal, type:
```
crontab -e
```
and here, just add this line:
```
* * * * * python path/to/scriptCheckDB.py > /dev/null 2>&1
```


The application is now ready!

## Features 

Le_chat is a global chat. Everyone can write something and everyone can read. For now, there is not the possibility to send a private message to an other user.


* You can share pictures
* Sending a youtube link will display it in a placeholder with a thumbnail and the title... 
* Night mode
* An awful cash register sound will play when you send a message (can be desactivated)
* Inactive users are disconnected after ten minutes
* A secret feature
