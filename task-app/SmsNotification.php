<?php
require_once('Notifiable.php');
class SmsNotification implements Notifiable
{
    public function notify(): void
    {
        echo "Sending Sms";
    }
}