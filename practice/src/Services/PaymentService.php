<?php
namespace App\Services;
use App\Contracts\PaymentGateway;
class PaymentService
{

    public function __construct(private PaymentGateway $paymentGateway)
    {
    }
    public function pay(float $amount): bool
    {
        return $this->paymentGateway->pay($amount);
    }
}