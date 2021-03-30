<?php

namespace TodoApi;

use Psr\Container\ContainerInterface;
use TodoApi\TodoItem;
use PDO;

class TodoItemRepository
{

    /**
     * @return TodoItem[]
     */

    public function __construct(ContainerInterface $container)
    {
        $this->db = $container['db'];
    }

    public function fetchAllItems() : array
    {
        $stmt = $this->db->prepare("SELECT * FROM todo_items");
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'TodoItem::class');
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

    public function addItem($data) : array
    {
        $listId = $data['listId'];
        $itemDesc = $data['itemDesc'];
        $itemDue = $data['itemDue'];
        $itemComplete = $data['itemComplete'];

        $stmt = $this->db->prepare("INSERT INTO todo_items (itemDesc, itemDue, itemComplete) VALUES (:itemDesc, :itemDue, :itemComplete)");
        $stmt->bindParam(":itemDesc", $itemDesc, PDO::PARAM_STR);
        $stmt->bindParam(":itemDue", $itemDue, PDO::PARAM_STR);
        $stmt->bindParam(":itemComplete", $itemComplete, PDO::PARAM_INT);
        if ($stmt->execute())
        {
            $lastId = $this->db->lastInsertID();
            $stmt = $this->db->prepare("INSERT INTO todo_lists_items (todolistid, todoitemid) VALUES (:listId, :itemId)");
            $stmt->bindParam(":listId", $listId, PDO::PARAM_INT);
            $stmt->bindParam(":itemId", $lastId, PDO::PARAM_INT);
            $stmt->execute();

            $result = [
                "listId" => $listId,
                "itemId" => $lastId,
            ];
        } else {
            $result = null;
        }
        return $result;
    }
}
