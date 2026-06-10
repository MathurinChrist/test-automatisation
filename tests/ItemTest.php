<?php

    namespace App\Tests;

    use App\Entity\Item;
    use App\Entity\TodoList;
    use PHPUnit\Framework\TestCase;

    class ItemTest extends TestCase
    {
        private function createItem(): Item
        {
            return (new Item())
                ->setName('Item test')
                ->setContent('Contenu de test')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setTodoList(new TodoList());
        }

        public function testGettersAndSetters(): void
        {
            $createdAt = new \DateTimeImmutable('2026-01-01');
            $todoList = new TodoList();

            $item = (new Item())
                ->setName('Acheter du pain')
                ->setContent('Aller à la boulangerie')
                ->setCreatedAt($createdAt)
                ->setTodoList($todoList);

            $this->assertNull($item->getId());
            $this->assertSame('Acheter du pain', $item->getName());
            $this->assertSame('Aller à la boulangerie', $item->getContent());
            $this->assertSame($createdAt, $item->getCreatedAt());
            $this->assertSame($todoList, $item->getTodoList());
        }

        public function testSetTodoListCanBeNull(): void
        {
            $item = $this->createItem();

            $item->setTodoList(null);

            $this->assertNull($item->getTodoList());
        }
    }
