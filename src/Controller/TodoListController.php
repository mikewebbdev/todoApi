<?php

namespace TodoApi\Controller;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use TodoApi\TodoListRepository;

class TodoListController
{

    /**
     * @var TodoListRepository
     */
    private $todoListRepository;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->todoListRepository = $container->get(TodoListRepository::class);
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function getAllTodoLists(Request $request, Response $response)
    {
        $data = [];
        $lists = $this->todoListRepository->fetchAllLists();
        return $response->withJson(['data' => $lists]);
    }

    public function getTodoListById(Request $request, Response $response, $args)
    {
        $list = $this->todoListRepository->fetchList($args['id']);
        return $response->withJson(['data' => $list]);
    }

    public function createTodoList(Request $request, Response $response, $args)
    {
        $data = [];
        $postValues = $request->getParsedBody();
        $data['name'] = filter_var($postValues['name'], FILTER_SANITIZE_STRING);
        $newList = $this->todoListRepository->addList($data['name']);
        return $response->withJson(['data' => $newList]);
    }

    public function updateTodoList(Request $request, Response $response, $args)
    {
        $data = [];
        $postValues = $request->getParsedBody();
        $data['name'] = filter_var($postValues['name'], FILTER_SANITIZE_STRING);
        $data['id'] = filter_var($postValues['id'], FILTER_SANITIZE_NUMBER_INT);
        $updatedList = $this->todoListRepository->updateList($data);
        return $response->withJson(['data' => $updatedList]);
    }

    public function deleteTodoList(Request $request, Response $response, $args)
    {
        $listId = $this->todoListRepository->deleteList($args['id']);
        return $response->withJson(['data' => $list]);
    }
}
