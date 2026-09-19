<?php
require_once("PaymentGateway.php");
class StripePayment implements PaymentGateway
{
    public function pay(float $amount): void
    {
        echo "payed with Stripe amounting to $amount";
    }
}