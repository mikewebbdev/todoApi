<?php

namespace TodoApi;

class TodoList
{

    private $id;

    private $description;

    private $dueDate;

    private $isComplete;

    public function __construct(int $id, string $description, string $duedate, bool $isComplete)
    {
        $this->id = $id;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->isComplete = $isComplete;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function dueDate(): string
    {
        return $this->dueDate;
    }

    public function isComplete(): bool
    {
        return $this->isComplete;
    }
}
