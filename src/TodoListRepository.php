<?php

namespace TodoApi;

use Psr\Container\ContainerInterface;
use TodoApi\TodoList;
use PDO;

class TodoListRepository
{

    /**
     * @return TodoList[]
     */

    public function __construct(ContainerInterface $container)
    {
        $this->db = $container['db'];
    }

    public function fetchAllLists() : array
    {
        $stmt = $this->db->prepare("SELECT * FROM todo_lists");
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'TodoList::class');
        $stmt->execute();
        if ($stmt) {
            foreach ($stmt as $row) {
                $result[] = $row;
            }
        } else {
            $result = null;
        }
        return $result;
    }

    public function fetchList($listId) : array
    {
        $stmt = $this->db->prepare("SELECT * FROM todo_lists WHERE id = :id");
        $stmt->bindParam(":id", $listId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) {
            $result = $stmt->fetch();
        } else {
            $result = null;
        }
        return $result;
    }

    public function addList($name) : string
    {
        $stmt = $this->db->prepare("INSERT INTO todo_lists (name) VALUES (:name)");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $lastId = $this->db->lastInsertID();
        return $lastId;
    }

    public function updateList($data) : array
    {
        $listId = $data['id'];
        $newName = $data['name'];
        $stmt = $this->db->prepare("UPDATE todo_lists SET name = :newName WHERE id = :updateId");
        $stmt->bindParam(":newName", $newName, PDO::PARAM_STR);
        $stmt->bindParam(":updateId", $listId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $this->db->prepare("SELECT * FROM todo_lists WHERE id = :id");
        $stmt->bindParam(":id", $listId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) {
            $result = $stmt->fetch();
        } else {
            $result = null;
        }
        return $result;
    }

    public function deleteList($listId) : int
    {
        $deleteId = $listId;
        $stmt = $this->db->prepare("DELETE FROM todo_lists WHERE id = :deleteId LIMIT 1");
        $stmt->bindParam(":deleteId", $deleteId, PDO::PARAM_INT);
        $stmt->execute();
        $cleanItems = $this->todoItemRepository->deleteItemsFromList($deleteId);
        if ($cleanItems) {
            return $response->withJson(['data' => $cleanItems]);
        } else {
            return $response->withJson(['data' => $deleteId]);
        }
    }
}
