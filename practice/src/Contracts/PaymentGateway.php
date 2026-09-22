<?php
namespace App\Contracts;
interface PaymentGateway
{
    public function pay(float $amount): bool;
}