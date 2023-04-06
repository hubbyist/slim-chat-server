SLIM CHAT SERVER APPLICATION [WIP]
============================

INSTALLATION AND USAGE
----------------------

To start server cd into the project folder

Use composer to install dependencies

Create an empty database
```
sqlite3 common/slim-chat-server.db
```

Use supplied sql script to initialize database
```
sqlite3 common/slim-chat-server.db < common/slim-chat-server-database-structure.sqlite.sql
```

You can also rename the sample database
```
mv common/slim-chat-server.sample.db common/slim-chat-server.db
```

To start server cd into the project folder than issue following command.
```
php -S localhost:8000 -t $PWD/public $PWD/public/router.php
```

For testing the current state navigate to

```
http://localhost:8000/client.html
```
--------------------------------------------------------------------------------
Copyright 2023 Mehmet Durgel. All Rights Reserved.

author : Mehmet Durgel<md@legrud.net>
