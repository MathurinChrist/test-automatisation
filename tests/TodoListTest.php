<?php

    namespace App\Tests\Entity;

    use App\Entity\Item;
    use App\Entity\TodoList;
    use App\Entity\User;
    use App\Service\SendEmail;
    use App\Service\TodoListService;
    use PHPUnit\Framework\TestCase;

    class TodoListTest extends TestCase
    {
        private readonly SendEmail $sendEmail;
        public function testTasksCollectionIsInitialized(): void
        {
            $todoList = new TodoList();

            $this->assertCount(0, $todoList->getTasks());
        }

        public function testAddTask(): void
        {
            $todoList = new TodoList();

            $item = (new Item())
                ->setName('Task 1')
                ->setContent('Content 1')
                ->setCreatedAt(
                    (new \DateTimeImmutable())->modify('-1 hour')
                );

            $todoList->addTask($item);

            if (count($todoList->getTasks()) === 8) {
                $this->sendEmail->send(
                    $todoList->getUserConcern()?->getEmail() ?? 'user@mail.com',
                    ' 8 tâches atteintes',
                    'Votre todo list contient maintenant 8 tâches.'
                );
            }

            $this->assertCount(1, $todoList->getTasks());
            $this->assertTrue($todoList->getTasks()->contains($item));
            $this->assertSame($todoList, $item->getTodoList());
        }

        public function testCannotAddTaskBeforeThirtyMinutes(): void
        {
            $this->expectException(\Exception::class);

            $todoList = new TodoList();

            $firstItem = (new Item())
                ->setName('Task 1')
                ->setContent('Content 1')
                ->setCreatedAt(new \DateTimeImmutable());

            $secondItem = (new Item())
                ->setName('Task 2')
                ->setContent('Content 2')
                ->setCreatedAt(new \DateTimeImmutable());

            $todoList->addTask($firstItem);

            $todoList->addTask($secondItem);
        }

        public function testRemoveTask(): void
        {
            $todoList = new TodoList();

            $item = (new Item())
                ->setName('Task 1')
                ->setContent('Content 1')
                ->setCreatedAt(
                    (new \DateTimeImmutable())->modify('-1 hour')
                );

            $todoList->addTask($item);

            $this->assertCount(1, $todoList->getTasks());

            $todoList->removeTask($item);

            $this->assertCount(0, $todoList->getTasks());
            $this->assertNull($item->getTodoList());
        }

        public function testUserConcernGetterSetter(): void
        {
            $todoList = new TodoList();

            $user = (new User())
                ->setName('Doe')
                ->setFirstName('John')
                ->setEmail('john@test.com')
                ->setPassword('Password123')
                ->setBirthDate(new \DateTime('2000-01-01'));

            $todoList->setUserConcern($user);

            $this->assertSame($user, $todoList->getUserConcern());
        }

        public function testUserConcernCanBeNull(): void
        {
            $todoList = new TodoList();

            $todoList->setUserConcern(null);

            $this->assertNull($todoList->getUserConcern());
        }

        public function testEmailSentAt8Tasks()
        {
            $sendEmail = $this->createMock(SendEmail::class);

            $sendEmail->expects($this->once())
                ->method('send');

            $service = new TodoListService($sendEmail);

            $todoList = new TodoList();

            for ($i = 0; $i < 8; $i++) {
                $item = (new Item())
                    ->setName('Task '.$i)
                    ->setContent('Content')
                    ->setCreatedAt(new \DateTimeImmutable());

                $service->addTask($todoList, $item);
            }

            $this->assertCount(8, $todoList->getTasks());
        }
    }
