# Le_chat

Le_chat is an application developped in PHP, javascript.  
I used the ORM Doctrine, jQuery and the CSS framework Materialize.

## Prerequisites

You need to have installed on your computer `Composoer` and `MySQL`.

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


You need now to configure your database in the file `bootstrap.php`

Then, make sure your database is started and run this command :
```
vendor/bin/doctrine orm:schema-tool:create
```

The application is now ready!