<?php

    namespace App\Service;

    use App\Entity\Item;
    use App\Entity\TodoList;

    class TodoListService
    {
        public function __construct(
            private SendEmail $sendEmail
        ) {}

        public function addTask(TodoList $todoList, Item $item): void
        {
            $todoList->addTask($item);

            if (count($todoList->getTasks()) === 8) {
                $this->sendEmail->send(
                    $todoList->getUserConcern()?->getEmail() ?? 'user@mail.com',
                    '8 tâches atteintes',
                    'Votre todo list contient maintenant 8 tâches.'
                );
            }
        }
    }
