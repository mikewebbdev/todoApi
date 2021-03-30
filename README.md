# Todo API


## Running
```bash
composer install
php -S localhost:8888 -t public public/index.php
```

## Routes

### Lists
- GET localhost:8888/todoApi/lists \
: Returns all current lists
- GET localhost:8888/todoApi/lists/# \
: Gets list by ID where # is the target list id
- POST localhost:8888/todoApi/lists \
: Takes a 'name' string and creates a new Todo List
- PUT localhost:8888/todoApi/lists/# \
: Takes a 'name' string and a list ID and updates the name of the list, where # is the target list ID
- DELETE localhost:8888/todoApi/lists/# \
: Deletes a list where # is the target list id, also checks for any items connected to the list and deletes where necessary

### Items
- POST localhost:8888/todoApi/listItems/#/create \
: Takes a 'description', 'due date' and 'completion status' and creates a new item in the todo list, where # is the id of the list

## Still in progress

### Items

