<?php

use Slim\App;
use TodoApi\Controller\TodoListController;
use TodoApi\Controller\TodoItemController;
use TodoApi\TodoListRepository;
use TodoApi\TodoItemRepository;

require __DIR__ . '/../vendor/autoload.php';
$settings = require __DIR__ . '/../src/settings.php';
$app = new App($settings);

$container = $app->getContainer();

$container['db'] = function($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container[TodoListRepository::class] = function($c) {
    return new TodoListRepository($c);
};
$container[TodoItemRepository::class] = function($c) {
    return new TodoItemRepository($c);
};

$app->group('/todoApi', function() use ($app) {
    $app->group('/lists', function() use ($app) {
        $app->get('', TodoListController::class . ':getAllTodoLists');
        $app->get('/{id}', TodoListController::class . ':getTodoListById');
        $app->post('', TodoListController::class . ':createTodoList');
        $app->put('/{id}', TodoListController::class . ':updateTodoList');
        $app->delete('/{id}', TodoListController::class . ':deleteTodoList');
    });
    $app->group('/listItems', function() use ($app) {
        $app->get('', TodoItemController::class . ':getAllItemsByList');
        $app->get('/overdue', TodoItemController::class . ':getAllItemsByOverdue');
        $app->post('/{listid}/create', TodoItemController::class . ':createTodoItem');
        $app->put('/{itemid}', TodoItemController::class . ':updateTodoItem');
        $app->delete('/{listid}/{itemid}', TodoItemController::class . ':deleteTodoItem');
    });
});

$app->run();