<?php
require_once('PaymentGateway.php');
class PaypalPayment implements PaymentGateway
{

    public function pay(float $amount): void
    {
        echo "payed with paypal amounting to $amount";
    }
}