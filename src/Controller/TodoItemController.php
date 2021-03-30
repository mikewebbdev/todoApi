<?php

namespace TodoApi\Controller;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use TodoApi\TodoItemRepository;

class TodoItemController
{

    /**
     * @var TodoItemRepository
     */
    private $todoItemRepository;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->todoItemRepository = $container->get(TodoItemRepository::class);
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function getAllTodoItems(Request $request, Response $response)
    {
        $data = [];
        $items = $this->todoItemRepository->fetchAll();
        foreach ($items as $item) {
            $data[] = [
                'id' => $item->id(),
                'name' => $item->name(),
            ];
        }
        return $response->withJson(['data' => $data]);
    }

    public function createTodoItem(Request $request, Response $response, $args)
    {
        $data = [];
        $postValues = $request->getParsedBody();
        $data['listId'] = $args['listid'];
        $data['itemDesc'] = filter_var($postValues['itemDesc'], FILTER_SANITIZE_STRING);
        $time = strtotime($postValues['itemDue']);
        $data['itemDue'] = date("Y-m-d H:i:s", $time);
        $data['itemComplete'] = filter_var($postValues['itemComplete'], FILTER_VALIDATE_BOOLEAN);
        $newItem = $this->todoItemRepository->addItem($data);
        return $response->withJson(['data' => $newItem]);
    }
}
