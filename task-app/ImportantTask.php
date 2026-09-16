<?php
require_once('Task.php');
class ImportantTask extends Task
{
    public function getStatus(): string
    {
        return "IMPORTANT - " . parent::getStatus();
    }
}