<?php 
namespace App\Payments;
use App\Contracts\PaymentGateway;
class PaypalPayment implements PaymentGateway{
    public function pay(float $amount) : bool {
        echo "Payed using paypal amounting $amount";
        return true;
    }
}