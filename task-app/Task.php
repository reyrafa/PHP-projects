<?php
class Task
{
    public string $title;
    private bool $completed;

    public function __construct(string $title, bool $completed)
    {
        $this->title = $title;
        $this->completed = $completed;
    }
    public function getStatus(): string
    {
        if ($this->completed === true) {
            return 'Completed';
        }
        return 'Pending';
    }

    public function complete(): void
    {
        $this->completed = true;
    }
}