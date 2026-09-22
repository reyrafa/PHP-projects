<?php
namespace App\Payments;
use App\Contracts\PaymentGateway;
class StripePayment implements PaymentGateway
{
    public function pay(float $amount): bool
    {
        echo "Payed using stripe amounting $amount";
        return true;
    }
}