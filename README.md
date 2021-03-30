# Todo API


## Running
```bash
composer install
php -S localhost:8888 -t public public/index.php
```
Edit the database connection username/password in src/settings.php
Import the included orlo.sql database to your mysql server.

## Routes

### Lists
- GET localhost:8888/todoApi/lists \
=>Returns all current lists
- GET localhost:8888/todoApi/lists/# \
=> Gets list by ID where # is the target list id
- POST localhost:8888/todoApi/lists \
=> Takes a 'name' string and creates a new Todo List
- PUT localhost:8888/todoApi/lists/# \
=> Takes an array of  'name' and 'listId', and updates the name of the list, where # is the target list ID
- DELETE localhost:8888/todoApi/lists/# \
=> Deletes a list where # is the target list id, also checks for any items connected to the list and deletes where necessary

### Items
- POST localhost:8888/todoApi/listItems/#/create \
=> Takes an array of  'itemDesc', 'itemDue' and 'itemComplete', and creates a new item in the todo list, where # is the id of the list

## Still in progress

### Items
- GET localhost:8888/todoApi/listItems \
=> Gets all items grouped by list (default sort)
- GET localhost:8888/todoApi/listItems/overdue \
=> Gets all overdue items, sorted by due date
- PUT localhost:8888/todoApi/listItems/# \
=> Takes an array of 'itemDesc', 'itemDue' and 'itemComplete' and updates an item where # is the item id
- DELETE localhost:8888/todoApi/listItems/#/##
=> Deletes an item where # is the list id, and ## is the item id. Additionally deletes matching entries from the todo_items_lists table
