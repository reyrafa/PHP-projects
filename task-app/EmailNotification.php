<?php
require_once('Notifiable.php');
class EmailNofication implements Notifiable
{
    public function notify(): void
    {
        echo "Sending email";
    }
}