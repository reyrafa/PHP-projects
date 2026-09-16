<?php
class Task
{
    private string $title;
    private bool $completed;

    public function __construct(string $title, bool $completed)
    {
        $this->title = $title;
        $this->completed = $completed;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getStatus(): string
    {
        if ($this->isCompleted()) {
            return 'Completed';
        }
        return 'Pending';
    }

    public function complete(): void
    {
        $this->completed = true;
    }
}