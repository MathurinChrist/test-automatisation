<?php

namespace App\Entity;

use App\Repository\TodoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoListRepository::class)]
class TodoList
{
    private static string $duration = 'PT30M';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'todoList')]
    private Collection $tasks;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $userConcern = null;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Item $task): static
    {
        $lastTask = $this->tasks->last();
        if ($lastTask !==  false) {
            $createdAt = $lastTask->getCreatedAt();
            $now = new \DateTimeImmutable();

            $limitDate = $createdAt->add(new \DateInterval(static::$duration));

            if ($now < $limitDate) {
                throw new \Exception("Vous devez attendre 30 minutes avant d'ajouter une nouvelle tâche.");
            }
        }

        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setTodoList($this);
        }

        return $this;
    }


    public function removeTask(Item $task): static
    {
        if ($this->tasks->removeElement($task)) {
            if ($task->getTodoList() === $this) {
                $task->setTodoList(null);
            }
        }

        return $this;
    }

    public function getUserConcern(): ?User
    {
        return $this->userConcern;
    }

    public function setUserConcern (?User $userConcern): static
    {
        $this->userConcern = $userConcern;

        return $this;
    }
}
